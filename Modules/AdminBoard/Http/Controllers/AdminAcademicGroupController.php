<?php

namespace Modules\AdminBoard\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;
use Modules\AdminBoard\Forms\AdminAcademicGroupForm;
use Modules\KamrulDashboard\Events\DeletedContentEvent;
use Modules\KamrulDashboard\Events\UpdatedContentEvent;
use Modules\KamrulDashboard\Events\CreatedContentEvent;
use Modules\KamrulDashboard\Http\Responses\DboardHttpResponse;
use Modules\AdminBoard\Http\Models\AdminAcademicGroup;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Modules\KamrulDashboard\Traits\HasDeleteManyItemsTrait;
use Illuminate\Routing\Controller;
use Modules\AdminBoard\Repositories\Interfaces\AdminAcademicGroupInterface;
use Modules\AdminBoard\Http\Imports\AdminAcademicGroupImport;
use Modules\AdminBoard\Tables\AdminAcademicGroupTable;
use mysql_xdevapi\Exception;
use Throwable;

class AdminAcademicGroupController extends Controller
{
    use HasDeleteManyItemsTrait;
    /**
     * @var AdminAcademicGroupInterface
     */
    protected $adminacademicgroupRepository;

    /**
     * AdminAcademicGroupController constructor.
     * @param AdminAcademicGroupInterface $adminacademicgroupRepository
     */
    public function __construct(AdminAcademicGroupInterface $adminacademicgroupRepository)
    {
        $this->adminacademicgroupRepository = $adminacademicgroupRepository;
    }
    protected $photo_path = 'uploads/adminboard/adminacademicgroup/';

    /**
     * @param AdminAcademicGroupTable $dataTable
     * @return JsonResponse|View
     *
     * @throws Throwable
     */
    public function index(AdminAcademicGroupTable $dataTable)
    {
        if (!auth()->user()->can('adminacademicgroup_access')) {
            abort(403, 'Unauthorized action.');
        }
        page_title()->setTitle(trans('adminboard::lang.adminacademicgroup'));

        return $dataTable->renderTable();
    }

