<?php

namespace Modules\KamrulDashboard\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;
use Modules\KamrulDashboard\Http\Models\Permission;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\KamrulDashboard\Http\Imports\PermissionImport;
use Modules\KamrulDashboard\Http\Responses\DboardHttpResponse;
use Modules\KamrulDashboard\Repositories\Interfaces\PermissionInterface;
use Modules\KamrulDashboard\Tables\PermissionTable;
use Modules\KamrulDashboard\Traits\HasDeleteManyItemsTrait;
use mysql_xdevapi\Exception;
use Throwable;

class PermissionController extends Controller
{

    use HasDeleteManyItemsTrait;
    protected $photo_path = '../uploads/kamruldashboard/permission/';

    /**
     * @var PermissionInterface
     */
    protected $permissionRepository;

    /**
     * PermissionController constructor.
     * @param PermissionInterface $permissionRepository
     */
    public function __construct(PermissionInterface $permissionRepository)
    {
        $this->permissionRepository = $permissionRepository;
    }

    /**
     * @param PermissionTable $dataTable
     * @return JsonResponse|View
     *
     * @throws Throwable
     */
    public function index(PermissionTable $dataTable)
    {
        if (!auth()->user()->can('permission_access')) {
            abort(403, 'Unauthorized action.');
        }
        page_title()->setTitle(trans('kamruldashboard::lang.permission'));

        return $dataTable->renderTable();
//        $data = array();
//        $data['title']        = 'permission';
//        return view('kamruldashboard::permission.index',$data);
    }

