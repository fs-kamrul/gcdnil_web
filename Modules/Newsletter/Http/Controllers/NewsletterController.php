<?php

namespace Modules\Newsletter\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;
use Modules\KamrulDashboard\Events\DeletedContentEvent;
use Modules\KamrulDashboard\Http\Responses\DboardHttpResponse;
use Modules\KamrulDashboard\Traits\HasDeleteManyItemsTrait;
use Modules\Newsletter\Http\Models\Newsletter;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Newsletter\Http\packages\NewsletterStatus;
use Modules\Newsletter\Repositories\Interfaces\NewsletterInterface;
use Modules\Newsletter\Http\Imports\NewsletterImport;
use Modules\Newsletter\Tables\NewsletterTable;
use Throwable;
use Exception;

class NewsletterController extends Controller
{
    use HasDeleteManyItemsTrait;
    /**
     * @var NewsletterInterface
     */
    protected $newsletterRepository;

    /**
     * NewsletterController constructor.
     * @param NewsletterInterface $newsletterRepository
     */
    public function __construct(NewsletterInterface $newsletterRepository)
    {
        $this->newsletterRepository = $newsletterRepository;
    }
    protected $photo_path = 'uploads/newsletter/';

    /**
     * @param NewsletterTable $dataTable
     * @return JsonResponse|View
     *
     * @throws Throwable
     */
    public function index(NewsletterTable $dataTable)
    {
        if (!auth()->user()->can('newsletter_access')) {
            abort(403, 'Unauthorized action.');
        }
        page_title()->setTitle(trans('newsletter::lang.newsletter'));

        return $dataTable->renderTable();
//        $data = array();
//        $data['title']        = 'newsletter';
//        return view('newsletter::newsletter.index',$data);
    }

    public function import()
    {
        if (!auth()->user()->can('newsletter_import')) {
            abort(403, 'Unauthorized action.');
        }
        $data = array();
        $data['title']        = 'newsletter_import';
        return view('newsletter::newsletter.create_import',$data);
    }
    public function store_import(Request $request)
    {
        if (!auth()->user()->can('newsletter_import')) {
            abort(403, 'Unauthorized action.');
        }
        $file = $request->file('photo');
        Excel::import(new NewsletterImport, $file);
        $response_data['status'] = 1;
        $response_data['message'] =  __('newsletter::lang.record_save_successfully');
        return redirect()->route('newsletter.index')->with('response_data', $response_data);
    }
    public function data()
    {
        if (!auth()->user()->can('newsletter_access')) {
            abort(403, 'Unauthorized action.');
        }
        if(auth()->user()->can('newsletter_list_all')) {
            $custom_table = Newsletter::all();
        }else {
            $custom_table = Newsletter::where('user_id', Auth::id())->get();
        }
        return datatables()->of($custom_table)->addColumn('action', function ($row) {
            $html = '';
//            if(auth()->user()->can('newsletter_pdf')) {
//                $html .= '<a target="_blank" href="' . route('newsletter.pdf_show', $row->id) . '" class="btn btn-xs btn-success">' . __('newsletter::lang.pdf') . '</a> ';
//            }
//            if(auth()->user()->can('newsletter_show')) {
//                $html .= '<a href="' . route('newsletter.show', $row->id) . '" class="btn btn-xs btn-success">' . __('newsletter::lang.view') . '</a> ';
//            }
//            if(auth()->user()->can('newsletter_edit')) {
//                $html .= '<a  href="' . route('newsletter.edit', $row->id) . '" class="btn btn-xs btn-secondary">' . __('newsletter::lang.edit') . '</a> ';
//            }
            if(auth()->user()->can('newsletter_destroy')) {
                $html .= '<form action="' . route('newsletter.destroy', $row->id) . '" method="POST" style="display: inline-block;">
                        ' . csrf_field() . '
                        ' . method_field("DELETE") . '
                        <button type="submit" class="btn btn-xs btn-danger"
                            onclick="return confirm(\'Are You Sure Want to Delete?\')"
                            style="padding: .0em !important;"><i class="icon-trash"> </i>' . __('newsletter::lang.delete') . '</button>
                        </form>';
            }
            return $html;
        })->addColumn('status', function ($row) {
            $html = array_status_set_value($row->status,NewsletterStatus::DATA);
            return $html;
        })->rawColumns(['action','status'])->toJson();;
    }
    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        if (!auth()->user()->can('newsletter_create')) {
            abort(403, 'Unauthorized action.');
        }
        $data = array();
        $data['title']        = 'newsletter_create';
        return view('newsletter::newsletter.create',$data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!auth()->user()->can('newsletter_create')) {
            abort(403, 'Unauthorized action.');
        }
        $validated = $request->validate([
            'email'              => 'required', 'string', 'email', 'max:255',
        ]);

