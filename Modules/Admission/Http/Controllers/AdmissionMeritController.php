<?php

namespace Modules\Admission\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;
use Modules\KamrulDashboard\Events\DeletedContentEvent;
use Modules\KamrulDashboard\Events\UpdatedContentEvent;
use Modules\KamrulDashboard\Events\CreatedContentEvent;
use Modules\KamrulDashboard\Http\Responses\DboardHttpResponse;
use Modules\Admission\Http\Models\AdmissionMerit;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Modules\KamrulDashboard\Traits\HasDeleteManyItemsTrait;
use Illuminate\Routing\Controller;
use Modules\Admission\Repositories\Interfaces\AdmissionMeritInterface;
use Modules\Admission\Http\Imports\AdmissionMeritImport;
use Modules\Admission\Tables\AdmissionMeritTable;
use mysql_xdevapi\Exception;
use Throwable;

class AdmissionMeritController extends Controller
{
    use HasDeleteManyItemsTrait;
    /**
     * @var AdmissionMeritInterface
     */
    protected $admissionmeritRepository;

    /**
     * AdmissionMeritController constructor.
     * @param AdmissionMeritInterface $admissionmeritRepository
     */
    public function __construct(AdmissionMeritInterface $admissionmeritRepository)
    {
        $this->admissionmeritRepository = $admissionmeritRepository;
    }
    protected $photo_path = 'uploads/admission/admissionmerit/';

    /**
     * @param AdmissionMeritTable $dataTable
     * @return JsonResponse|View
     *
     * @throws Throwable
     */
    public function index(AdmissionMeritTable $dataTable)
    {
        if (!auth()->user()->can('admissionmerit_access')) {
            abort(403, 'Unauthorized action.');
        }
        page_title()->setTitle(trans('admission::lang.admissionmerit'));

        return $dataTable->renderTable();
    }

