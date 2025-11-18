<?php

namespace Modules\KamrulDashboard\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;
use Modules\KamrulDashboard\Http\Models\Permission;
use Modules\KamrulDashboard\Http\Models\Role;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\KamrulDashboard\Http\Imports\RoleImport;
use Modules\KamrulDashboard\Http\Models\RolePermission;
use Modules\KamrulDashboard\Http\Responses\DboardHttpResponse;
use Modules\KamrulDashboard\Repositories\Interfaces\RoleInterface;
use Modules\KamrulDashboard\Tables\RoleTable;
use Modules\KamrulDashboard\Traits\HasDeleteManyItemsTrait;
use mysql_xdevapi\Exception;
use Throwable;

class RoleController extends Controller
{

    use HasDeleteManyItemsTrait;
    protected $photo_path = '../uploads/kamruldashboard/role/';

    /**
     * @var RoleInterface
     */
    protected $roleRepository;

    /**
     * RoleController constructor.
     * @param RoleInterface $roleRepository
     */
    public function __construct(RoleInterface $roleRepository)
    {
        $this->roleRepository = $roleRepository;
    }

    /**
     * @param RoleTable $dataTable
     * @return JsonResponse|View
     *
     * @throws Throwable
     */
    public function index(RoleTable $dataTable)
    {
        if (!auth()->user()->can('role_access')) {
            abort(403, 'Unauthorized action.');
        }
        page_title()->setTitle(trans('kamruldashboard::lang.role'));

        return $dataTable->renderTable();
//        $data = array();
//        $data['title']        = 'role';
//        return view('kamruldashboard::role.index',$data);
    }

    public function import()
    {
        if (!auth()->user()->can('role_import')) {
            abort(403, 'Unauthorized action.');
        }
        $data = array();
        $data['title']        = 'role_import';
        return view('kamruldashboard::role.create_import',$data);
    }
    public function store_import(Request $request)
    {
        if (!auth()->user()->can('role_import')) {
            abort(403, 'Unauthorized action.');
        }
        $file = $request->file('photo');
        Excel::import(new RoleImport, $file);
        $response_data['status'] = 1;
        $response_data['message'] =  __('kamruldashboard::lang.record_save_successfully');
        return redirect()->route('role.index')->with('response_data', $response_data);
    }
    public function data()
    {
        if (!auth()->user()->can('role_access')) {
            abort(403, 'Unauthorized action.');
        }
        $custom_table = Role::all();
        return datatables()->of($custom_table)->addColumn('action', function ($row) {
            $html = '';
            if(auth()->user()->can('role_pdf')) {
                $html .= '<a target="_blank" href="' . url('kamruldashboard/role/pdf_show', $row->id) . '" class="btn btn-xs btn-success">' . __('kamruldashboard::lang.pdf') . '</a> ';
            }
            if(auth()->user()->can('role_show')) {
                $html .= '<a href="' . url('kamruldashboard/role/' . $row->id) . '" class="btn btn-xs btn-success">'. __('kamruldashboard::lang.view') .'</a> ';
            }
            if(auth()->user()->can('role_edit')) {
                $html .= '<a  href="' . url('kamruldashboard/role/' . $row->id . "/edit") . '" class="btn btn-xs btn-secondary">'. __('kamruldashboard::lang.edit') .'</a> ';
            }
            if(auth()->user()->can('role_destroy')) {
                $html .= '<form action="' . url('kamruldashboard/role', $row->id) . '" method="POST" style="display: inline-block;">
                            ' . csrf_field() . '
                            ' . method_field("DELETE") . '
                            <button type="submit" class="btn btn-xs btn-danger"
                                onclick="return confirm(\'Are You Sure Want to Delete?\')"
                                style="padding: .0em !important;"><i class="icon-trash"> </i>' . __('kamruldashboard::lang.delete') . '</button>
                            </form>';
            }
            return $html;
        })->addColumn('photo', function ($row) {
            if($row->photo == ''){
                $photo = 'vendor/kamruldashboard/images/image-not-found.jpg';
            }else{
                $photo = $this->photo_path . $row->photo;
            }
            $html = '<img style="height: 100px;width: 100px;" src="' . url($photo) . '" alt="' . $row->photo . '" class="img-rounded img-preview">';
            return $html;
        })->addColumn('status', function ($row) {
            $html = array_status_disign($row->status);
            return $html;
        })->rawColumns(['action','status','photo'])->toJson();;
    }
    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        if (!auth()->user()->can('role_create')) {
            abort(403, 'Unauthorized action.');
        }
        $data = array();
        $data['title']        = 'role_create';
        $data['permission']   = Permission::get();
        return view('kamruldashboard::role.create',$data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!auth()->user()->can('role_create')) {
            abort(403, 'Unauthorized action.');
        }
        $validated = $request->validate([
            'name'              => 'bail|required|max:255',
        ]);

