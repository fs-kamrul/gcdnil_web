<?php

namespace Modules\Shortcodes\Http\Controllers;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Modules\Post\Http\Models\PostGallery;
use Modules\Shortcodes\Http\Models\Shortcodes;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Shortcodes\Http\Imports\ShortcodesImport;
use mysql_xdevapi\Exception;

class ShortcodesController extends Controller
{

    protected $photo_path = 'uploads/shortcodes/';

    public function ajaxGetAdminConfig($key, Request $request)
    {
        $registered = shortcode()->getAll();

        $data['data'] = Arr::get($registered, $key . '.admin_config');

        $code = $request->input('code');

        $attributes = [];
        $content = null;

        if ($code) {
            $compiler = shortcode()->getCompiler();
            $attributes = $compiler->getAttributes(html_entity_decode($code));
            $content = $compiler->getContent();
        }

        if ($data['data'] instanceof \Closure) {
            $data['data'] = call_user_func($data['data'], $attributes, $content);
        }

        $data = apply_filters(SHORTCODE_REGISTER_CONTENT_IN_ADMIN, $data, $key, $attributes);

        return $data;
//        return $response->setData($data);
    }
    public function uploadFile(Request $request, $type)
    {
//        return $request;
        $fileName = 'file';
//        if ($request->hasFile($file_name))
//        {
//            return $file_name;
        $rules = $request->validate([
            //mimes:jpeg,jpg,png,gif|
//                "firstname" => 'bail|required|max:255',
            "file" => 'mimes:jpeg,jpg,webp,png,gif,pdf,zip|max:20000'
        ]);
        $path = $this->photo_path;
//        $image = $request->file($fileName);
//        $fileInfo = $image->getClientOriginalName();
//        $filename = pathinfo($fileInfo, PATHINFO_FILENAME);
//        $extension = pathinfo($fileInfo, PATHINFO_EXTENSION);
//        $file_name= $filename.'-'.time().'.'.$extension;
//        $image->move($path,$file_name);
        if ($type == 'download') {
            $file_name = documentProcessUpload($request, '', $fileName, $path);
        }else{
            $file_name = processUpload($request, '', $fileName, $path);
        }

        $imageUpload                = new PostGallery();
        $imageUpload->name          = $file_name;
        $imageUpload->user_id       = Auth::id();
        $imageUpload->save();

//        return response()->json(['success'=>$imageUpload->id]);
        return response()->json(['success'=>$file_name,'photo_data'=>$imageUpload->id]);
    }
    public function destroy_uploadFile(Request $request)
    {
        $path = $this->photo_path;
        $filename =  $request->get('filename');
//        return $filename;
        $data = PostGallery::where('name',$filename)->first();
        PostGallery::where('name',$filename)->delete();
//        dd($data);
        $path = $path.$filename;
        if (file_exists($path)) {
            unlink($path);
        }
        return response()->json(['success'=>$filename, 'id' => $data->id]);
    }
    public function getImages($id)
    {
        $images = array();
        $data = array();
        $tableImages = array();
        $path = $this->photo_path;
        if (is_array(json_decode($id))) {
            $id = json_decode($id);
        } else {
            $id = explode(",", $id);
        }
        foreach ($id as $value) {
            $image_data = PostGallery::where('id', $value)->get();
            if (!$image_data->isEmpty() && $value != 0) {
                foreach ($image_data as $key => $image_to) {
                    $tableImages[$key] = $image_to->name;
                }
                $storeFolder = public_path('uploads/shortcodes');
                $files = scandir($storeFolder);
                foreach ($files as $file) {
                    if ($file != '.' && $file != '..' && in_array($file, $tableImages)) {
                        $obj['id'] = $value;
                        $obj['name'] = $file;
                        $file_path = public_path('uploads/shortcodes/') . $file;
                        $obj['size'] = filesize($file_path);
                        $obj['path'] = url('uploads/shortcodes/' . $file);
                        $data[] = $obj;
                    }
                }
            }
        }
        return response()->json($data);
    }
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        if (!auth()->user()->can('shortcodes_access')) {
            abort(403, 'Unauthorized action.');
        }
        $data = array();
        $data['title']        = 'shortcodes';
        return view('shortcodes::shortcodes.index',$data);
    }

    public function import()
    {
        if (!auth()->user()->can('shortcodes_import')) {
            abort(403, 'Unauthorized action.');
        }
        $data = array();
        $data['title']        = 'shortcodes_import';
        return view('shortcodes::shortcodes.create_import',$data);
    }
    public function store_import(Request $request)
    {
        if (!auth()->user()->can('shortcodes_import')) {
            abort(403, 'Unauthorized action.');
        }
        $file = $request->file('photo');
        Excel::import(new ShortcodesImport, $file);
        $response_data['status'] = 1;
        $response_data['message'] =  __('shortcodes::lang.record_save_successfully');
        return redirect('shortcodes')->with('response_data', $response_data);
    }
    public function data()
    {
        if (!auth()->user()->can('shortcodes_access')) {
            abort(403, 'Unauthorized action.');
        }
        if(auth()->user()->can('shortcodes_list_all')) {
            $custom_table = Shortcodes::all();
        }else {
            $custom_table = Shortcodes::where('user_id', Auth::id())->get();
        }
        return datatables()->of($custom_table)->addColumn('action', function ($row) {
            $html = '';
            if(auth()->user()->can('shortcodes_pdf')) {
                $html .= '<a target="_blank" href="' . route('shortcodes.pdf_show', $row->id) . '" class="btn btn-xs btn-success">' . __('shortcodes::lang.pdf') . '</a> ';
            }
            if(auth()->user()->can('shortcodes_show')) {
                $html .= '<a href="' . route('shortcodes.show', $row->id) . '" class="btn btn-xs btn-success">' . __('shortcodes::lang.view') . '</a> ';
            }
            if(auth()->user()->can('shortcodes_edit')) {
                $html .= '<a  href="' . route('shortcodes.edit', $row->id) . '" class="btn btn-xs btn-secondary">' . __('shortcodes::lang.edit') . '</a> ';
            }
            if(auth()->user()->can('shortcodes_destroy')) {
                $html .= '<form action="' . route('shortcodes.destroy', $row->id) . '" method="POST" style="display: inline-block;">
                        ' . csrf_field() . '
                        ' . method_field("DELETE") . '
                        <button type="submit" class="btn btn-xs btn-danger"
                            onclick="return confirm(\'Are You Sure Want to Delete?\')"
                            style="padding: .0em !important;"><i class="icon-trash"> </i>' . __('shortcodes::lang.delete') . '</button>
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
        if (!auth()->user()->can('shortcodes_create')) {
            abort(403, 'Unauthorized action.');
        }
        $data = array();
        $data['title']        = 'shortcodes_create';
        return view('shortcodes::shortcodes.create',$data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!auth()->user()->can('shortcodes_create')) {
            abort(403, 'Unauthorized action.');
        }
        $validated = $request->validate([
            'name'              => 'bail|required|max:255',
        ]);

        try {
            $record = new Shortcodes();
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
            $response_data['message'] =  __('shortcodes::lang.record_save_successfully');
            return redirect('shortcodes')->with('response_data', $response_data);
        }catch (Exception $e){

            $response_data['status'] = 0;
            $response_data['message'] =  __('shortcodes::lang.something_error_please_try_again_later');
            return redirect('shortcodes')->with('response_data', $response_data);
        }
    }

    /**
     * Show the specified resource.
     * @param  Shortcodes\Http\Models\Shortcodes  $shortcode
     * @return \Illuminate\Http\Response
     */
    public function show(Shortcodes $shortcode)
    {
        if (!auth()->user()->can('shortcodes_show')) {
            abort(403, 'Unauthorized action.');
        }
        $data = array();
        $data['shortcodes']        = $shortcode;
        $data['title']        = 'shortcodes_show';
        return view('shortcodes::shortcodes.show',$data);
    }
    /**
     * Show the specified resource.
     * @param  Shortcodes\Http\Models\Shortcodes  $shortcode
     * @return \Illuminate\Http\Response
     */
    public function pdf(Shortcodes $shortcode)
    {
        if (!auth()->user()->can('shortcodes_pdf')) {
            abort(403, 'Unauthorized action.');
        }
        $data = array();
        $data['shortcodes']        = $shortcode;
        $data['title']        = 'shortcodes_show';
        return view('shortcodes::shortcodes.pdf',$data);
    }

    /**
     * Show the form for editing the specified resource.
     * @param  Shortcodes\Http\Models\Shortcodes  $shortcode
     * @return \Illuminate\Http\Response
     */
    public function edit(Shortcodes $shortcode)
    {
        if (!auth()->user()->can('shortcodes_edit')) {
            abort(403, 'Unauthorized action.');
        }
        $data = array();
        $data['title']        = 'shortcodes_edit';
        $data['record']        = $shortcode;
        return view('shortcodes::shortcodes.create',$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Shortcodes\Http\Models\Shortcodes  $shortcode
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Shortcodes  $shortcode)
    {
        if (!auth()->user()->can('shortcodes_edit')) {
            abort(403, 'Unauthorized action.');
        }
        $validated = $request->validate([
            'name'              => 'bail|required|max:255',
        ]);

        $shortcode->name             = $request->name;
        $shortcode->description      = $request->description;
        $shortcode->status           = $request->status;
        $shortcode->save();

        $file_name = 'photo';
        if ($request->hasFile($file_name))
        {
//            return $file_name;
            $rules = $request->validate([
                "$file_name" => 'mimes:jpeg,jpg,png,gif|max:10000'
            ]);
            $path = $this->photo_path;
            deleteFile($shortcode->photo, $path);

            $shortcode->$file_name      = processUpload($request, $shortcode,$file_name,$path);
            $shortcode->save();
        }

        $response_data['status'] = 1;
        $response_data['message'] =  __('shortcodes::lang.record_update_successfully');
        return redirect('shortcodes')->with('response_data', $response_data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Shortcodes\Http\Models\Shortcodes  $shortcode
     * @return \Illuminate\Http\Response
     */
    public function destroy(Shortcodes  $shortcode)
    {
        if (!auth()->user()->can('shortcodes_destroy')) {
            abort(403, 'Unauthorized action.');
        }
        try{
            $shortcode->delete();
            $path = $this->photo_path;
            deleteFile($shortcode->photo, $path);
            $response_data['status'] = 1;
            $response_data['message'] =  __('shortcodes::lang.record_deleted_successfully');
        } catch ( \Exception $e) {
            $response_data['status'] = 0;
            $response_data['message'] =  __('shortcodes::lang.this_record_is_in_use_in_other_modules');
        }
        return redirect('shortcodes')->with('response_data', $response_data);
    }
}
