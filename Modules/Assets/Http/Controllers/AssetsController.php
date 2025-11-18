<?php

namespace Modules\Assets\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Modules\Assets\Http\Models\Assets;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Assets\Repositories\Interfaces\AssetsInterface;
use Modules\Assets\Http\Imports\AssetsImport;
use mysql_xdevapi\Exception;

class AssetsController extends Controller
{
    /**
     * @var AssetsInterface
     */
    protected $assetsRepository;

    /**
     * AssetsController constructor.
     * @param AssetsInterface $assetsRepository
     */
    public function __construct(AssetsInterface $assetsRepository)
    {
        $this->assetsRepository = $assetsRepository;
    }
    protected $photo_path = 'uploads/assets/';
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        if (!auth()->user()->can('assets_access')) {
            abort(403, 'Unauthorized action.');
        }
        $data = array();
        $data['title']        = 'assets';
        return view('assets::assets.index',$data);
    }

    public function import()
    {
        if (!auth()->user()->can('assets_import')) {
            abort(403, 'Unauthorized action.');
        }
        $data = array();
        $data['title']        = 'assets_import';
        return view('assets::assets.create_import',$data);
    }
    public function store_import(Request $request)
    {
        if (!auth()->user()->can('assets_import')) {
            abort(403, 'Unauthorized action.');
        }
        $file = $request->file('photo');
        Excel::import(new AssetsImport, $file);
        $response_data['status'] = 1;
        $response_data['message'] =  __('assets::lang.record_save_successfully');
        return redirect('assets')->with('response_data', $response_data);
    }
    public function data()
    {
        if (!auth()->user()->can('assets_access')) {
            abort(403, 'Unauthorized action.');
        }
        if(auth()->user()->can('assets_list_all')) {
            $custom_table = Assets::all();
        }else {
            $custom_table = Assets::where('user_id', Auth::id())->get();
        }
        return datatables()->of($custom_table)->addColumn('action', function ($row) {
            $html = '';
            if(auth()->user()->can('assets_pdf')) {
                $html .= '<a target="_blank" href="' . route('assets.pdf_show', $row->id) . '" class="btn btn-xs btn-success">' . __('assets::lang.pdf') . '</a> ';
            }
            if(auth()->user()->can('assets_show')) {
                $html .= '<a href="' . route('assets.show', $row->id) . '" class="btn btn-xs btn-success">' . __('assets::lang.view') . '</a> ';
            }
            if(auth()->user()->can('assets_edit')) {
                $html .= '<a  href="' . route('assets.edit', $row->id) . '" class="btn btn-xs btn-secondary">' . __('assets::lang.edit') . '</a> ';
            }
            if(auth()->user()->can('assets_destroy')) {
                $html .= '<form action="' . route('assets.destroy', $row->id) . '" method="POST" style="display: inline-block;">
                        ' . csrf_field() . '
                        ' . method_field("DELETE") . '
                        <button type="submit" class="btn btn-xs btn-danger"
                            onclick="return confirm(\'Are You Sure Want to Delete?\')"
                            style="padding: .0em !important;"><i class="icon-trash"> </i>' . __('assets::lang.delete') . '</button>
                        </form>';
            }
            return $html;
        })->addColumn('photo', function ($row) {
            $html = '<img style="height: 100px;width: 100px;" src="' . getImageUrl($row->photo,'assets') . '" alt="' . $row->name . '" class="img-rounded img-preview">';
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
        if (!auth()->user()->can('assets_create')) {
            abort(403, 'Unauthorized action.');
        }
        $data = array();
        $data['title']        = 'assets_create';
        return view('assets::assets.create',$data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!auth()->user()->can('assets_create')) {
            abort(403, 'Unauthorized action.');
        }
        $validated = $request->validate([
            'name'              => 'bail|required|max:255',
        ]);

        try {
            $record             = $this->assetsRepository->getModel();
            $record->fill($request->input());
            $record->user_id    = Auth::id();
            $record->uuid       = gen_uuid();
            $record->slug       = $this->assetsRepository->createSlug($request->input('name'));
            $record             = $this->assetsRepository->createOrUpdate($record);

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
            $response_data['message'] =  __('assets::lang.record_save_successfully');
            return redirect('assets')->with('response_data', $response_data);
        }catch (Exception $e){

            $response_data['status'] = 0;
            $response_data['message'] =  __('assets::lang.something_error_please_try_again_later');
            return redirect('assets')->with('response_data', $response_data);
        }
    }

    /**
     * Show the specified resource.
     * @param  Assets\Http\Models\Assets  $asset
     * @return \Illuminate\Http\Response
     */
    public function show(Assets $asset)
    {
        if (!auth()->user()->can('assets_show')) {
            abort(403, 'Unauthorized action.');
        }
        $data = array();
        $data['assets']        = $asset;
        $data['title']        = 'assets_show';
        return view('assets::assets.show',$data);
    }
    /**
     * Show the specified resource.
     * @param  Assets\Http\Models\Assets  $asset
     * @return \Illuminate\Http\Response
     */
    public function pdf(Assets $asset)
    {
        if (!auth()->user()->can('assets_pdf')) {
            abort(403, 'Unauthorized action.');
        }
        $data = array();
        $data['assets']        = $asset;
        $data['title']        = 'assets_show';
        return view('assets::assets.pdf',$data);
    }

    /**
     * Show the form for editing the specified resource.
     * @param  Assets\Http\Models\Assets  $asset
     * @return \Illuminate\Http\Response
     */
    public function edit(Assets $asset)
    {
        if (!auth()->user()->can('assets_edit')) {
            abort(403, 'Unauthorized action.');
        }
        $data = array();
        $data['title']        = 'assets_edit';
        $data['record']        = $asset;
        return view('assets::assets.create',$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Assets\Http\Models\Assets  $asset
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Assets  $asset)
    {
        if (!auth()->user()->can('assets_edit')) {
            abort(403, 'Unauthorized action.');
        }
        $validated = $request->validate([
            'name'              => 'bail|required|max:255',
        ]);

        $id = $asset->id;
        $asset = $this->assetsRepository->firstOrNew(compact('id'));
        $asset->fill($request->input());
        $this->assetsRepository->createOrUpdate($asset);

        $file_name = 'photo';
        if ($request->hasFile($file_name))
        {
//            return $file_name;
            $rules = $request->validate([
                "$file_name" => 'mimes:jpeg,jpg,png,gif|max:10000'
            ]);
            $path = $this->photo_path;
            deleteFile($asset->photo, $path);

            $asset->$file_name      = processUpload($request, $asset,$file_name,$path);
            $asset->save();
        }

        $response_data['status'] = 1;
        $response_data['message'] =  __('assets::lang.record_update_successfully');
        return redirect('assets')->with('response_data', $response_data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Assets\Http\Models\Assets  $asset
     * @return \Illuminate\Http\Response
     */
    public function destroy(Assets  $asset)
    {
        if (!auth()->user()->can('assets_destroy')) {
            abort(403, 'Unauthorized action.');
        }
        try{
            $asset->delete();
            $path = $this->photo_path;
            deleteFile($asset->photo, $path);
            $response_data['status'] = 1;
            $response_data['message'] =  __('assets::lang.record_deleted_successfully');
        } catch ( \Exception $e) {
            $response_data['status'] = 0;
            $response_data['message'] =  __('assets::lang.this_record_is_in_use_in_other_modules');
        }
        return redirect('assets')->with('response_data', $response_data);
    }
}
