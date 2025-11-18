<?php

namespace Modules\Admission\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;
use Modules\Admission\Events\AdmissionContentEvent;
use Modules\Admission\Http\Models\Admission;
use Modules\Admission\Repositories\Interfaces\AdmissionInterface;
use Modules\KamrulDashboard\Events\DeletedContentEvent;
use Modules\KamrulDashboard\Events\UpdatedContentEvent;
use Modules\KamrulDashboard\Events\CreatedContentEvent;
use Modules\KamrulDashboard\Http\Responses\DboardHttpResponse;
use Modules\Admission\Http\Models\AdmissionMark;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Modules\KamrulDashboard\Traits\HasDeleteManyItemsTrait;
use Illuminate\Routing\Controller;
use Modules\Admission\Repositories\Interfaces\AdmissionMarkInterface;
use Modules\Admission\Http\Imports\AdmissionMarkImport;
use Modules\Admission\Tables\AdmissionMarkTable;
use mysql_xdevapi\Exception;
use Throwable;

class AdmissionMarkController extends Controller
{
    use HasDeleteManyItemsTrait;

    /**
     * @var AdmissionMarkInterface
     */
    protected $admissionmarkRepository;
    /**
     * @var AdmissionInterface
     */
    protected $admissionRepository;

    /**
     * AdmissionMarkController constructor.
     * @param AdmissionMarkInterface $admissionmarkRepository
     */
    public function __construct(AdmissionMarkInterface $admissionmarkRepository, AdmissionInterface $admissionRepository)
    {
        $this->admissionmarkRepository = $admissionmarkRepository;
        $this->admissionRepository = $admissionRepository;
    }

    protected $photo_path = 'uploads/admission/admissionmark/';

    /**
     * @param AdmissionMarkTable $dataTable
     * @return JsonResponse|View
     *
     * @throws Throwable
     */
    public function index(AdmissionMarkTable $dataTable)
    {
        if (!auth()->user()->can('admissionmark_access')) {
            abort(403, 'Unauthorized action.');
        }
        page_title()->setTitle(trans('admission::lang.admissionmark'));

        return $dataTable->renderTable();
    }

    public function import()
    {
        if (!auth()->user()->can('admissionmark_import')) {
            abort(403, 'Unauthorized action.');
        }
        page_title()->setTitle(trans('admission::lang.admissionmark_import'));
        $data = array();
        $data['title'] = 'admissionmark_import';
        return view('admission::admissionmark.create_import', $data);
    }

    public function store_import(Request $request)
    {
        if (!auth()->user()->can('admissionmark_import')) {
            abort(403, 'Unauthorized action.');
        }
        $file = $request->file('photo');
        Excel::import(new AdmissionMarkImport, $file);
        $response_data['status'] = 1;
        $response_data['message'] = __('admission::lang.record_save_successfully');
        return redirect()->route('admissionmark.index')->with('response_data', $response_data);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        if (!auth()->user()->can('admissionmark_create')) {
            abort(403, 'Unauthorized action.');
        }
        page_title()->setTitle(trans('admission::lang.admissionmark_create'));
        $data = array();
        $data['title'] = 'admissionmark_create';
        return view('admission::admissionmark.create', $data);
    }

