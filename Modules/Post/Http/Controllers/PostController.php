<?php

namespace Modules\Post\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Modules\KamrulDashboard\Events\BeforeEditContentEvent;
use Modules\KamrulDashboard\Events\CreatedContentEvent;
use Modules\KamrulDashboard\Events\UpdatedContentEvent;
use Modules\KamrulDashboard\Http\Models\Slug;
use Modules\KamrulDashboard\Http\Responses\DboardHttpResponse;
use Modules\KamrulDashboard\Packages\Supports\DboardStatus;
use Modules\KamrulDashboard\Traits\HasDeleteManyItemsTrait;
use Modules\Post\Http\Models\Category;
use Modules\Post\Http\Models\Post;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Post\Http\Imports\PostImport;
use Modules\Post\Http\Models\PostGallery;
use Modules\Post\Http\Models\PostGalleryParameter;
use Modules\Post\Http\Models\PostType;
use Modules\Post\Repositories\Interfaces\CategoryInterface;
use Modules\Post\Repositories\Interfaces\PostInterface;
use Modules\Post\Tables\PostTable;
use mysql_xdevapi\Exception;
use SlugHelper;

class PostController extends Controller
{

    use HasDeleteManyItemsTrait;
    /**
     * @var PostInterface
     */
    protected $postRepository;
    /**
     * @var CategoryInterface
     */
    protected $categoryRepository;
    protected $photo_path = 'uploads/post/';

    /**
     * @param PostInterface $postRepository
     * @param CategoryInterface $categoryRepository
     */
    public function __construct(
        PostInterface $postRepository,
        CategoryInterface $categoryRepository
    ) {
        $this->postRepository = $postRepository;
        $this->categoryRepository = $categoryRepository;
    }
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(PostTable $dataTable)
    {
        if (!auth()->user()->can('post_access')) {
            abort(403, 'Unauthorized action.');
        }
        page_title()->setTitle(trans('post::lang.post'));

        return $dataTable->renderTable();
//        $data = array();
//        $data['title']        = 'post';
//        return view('post::post.index',$data);
    }

    public function import()
    {
        $data = array();
        page_title()->setTitle(trans('post::lang.post_import'));
        $data['title']        = 'post_import';
        return view('post::post.create_import',$data);
    }
    public function store_import(Request $request)
    {
        $file = $request->file('photo');
        Excel::import(new PostImport, $file);
        $response_data['status'] = 1;
        $response_data['message'] =  __('post::lang.record_save_successfully');
        return redirect()->route('post.index')->with('response_data', $response_data);
    }
    public function data()
    {
        if(auth()->user()->can('post_list_all')) {
            $custom_table = Post::all();
        }else {
            $custom_table = Post::where('user_id', Auth::id())->get();
        }
        return datatables()->of($custom_table)->addColumn('action', function ($row) {
            $html = '';
            if(auth()->user()->can('post_pdf')) {
                $html .= '<a target="_blank" href="' . route('post.pdf_show', $row->id) . '" class="btn btn-xs btn-success">' . __('post::lang.pdf') . '</a> ';
            }
            if(auth()->user()->can('post_show')) {
                $html .= '<a href="' . route('post.show', $row->id) . '" class="btn btn-xs btn-success">' . __('post::lang.view') . '</a> ';
            }
            if(auth()->user()->can('post_edit')) {
                $html .= '<a  href="' . route('post.edit', $row->id) . '" class="btn btn-xs btn-secondary">' . __('post::lang.edit') . '</a> ';
            }
            if(auth()->user()->can('post_destroy')) {
                $html .= '<form action="' . route('post.destroy', $row->id) . '" method="POST" style="display: inline-block;">
                        ' . csrf_field() . '
                        ' . method_field("DELETE") . '
                        <button type="submit" class="btn btn-xs btn-danger"
                            onclick="return confirm(\'Are You Sure Want to Delete?\')"
                            style="padding: .0em !important;"><i class="icon-trash"> </i>' . __('post::lang.delete') . '</button>
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
        })->addColumn('post_types', function ($row) {
            if($row->post_types != ''){
                $html = $row->post_types->name;
            }else{
                $html = '';
            }
            return $html;
        })->rawColumns(['action','status','photo','user','post_types'])->toJson();;
    }
    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        page_title()->setTitle(trans('post::lang.post_create'));
        $data = array();
        $data['title']        = 'post_create';
        $data['category']   = Category::where('status',DboardStatus::PUBLISHED)->get();
//        $data['category']   = Category::where('status',DboardStatus::PUBLISHED)->where('user_id',Auth::id())->get();
        $data['posttype']   = PostType::where('status',Dboardstatus::PUBLISHED)->get();
        return view('post::post.create',$data);
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
            'post_types_id'     => 'bail|required',
        ]);

