<?php

namespace Modules\Post\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;
use Modules\KamrulDashboard\Events\BeforeEditContentEvent;
use Modules\KamrulDashboard\Events\CreatedContentEvent;
use Modules\KamrulDashboard\Events\DeletedContentEvent;
use Modules\KamrulDashboard\Events\UpdatedContentEvent;
use Modules\KamrulDashboard\Http\Models\Slug;
use Modules\KamrulDashboard\Http\Responses\DboardHttpResponse;
use Modules\KamrulDashboard\Traits\HasDeleteManyItemsTrait;
use Modules\Post\Http\Models\Category;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Post\Http\Imports\CategoryImport;
use Modules\Post\Repositories\Interfaces\CategoryInterface;
use Modules\Post\Tables\CategoryTable;
use Exception;
use SlugHelper;
use Throwable;

class CategoryController extends Controller
{

    use HasDeleteManyItemsTrait;
    protected $photo_path = 'uploads/post/category/';


    /**
     * @var CategoryInterface
     */
    protected $categoryRepository;

    /**
     * CategoryController constructor.
     * @param CategoryInterface $categoryRepository
     */
    public function __construct(CategoryInterface $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * @param CategoryTable $dataTable
     * @return JsonResponse|View
     *
     * @throws Throwable
     */
    public function index(CategoryTable $dataTable)
    {
        if (!auth()->user()->can('category_access')) {
            abort(403, 'Unauthorized action.');
        }
        page_title()->setTitle(trans('post::lang.category'));

        return $dataTable->renderTable();
//        $data = array();
//        $data['title']        = 'category';
//        return view('post::category.index',$data);
    }

    public function import()
    {
        $data = array();
        $data['title']        = 'category_import';
        return view('post::category.create_import',$data);
    }
    public function store_import(Request $request)
    {
        $file = $request->file('photo');
        Excel::import(new CategoryImport, $file);
        $response_data['status'] = 1;
        $response_data['message'] =  __('post::lang.record_save_successfully');
        return redirect()->route('category.index')->with('response_data', $response_data);
    }
    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $data = array();
        $data['title']        = 'category_create';
        $data['category']     = Category::get();
        return view('post::category.create',$data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, DboardHttpResponse $response)
    {
        $validated = $request->validate([
            'name'              => 'bail|required|max:255',
        ]);

        try {
            $record = $this->categoryRepository->createOrUpdate(array_merge($request->input(), [
                'uuid'    => gen_uuid(),
                'user_id' => Auth::id(),
            ]));
//            $record = new Category();
//            $record->name           = $request->name;
//            $record->description    = $request->description;
//            $record->status         = $request->status;
////            $record->slug           = $record->createSlug($request->name);
//            $record->slug           = null;
//            $record->short_description = $request->short_description;
//            $record->parent_id      = $request->parent_id;
//            $record->uuid           = gen_uuid();
//            $record->user_id        = Auth::id();
//            $record->save();

//            slugs_data_set($record->slug, $record->id,Category::class,SlugHelper::getPrefix(Category::class));

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
            event(new CreatedContentEvent(CATEGORY_MODULE_SCREEN_NAME, $request, $record));

            $response_data['status'] = 1;
            $response_data['message'] =  __('post::lang.record_save_successfully');
            return redirect()->route('category.index')->with('response_data', $response_data);
        }catch (Exception $e){

            $response_data['status'] = 0;
            $response_data['message'] =  __('post::lang.something_error_please_try_again_later');
            return redirect()->route('category.index')->with('response_data', $response_data);
        }
    }

    /**
     * Show the specified resource.
     * @param  Category\Http\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        $data = array();
        $data['category']        = $category;
        $data['title']        = 'category_show';
        return view('post::category.show',$data);
    }
    /**
     * Show the specified resource.
     * @param  Category\Http\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function pdf(Category $category)
    {
        $data = array();
        $data['category']        = $category;
        $data['title']        = 'category_show';
        return view('post::category.pdf',$data);
    }

    /**
     * Show the form for editing the specified resource.
     * @param  Category\Http\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category, Request $request)
    {
        page_title()->setTitle(trans('post::lang.category_edit'));
        $categories = $this->categoryRepository->findOrFail($category->id);
        event(new BeforeEditContentEvent($request, $category));
        $data = array();
        $data['title']        = 'category_edit';
        $data['record']       = $categories;
        $data['category']     = Category::get();
        return view('post::category.create',$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Category\Http\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category  $category)
    {
        $validated = $request->validate([
            'name'              => 'bail|required|max:255',
        ]);

        $id = $category->id;
        $category = $this->categoryRepository->firstOrNew(compact('id'));
        $category->fill($request->input());
        $this->categoryRepository->createOrUpdate($category);
//        $category->name             = $request->name;
//        $category->description      = $request->description;
////        $category->slug             = update_slug_table($request->slug,$request->slug_id,Category::class);
//        $category->short_description= $request->short_description;
//        $category->status           = $request->status;
//        $category->parent_id        = $request->parent_id;
//        $category->save();

        $file_name = 'photo';
        if ($request->hasFile($file_name))
        {
//            return $file_name;
            $rules = $request->validate([
                "$file_name" => 'mimes:jpeg,jpg,png,gif|max:10000'
            ]);
            $path = $this->photo_path;
            deleteFile($category->photo, $path);

            $category->$file_name      = processUpload($request, $category,$file_name,$path);
            $category->save();
        }
        event(new UpdatedContentEvent(CATEGORY_MODULE_SCREEN_NAME, $request, $category));

        $response_data['status'] = 1;
        $response_data['message'] =  __('post::lang.record_update_successfully');
        return redirect()->route('category.index')->with('response_data', $response_data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Category\Http\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Category  $category)
    {
        try{
            event(new DeletedContentEvent(PAGE_MODULE_SCREEN_NAME, $request, $category));
            Slug::where('key',$category->slug)->where('reference_id',$category->id)->where('reference_type',Category::class)->delete();
            $category->delete();
            $path = $this->photo_path;
            deleteFile($category->photo, $path);
            $response_data['status'] = 1;
            $response_data['message'] =  __('post::lang.record_deleted_successfully');
        } catch ( \Exception $e) {
            $response_data['status'] = 0;
            $response_data['message'] =  __('post::lang.this_record_is_in_use_in_other_modules');
        }
        return redirect()->route('category.index')->with('response_data', $response_data);
    }
    /**
     * @param Request $request
     * @param DboardHttpResponse $response
     * @return DboardHttpResponse
     * @throws \Exception
     */
    public function deletes(Request $request, DboardHttpResponse $response)
    {
        return $this->executeDeleteItems($request, $response, $this->categoryRepository, PAGE_MODULE_SCREEN_NAME);
    }
}
