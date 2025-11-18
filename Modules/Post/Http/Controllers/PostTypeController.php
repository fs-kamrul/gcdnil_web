<?php

namespace Modules\Post\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;
use Modules\KamrulDashboard\Http\Responses\DboardHttpResponse;
use Modules\KamrulDashboard\Traits\HasDeleteManyItemsTrait;
use Modules\Post\Http\Models\PostType;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Post\Http\Imports\PostTypeImport;
use Modules\Post\Repositories\Interfaces\PosttypeInterface;
use Modules\Post\Tables\PostTypeTable;
use mysql_xdevapi\Exception;
use Throwable;

class PostTypeController extends Controller
{

    use HasDeleteManyItemsTrait;
    protected $photo_path = 'uploads/post/posttype/';


    /**
     * @var PostTypeInterface
     */
    protected $posttypeRepository;

    /**
     * PostTypeController constructor.
     * @param PosttypeInterface $posttypeRepository
     */
    public function __construct(PostTypeInterface $posttypeRepository)
    {
        $this->posttypeRepository = $posttypeRepository;
    }

    /**
     * @param PostTypeTable $dataTable
     * @return JsonResponse|View
     *
     * @throws Throwable
     */
    public function index(PostTypeTable $dataTable)
    {
        $data = array();
        $data['title']        = 'posttype';
        page_title()->setTitle(trans('post::lang.posttype'));

        return $dataTable->renderTable();
//        return view('post::posttype.index',$data);
    }

    public function import()
    {
        $data = array();
        $data['title']        = 'posttype_import';
        return view('post::posttype.create_import',$data);
    }
    public function store_import(Request $request)
    {
        $file = $request->file('photo');
        Excel::import(new PostTypeImport, $file);
        $response_data['status'] = 1;
        $response_data['message'] =  __('post::lang.record_save_successfully');
        return redirect()->route('posttype.index')->with('response_data', $response_data);
    }
    public function data()
    {
        if(auth()->user()->can('posttype_list_all')) {
            $custom_table = PostType::all();
        }else {
            $custom_table = PostType::where('user_id', Auth::id())->get();
        }
        return datatables()->of($custom_table)->addColumn('action', function ($row) {
            $html = '';
            if(auth()->user()->can('posttype_pdf')) {
                $html .= '<a target="_blank" href="' . route('posttype.pdf_show', $row->id) . '" class="btn btn-xs btn-success">' . __('post::lang.pdf') . '</a> ';
            }
            if(auth()->user()->can('posttype_show')) {
                $html .= '<a href="' . route('posttype.show', $row->id) . '" class="btn btn-xs btn-success">' . __('post::lang.view') . '</a> ';
            }
            if(auth()->user()->can('posttype_edit')) {
//                $html .= '<a  href="' . route('posttype.edit', $row->id) . '" class="btn btn-xs btn-secondary">' . __('post::lang.edit') . '</a> ';
            }
            if(auth()->user()->can('posttype_destroy')) {
//                $html .= '<form action="' . route('posttype.destroy', $row->id) . '" method="POST" style="display: inline-block;">
//                            ' . csrf_field() . '
//                            ' . method_field("DELETE") . '
//                            <button type="submit" class="btn btn-xs btn-danger"
//                                onclick="return confirm(\'Are You Sure Want to Delete?\')"
//                                style="padding: .0em !important;"><i class="icon-trash"> </i>' . __('post::lang.delete') . '</button>
//                            </form>';
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
        $data = array();
        $data['title']        = 'posttype_create';
        return view('post::posttype.create',$data);
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
            $record = new PostType();
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
            $response_data['message'] =  __('post::lang.record_save_successfully');
            return redirect()->route('posttype.index')->with('response_data', $response_data);
        }catch (Exception $e){

            $response_data['status'] = 0;
            $response_data['message'] =  __('post::lang.something_error_please_try_again_later');
            return redirect()->route('posttype.index')->with('response_data', $response_data);
        }
    }

    /**
     * Show the specified resource.
     * @param  \Modules\Post\Http\Models\PostType  $posttype
     * @return \Illuminate\Http\Response
     */
    public function show(PostType $posttype)
    {
        $data = array();
        $data['posttype']        = $posttype;
        $data['title']        = 'posttype_show';
        return view('post::posttype.show',$data);
    }
    /**
     * Show the specified resource.
     * @param  PostType\Http\Models\PostType  $posttype
     * @return \Illuminate\Http\Response
     */
    public function pdf(PostType $posttype)
    {
        $data = array();
        $data['posttype']        = $posttype;
        $data['title']        = 'posttype_show';
        return view('post::posttype.pdf',$data);
    }

    /**
     * Show the form for editing the specified resource.
     * @param  \Modules\Post\Http\Models\PostType  $posttype
     * @return \Illuminate\Http\Response
     */
    public function edit(PostType $posttype)
    {
        $data = array();
        $data['title']        = 'posttype_edit';
        $data['record']        = $posttype;
        return view('post::posttype.create',$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Modules\Post\Http\Models\PostType  $posttype
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PostType  $posttype)
    {
        $validated = $request->validate([
            'name'              => 'bail|required|max:255',
        ]);

        $posttype->name             = $request->name;
        $posttype->description      = $request->description;
        $posttype->status           = $request->status;
        $posttype->save();

        $file_name = 'photo';
        if ($request->hasFile($file_name))
        {
//            return $file_name;
            $rules = $request->validate([
                "$file_name" => 'mimes:jpeg,jpg,png,gif|max:10000'
            ]);
            $path = $this->photo_path;
            deleteFile($posttype->photo, $path);

            $posttype->$file_name      = processUpload($request, $posttype,$file_name,$path);
            $posttype->save();
        }

        $response_data['status'] = 1;
        $response_data['message'] =  __('post::lang.record_update_successfully');
        return redirect()->route('posttype.index')->with('response_data', $response_data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Modules\Post\Http\Models\PostType  $posttype
     * @return \Illuminate\Http\Response
     */
    public function destroy(PostType  $posttype)
    {
        try{
            $posttype->delete();
            $path = $this->photo_path;
            deleteFile($posttype->photo, $path);
            $response_data['status'] = 1;
            $response_data['message'] =  __('post::lang.record_deleted_successfully');
        } catch ( \Exception $e) {
            $response_data['status'] = 0;
            $response_data['message'] =  __('post::lang.this_record_is_in_use_in_other_modules');
        }
        return redirect()->route('posttype.index')->with('response_data', $response_data);
    }
    /**
     * @param Request $request
     * @param DboardHttpResponse $response
     * @return DboardHttpResponse
     * @throws \Exception
     */
    public function deletes(Request $request, DboardHttpResponse $response)
    {
        return $this->executeDeleteItems($request, $response, $this->posttypeRepository, PAGE_MODULE_SCREEN_NAME);
    }
}