    public function import()
    {
        if (!auth()->user()->can('permission_import')) {
            abort(403, 'Unauthorized action.');
        }
        $data = array();
        $data['title']        = 'permission_import';
        return view('kamruldashboard::permission.create_import',$data);
    }
    public function store_import(Request $request)
    {
        if (!auth()->user()->can('permission_import')) {
            abort(403, 'Unauthorized action.');
        }
        $file = $request->file('photo');
        Excel::import(new PermissionImport, $file);
        $response_data['status'] = 1;
        $response_data['message'] =  __('kamruldashboard::lang.record_save_successfully');
        return redirect()->route('permission.index')->with('response_data', $response_data);
    }
    public function data()
    {
        if (!auth()->user()->can('permission_access')) {
            abort(403, 'Unauthorized action.');
        }
        $custom_table = Permission::all();
        return datatables()->of($custom_table)->addColumn('action', function ($row) {
            $html = '';
            if(auth()->user()->can('permission_pdf')) {
                $html .= '<a target="_blank" href="' . url('kamruldashboard/permission/pdf_show', $row->id) . '" class="btn btn-xs btn-success">' . __('kamruldashboard::lang.pdf') . '</a> ';
            }
            if(auth()->user()->can('permission_show')) {
                $html .= '<a href="' . url('kamruldashboard/permission/' . $row->id) . '" class="btn btn-xs btn-success">' . __('kamruldashboard::lang.view') . '</a> ';
            }
            if($row->is_default == 0) {
                if(auth()->user()->can('permission_edit')) {
                    $html .= '<a  href="' . url('kamruldashboard/permission/' . $row->id . "/edit") . '" class="btn btn-xs btn-secondary">'. __('kamruldashboard::lang.edit') .'</a> ';
                }
                if(auth()->user()->can('permission_destroy')) {
                    $html .= '<form action="' . url('kamruldashboard/permission', $row->id) . '" method="POST" style="display: inline-block;">
                            ' . csrf_field() . '
                            ' . method_field("DELETE") . '
                            <button type="submit" class="btn btn-xs btn-danger"
                                onclick="return confirm(\'Are You Sure Want to Delete?\')"
                                style="padding: .0em !important;"><i class="icon-trash"> </i>' . __('kamruldashboard::lang.delete') . '</button>
                            </form>';
                }
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
        if (!auth()->user()->can('permission_create')) {
            abort(403, 'Unauthorized action.');
        }
        $data = array();
        $data['title']        = 'permission_create';
        return view('kamruldashboard::permission.create',$data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!auth()->user()->can('permission_create')) {
            abort(403, 'Unauthorized action.');
        }
        $validated = $request->validate([
            'name'              => 'bail|required|max:255',
        ]);

        try {
            $record = new Permission();
            $record->name           = $request->name;
            $record->is_default     = 0;
//            $record->status         = $request->status;
//            $record->uuid         = gen_uuid();
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
            $response_data['message'] =  __('kamruldashboard::lang.record_save_successfully');
            return redirect()->route('permission.index')->with('response_data', $response_data);
        }catch (Exception $e){

            $response_data['status'] = 0;
            $response_data['message'] =  __('kamruldashboard::lang.something_error_please_try_again_later');
            return redirect()->route('permission.index')->with('response_data', $response_data);
        }
    }

    /**
     * Show the specified resource.
     * @param  Permission\Http\Models\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function show(Permission $permission)
    {
        if (!auth()->user()->can('permission_show')) {
            abort(403, 'Unauthorized action.');
        }
        $data = array();
        $data['permission']        = $permission;
        $data['title']        = 'permission_show';
        return view('kamruldashboard::permission.show',$data);
    }
    /**
     * Show the specified resource.
     * @param  Permission\Http\Models\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function pdf(Permission $permission)
    {
        if (!auth()->user()->can('permission_pdf')) {
            abort(403, 'Unauthorized action.');
        }
        $data = array();
        $data['permission']        = $permission;
        $data['title']        = 'permission_show';
        return view('kamruldashboard::permission.pdf',$data);
    }

    /**
     * Show the form for editing the specified resource.
     * @param  Permission\Http\Models\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function edit(Permission $permission)
    {
        if (!auth()->user()->can('permission_edit')) {
            abort(403, 'Unauthorized action.');
        }
        $data = array();
        $data['title']        = 'permission_edit';
        $data['record']        = $permission;
        return view('kamruldashboard::permission.create',$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Permission\Http\Models\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Permission  $permission)
    {
        if (!auth()->user()->can('permission_edit')) {
            abort(403, 'Unauthorized action.');
        }
        $validated = $request->validate([
            'name'              => 'bail|required|max:255',
        ]);

        $permission->name             = $request->name;
        $permission->is_default       = 0;
        $permission->save();

        $file_name = 'photo';
        if ($request->hasFile($file_name))
        {
//            return $file_name;
            $rules = $request->validate([
                "$file_name" => 'mimes:jpeg,jpg,png,gif|max:10000'
            ]);
            $path = $this->photo_path;
            deleteFile($permission->photo, $path);

            $permission->$file_name      = processUpload($request, $permission,$file_name,$path);
            $permission->save();
        }

        $response_data['status'] = 1;
        $response_data['message'] =  __('kamruldashboard::lang.record_update_successfully');
        return redirect()->route('permission.index')->with('response_data', $response_data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Permission\Http\Models\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function destroy(Permission  $permission)
    {
        if (!auth()->user()->can('permission_destroy')) {
            abort(403, 'Unauthorized action.');
        }
        try{
            $permission->delete();
            $path = $this->photo_path;
            deleteFile($permission->photo, $path);
            $response_data['status'] = 1;
            $response_data['message'] =  __('kamruldashboard::lang.record_deleted_successfully');
        } catch ( \Exception $e) {
            $response_data['status'] = 0;
            $response_data['message'] =  __('kamruldashboard::lang.this_record_is_in_use_in_other_modules');
        }
        return redirect()->route('permission.index')->with('response_data', $response_data);
    }
    /**
     * @param Request $request
     * @param DboardHttpResponse $response
     * @return DboardHttpResponse
     * @throws \Exception
     */
    public function deletes(Request $request, DboardHttpResponse $response)
    {
        return $this->executeDeleteItems($request, $response, $this->permissionRepository, PAGE_MODULE_SCREEN_NAME);
    }
}
