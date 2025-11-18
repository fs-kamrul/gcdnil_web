<?php

namespace Modules\AdminBoard\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;
use Modules\AdminBoard\Forms\AdminStudentGuidelineForm;
use Modules\KamrulDashboard\Events\DeletedContentEvent;
use Modules\KamrulDashboard\Events\UpdatedContentEvent;
use Modules\KamrulDashboard\Events\CreatedContentEvent;
use Modules\KamrulDashboard\Http\Responses\DboardHttpResponse;
use Modules\AdminBoard\Http\Models\AdminStudentGuideline;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Modules\KamrulDashboard\Traits\HasDeleteManyItemsTrait;
use Illuminate\Routing\Controller;
use Modules\AdminBoard\Repositories\Interfaces\AdminStudentGuidelineInterface;
use Modules\AdminBoard\Http\Imports\AdminStudentGuidelineImport;
use Modules\AdminBoard\Tables\AdminStudentGuidelineTable;
use mysql_xdevapi\Exception;
use Throwable;

class AdminStudentGuidelineController extends Controller
{
    use HasDeleteManyItemsTrait;
    /**
     * @var AdminStudentGuidelineInterface
     */
    protected $adminstudentguidelineRepository;

    /**
     * AdminStudentGuidelineController constructor.
     * @param AdminStudentGuidelineInterface $adminstudentguidelineRepository
     */
    public function __construct(AdminStudentGuidelineInterface $adminstudentguidelineRepository)
    {
        $this->adminstudentguidelineRepository = $adminstudentguidelineRepository;
    }
    protected $photo_path = 'uploads/adminboard/adminstudentguideline/';

    /**
     * @param AdminStudentGuidelineTable $dataTable
     * @return JsonResponse|View
     *
     * @throws Throwable
     */
    public function index(AdminStudentGuidelineTable $dataTable)
    {
        if (!auth()->user()->can('adminstudentguideline_access')) {
            abort(403, 'Unauthorized action.');
        }
        page_title()->setTitle(trans('adminboard::lang.adminstudentguideline'));

        return $dataTable->renderTable();
    }

