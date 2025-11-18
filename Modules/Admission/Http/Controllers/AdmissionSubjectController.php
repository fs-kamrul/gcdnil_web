<?php

namespace Modules\Admission\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;
use Modules\Admission\Http\Requests\AdmissionSubjectRequest;
use Modules\KamrulDashboard\Events\DeletedContentEvent;
use Modules\KamrulDashboard\Events\UpdatedContentEvent;
use Modules\KamrulDashboard\Events\CreatedContentEvent;
use Modules\KamrulDashboard\Http\Responses\DboardHttpResponse;
use Modules\Admission\Http\Models\AdmissionSubject;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Modules\KamrulDashboard\Traits\HasDeleteManyItemsTrait;
use Illuminate\Routing\Controller;
use Modules\Admission\Repositories\Interfaces\AdmissionSubjectInterface;
use Modules\Admission\Http\Imports\AdmissionSubjectImport;
use Modules\Admission\Tables\AdmissionSubjectTable;
use mysql_xdevapi\Exception;
use Throwable;

class AdmissionSubjectController extends Controller
{
    use HasDeleteManyItemsTrait;
    /**
     * @var AdmissionSubjectInterface
     */
    protected $admissionsubjectRepository;

    /**
     * AdmissionSubjectController constructor.
     * @param AdmissionSubjectInterface $admissionsubjectRepository
     */
    public function __construct(AdmissionSubjectInterface $admissionsubjectRepository)
    {
        $this->admissionsubjectRepository = $admissionsubjectRepository;
    }
    protected $photo_path = 'uploads/admission/admissionsubject/';

    /**
     * @param AdmissionSubjectTable $dataTable
     * @return JsonResponse|View
     *
     * @throws Throwable
     */
    public function index(AdmissionSubjectTable $dataTable)
    {
        if (!auth()->user()->can('admissionsubject_access')) {
            abort(403, 'Unauthorized action.');
        }
        page_title()->setTitle(trans('admission::lang.admissionsubject'));

        return $dataTable->renderTable();
    }