//        $categories = $request->categories;
        try {
//            $record             = $this->postRepository->getModel();
//            $record->fill($request->input());
//            $record->user_id    = Auth::id();
//            $record->uuid       = gen_uuid();
//            $record->slug       = $this->postRepository->createSlug($request->input('name'));
//            $record             = $this->postRepository->createOrUpdate($record);

//            $record = $this->postRepository->createOrUpdate(
//                array_merge($request->input(), [
//                    'user_id'       => Auth::id(),
//                    'uuid'          => gen_uuid(),
//                    'slug'          => gen_uuid(),
//                ])
//            );
            $record = new Post();
            $data_slug          = $record->createSlug($request->name);
            $record->name               = $request->name;
            $record->header_title       = $request->header_title;
            $record->tag_line           = $request->tag_line;
//            $record->icon_set               = $request->icon_set;
            $record->check_design       = $request->check_design;
            $record->start_date         = $request->start_date;
            $record->set_time           = $request->set_time;
            $record->description        = $request->description;
            $record->short_description  = $request->short_description;
            $record->slug               = $data_slug;
            $record->status             = $request->status;
            $record->post_types_id      = $request->post_types_id;
            $record->designation        = $request->designation;
            $record->uuid               = gen_uuid();
            $record->user_id            = Auth::id();
            $record->save();
            slugs_data_set($data_slug, $record->id,Post::class,SlugHelper::getPrefix(Post::class));
            event(new CreatedContentEvent(POST_MODULE_SCREEN_NAME, $request, $record));
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
            $file_name1 = 'document_file';
            if ($request->hasFile($file_name1))
            {
//                return $file_name1;
//                $rules = $request->validate([
//                    "$file_name1" => 'mimes:jpeg,jpg,png,gif,pdf,zip,rir|max:10000'
//                ]);
                $path = $this->photo_path;
                deleteFile($record->$file_name1, $path);

                $record->$file_name1      = documentProcessUpload($request, $record,$file_name1, $path);
                $record->save();
            }
            $file_name2 = 'icon_set';
            if ($request->hasFile($file_name2))
            {
//                return $file_name2;
//                $rules = $request->validate([
//                    "$file_name2" => 'mimes:jpeg,jpg,png,gif,pdf,zip,rir|max:10000'
//                ]);
                $path = $this->photo_path;
                deleteFile($record->$file_name2, $path);

                $record->$file_name2      = processUpload($request, $record,$file_name2, $path);
                $record->save();
            }
            $categories = $request->categories;
            if (!empty($categories) && is_array($categories)) {
                $record->categories()->sync($categories);
            }

            if(is_module_active('Branch')) {
                $branch = $request->branch;
                if (!empty($branch) && is_array($branch)) {
                    $record->branch()->sync($branch);
                }
            }
            $PostGalleryParameter = $request->pics_file;
            if (!empty($PostGalleryParameter) && is_array($PostGalleryParameter)) {
                $record->PostGalleryParameter()->sync($PostGalleryParameter);
            }
            $response_data['status'] = 1;
            $response_data['message'] =  __('post::lang.record_save_successfully');
            return redirect()->route('post.index')->with('response_data', $response_data);
        }catch (Exception $e){

            $response_data['status'] = 0;
            $response_data['message'] =  __('post::lang.something_error_please_try_again_later');
            return redirect()->route('post.index')->with('response_data', $response_data);
        }
    }

    /**
     * Show the specified resource.
     * @param  Post\Http\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        page_title()->setTitle(trans('post::lang.post_show'));
        $data = array();
        $data['post']        = $post;
        $data['title']        = 'post_show';
        return view('post::post.show',$data);
    }
    /**
     * Show the specified resource.
     * @param  Post\Http\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function pdf(Post $post)
    {
        $data = array();
        $data['post']        = $post;
        $data['title']        = 'post_show';
        return view('post::post.pdf',$data);
    }

    /**
     * Show the form for editing the specified resource.
     * @param  Post\Http\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post, Request $request)
    {
        page_title()->setTitle(trans('post::lang.post_edit'));
        $data = array();
        $data['title']        = 'post_edit';
        $page = $this->postRepository->findOrFail($post->id);
        event(new BeforeEditContentEvent($request, $post));
        $data['record']        = $page;
        $data['category']   = Category::where('status',1)->get();
        $data['posttype']   = PostType::where('status',1)->get();
        return view('post::post.create',$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function uploadFile(Request $request)
    {
//        return $request;
        $file_name = 'file';
//        if ($request->hasFile($file_name))
//        {
//            return $file_name;
            $rules = $request->validate([
                //mimes:jpeg,jpg,png,gif|
//                "firstname" => 'bail|required|max:255',
                "file" => 'mimes:jpeg,jpg,png,gif|max:20000'
            ]);
            $path = $this->photo_path;
//        $image = $request->file('file');
//        $fileInfo = $image->getClientOriginalName();
//        $filename = pathinfo($fileInfo, PATHINFO_FILENAME);
//        $extension = pathinfo($fileInfo, PATHINFO_EXTENSION);
//        $file_name= $filename.'-'.time().'.'.$extension;
//        $image->move($path,$file_name);
        $file_name = processUpload($request, '', $file_name, $path);

        $imageUpload                = new PostGallery();
        $imageUpload->name          = $file_name;
        $imageUpload->user_id       = Auth::id();
        $imageUpload->save();

//        return response()->json(['success'=>$imageUpload->id]);
        return response()->json(['success'=>$file_name,'photo_data'=>$imageUpload->id]);
//        return response()->json(['success'=>$file_name]);
//            $image = $request->file($file_name);
//            $imageName = time() . '.' . $image->extension();
//            $image->move($path, $imageName);
//            return response()->json(['success' => $imageName]);
//            $path = $this->photo_path;
//            deleteFile($post->photo, $path);
//
//            $post->$file_name      = processUpload($request, $post,$file_name,$path);
//            $post->save();
//        }
    }
    public function destroy_uploadFile(Request $request)
    {
        $path = $this->photo_path;
        $filename =  $request->get('filename');
//        return $filename;
        PostGallery::where('name',$filename)->delete();
        $path = $path.$filename;
        if (file_exists($path)) {
            unlink($path);
        }
        return response()->json(['success'=>$filename]);
    }
    public function getImages($id)
    {
        $images = array();
        $data = array();
        $tableImages = array();
        $path = $this->photo_path;
//        $images = PostGallery::all()->toArray();
        $image_data = PostGalleryParameter::where('post_id', $id)->get();
//        $images = PostGalleryParameter::where('post_id', 49)->get()->toArray();
        if($image_data && $id!=0) {
            foreach ($image_data as $key => $image_to) {
                $images[$key] = $image_to->PostGallery->toArray();
            }

            foreach ($images as $image) {
                $tableImages[] = $image['name'];
            }
//        $storeFolder = $path;
//        $file_path = $path;
            $storeFolder = public_path('uploads/post');
//            $file_path = public_path('uploads/post/');
//            $files = scandir($storeFolder);


            foreach ($tableImages as $tableImage) {
                $file_path = public_path('uploads/post/') . $tableImage;
                if(file_exists($file_path)){
                    $obj['name'] = $tableImage;
                    $obj['size'] = filesize($file_path);
                    $obj['path'] = url('uploads/post/' . $tableImage);
                    $data[] = $obj;
                }
            }
//            dd($tableImage);
//            dd($data);
//            foreach ($files as $file) {
//                if ($file != '.' && $file != '..' && in_array($file, $tableImages)) {
//                    $obj['name'] = $file;
//                    $file_path = public_path('uploads/post/') . $file;
//                    $obj['size'] = filesize($file_path);
//                    $obj['path'] = url('uploads/post/' . $file);
//                    $data[] = $obj;
//                }
//            }
        }
        return response()->json($data);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Modules\Post\Http\Models\Post  $post
     * @param DboardHttpResponse $response
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post  $post, DboardHttpResponse $response)
    {
        $validated = $request->validate([
            'name'              => 'bail|required|max:255',
            'post_types_id'     => 'bail|required',
        ]);
//        $post = $this->postRepository->findOrFail($post->id);
////
//        $post->fill($request->input());

//        $this->postRepository->createOrUpdate($post);
        $post->name             = $request->name;
        $post->header_title     = $request->header_title;
        $post->tag_line         = $request->tag_line;
//        $post->icon_set             = $request->icon_set;
        $post->check_design     = $request->check_design;
        $post->start_date       = $request->start_date;
        $post->set_time         = $request->set_time;
        $post->description      = $request->description;
        $post->slug             = update_slug_table($request->slug,$request->slug_id,Post::class);
        $post->short_description = $request->short_description;
        $post->status           = $request->status;
        $post->post_types_id    = $request->post_types_id;
        $post->designation      = $request->designation;
        $post->save();

        $file_name = 'photo';
        if ($request->hasFile($file_name))
        {
//            return $file_name;
            $rules = $request->validate([
                "$file_name" => 'mimes:jpeg,jpg,png,gif|max:10000'
            ]);
            $path = $this->photo_path;
            deleteFile($post->$file_name, $path);

            $post->$file_name      = processUpload($request, $post,$file_name,$path);
            $post->save();
        }
        $file_name1 = 'document_file';
        if ($request->hasFile($file_name1))
        {
//                return $file_name1;
                $rules = $request->validate([
                    "$file_name1" => 'max:10000'
                ]);
            $path = $this->photo_path;
            deleteFile($post->$file_name1, $path);

            $post->$file_name1      = documentProcessUpload($request, $post,$file_name1, $path);
            $post->save();
        }

        $file_name2 = 'icon_set';
        if ($request->hasFile($file_name2))
        {
//                return $file_name2;
//                $rules = $request->validate([
//                    "$file_name2" => 'mimes:jpeg,jpg,png,gif,pdf,zip,rir|max:10000'
//                ]);
            $path = $this->photo_path;
            deleteFile($post->$file_name2, $path);

            $post->$file_name2      = processUpload($request, $post,$file_name2, $path);
            $post->save();
        }
        $categories = $request->categories;
//        if (!empty($categories) && is_array($categories)) {
            $post->categories()->sync($categories);
//        }
        if(is_module_active('Branch')) {
            $branch = $request->branch;
            $post->branch()->sync($branch);
        }
        $PostGalleryParameter = $request->pics_file;
        $post->PostGalleryParameter()->sync($PostGalleryParameter);

        $response_data['status'] = 1;
        $response_data['message'] =  __('post::lang.record_update_successfully');

        event(new UpdatedContentEvent(POST_MODULE_SCREEN_NAME, $request, $post));

        return $response
            ->setPreviousUrl(route('post.index'))
            ->setMessage(trans('kamruldashboard::notices.update_success_message'));
//        return redirect()->route('post.index')->with('response_data', $response_data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Post\Http\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post  $post)
    {
        try{
            Slug::where('key',$post->slug)->where('reference_id',$post->id)->where('reference_type',Post::class)->delete();
            $post->delete();
            $path = $this->photo_path;
            deleteFile($post->photo, $path);
            $response_data['status'] = 1;
            $response_data['message'] =  __('post::lang.record_deleted_successfully');
        } catch ( \Exception $e) {
            $response_data['status'] = 0;
            $response_data['message'] =  __('post::lang.this_record_is_in_use_in_other_modules');
        }
        return redirect()->route('post.index')->with('response_data', $response_data);
    }
    /**
     * @param Request $request
     * @param DboardHttpResponse $response
     * @return DboardHttpResponse
     * @throws \Exception
     */
    public function deletes(Request $request, DboardHttpResponse $response)
    {
        return $this->executeDeleteItems($request, $response, $this->postRepository, PAGE_MODULE_SCREEN_NAME);
    }
}
