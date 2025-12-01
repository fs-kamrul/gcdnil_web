<?php

namespace Modules\Admission\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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

class AdmissionMigrationController extends Controller
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

    public function add_migration($class_id, $year_id)
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
//                ['roll', 'NOT_IN', 0],
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
        return view('admission::admissionmigration.add_migration', $data);
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
//        $data = array();
//        $datap = array();
        $class_id = $request->input('class_id');
        $year_id = $request->input('year_id');

        $admissions = $this->admissionRepository->advancedGet([
            'condition' => [
                'class' => $class_id,
                'year' => $year_id,
//                ['roll', 'NOT_IN', 0],
            ],
            'order_by' => ['roll' => 'asc'],
//            'take'      => 1,
        ]);
        foreach ($admissions as $admission) {
            $data = [
                'id' => $admission->student_id,
                'password' => md5('123456'),
                'name' => $admission->name,
                'bl_name' => $admission->bl_name,                           // bl_name
                'email' => $admission->email,
                'stu_phone' => $admission->phone,
                'photo' => 'images/upload/students/'. $admission->classes->name . '/' . $admission->photo,
                'nationality' => $admission->nationalities->name ?? Null,
                'birth_registration_number' => $admission->birth_registration,
                'roll' => $admission->roll ?? 0,
                'father_name' => $admission->father_name,
                'bl_father_name' => $admission->bl_father_name,             // bl_father_name
                'father_phone' => $admission->father_phone,
                'mother_name' => $admission->mother_nane,
                'bl_mother_name' => $admission->bl_mother_nane,             // bl_mother_name
                'mobile_number' => $admission->mother_phone,
                'birth_bate' => $admission->dob,
                'blood_group' => $admission->blood_groups->name ?? Null,
                'religion' => $admission->religions->name ?? Null,
                'gender' => $admission->genders->name ?? Null,
                'class' => $admission->classes->name ?? Null,
                'year' => $admission->years->name ?? Null,
                'group_r' => $admission->admission_groups->name ?? Null,
//                'admission_group' => $admission->admission_groups->name ?? Null,
                'pre_institution' => $admission->pre_institution,           // pre_institution
                'pre_class' => $admission->pre_classes->name ?? Null,       // pre_class
                'pre_gpa' => $admission->pre_gpa,                           // pre_gpa
                'ssc_board' => $admission->ssc_board,                       // ssc_board
                'ssc_year' => $admission->ssc_years->name ?? Null,          // ssc_year
                'ssc_roll' => $admission->ssc_roll,                         //ssc_roll
                'ssc_group' => $admission->ssc_groups->name ?? Null,        //ssc_group
                'ssc_registration' => $admission->ssc_registration,         //ssc_registration
                'ssc_gpa' => $admission->ssc_gpa,                           //ssc_gpa
                'ssc_transcript' => $admission->ssc_transcript,             //ssc_transcript
                'ssc_testimonial' => $admission->ssc_testimonial,           //ssc_testimonial

                'village' => $admission->pre_address,
                'post' => $admission->pre_postcode,
                'zip_code' => $admission->pre_postcode,
                'country' => $admission->pre_countrys->name ?? Null,
                'division' => $admission->pre_statess->name ?? Null,
                'district' => $admission->pre_citys->name ?? Null,
//                'sub_district' => $admission->psub_district,

                'per_address' => $admission->per_address,                   //per_address
                'per_postcode' => $admission->per_postcode,                 //per_postcode
                'per_country' => $admission->per_countrys->name ?? Null,    //per_country
                'per_states' => $admission->per_statess->name ?? Null,      //per_states
                'per_city' => $admission->per_citys->name ?? Null,          //per_city
                'loc_name' => $admission->loc_name,                         //loc_name
                'loc_phone' => $admission->loc_phone,                       //loc_phone
                'loc_relation' => $admission->loc_relation,                 //loc_relation
                'loc_address' => $admission->loc_address,                   // loc_address
                'loc_postcode' => $admission->loc_postcode,                 // loc_postcode
                'payment_amount' => $admission->payment_amount,             // payment_amount
                'payment_status' => $admission->payment_status,             // payment_status
                'admission_merits_id' => $admission->admission_merits_id,   // admission_merits_id
                'mark' => $admission->mark,                                 // mark
                'tex_id' => $admission->tex_id,                             // tex_id

//                'village' => $admission->student_id,
//                'post' => $admission->student_id,
//                'sub_district' => $admission->student_id,
//                'district' => $admission->student_id,
//                'division' => $admission->student_id,
//                'country' => $admission->student_id,
//                'zip_code' => $admission->student_id,
            ];
            $datap = [
                'roll' => $admission->roll ?? 0,
                'class' => $admission->classes->name ?? Null,
                'section' => 'A',
                'group_r' => $admission->admission_groups->name ?? Null,
                'year' => $admission->years->name ?? Null,
            ];
//            dd($data);
            // ======================================================
            //   INSERT INTO SECOND DATABASE anik_school_manesment_kpg
            // ======================================================

            DB::connection('anik')->beginTransaction();

            try {

                // ---------------- CHECK IF STUDENT EXISTS ----------------
                $exist = DB::connection('anik')
                    ->table('student_information')
                    ->where('id', $admission->student_id)
                    ->first();

//                dd($exist);
                if ($exist) {
                    $reg_id = $exist->reg_id;  // Existing reg_id
                } else {
                    // ---------------- INSERT student_information ----------------
                    $reg_id = DB::connection('anik')
                        ->table('student_information')
                        ->insertGetId($data);  // Auto increment reg_id
                }

                // ---------------- INSERT tbl_all_registration_info ----------------
                $datap['reg_id'] = $reg_id; // foreign key mapping

//                dd($datap);
                DB::connection('anik')
                    ->table('tbl_all_registration_info')
                    ->insert($datap);

                DB::connection('anik')->commit();

//                dd($datap);
            } catch (\Exception $e) {

                DB::connection('anik')->rollBack();

                return $response
                    ->setPreviousUrl(route('admissionmigration', [$class_id, $year_id]))
                    ->setMessage($e->getMessage());
//                    ->setMessage(trans('kamruldashboard::notices.something_error_please_try_again_later'));
//                return back()->with('error', 'Error inserting into secondary DB: '.$e->getMessage());
            }
        }
//        dd($datap);
//        dd($data);
//            event(new AdmissionContentEvent(ADMISSIONMARK_MODULE_SCREEN_NAME, $request, $record, $mark[1]));
//            event(new CreatedContentEvent(ADMISSIONMARK_MODULE_SCREEN_NAME, $request, $record));
            return $response
                ->setPreviousUrl(route('get-student-list', [$class_id, $year_id]))
                ->setNextUrl(route('admissionmigration', [$class_id, $year_id]))
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
