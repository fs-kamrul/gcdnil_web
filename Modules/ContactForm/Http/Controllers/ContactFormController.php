<?php

namespace Modules\ContactForm\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;
use Modules\ContactForm\Enums\ContactStatus;
use Modules\ContactForm\Http\Models\ContactForm;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\ContactForm\Http\Imports\ContactFormImport;
use Modules\ContactForm\Http\Requests\ContactReplyRequest;
use Modules\ContactForm\Http\Requests\EditContactRequest;
use Modules\ContactForm\Repositories\Interfaces\ContactInterface;
use Modules\ContactForm\Repositories\Interfaces\ContactReplyInterface;
use Modules\ContactForm\Tables\ContactFormTable;
use Modules\KamrulDashboard\Events\DeletedContentEvent;
use Modules\KamrulDashboard\Events\UpdatedContentEvent;
use Modules\KamrulDashboard\Http\Responses\DboardHttpResponse;
use Modules\KamrulDashboard\Traits\HasDeleteManyItemsTrait;
use Exception;
use Throwable;
use Assets;
use EmailHandler;

class ContactFormController extends Controller
{
    use HasDeleteManyItemsTrait;


    /**
     * @var ContactInterface
     */
    protected $contactRepository;

    /**
     * @param ContactInterface $contactRepository
     */
    public function __construct(ContactInterface $contactRepository)
    {
        $this->contactRepository = $contactRepository;
    }
    protected $photo_path = 'uploads/contactform/';

    /**
     * @param ContactFormTable $dataTable
     * @return JsonResponse|View
     *
     * @throws Throwable
     */
    public function index(ContactFormTable $dataTable)
    {
        if (!auth()->user()->can('contactform_access')) {
            abort(403, 'Unauthorized action.');
        }
        page_title()->setTitle(trans('contactform::contact.menu'));

        return $dataTable->renderTable();
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        if (!auth()->user()->can('contactform_create')) {
            abort(403, 'Unauthorized action.');
        }
        $data = array();
        $data['title']        = 'contactform_create';
        return view('contactform::contactform.create',$data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!auth()->user()->can('contactform_create')) {
            abort(403, 'Unauthorized action.');
        }
        $validated = $request->validate([
            'name'              => 'bail|required|max:255',
        ]);

        try {
            $record = new ContactForm();
            $record->name           = $request->name;
            $record->description    = $request->description;
            $record->status         = $request->status;
            $record->uuid           = gen_uuid();
            $record->user_id        = Auth::id();
            $record->save();

            $file_name = 'photo';
            if ($request->hasFile($file_name))
            {
//                return $file_name;
                $rules = $request->validate([
                    "$file_name" => 'mimes:jpeg,jpg,png,gif|max:10000'
                ]);
                $path = $this->photo_path;
                deleteFile($record->photo, $path);

                $record->$file_name      = processUpload($request, $record,$file_name, $path);
                $record->save();
            }

            $response_data['status'] = 1;
            $response_data['message'] =  __('contactform::lang.record_save_successfully');
            return redirect('contactform')->with('response_data', $response_data);
        }catch (Exception $e){

            $response_data['status'] = 0;
            $response_data['message'] =  __('contactform::lang.something_error_please_try_again_later');
            return redirect('contactform')->with('response_data', $response_data);
        }
    }


    /**
     * Show the form for editing the specified resource.
     * @param  ContactForm\Http\Models\ContactForm  $contactform
     * @return \Illuminate\Http\Response
     */
    public function edit(ContactForm $contactform)
    {
        if (!auth()->user()->can('contactform_edit')) {
            abort(403, 'Unauthorized action.');
        }
        Assets::addStylesDirectly([
            'vendor/Modules/ContactForm/css/contact.css',
        ])->addScriptsDirectly([
            'vendor/Modules/ContactForm/js/contact.js',
        ]);
        page_title()->setTitle(trans('contactform::contact.edit'));
        $data = array();
        $data['title']        = 'contactform_edit';
        $data['record']        = $contactform;
//        $data['contact']        = $contactform;
        return view('contactform::contactform.create',$data);
    }

    public function update(int $id, EditContactRequest $request, DboardHttpResponse $response)
    {
        if (!auth()->user()->can('contactform_edit')) {
            abort(403, 'Unauthorized action.');
        }
        $contact = $this->contactRepository->findOrFail($id);

        $contact->fill($request->input());

        $this->contactRepository->createOrUpdate($contact);

        event(new UpdatedContentEvent(CONTACT_MODULE_SCREEN_NAME, $request, $contact));

        return $response
            ->setPreviousUrl(route('contactform.index'))
            ->setMessage(trans('kamruldashboard::notices.update_success_message'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  ContactForm\Http\Models\ContactForm  $contactform
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id, Request $request, DboardHttpResponse $response)
    {
        if (!auth()->user()->can('contactform_destroy')) {
            abort(403, 'Unauthorized action.');
        }
        try {
            $contact = $this->contactRepository->findOrFail($id);
            $this->contactRepository->delete($contact);
            event(new DeletedContentEvent(CONTACT_MODULE_SCREEN_NAME, $request, $contact));

            return $response->setMessage(trans('kamruldashboard::notices.delete_success_message'));
        } catch (Exception $exception) {
            return $response
                ->setError()
                ->setMessage($exception->getMessage());
        }
    }
    /**
     * @param Request $request
     * @param DboardHttpResponse $response
     * @return DboardHttpResponse
     * @throws \Exception
     */
    public function deletes(Request $request, DboardHttpResponse $response)
    {
        return $this->executeDeleteItems($request, $response, $this->contactRepository, CONTACT_MODULE_SCREEN_NAME);
    }

    public function postReply(
        int $id,
        ContactReplyRequest $request,
        DboardHttpResponse $response,
        ContactReplyInterface $contactReplyRepository
    ) {
        $contact = $this->contactRepository->findOrFail($id);

        EmailHandler::send($request->input('message'), 'Re: ' . $contact->subject, $contact->email);

        $contactReplyRepository->create([
            'message' => $request->input('message'),
            'contact_form_id' => $id,
        ]);

        $contact->status = ContactStatus::READ();
        $this->contactRepository->createOrUpdate($contact);

        return $response
            ->setMessage(trans('contactform::contact.message_sent_success'));
    }
}