    public function add_mark($class_id, $year_id)
    {
        if (!auth()->user()->can('admissionmark_create')) {
            abort(403, 'Unauthorized action.');
        }
        $admissionId = 27;

//        $admission = Admission::with('marks.subject.optionClass')->find($admissionId);

// Access the average mark for the admission
//        $averageMark = $admission->averageMark();
//        dd($averageMark);
//        $admission =Admission::find(27);
//        dd($admission->averageMark());
        $admission = $this->admissionRepository->advancedGet([
            'condition' => [
                'class' => $class_id,
                'year' => $year_id,
                ['roll', 'NOT_IN', 0],
            ],
            'order_by' => ['roll' => 'asc'],
//            'take'      => 1,
        ]);
        page_title()->setTitle(trans('admission::lang.admissionmark_create'));
        $data = array();
        $data['title'] = 'admissionmark_create';
//        $data['admission']        = $admission;
        $data['record'] = $admission;
        $data['class_id'] = $class_id;
        $data['year_id'] = $year_id;
        return view('admission::admissionmark.add_mark', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param DboardHttpResponse $response
     * @return DboardHttpResponse
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, DboardHttpResponse $response)
    {
        if (!auth()->user()->can('admissionmark_create')) {
            abort(403, 'Unauthorized action.');
        }
        $validated = $request->validate([
//            'name'              => 'bail|required|max:255',
            'mark.*.*'        => 'required|numeric|min:0|max:100',
        ]);

        $mark = $request->input('mark');
        $class_id = $request->input('class_id');
        $year_id = $request->input('year_id');
        $mark_array = [];
        $admission_id = $request->input('admission_id');
//        try {
//        dd($mark);
            foreach ($mark as $outerKey => $innerArray) {
                foreach ($innerArray as $Key => $value) {
                    if ($value == null) {
                        $value = 0;
                    }
                    $id = $admission_id[$outerKey][$Key];
                    if ($id) {
                        $mark_array['id'] = $admission_id[$outerKey][$Key];
                    }
                    $record = $this->admissionmarkRepository->createOrUpdate([
                        'admission_subjects_id' => $outerKey,
                        'admissions_id' => $Key,
                        'mark' => $value,
                        'user_id' => Auth::id(),
                    ], $mark_array);
                }
            }
            event(new AdmissionContentEvent(ADMISSIONMARK_MODULE_SCREEN_NAME, $request, $record, $mark[1]));
            event(new CreatedContentEvent(ADMISSIONMARK_MODULE_SCREEN_NAME, $request, $record));
            return $response
                ->setPreviousUrl(route('get-student-list', [$class_id, $year_id]))
                ->setNextUrl(route('admissionmark.mark', [$class_id, $year_id]))
                ->setMessage(trans('kamruldashboard::notices.create_success_message'));
//        } catch (\Exception $e) {
//            return $response
//                ->setPreviousUrl(route('admissionmark.index'))
//                ->setMessage(trans('kamruldashboard::notices.something_error_please_try_again_later'));
//        }
    }

    /**
     * Show the specified resource.
     * @param \Modules\Admission\Http\Models\AdmissionMark $admissionmark
     * @return \Illuminate\Http\Response
     */
    public function show(AdmissionMark $admissionmark)
    {
        if (!auth()->user()->can('admissionmark_show')) {
            abort(403, 'Unauthorized action.');
        }
        page_title()->setTitle(trans('admission::lang.admissionmark_show'));
        $data = array();
        $data['admissionmark'] = $admissionmark;
        $data['title'] = 'admissionmark_show';
        return view('admission::admissionmark.show', $data);
    }

    /**
     * Show the specified resource.
     * @param \Modules\Admission\Http\Models\AdmissionMark $admissionmark
     * @return \Illuminate\Http\Response
     */
    public function pdf(AdmissionMark $admissionmark)
    {
        if (!auth()->user()->can('admissionmark_pdf')) {
            abort(403, 'Unauthorized action.');
        }
        page_title()->setTitle(trans('admission::lang.admissionmark_show'));
        $data = array();
        $data['admissionmark'] = $admissionmark;
        $data['title'] = 'admissionmark_show';
        return view('admission::admissionmark.pdf', $data);
    }

    /**
     * Show the form for editing the specified resource.
     * @param \Modules\Admission\Http\Models\AdmissionMark $admissionmark
     * @return \Illuminate\Http\Response
     */
    public function edit(AdmissionMark $admissionmark)
    {
        if (!auth()->user()->can('admissionmark_edit')) {
            abort(403, 'Unauthorized action.');
        }
        page_title()->setTitle(trans('admission::lang.admissionmark_edit'));
        $data = array();
        $data['title'] = 'admissionmark_edit';
        $data['record'] = $this->admissionmarkRepository->findOrFail($admissionmark->id);
        return view('admission::admissionmark.create', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Modules\Admission\Http\Models\AdmissionMark $admissionmark
     * @param DboardHttpResponse $response
     * @return DboardHttpResponse
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AdmissionMark $admissionmark, DboardHttpResponse $response)
    {
        if (!auth()->user()->can('admissionmark_edit')) {
            abort(403, 'Unauthorized action.');
        }
        $validated = $request->validate([
            'name' => 'bail|required|max:255',
        ]);

        $id = $admissionmark->id;
        $admissionmark = $this->admissionmarkRepository->firstOrNew(compact('id'));
        $admissionmark->fill($request->input());
        $this->admissionmarkRepository->createOrUpdate($admissionmark);

        $file_name = 'photo';
        if ($request->hasFile($file_name)) {
//            return $file_name;
            $rules = $request->validate([
                "$file_name" => 'mimes:jpeg,jpg,png,gif|max:10000'
            ]);
            $path = $this->photo_path;
            deleteFile($admissionmark->$file_name, $path);

            $admissionmark->$file_name = processUpload($request, $admissionmark, $file_name, $path);
            $admissionmark->save();
        }

        event(new UpdatedContentEvent(ADMISSIONMARK_MODULE_SCREEN_NAME, $request, $admissionmark));

        return $response
            ->setPreviousUrl(route('admissionmark.index'))
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
        if (!auth()->user()->can('admissionmark_destroy')) {
            abort(403, 'Unauthorized action.');
        }
        try {

            $admissionmark = $this->admissionmarkRepository->findOrFail($id);
            $this->admissionmarkRepository->delete($admissionmark);
            $path = $this->photo_path;
            deleteFile($admissionmark->photo, $path);
            event(new DeletedContentEvent(ADMISSIONMARK_MODULE_SCREEN_NAME, $request, $admissionmark));

            return $response->setMessage(trans('kamruldashboard::notices.delete_success_message'));
        } catch (\Exception $e) {
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
        return $this->executeDeleteItems($request, $response, $this->admissionmarkRepository, ADMISSIONMARK_MODULE_SCREEN_NAME);
    }
}
