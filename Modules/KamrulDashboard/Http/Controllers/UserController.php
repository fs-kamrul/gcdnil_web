<?php

namespace Modules\KamrulDashboard\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;
use Modules\KamrulDashboard\Http\Models\Role;
use Modules\KamrulDashboard\Http\Models\User;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\KamrulDashboard\Http\Imports\UserImport;
use Modules\KamrulDashboard\Http\Responses\DboardHttpResponse;
use Modules\KamrulDashboard\Packages\Supports\DboardStatus;
use Modules\KamrulDashboard\Repositories\Interfaces\UserInterface;
use Modules\KamrulDashboard\Tables\UserTable;
use Modules\KamrulDashboard\Traits\HasDeleteManyItemsTrait;
use Savefunction;
use Throwable;
use mysql_xdevapi\Exception;

class UserController extends Controller
{
    use HasDeleteManyItemsTrait;

    protected $photo_path = 'uploads/kamruldashboard/user/';

    /**
     * @var UserInterface
     */
    protected $userRepository;

    /**
     * UserController constructor.
     * @param UserInterface $userRepository
     */
    public function __construct(UserInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @param UserTable $dataTable
     * @return JsonResponse|View
     *
     * @throws Throwable
     */
    public function index(UserTable $dataTable)
    {
        if (!auth()->user()->can('user_access')) {
            abort(403, 'Unauthorized action.');
        }
        page_title()->setTitle(trans('kamruldashboard::lang.user'));

        return $dataTable->renderTable();
//        $data = array();
//        $data['title']        = 'user';
//        return view('kamruldashboard::user.index',$data);
    }

    public function import()
    {
        if (!auth()->user()->can('user_import')) {
            abort(403, 'Unauthorized action.');
        }
        $data = array();
        $data['title']        = 'user_import';
        return view('kamruldashboard::user.create_import',$data);
    }
    public function store_import(Request $request)
    {
        if (!auth()->user()->can('user_import')) {
            abort(403, 'Unauthorized action.');
        }
        $file = $request->file('photo');
        Excel::import(new UserImport, $file);
        $response_data['status'] = 1;
        $response_data['message'] =  __('kamruldashboard::lang.record_save_successfully');
        return redirect()->route('user.index')->with('response_data', $response_data);
    }
    public function data()
    {
        if (!auth()->user()->can('user_access')) {
            abort(403, 'Unauthorized action.');
        }
        $custom_table = User::all();
        return datatables()->of($custom_table)->addColumn('action', function ($row) {
            $html = '';
            if(auth()->user()->can('user_pdf')) {
                $html .= '<a target="_blank" href="' . url('kamruldashboard/user/pdf_show', $row->id) . '" class="btn btn-xs btn-success">' . __('kamruldashboard::lang.pdf') . '</a> ';
            }
            if(auth()->user()->can('user_show')) {
                $html .= '<a href="' . url('kamruldashboard/user/' . $row->id) . '" class="btn btn-xs btn-success">'. __('kamruldashboard::lang.view') .'</a> ';
            }
            if(auth()->user()->can('user_edit')) {
                $html .= '<a  href="' . url('kamruldashboard/user/' . $row->id . "/edit") . '" class="btn btn-xs btn-secondary">'. __('kamruldashboard::lang.edit') .'</a> ';
            }
            if(auth()->user()->can('password_update')) {
                $html .= '<a  href="' . url('kamruldashboard/user/change_password/' . $row->id . "") . '" class="btn btn-xs btn-secondary">'. __('kamruldashboard::lang.change_password') .'</a> ';
            }
            if(auth()->user()->can('user_destroy')) {
                $html .= '<form action="' . url('kamruldashboard/user', $row->id) . '" method="POST" style="display: inline-block;">
                            ' . csrf_field() . '
                            ' . method_field("DELETE") . '
                            <button type="submit" class="btn btn-xs btn-danger"
                                onclick="return confirm(\'Are You Sure Want to Delete?\')"
                                style="padding: .0em !important;"><i class="icon-trash"> </i>'. __('kamruldashboard::lang.delete') .'</button>
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
        })->addColumn('role', function ($row) {
            $html = $row->role->name;
            return $html;
        })->rawColumns(['action','status','photo','role'])->toJson();;
    }
    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        if (!auth()->user()->can('user_create')) {
            abort(403, 'Unauthorized action.');
        }
        $data = array();
        $data['title']        = 'user_create';
        $data['role']         = Role::where('status', DboardStatus::PUBLISHED)->get();
        return view('kamruldashboard::user.create',$data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!auth()->user()->can('user_create')) {
            abort(403, 'Unauthorized action.');
        }
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'username' => ['required', 'string', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
        try {
            $record = new User();
            $record->name           = $request->name;
            $record->username       = $request->username;
            $record->email          = $request->email;
            $record->role_id        = $request->role_id;
            $record->password        = Hash::make($request->password);
            $record->status         = $request->status;
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

            $dda = Savefunction::request_to_redirect_function('employee_save', $record);

            $_module = Savefunction::request_module_defined('Branch');
            if($_module) {
                $branch = $request->branch;
                if (!empty($branch) && is_array($branch)) {
                    $record->branch()->sync($branch);
                }
            }
            $response_data['status'] = 1;
            $response_data['message'] =  __('kamruldashboard::lang.record_save_successfully');
            return redirect()->route('user.index')->with('response_data', $response_data);
        }catch (Exception $e){

            $response_data['status'] = 0;
            $response_data['message'] =  __('kamruldashboard::lang.something_error_please_try_again_later');
            return redirect()->route('user.index')->with('response_data', $response_data);
        }
    }

    /**
     * Show the specified resource.
     * @param  User\Http\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        if (!auth()->user()->can('user_show')) {
            abort(403, 'Unauthorized action.');
        }
        $data = array();
        $data['user']        = $user;
        $data['title']        = 'user_show';
        return view('kamruldashboard::user.show',$data);
    }
    /**
     * Show the specified resource.
     * @param  User\Http\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function pdf(User $user)
    {
        if (!auth()->user()->can('user_pdf')) {
            abort(403, 'Unauthorized action.');
        }
        $data = array();
        $data['user']        = $user;
        $data['title']        = 'user_show';
        return view('kamruldashboard::user.pdf',$data);
    }

    /**
     * Show the form for editing the specified resource.
     * @param  User\Http\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        if (!auth()->user()->can('user_edit')) {
            abort(403, 'Unauthorized action.');
        }
        $data = array();
        $data['title']        = 'user_edit';
        $data['record']        = $user;
        $data['role']         = Role::where('status', 1)->get();
        return view('kamruldashboard::user.create',$data);
    }
    /**
     * Show the form for editing the specified resource.
     * @param  \Modules\KamrulDashboard\Http\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function change_password(User $user)
    {
        if (!auth()->user()->can('password_update')) {
            abort(403, 'Unauthorized action.');
        }
        $data = array();
        $data['title']        = 'user_edit';
        $data['record']        = $user;
        $data['role']         = Role::where('status', 1)->get();
        return view('kamruldashboard::user.change_password',$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Modules\KamrulDashboard\Http\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function password_update(Request $request, User  $user)
    {
        if (!auth()->user()->can('password_update')) {
            abort(403, 'Unauthorized action.');
        }
        $validated = $request->validate([
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
        $user->password        = Hash::make($request->password);
        $user->save();
        $response_data['status'] = 1;
        $response_data['message'] =  __('kamruldashboard::lang.password_update_successfully');
        return redirect()->route('user.index')->with('response_data', $response_data);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Modules\KamrulDashboard\Http\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User  $user)
    {
        if (!auth()->user()->can('user_edit')) {
            abort(403, 'Unauthorized action.');
        }
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,'.$user->id],
            'username' => ['required', 'string', 'max:255', 'unique:users,username,'.$user->id],
//            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user->name             = $request->name;
        $user->username       = $request->username;
        $user->email          = $request->email;
        $user->role_id        = $request->role_id;
//        $user->password        = Hash::make($request->password);
        $user->status         = $request->status;
        $user->save();

        $file_name = 'photo';
        if ($request->hasFile($file_name))
        {
//            return $file_name;
            $rules = $request->validate([
                "$file_name" => 'mimes:jpeg,jpg,png,gif|max:10000'
            ]);
            $path = $this->photo_path;
            deleteFile($user->photo, $path);

            $user->$file_name      = processUpload($request, $user,$file_name,$path);
            $user->save();
        }

        $_module = Savefunction::request_module_defined('Branch');
        if($_module) {
            $branch = $request->branch;
            if (empty($branch)){
                $branch = array();
            }
            if (is_array($branch)) {
                $user->branch()->sync($branch);
            }
        }
        $response_data['status'] = 1;
        $response_data['message'] =  __('kamruldashboard::lang.record_update_successfully');
        return redirect()->route('user.index')->with('response_data', $response_data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  User\Http\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User  $user)
    {
        if (!auth()->user()->can('user_destroy')) {
            abort(403, 'Unauthorized action.');
        }
        try{
            $user->delete();
            $path = $this->photo_path;
            deleteFile($user->photo, $path);
            $response_data['status'] = 1;
            $response_data['message'] =  __('kamruldashboard::lang.record_deleted_successfully');
        } catch ( \Exception $e) {
            $response_data['status'] = 0;
            $response_data['message'] =  __('kamruldashboard::lang.this_record_is_in_use_in_other_modules');
        }
        return redirect()->route('user.index')->with('response_data', $response_data);
    }
    /**
     * @param Request $request
     * @param DboardHttpResponse $response
     * @return DboardHttpResponse
     * @throws \Exception
     */
    public function deletes(Request $request, DboardHttpResponse $response)
    {
        return $this->executeDeleteItems($request, $response, $this->userRepository, PAGE_MODULE_SCREEN_NAME);
    }
}