        try {
            $record = new Role();
            $record->name           = $request->name;
//            $record->description    = $request->description;
            $record->status         = $request->status;
            $record->uuid         = gen_uuid();
            $record->save();
            $permissions           = $request->permissions;
            if($permissions != null) {
                foreach ($permissions as $key => $value) {
                    $permission = new RolePermission();
                    $permission->permission_id = $key;
                    $permission->role_id = $record->id;
                    $permission->save();
                }
            }

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
            $response_data['message'] =  __('kamruldashboard::lang.record_save_successfully');

            return redirect()->route('role.index')->with('response_data', $response_data);
        }catch (Exception $e){

            $response_data['status'] = 0;
            $response_data['message'] =  __('kamruldashboard::lang.something_error_please_try_again_later');

            return redirect()->route('role.index')->with('response_data', $response_data);
        }
    }

    /**
     * Show the specified resource.
     * @param  Role\Http\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function show(Role $role)
    {
        if (!auth()->user()->can('role_show')) {
            abort(403, 'Unauthorized action.');
        }
        $data = array();
        $data['role']        = $role;
        $data['title']        = 'role_show';
        return view('kamruldashboard::role.show',$data);
    }
    /**
     * Show the specified resource.
     * @param  Role\Http\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function pdf(Role $role)
    {
        if (!auth()->user()->can('role_pdf')) {
            abort(403, 'Unauthorized action.');
        }
        $data = array();
        $data['role']        = $role;
        $data['permissions'] = '';
        $data['title']        = 'role_show';
//        if(count($data['role']->permission)>0){
//            foreach ($data['role']->permission as $key=>$value) {
//                $data['permissions'][$value->id] = $value->id;
//            }
//        }
        return view('kamruldashboard::role.pdf',$data);
    }

    /**
     * Show the form for editing the specified resource.
     * @param  Role\Http\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $role)
    {
        if (!auth()->user()->can('role_edit')) {
            abort(403, 'Unauthorized action.');
        }
        $data = array();
        $data['title']        = 'role_edit';
        $data['permissions'] = null;
        $data['record']       = $role;
        $data['permission']   = Permission::get();
        if(count($data['record']->permission)>0){
            foreach ($data['record']->permission as $key=>$value) {
                $data['permissions'][$value->id] = $value->id;
            }
        }
        return view('kamruldashboard::role.create',$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Role\Http\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Role  $role)
    {
        if (!auth()->user()->can('role_edit')) {
            abort(403, 'Unauthorized action.');
        }
        $validated = $request->validate([
            'name'              => 'bail|required|max:255',
        ]);

        $role->name             = $request->name;
//        $role->description      = $request->description;
        $role->status           = $request->status;
        $role->save();
        $permission_d = RolePermission::where('role_id',$role->id)->delete();
//        $permission_d->delete();
        $permissions           = $request->permissions;
        if($permissions != null) {
            foreach ($permissions as $key => $value) {
                $permission = new RolePermission();
                $permission->permission_id = $key;
                $permission->role_id = $role->id;
                $permission->save();
            }
        }
        $file_name = 'photo';
        if ($request->hasFile($file_name))
        {
//            return $file_name;
            $rules = $request->validate([
                "$file_name" => 'mimes:jpeg,jpg,png,gif|max:10000'
            ]);
            $path = $this->photo_path;
            deleteFile($role->photo, $path);

            $role->$file_name      = processUpload($request, $role,$file_name,$path);
            $role->save();
        }

        $response_data['status'] = 1;
        $response_data['message'] =  __('kamruldashboard::lang.record_update_successfully');

        return redirect()->route('role.index')->with('response_data', $response_data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Role\Http\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role  $role)
    {
        if (!auth()->user()->can('role_destroy')) {
            abort(403, 'Unauthorized action.');
        }
        try{
            $role->delete();
            $path = $this->photo_path;
            deleteFile($role->photo, $path);
            $response_data['status'] = 1;
            $response_data['message'] =  __('kamruldashboard::lang.record_deleted_successfully');
        } catch ( \Exception $e) {
            $response_data['status'] = 0;
            $response_data['message'] =  __('kamruldashboard::lang.this_record_is_in_use_in_other_modules');
        }

        return redirect()->route('role.index')->with('response_data', $response_data);
    }
    /**
     * @param Request $request
     * @param DboardHttpResponse $response
     * @return DboardHttpResponse
     * @throws \Exception
     */
    public function deletes(Request $request, DboardHttpResponse $response)
    {
        return $this->executeDeleteItems($request, $response, $this->roleRepository, PAGE_MODULE_SCREEN_NAME);
    }
}