    public function import()
    {
        if (!auth()->user()->can('admissionmerit_import')) {
            abort(403, 'Unauthorized action.');
        }
        page_title()->setTitle(trans('admission::lang.admissionmerit_import'));
        $data = array();
        $data['title']        = 'admissionmerit_import';
        return view('admission::admissionmerit.create_import',$data);
    }
    public function store_import(Request $request)
    {
        if (!auth()->user()->can('admissionmerit_import')) {
            abort(403, 'Unauthorized action.');
        }
        $file = $request->file('photo');
        Excel::import(new AdmissionMeritImport, $file);
        $response_data['status'] = 1;
        $response_data['message'] =  __('admission::lang.record_save_successfully');
        return redirect()->route('admissionmerit.index')->with('response_data', $response_data);
    }
    public function data()
    {
        if (!auth()->user()->can('admissionmerit_access')) {
            abort(403, 'Unauthorized action.');
        }
        if(auth()->user()->can('admissionmerit_list_all')) {
            $custom_table = AdmissionMerit::all();
        }else {
            $custom_table = AdmissionMerit::where('user_id', Auth::id())->get();
        }
        return datatables()->of($custom_table)->addColumn('action', function ($row) {
            $html = '';
            if(auth()->user()->can('admissionmerit_pdf')) {
                $html .= '<a target="_blank" href="' . url('admission/admissionmerit/pdf_show', $row->id) . '" class="btn btn-xs btn-success">' . __('admission::lang.pdf') . '</a> ';
            }
            if(auth()->user()->can('admissionmerit_show')) {
                $html .= '<a href="' . url('admission/admissionmerit/' . $row->id) . '" class="btn btn-xs btn-success">' . __('admission::lang.view') . '</a> ';
            }
            if(auth()->user()->can('admissionmerit_edit')) {
                $html .= '<a  href="' . url('admission/admissionmerit/' . $row->id . "/edit") . '" class="btn btn-xs btn-secondary">' . __('admission::lang.edit') . '</a> ';
            }
            if(auth()->user()->can('admissionmerit_destroy')) {
                $html .= '<form action="' . url('admission/admissionmerit', $row->id) . '" method="POST" style="display: inline-block;">
                            ' . csrf_field() . '
                            ' . method_field("DELETE") . '
                            <button type="submit" class="btn btn-xs btn-danger"
                                onclick="return confirm(\'Are You Sure Want to Delete?\')"
                                style="padding: .0em !important;"><i class="icon-trash"> </i>' . __('admission::lang.delete') . '</button>
                            </form>';
            }
            return $html;
        })->addColumn('photo', function ($row) {
            $html = '<img style="height: 100px;width: 100px;" src="' . getImageUrl($row->photo,'admission/admissionmerit') . '" alt="' . $row->name . '" class="img-rounded img-preview">';
            return $html;
        })->addColumn('status', function ($row) {
            $html = array_status_disign($row->status);
            return $html;
        })->addColumn('user', function ($row) {
            $html = $row->user->name;
            return $html;
        })->rawColumns(['action','status','photo','user'])->toJson();;
    }
    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        if (!auth()->user()->can('admissionmerit_create')) {
            abort(403, 'Unauthorized action.');
        }
        page_title()->setTitle(trans('admission::lang.admissionmerit_create'));
        $data = array();
        $data['title']        = 'admissionmerit_create';
        return view('admission::admissionmerit.create',$data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param DboardHttpResponse $response
     * @return DboardHttpResponse
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, DboardHttpResponse $response)
    {
        if (!auth()->user()->can('admissionmerit_create')) {
            abort(403, 'Unauthorized action.');
        }
        $validated = $request->validate([
            'name'              => 'bail|required|max:255',
        ]);

        try {
            $record = $this->admissionmeritRepository->createOrUpdate(array_merge($request->input(), [
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
            event(new CreatedContentEvent(ADMISSIONMERIT_MODULE_SCREEN_NAME, $request, $record));

            return $response
                ->setPreviousUrl(route('admissionmerit.index'))
                ->setNextUrl(route('admissionmerit.edit', $record->id))
                ->setMessage(trans('kamruldashboard::notices.create_success_message'));
        }catch (\Exception $e){

            return $response
                ->setPreviousUrl(route('admissionmerit.index'))
                ->setMessage(trans('kamruldashboard::notices.something_error_please_try_again_later'));
        }
    }

    /**
     * Show the specified resource.
     * @param  \Modules\Admission\Http\Models\AdmissionMerit  $admissionmerit
     * @return \Illuminate\Http\Response
     */
    public function show(AdmissionMerit $admissionmerit)
    {
        if (!auth()->user()->can('admissionmerit_show')) {
            abort(403, 'Unauthorized action.');
        }
        page_title()->setTitle(trans('admission::lang.admissionmerit_show'));
        $data = array();
        $data['admissionmerit']        = $admissionmerit;
        $data['title']        = 'admissionmerit_show';
        return view('admission::admissionmerit.show',$data);
    }
    /**
     * Show the specified resource.
     * @param  \Modules\Admission\Http\Models\AdmissionMerit  $admissionmerit
     * @return \Illuminate\Http\Response
     */
    public function pdf(AdmissionMerit $admissionmerit)
    {
        if (!auth()->user()->can('admissionmerit_pdf')) {
            abort(403, 'Unauthorized action.');
        }
        page_title()->setTitle(trans('admission::lang.admissionmerit_show'));
        $data = array();
        $data['admissionmerit']        = $admissionmerit;
        $data['title']        = 'admissionmerit_show';
        return view('admission::admissionmerit.pdf',$data);
    }

    /**
     * Show the form for editing the specified resource.
     * @param  \Modules\Admission\Http\Models\AdmissionMerit  $admissionmerit
     * @return \Illuminate\Http\Response
     */
    public function edit(AdmissionMerit $admissionmerit)
    {
        if (!auth()->user()->can('admissionmerit_edit')) {
            abort(403, 'Unauthorized action.');
        }
        page_title()->setTitle(trans('admission::lang.admissionmerit_edit'));
        $data = array();
        $data['title']        = 'admissionmerit_edit';
        $data['record']        = $this->admissionmeritRepository->findOrFail($admissionmerit->id);
        return view('admission::admissionmerit.create',$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Modules\Admission\Http\Models\AdmissionMerit  $admissionmerit
     * @param  DboardHttpResponse  $response
     * @return DboardHttpResponse
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AdmissionMerit  $admissionmerit, DboardHttpResponse $response)
    {
        if (!auth()->user()->can('admissionmerit_edit')) {
            abort(403, 'Unauthorized action.');
        }
        $validated = $request->validate([
            'name'              => 'bail|required|max:255',
        ]);

        $id = $admissionmerit->id;
        $admissionmerit = $this->admissionmeritRepository->firstOrNew(compact('id'));
        $admissionmerit->fill($request->input());
        $this->admissionmeritRepository->createOrUpdate($admissionmerit);

        $file_name = 'photo';
        if ($request->hasFile($file_name))
        {
//            return $file_name;
            $rules = $request->validate([
                "$file_name" => 'mimes:jpeg,jpg,png,gif|max:10000'
            ]);
            $path = $this->photo_path;
            deleteFile($admissionmerit->$file_name, $path);

            $admissionmerit->$file_name      = processUpload($request, $admissionmerit,$file_name,$path);
            $admissionmerit->save();
        }

        event(new UpdatedContentEvent(ADMISSIONMERIT_MODULE_SCREEN_NAME, $request, $admissionmerit));

        return $response
            ->setPreviousUrl(route('admissionmerit.index'))
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
        if (!auth()->user()->can('admissionmerit_destroy')) {
            abort(403, 'Unauthorized action.');
        }
        try{

            $admissionmerit = $this->admissionmeritRepository->findOrFail($id);
            $this->admissionmeritRepository->delete($admissionmerit);
            $path = $this->photo_path;
            deleteFile($admissionmerit->photo, $path);
            event(new DeletedContentEvent(ADMISSIONMERIT_MODULE_SCREEN_NAME, $request, $admissionmerit));

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
        return $this->executeDeleteItems($request, $response, $this->admissionmeritRepository, ADMISSIONMERIT_MODULE_SCREEN_NAME);
    }
}