    public function import()
    {
        if (!auth()->user()->can('adminstudentguideline_import')) {
            abort(403, 'Unauthorized action.');
        }
        page_title()->setTitle(trans('adminboard::lang.adminstudentguideline_import'));
        $data = array();
        $data['title']        = 'adminstudentguideline_import';
        return view('adminboard::adminstudentguideline.create_import',$data);
    }
    public function store_import(Request $request)
    {
        if (!auth()->user()->can('adminstudentguideline_import')) {
            abort(403, 'Unauthorized action.');
        }
        $file = $request->file('photo');
        Excel::import(new AdminStudentGuidelineImport, $file);
        $response_data['status'] = 1;
        $response_data['message'] =  __('adminboard::lang.record_save_successfully');
        return redirect()->route('adminstudentguideline.index')->with('response_data', $response_data);
    }
    public function data()
    {
        if (!auth()->user()->can('adminstudentguideline_access')) {
            abort(403, 'Unauthorized action.');
        }
        if(auth()->user()->can('adminstudentguideline_list_all')) {
            $custom_table = AdminStudentGuideline::all();
        }else {
            $custom_table = AdminStudentGuideline::where('user_id', Auth::id())->get();
        }
        return datatables()->of($custom_table)->addColumn('action', function ($row) {
            $html = '';
            if(auth()->user()->can('adminstudentguideline_pdf')) {
                $html .= '<a target="_blank" href="' . url('adminboard/adminstudentguideline/pdf_show', $row->id) . '" class="btn btn-xs btn-success">' . __('adminboard::lang.pdf') . '</a> ';
            }
            if(auth()->user()->can('adminstudentguideline_show')) {
                $html .= '<a href="' . url('adminboard/adminstudentguideline/' . $row->id) . '" class="btn btn-xs btn-success">' . __('adminboard::lang.view') . '</a> ';
            }
            if(auth()->user()->can('adminstudentguideline_edit')) {
                $html .= '<a  href="' . url('adminboard/adminstudentguideline/' . $row->id . "/edit") . '" class="btn btn-xs btn-secondary">' . __('adminboard::lang.edit') . '</a> ';
            }
            if(auth()->user()->can('adminstudentguideline_destroy')) {
                $html .= '<form action="' . url('adminboard/adminstudentguideline', $row->id) . '" method="POST" style="display: inline-block;">
                            ' . csrf_field() . '
                            ' . method_field("DELETE") . '
                            <button type="submit" class="btn btn-xs btn-danger"
                                onclick="return confirm(\'Are You Sure Want to Delete?\')"
                                style="padding: .0em !important;"><i class="icon-trash"> </i>' . __('adminboard::lang.delete') . '</button>
                            </form>';
            }
            return $html;
        })->addColumn('photo', function ($row) {
            $html = '<img style="height: 100px;width: 100px;" src="' . getImageUrl($row->photo,'adminboard/adminstudentguideline') . '" alt="' . $row->name . '" class="img-rounded img-preview">';
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
        if (!auth()->user()->can('adminstudentguideline_create')) {
            abort(403, 'Unauthorized action.');
        }
        page_title()->setTitle(trans('adminboard::lang.adminstudentguideline_create'));

        return AdminStudentGuidelineForm::create()->renderForm();
        //$data = array();
        //$data['title']        = 'adminstudentguideline_create';
        //return view('adminboard::adminstudentguideline.create',$data);
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
        if (!auth()->user()->can('adminstudentguideline_create')) {
            abort(403, 'Unauthorized action.');
        }
        $validated = $request->validate([
            'name'              => 'bail|required|max:255',
        ]);

        try {
            $record = $this->adminstudentguidelineRepository->createOrUpdate(array_merge($request->input(), [
                'user_id' => Auth::id(),
                'uuid'    => gen_uuid(),
                'slug'    => checkSlugFunction($request->input('name')),
            ]));

            $file_name = 'document';
            if ($request->hasFile($file_name))
            {
//                return $file_name;
//                $rules = $request->validate([
//                    "$file_name" => 'mimes:jpeg,jpg,png,gif|max:10000'
//                ]);
                $path = $this->photo_path;
                deleteFile($record->$file_name, $path);

                $record->$file_name      = documentProcessUpload($request, $record,$file_name, $path);
                $record->save();
            }
            event(new CreatedContentEvent(ADMINSTUDENTGUIDELINE_MODULE_SCREEN_NAME, $request, $record));

            return $response
                ->setPreviousUrl(route('adminstudentguideline.index'))
                ->setNextUrl(route('adminstudentguideline.edit', $record->id))
                ->setMessage(trans('kamruldashboard::notices.create_success_message'));
        }catch (\Exception $e){

            return $response
                ->setPreviousUrl(route('adminstudentguideline.index'))
                ->setMessage(trans('kamruldashboard::notices.something_error_please_try_again_later'));
        }
    }

    /**
     * Show the specified resource.
     * @param  \Modules\AdminBoard\Http\Models\AdminStudentGuideline  $adminstudentguideline
     * @return \Illuminate\Http\Response
     */
    public function show(AdminStudentGuideline $adminstudentguideline)
    {
        if (!auth()->user()->can('adminstudentguideline_show')) {
            abort(403, 'Unauthorized action.');
        }
        page_title()->setTitle(trans('adminboard::lang.adminstudentguideline_show'));
        $data = array();
        $data['adminstudentguideline']        = $adminstudentguideline;
        $data['title']        = 'adminstudentguideline_show';
        return view('adminboard::adminstudentguideline.show',$data);
    }
    /**
     * Show the specified resource.
     * @param  \Modules\AdminBoard\Http\Models\AdminStudentGuideline  $adminstudentguideline
     * @return \Illuminate\Http\Response
     */
    public function pdf(AdminStudentGuideline $adminstudentguideline)
    {
        if (!auth()->user()->can('adminstudentguideline_pdf')) {
            abort(403, 'Unauthorized action.');
        }
        page_title()->setTitle(trans('adminboard::lang.adminstudentguideline_show'));
        $data = array();
        $data['adminstudentguideline']        = $adminstudentguideline;
        $data['title']        = 'adminstudentguideline_show';
        return view('adminboard::adminstudentguideline.pdf',$data);
    }

    /**
     * Show the form for editing the specified resource.
     * @param  \Modules\AdminBoard\Http\Models\AdminStudentGuideline  $adminstudentguideline
     * @return \Illuminate\Http\Response
     */
    public function edit(AdminStudentGuideline $adminstudentguideline)
    {
        if (!auth()->user()->can('adminstudentguideline_edit')) {
            abort(403, 'Unauthorized action.');
        }
        page_title()->setTitle(trans('adminboard::lang.adminstudentguideline_edit'));

        return AdminStudentGuidelineForm::createFromModel($adminstudentguideline)->renderForm();
     //   $data = array();
      //  $data['title']        = 'adminstudentguideline_edit';
     //   $data['record']        = $this->adminstudentguidelineRepository->findOrFail($adminstudentguideline->id);
      //  return view('adminboard::adminstudentguideline.create',$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Modules\AdminBoard\Http\Models\AdminStudentGuideline  $adminstudentguideline
     * @param  DboardHttpResponse  $response
     * @return DboardHttpResponse
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AdminStudentGuideline  $adminstudentguideline, DboardHttpResponse $response)
    {
        if (!auth()->user()->can('adminstudentguideline_edit')) {
            abort(403, 'Unauthorized action.');
        }
        $validated = $request->validate([
            'name'              => 'bail|required|max:255',
        ]);

        $id = $adminstudentguideline->id;
        $adminstudentguideline = $this->adminstudentguidelineRepository->firstOrNew(compact('id'));
        $adminstudentguideline->fill($request->input());
        $this->adminstudentguidelineRepository->createOrUpdate($adminstudentguideline);

        $file_name = 'document';
        if ($request->hasFile($file_name))
        {
//            return $file_name;
//            $rules = $request->validate([
//                "$file_name" => 'mimes:jpeg,jpg,png,gif|max:10000'
//            ]);
            $path = $this->photo_path;
            deleteFile($adminstudentguideline->$file_name, $path);

            $adminstudentguideline->$file_name      = documentProcessUpload($request, $adminstudentguideline,$file_name,$path);
            $adminstudentguideline->save();
        }

        event(new UpdatedContentEvent(ADMINSTUDENTGUIDELINE_MODULE_SCREEN_NAME, $request, $adminstudentguideline));

        return $response
            ->setPreviousUrl(route('adminstudentguideline.index'))
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
        if (!auth()->user()->can('adminstudentguideline_destroy')) {
            abort(403, 'Unauthorized action.');
        }
        try{

            $adminstudentguideline = $this->adminstudentguidelineRepository->findOrFail($id);
            $this->adminstudentguidelineRepository->delete($adminstudentguideline);
            $path = $this->photo_path;
            deleteFile($adminstudentguideline->photo, $path);
            event(new DeletedContentEvent(ADMINSTUDENTGUIDELINE_MODULE_SCREEN_NAME, $request, $adminstudentguideline));

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
        return $this->executeDeleteItems($request, $response, $this->adminstudentguidelineRepository, ADMINSTUDENTGUIDELINE_MODULE_SCREEN_NAME);
    }
}