    public function import()
    {
        if (!auth()->user()->can('adminacademicgroup_import')) {
            abort(403, 'Unauthorized action.');
        }
        page_title()->setTitle(trans('adminboard::lang.adminacademicgroup_import'));
        $data = array();
        $data['title']        = 'adminacademicgroup_import';
        return view('adminboard::adminacademicgroup.create_import',$data);
    }
    public function store_import(Request $request)
    {
        if (!auth()->user()->can('adminacademicgroup_import')) {
            abort(403, 'Unauthorized action.');
        }
        $file = $request->file('photo');
        Excel::import(new AdminAcademicGroupImport, $file);
        $response_data['status'] = 1;
        $response_data['message'] =  __('adminboard::lang.record_save_successfully');
        return redirect()->route('adminacademicgroup.index')->with('response_data', $response_data);
    }
    public function data()
    {
        if (!auth()->user()->can('adminacademicgroup_access')) {
            abort(403, 'Unauthorized action.');
        }
        if(auth()->user()->can('adminacademicgroup_list_all')) {
            $custom_table = AdminAcademicGroup::all();
        }else {
            $custom_table = AdminAcademicGroup::where('user_id', Auth::id())->get();
        }
        return datatables()->of($custom_table)->addColumn('action', function ($row) {
            $html = '';
            if(auth()->user()->can('adminacademicgroup_pdf')) {
                $html .= '<a target="_blank" href="' . url('adminboard/adminacademicgroup/pdf_show', $row->id) . '" class="btn btn-xs btn-success">' . __('adminboard::lang.pdf') . '</a> ';
            }
            if(auth()->user()->can('adminacademicgroup_show')) {
                $html .= '<a href="' . url('adminboard/adminacademicgroup/' . $row->id) . '" class="btn btn-xs btn-success">' . __('adminboard::lang.view') . '</a> ';
            }
            if(auth()->user()->can('adminacademicgroup_edit')) {
                $html .= '<a  href="' . url('adminboard/adminacademicgroup/' . $row->id . "/edit") . '" class="btn btn-xs btn-secondary">' . __('adminboard::lang.edit') . '</a> ';
            }
            if(auth()->user()->can('adminacademicgroup_destroy')) {
                $html .= '<form action="' . url('adminboard/adminacademicgroup', $row->id) . '" method="POST" style="display: inline-block;">
                            ' . csrf_field() . '
                            ' . method_field("DELETE") . '
                            <button type="submit" class="btn btn-xs btn-danger"
                                onclick="return confirm(\'Are You Sure Want to Delete?\')"
                                style="padding: .0em !important;"><i class="icon-trash"> </i>' . __('adminboard::lang.delete') . '</button>
                            </form>';
            }
            return $html;
        })->addColumn('photo', function ($row) {
            $html = '<img style="height: 100px;width: 100px;" src="' . getImageUrl($row->photo,'adminboard/adminacademicgroup') . '" alt="' . $row->name . '" class="img-rounded img-preview">';
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
        if (!auth()->user()->can('adminacademicgroup_create')) {
            abort(403, 'Unauthorized action.');
        }
        page_title()->setTitle(trans('adminboard::lang.adminacademicgroup_create'));

        return AdminAcademicGroupForm::create()->renderForm();
        //$data = array();
        //$data['title']        = 'adminacademicgroup_create';
        //return view('adminboard::adminacademicgroup.create',$data);
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
        if (!auth()->user()->can('adminacademicgroup_create')) {
            abort(403, 'Unauthorized action.');
        }
        $validated = $request->validate([
            'name'              => 'bail|required|max:255',
        ]);

        try {
            $record = $this->adminacademicgroupRepository->createOrUpdate(array_merge($request->input(), [
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
            event(new CreatedContentEvent(ADMINACADEMICGROUP_MODULE_SCREEN_NAME, $request, $record));

            return $response
                ->setPreviousUrl(route('adminacademicgroup.index'))
                ->setNextUrl(route('adminacademicgroup.edit', $record->id))
                ->setMessage(trans('kamruldashboard::notices.create_success_message'));
        }catch (\Exception $e){

            return $response
                ->setPreviousUrl(route('adminacademicgroup.index'))
                ->setMessage(trans('kamruldashboard::notices.something_error_please_try_again_later'));
        }
    }

    /**
     * Show the specified resource.
     * @param  \Modules\AdminBoard\Http\Models\AdminAcademicGroup  $adminacademicgroup
     * @return \Illuminate\Http\Response
     */
    public function show(AdminAcademicGroup $adminacademicgroup)
    {
        if (!auth()->user()->can('adminacademicgroup_show')) {
            abort(403, 'Unauthorized action.');
        }
        page_title()->setTitle(trans('adminboard::lang.adminacademicgroup_show'));
        $data = array();
        $data['adminacademicgroup']        = $adminacademicgroup;
        $data['title']        = 'adminacademicgroup_show';
        return view('adminboard::adminacademicgroup.show',$data);
    }
    /**
     * Show the specified resource.
     * @param  \Modules\AdminBoard\Http\Models\AdminAcademicGroup  $adminacademicgroup
     * @return \Illuminate\Http\Response
     */
    public function pdf(AdminAcademicGroup $adminacademicgroup)
    {
        if (!auth()->user()->can('adminacademicgroup_pdf')) {
            abort(403, 'Unauthorized action.');
        }
        page_title()->setTitle(trans('adminboard::lang.adminacademicgroup_show'));
        $data = array();
        $data['adminacademicgroup']        = $adminacademicgroup;
        $data['title']        = 'adminacademicgroup_show';
        return view('adminboard::adminacademicgroup.pdf',$data);
    }

    /**
     * Show the form for editing the specified resource.
     * @param  \Modules\AdminBoard\Http\Models\AdminAcademicGroup  $adminacademicgroup
     * @return \Illuminate\Http\Response
     */
    public function edit(AdminAcademicGroup $adminacademicgroup)
    {
        if (!auth()->user()->can('adminacademicgroup_edit')) {
            abort(403, 'Unauthorized action.');
        }
        page_title()->setTitle(trans('adminboard::lang.adminacademicgroup_edit'));

        return AdminAcademicGroupForm::createFromModel($adminacademicgroup)->renderForm();
     //   $data = array();
      //  $data['title']        = 'adminacademicgroup_edit';
     //   $data['record']        = $this->adminacademicgroupRepository->findOrFail($adminacademicgroup->id);
      //  return view('adminboard::adminacademicgroup.create',$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Modules\AdminBoard\Http\Models\AdminAcademicGroup  $adminacademicgroup
     * @param  DboardHttpResponse  $response
     * @return DboardHttpResponse
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AdminAcademicGroup  $adminacademicgroup, DboardHttpResponse $response)
    {
        if (!auth()->user()->can('adminacademicgroup_edit')) {
            abort(403, 'Unauthorized action.');
        }
        $validated = $request->validate([
            'name'              => 'bail|required|max:255',
        ]);

        $id = $adminacademicgroup->id;
        $adminacademicgroup = $this->adminacademicgroupRepository->firstOrNew(compact('id'));
        $adminacademicgroup->fill($request->input());
        $this->adminacademicgroupRepository->createOrUpdate($adminacademicgroup);

        $file_name = 'photo';
        if ($request->hasFile($file_name))
        {
//            return $file_name;
            $rules = $request->validate([
                "$file_name" => 'mimes:jpeg,jpg,png,gif|max:10000'
            ]);
            $path = $this->photo_path;
            deleteFile($adminacademicgroup->$file_name, $path);

            $adminacademicgroup->$file_name      = processUpload($request, $adminacademicgroup,$file_name,$path);
            $adminacademicgroup->save();
        }

        event(new UpdatedContentEvent(ADMINACADEMICGROUP_MODULE_SCREEN_NAME, $request, $adminacademicgroup));

        return $response
            ->setPreviousUrl(route('adminacademicgroup.index'))
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
        if (!auth()->user()->can('adminacademicgroup_destroy')) {
            abort(403, 'Unauthorized action.');
        }
        try{

            $adminacademicgroup = $this->adminacademicgroupRepository->findOrFail($id);
            $this->adminacademicgroupRepository->delete($adminacademicgroup);
            $path = $this->photo_path;
            deleteFile($adminacademicgroup->photo, $path);
            event(new DeletedContentEvent(ADMINACADEMICGROUP_MODULE_SCREEN_NAME, $request, $adminacademicgroup));

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
        return $this->executeDeleteItems($request, $response, $this->adminacademicgroupRepository, ADMINACADEMICGROUP_MODULE_SCREEN_NAME);
    }
}