    public function import()
    {
        if (!auth()->user()->can('admissionsubject_import')) {
            abort(403, 'Unauthorized action.');
        }
        page_title()->setTitle(trans('admission::lang.admissionsubject_import'));
        $data = array();
        $data['title']        = 'admissionsubject_import';
        return view('admission::admissionsubject.create_import',$data);
    }
    public function store_import(Request $request)
    {
        if (!auth()->user()->can('admissionsubject_import')) {
            abort(403, 'Unauthorized action.');
        }
        $file = $request->file('photo');
        Excel::import(new AdmissionSubjectImport, $file);
        $response_data['status'] = 1;
        $response_data['message'] =  __('admission::lang.record_save_successfully');
        return redirect()->route('admissionsubject.index')->with('response_data', $response_data);
    }
    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        if (!auth()->user()->can('admissionsubject_create')) {
            abort(403, 'Unauthorized action.');
        }
        page_title()->setTitle(trans('admission::lang.admissionsubject_create'));
        $data = array();
        $data['title']        = 'admissionsubject_create';
        return view('admission::admissionsubject.create',$data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param DboardHttpResponse $response
     * @return DboardHttpResponse
     * @return \Illuminate\Http\Response
     */
    public function store(AdmissionSubjectRequest $request, DboardHttpResponse $response)
    {
        if (!auth()->user()->can('admissionsubject_create')) {
            abort(403, 'Unauthorized action.');
        }
//        $validated = $request->validate([
//            'name'              => 'bail|required|max:255',
//            'total_mark'        => 'required|numeric|min:0|max:100',
//        ]);

        try {
            $record = $this->admissionsubjectRepository->createOrUpdate(array_merge($request->input(), [
                'user_id' => Auth::id(),
                'uuid'    => gen_uuid(),
                'slug'    => checkSlugFunction($request->input('name')),
            ]));

            $file_name = 'photo';
            if ($request->hasFile($file_name))
            {
//                return $file_name;
                $rules = $request->validate([
                    "$file_name" => 'mimes:jpeg,jpg,png,gif|max:10000'
                ]);
                $path = $this->photo_path;
                deleteFile($record->$file_name, $path);

                $record->$file_name      = processUpload($request, $record,$file_name, $path);
                $record->save();
            }
            event(new CreatedContentEvent(ADMISSIONSUBJECT_MODULE_SCREEN_NAME, $request, $record));

            return $response
                ->setPreviousUrl(route('admissionsubject.index'))
                ->setNextUrl(route('admissionsubject.edit', $record->id))
                ->setMessage(trans('kamruldashboard::notices.create_success_message'));
        }catch (\Exception $e){

            return $response
                ->setPreviousUrl(route('admissionsubject.index'))
                ->setMessage(trans('kamruldashboard::notices.something_error_please_try_again_later'));
        }
    }

    /**
     * Show the specified resource.
     * @param  \Modules\Admission\Http\Models\AdmissionSubject  $admissionsubject
     * @return \Illuminate\Http\Response
     */
    public function show(AdmissionSubject $admissionsubject)
    {
        if (!auth()->user()->can('admissionsubject_show')) {
            abort(403, 'Unauthorized action.');
        }
        page_title()->setTitle(trans('admission::lang.admissionsubject_show'));
        $data = array();
        $data['admissionsubject']        = $admissionsubject;
        $data['title']        = 'admissionsubject_show';
        return view('admission::admissionsubject.show',$data);
    }
    /**
     * Show the specified resource.
     * @param  \Modules\Admission\Http\Models\AdmissionSubject  $admissionsubject
     * @return \Illuminate\Http\Response
     */
    public function pdf(AdmissionSubject $admissionsubject)
    {
        if (!auth()->user()->can('admissionsubject_pdf')) {
            abort(403, 'Unauthorized action.');
        }
        page_title()->setTitle(trans('admission::lang.admissionsubject_show'));
        $data = array();
        $data['admissionsubject']        = $admissionsubject;
        $data['title']        = 'admissionsubject_show';
        return view('admission::admissionsubject.pdf',$data);
    }

    /**
     * Show the form for editing the specified resource.
     * @param  \Modules\Admission\Http\Models\AdmissionSubject  $admissionsubject
     * @return \Illuminate\Http\Response
     */
    public function edit(AdmissionSubject $admissionsubject)
    {
        if (!auth()->user()->can('admissionsubject_edit')) {
            abort(403, 'Unauthorized action.');
        }
        page_title()->setTitle(trans('admission::lang.admissionsubject_edit'));
        $data = array();
        $data['title']        = 'admissionsubject_edit';
        $data['record']        = $this->admissionsubjectRepository->findOrFail($admissionsubject->id);
        return view('admission::admissionsubject.create',$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Modules\Admission\Http\Models\AdmissionSubject  $admissionsubject
     * @param  DboardHttpResponse  $response
     * @return DboardHttpResponse
     * @return \Illuminate\Http\Response
     */
    public function update(AdmissionSubjectRequest $request, AdmissionSubject  $admissionsubject, DboardHttpResponse $response)
    {
        if (!auth()->user()->can('admissionsubject_edit')) {
            abort(403, 'Unauthorized action.');
        }
//        $validated = $request->validate([
//            'name'              => 'bail|required|max:255',
//        ]);

        $id = $admissionsubject->id;
        $admissionsubject = $this->admissionsubjectRepository->firstOrNew(compact('id'));
        $admissionsubject->fill($request->input());
        $this->admissionsubjectRepository->createOrUpdate($admissionsubject);

        $file_name = 'photo';
        if ($request->hasFile($file_name))
        {
//            return $file_name;
            $rules = $request->validate([
                "$file_name" => 'mimes:jpeg,jpg,png,gif|max:10000'
            ]);
            $path = $this->photo_path;
            deleteFile($admissionsubject->$file_name, $path);

            $admissionsubject->$file_name      = processUpload($request, $admissionsubject,$file_name,$path);
            $admissionsubject->save();
        }

        event(new UpdatedContentEvent(ADMISSIONSUBJECT_MODULE_SCREEN_NAME, $request, $admissionsubject));

        return $response
            ->setPreviousUrl(route('admissionsubject.index'))
            ->setMessage(trans('kamruldashboard::notices.update_success_message'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @param int $id
     * @param DboardHttpResponse $response
     * @return DboardHttpResponse
     */
    public function destroy(Request $request, $id, DboardHttpResponse $response)
    {
        if (!auth()->user()->can('admissionsubject_destroy')) {
            abort(403, 'Unauthorized action.');
        }
        try{

            $admissionsubject = $this->admissionsubjectRepository->findOrFail($id);
            $this->admissionsubjectRepository->delete($admissionsubject);
            $path = $this->photo_path;
            deleteFile($admissionsubject->photo, $path);
            event(new DeletedContentEvent(ADMISSIONSUBJECT_MODULE_SCREEN_NAME, $request, $admissionsubject));

            return $response->setMessage(trans('kamruldashboard::notices.delete_success_message'));
        } catch ( \Exception $e) {
            return $response
                ->setError()
                ->setMessage($e->getMessage());
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
        return $this->executeDeleteItems($request, $response, $this->admissionsubjectRepository, ADMISSIONSUBJECT_MODULE_SCREEN_NAME);
    }
}
