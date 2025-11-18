<?php

namespace Modules\ThemeIcon\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Modules\ThemeIcon\Http\Models\ThemeIcon;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\ThemeIcon\Http\Imports\ThemeIconImport;
use mysql_xdevapi\Exception;

class ThemeIconController extends Controller
{

    protected $photo_path = 'uploads/themeicon/';
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        if (!auth()->user()->can('themeicon_access')) {
            abort(403, 'Unauthorized action.');
        }
        page_title()->setTitle(trans('themeicon::lang.themeicon'));
        $data = array();
        $data['title']        = 'themeicon';
        $data['themeicon']    = ThemeIcon::get();
//        return view('themeicon::themeicon.index',$data);
        return view('themeicon::themeicon.index-card',$data);
    }
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function geticon()
    {
        if (!auth()->user()->can('themeicon_access')) {
            abort(403, 'Unauthorized action.');
        }
        $icon['message']       = ThemeIcon::pluck('name')->all();

        return $icon;
    }

    public function import()
    {
        if (!auth()->user()->can('themeicon_import')) {
            abort(403, 'Unauthorized action.');
        }
        $data = array();
        $data['title']        = 'themeicon_import';
        return view('themeicon::themeicon.create_import',$data);
    }
    public function store_import(Request $request)
    {
        if (!auth()->user()->can('themeicon_import')) {
            abort(403, 'Unauthorized action.');
        }
        $file = $request->file('photo');
        Excel::import(new ThemeIconImport, $file);
        $response_data['status'] = 1;
        $response_data['message'] =  __('themeicon::lang.record_save_successfully');
        return redirect('themeicon')->with('response_data', $response_data);
    }
    public function data()
    {
        if (!auth()->user()->can('themeicon_access')) {
            abort(403, 'Unauthorized action.');
        }
        if(auth()->user()->can('themeicon_list_all')) {
            $custom_table = ThemeIcon::all();
        }else {
            $custom_table = ThemeIcon::where('user_id', Auth::id())->get();
        }
        return datatables()->of($custom_table)->addColumn('action', function ($row) {
            $html = '';
            if(auth()->user()->can('themeicon_pdf')) {
                $html .= '<a target="_blank" href="' . route('themeicon.pdf_show', $row->id) . '" class="btn btn-xs btn-success">' . __('themeicon::lang.pdf') . '</a> ';
            }
            if(auth()->user()->can('themeicon_show')) {
                $html .= '<a href="' . route('themeicon.show', $row->id) . '" class="btn btn-xs btn-success">' . __('themeicon::lang.view') . '</a> ';
            }
            if(auth()->user()->can('themeicon_edit')) {
                $html .= '<a  href="' . route('themeicon.edit', $row->id) . '" class="btn btn-xs btn-secondary">' . __('themeicon::lang.edit') . '</a> ';
            }
            if(auth()->user()->can('themeicon_destroy')) {
                $html .= '<form action="' . route('themeicon.destroy', $row->id) . '" method="POST" style="display: inline-block;">
                        ' . csrf_field() . '
                        ' . method_field("DELETE") . '
                        <button type="submit" class="btn btn-xs btn-danger"
                            onclick="return confirm(\'Are You Sure Want to Delete?\')"
                            style="padding: .0em !important;"><i class="icon-trash"> </i>' . __('themeicon::lang.delete') . '</button>
                        </form>';
            }
            return $html;
        })->addColumn('photo', function ($row) {
            $html = '<i class="icon-32 '. $row->name .'"></i>';
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
        if (!auth()->user()->can('themeicon_create')) {
            abort(403, 'Unauthorized action.');
        }
        $data = array();
        $data['title']        = 'themeicon_create';
        return view('themeicon::themeicon.create',$data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!auth()->user()->can('themeicon_create')) {
            abort(403, 'Unauthorized action.');
        }
        $validated = $request->validate([
            'name'              => 'bail|required|max:255',
        ]);

        try {
            $record = new ThemeIcon();
            $record->name           = $request->name;
            $record->description    = $request->description;
            $record->status         = $request->status;
            $record->uuid           = gen_uuid();
            $record->user_id        = Auth::id();
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
            $response_data['message'] =  __('themeicon::lang.record_save_successfully');
            return redirect('themeicon')->with('response_data', $response_data);
        }catch (Exception $e){

            $response_data['status'] = 0;
            $response_data['message'] =  __('themeicon::lang.something_error_please_try_again_later');
            return redirect('themeicon')->with('response_data', $response_data);
        }
    }

    /**
     * Show the specified resource.
     * @param  ThemeIcon\Http\Models\ThemeIcon  $themeicon
     * @return \Illuminate\Http\Response
     */
    public function show(ThemeIcon $themeicon)
    {
        if (!auth()->user()->can('themeicon_show')) {
            abort(403, 'Unauthorized action.');
        }
        $data = array();
        $data['themeicon']        = $themeicon;
        $data['title']        = 'themeicon_show';
        return view('themeicon::themeicon.show',$data);
    }
    /**
     * Show the specified resource.
     * @param  ThemeIcon\Http\Models\ThemeIcon  $themeicon
     * @return \Illuminate\Http\Response
     */
    public function pdf(ThemeIcon $themeicon)
    {
        if (!auth()->user()->can('themeicon_pdf')) {
            abort(403, 'Unauthorized action.');
        }
        $data = array();
        $data['themeicon']        = $themeicon;
        $data['title']        = 'themeicon_show';
        return view('themeicon::themeicon.pdf',$data);
    }

    /**
     * Show the form for editing the specified resource.
     * @param  ThemeIcon\Http\Models\ThemeIcon  $themeicon
     * @return \Illuminate\Http\Response
     */
    public function edit(ThemeIcon $themeicon)
    {
        if (!auth()->user()->can('themeicon_edit')) {
            abort(403, 'Unauthorized action.');
        }
        $data = array();
        $data['title']        = 'themeicon_edit';
        $data['record']        = $themeicon;
        return view('themeicon::themeicon.create',$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  ThemeIcon\Http\Models\ThemeIcon  $themeicon
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ThemeIcon  $themeicon)
    {
        if (!auth()->user()->can('themeicon_edit')) {
            abort(403, 'Unauthorized action.');
        }
        $validated = $request->validate([
            'name'              => 'bail|required|max:255',
        ]);

        $themeicon->name             = $request->name;
        $themeicon->description      = $request->description;
        $themeicon->status           = $request->status;
        $themeicon->save();

        $file_name = 'photo';
        if ($request->hasFile($file_name))
        {
//            return $file_name;
            $rules = $request->validate([
                "$file_name" => 'mimes:jpeg,jpg,png,gif|max:10000'
            ]);
            $path = $this->photo_path;
            deleteFile($themeicon->photo, $path);

            $themeicon->$file_name      = processUpload($request, $themeicon,$file_name,$path);
            $themeicon->save();
        }

        $response_data['status'] = 1;
        $response_data['message'] =  __('themeicon::lang.record_update_successfully');
        return redirect('themeicon')->with('response_data', $response_data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  ThemeIcon\Http\Models\ThemeIcon  $themeicon
     * @return \Illuminate\Http\Response
     */
    public function destroy(ThemeIcon  $themeicon)
    {
        if (!auth()->user()->can('themeicon_destroy')) {
            abort(403, 'Unauthorized action.');
        }
        try{
            $themeicon->delete();
            $path = $this->photo_path;
            deleteFile($themeicon->photo, $path);
            $response_data['status'] = 1;
            $response_data['message'] =  __('themeicon::lang.record_deleted_successfully');
        } catch ( \Exception $e) {
            $response_data['status'] = 0;
            $response_data['message'] =  __('themeicon::lang.this_record_is_in_use_in_other_modules');
        }
        return redirect('themeicon')->with('response_data', $response_data);
    }
}