        try {
            $record = $this->newsletterRepository->createOrUpdate($request->input());
//            $record             = $this->newsletterRepository->getModel();
//            $record->fill($request->input());
//            $record             = $this->newsletterRepository->createOrUpdate($record);

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
            $response_data['message'] =  __('newsletter::lang.record_save_successfully');
            return redirect()->route('newsletter.index')->with('response_data', $response_data);
        }catch (Exception $e){

            $response_data['status'] = 0;
            $response_data['message'] =  __('newsletter::lang.something_error_please_try_again_later');
            return redirect()->route('newsletter.index')->with('response_data', $response_data);
        }
    }

    /**
     * Show the specified resource.
     * @param  Newsletter\Http\Models\Newsletter  $newsletter
     * @return \Illuminate\Http\Response
     */
    public function show(Newsletter $newsletter)
    {
        if (!auth()->user()->can('newsletter_show')) {
            abort(403, 'Unauthorized action.');
        }
        $data = array();
        $data['newsletter']        = $newsletter;
        $data['title']        = 'newsletter_show';
        return view('newsletter::newsletter.show',$data);
    }
    /**
     * Show the specified resource.
     * @param  Newsletter\Http\Models\Newsletter  $newsletter
     * @return \Illuminate\Http\Response
     */
    public function pdf(Newsletter $newsletter)
    {
        if (!auth()->user()->can('newsletter_pdf')) {
            abort(403, 'Unauthorized action.');
        }
        $data = array();
        $data['newsletter']        = $newsletter;
        $data['title']        = 'newsletter_show';
        return view('newsletter::newsletter.pdf',$data);
    }

    /**
     * Show the form for editing the specified resource.
     * @param  Newsletter\Http\Models\Newsletter  $newsletter
     * @return \Illuminate\Http\Response
     */
    public function edit(Newsletter $newsletter)
    {
        if (!auth()->user()->can('newsletter_edit')) {
            abort(403, 'Unauthorized action.');
        }
        $data = array();
        $data['title']        = 'newsletter_edit';
        $data['record']        = $newsletter;
        return view('newsletter::newsletter.create',$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Newsletter\Http\Models\Newsletter  $newsletter
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Newsletter  $newsletter)
    {
        if (!auth()->user()->can('newsletter_edit')) {
            abort(403, 'Unauthorized action.');
        }
        $validated = $request->validate([
            'name'              => 'bail|required|max:255',
        ]);

        $id = $newsletter->id;
        $newsletter = $this->newsletterRepository->firstOrNew(compact('id'));
        $newsletter->fill($request->input());
        $this->newsletterRepository->createOrUpdate($newsletter);

        $file_name = 'photo';
        if ($request->hasFile($file_name))
        {
//            return $file_name;
            $rules = $request->validate([
                "$file_name" => 'mimes:jpeg,jpg,png,gif|max:10000'
            ]);
            $path = $this->photo_path;
            deleteFile($newsletter->photo, $path);

            $newsletter->$file_name      = processUpload($request, $newsletter,$file_name,$path);
            $newsletter->save();
        }

        $response_data['status'] = 1;
        $response_data['message'] =  __('newsletter::lang.record_update_successfully');
        return redirect()->route('newsletter.index')->with('response_data', $response_data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Newsletter\Http\Models\Newsletter  $newsletter
     * @return \Illuminate\Http\Response
     */

    public function destroy(Request $request, int $id, DboardHttpResponse $response)
    {
        try {
            $newsletter = $this->newsletterRepository->findOrFail($id);
            $this->newsletterRepository->delete($newsletter);

            event(new DeletedContentEvent(NEWSLETTER_MODULE_SCREEN_NAME, $request, $newsletter));

            return $response->setMessage(trans('kamruldashboard::notices.delete_success_message'));
        } catch (Exception $exception) {
            return $response
                ->setError()
                ->setMessage($exception->getMessage());
        }
    }
//    public function destroy(Newsletter  $newsletter)
//    {
//        if (!auth()->user()->can('newsletter_destroy')) {
//            abort(403, 'Unauthorized action.');
//        }
//        try{
//            $newsletter->delete();
////            event(new DeletedContentEvent(NEWSLETTER_MODULE_SCREEN_NAME, $request, $newsletter));
//            $path = $this->photo_path;
//            deleteFile($newsletter->photo, $path);
//            $response_data['status'] = 1;
//            $response_data['message'] =  __('newsletter::lang.record_deleted_successfully');
//        } catch ( \Exception $e) {
//            $response_data['status'] = 0;
//            $response_data['message'] =  __('newsletter::lang.this_record_is_in_use_in_other_modules');
//        }
//        return redirect()->route('newsletter.index')->with('response_data', $response_data);
//    }
    /**
     * @param Request $request
     * @param DboardHttpResponse $response
     * @return DboardHttpResponse
     * @throws \Exception
     */
    public function deletes(Request $request, DboardHttpResponse $response)
    {
        return $this->executeDeleteItems($request, $response, $this->newsletterRepository, SITE_MODULE_SCREEN_NAME);
    }
}
