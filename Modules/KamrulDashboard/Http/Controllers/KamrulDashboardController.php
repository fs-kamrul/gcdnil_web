<?php

namespace Modules\KamrulDashboard\Http\Controllers;

use Maatwebsite\Excel\Facades\Excel;
use Modules\KamrulDashboard\Http\Models\KamrulDashboard;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\KamrulDashboard\Http\Imports\KamrulDashboardImport;
use mysql_xdevapi\Exception;

class KamrulDashboardController extends Controller
{

    protected $photo_path = 'uploads/kamruldashboard/';
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $data = array();
        page_title()->setTitle(trans('kamruldashboard::lang.kamruldashboard'));
        $data['title']        = 'kamruldashboard';
        return view('kamruldashboard::kamruldashboard.index',$data);
    }

    public function import()
    {
        $data = array();
        $data['title']        = 'kamruldashboard_import';
        return view('kamruldashboard::kamruldashboard.create_import',$data);
    }
    public function store_import(Request $request)
    {
        $file = $request->file('photo');
        Excel::import(new KamrulDashboardImport, $file);
        $response_data['status'] = 1;
        $response_data['message'] =  __('kamruldashboard::lang.record_save_successfully');
        return redirect('kamruldashboard')->with('response_data', $response_data);
    }
    public function data()
    {
        $custom_table = KamrulDashboard::all();
        return datatables()->of($custom_table)->addColumn('action', function ($row) {
            $html = '';
            $html .= '<a target="_blank" href="' . route('kamruldashboard.pdf_show', $row->id) . '" class="btn btn-xs btn-success">'. __('kamruldashboard::lang.pdf') .'</a> ';
            $html .= '<a href="' . route('kamruldashboard.show', $row->id) . '" class="btn btn-xs btn-success">'. __('kamruldashboard::lang.view') .'</a> ';
            $html .= '<a  href="' . route('kamruldashboard.edit', $row->id) . '" class="btn btn-xs btn-secondary">'. __('kamruldashboard::lang.edit') .'</a> ';

            $html .= '<form action="' . route('kamruldashboard.destroy', $row->id) . '" method="POST" style="display: inline-block;">
                        ' . csrf_field() . '
                        ' . method_field("DELETE") . '
                        <button type="submit" class="btn btn-xs btn-danger"
                            onclick="return confirm(\'Are You Sure Want to Delete?\')"
                            style="padding: .0em !important;"><i class="icon-trash"> </i>'. __('kamruldashboard::lang.delete') .'</button>
                        </form>';
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
        $data = array();
        $data['title']        = 'kamruldashboard_create';
        return view('kamruldashboard::kamruldashboard.create',$data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'              => 'bail|required|max:255',
        ]);

        try {
            $record = new KamrulDashboard();
            $record->name           = $request->name;
            $record->description    = $request->description;
            $record->status         = $request->status;
            $record->uuid         = gen_uuid();
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
            return redirect('kamruldashboard')->with('response_data', $response_data);
        }catch (Exception $e){

            $response_data['status'] = 0;
            $response_data['message'] =  __('kamruldashboard::lang.something_error_please_try_again_later');
            return redirect('kamruldashboard')->with('response_data', $response_data);
        }
    }

    /**
     * Show the specified resource.
     * @param  KamrulDashboard\Http\Models\KamrulDashboard  $kamruldashboard
     * @return \Illuminate\Http\Response
     */
    public function show(KamrulDashboard $kamruldashboard)
    {
        $data = array();
        $data['kamruldashboard']        = $kamruldashboard;
        $data['title']        = 'kamruldashboard_show';
        return view('kamruldashboard::kamruldashboard.show',$data);
    }
    /**
     * Show the specified resource.
     * @param  KamrulDashboard\Http\Models\KamrulDashboard  $kamruldashboard
     * @return \Illuminate\Http\Response
     */
    public function pdf(KamrulDashboard $kamruldashboard)
    {
        $data = array();
        $data['kamruldashboard']        = $kamruldashboard;
        $data['title']        = 'kamruldashboard_show';
        return view('kamruldashboard::kamruldashboard.pdf',$data);
    }

    /**
     * Show the form for editing the specified resource.
     * @param  KamrulDashboard\Http\Models\KamrulDashboard  $kamruldashboard
     * @return \Illuminate\Http\Response
     */
    public function edit(KamrulDashboard $kamruldashboard)
    {
        $data = array();
        $data['title']        = 'kamruldashboard_edit';
        $data['record']        = $kamruldashboard;
        return view('kamruldashboard::kamruldashboard.create',$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  KamrulDashboard\Http\Models\KamrulDashboard  $kamruldashboard
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, KamrulDashboard  $kamruldashboard)
    {
        $validated = $request->validate([
            'name'              => 'bail|required|max:255',
        ]);

        $kamruldashboard->name             = $request->name;
        $kamruldashboard->description      = $request->description;
        $kamruldashboard->status           = $request->status;
        $kamruldashboard->save();

        $file_name = 'photo';
        if ($request->hasFile($file_name))
        {
//            return $file_name;
            $rules = $request->validate([
                "$file_name" => 'mimes:jpeg,jpg,png,gif|max:10000'
            ]);
            $path = $this->photo_path;
            deleteFile($kamruldashboard->photo, $path);

            $kamruldashboard->$file_name      = processUpload($request, $kamruldashboard,$file_name,$path);
            $kamruldashboard->save();
        }

        $response_data['status'] = 1;
        $response_data['message'] =  __('kamruldashboard::lang.record_update_successfully');
        return redirect('kamruldashboard')->with('response_data', $response_data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  KamrulDashboard\Http\Models\KamrulDashboard  $kamruldashboard
     * @return \Illuminate\Http\Response
     */
    public function destroy(KamrulDashboard  $kamruldashboard)
    {
        try{
            $kamruldashboard->delete();
            $path = $this->photo_path;
            deleteFile($kamruldashboard->photo, $path);
            $response_data['status'] = 1;
            $response_data['message'] =  __('kamruldashboard::lang.record_deleted_successfully');
        } catch ( \Exception $e) {
            $response_data['status'] = 0;
            $response_data['message'] =  __('kamruldashboard::lang.this_record_is_in_use_in_other_modules');
        }
        return redirect('kamruldashboard')->with('response_data', $response_data);
    }
}
