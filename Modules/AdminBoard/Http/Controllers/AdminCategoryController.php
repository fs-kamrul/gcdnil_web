<?php

namespace Modules\AdminBoard\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;
use Modules\AdminBoard\Forms\CategoryForm;
use Modules\AdminBoard\Http\Requests\AdminCategoryRequest;
use Modules\AdminBoard\Http\Requests\UpdateTreeCategoryRequest;
use Modules\KamrulDashboard\Events\DeletedContentEvent;
use Modules\KamrulDashboard\Events\UpdatedContentEvent;
use Modules\KamrulDashboard\Events\CreatedContentEvent;
use Modules\KamrulDashboard\Forms\FormAbstract;
use Modules\KamrulDashboard\Forms\FormBuilder;
use Modules\KamrulDashboard\Http\Controllers\DboardController;
use Modules\KamrulDashboard\Http\Responses\DboardHttpResponse;
use Modules\AdminBoard\Http\Models\AdminCategory;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Modules\KamrulDashboard\Traits\HasDeleteManyItemsTrait;
use Modules\AdminBoard\Repositories\Interfaces\AdminCategoryInterface;
use Modules\AdminBoard\Http\Imports\AdminCategoryImport;
use Modules\AdminBoard\Tables\AdminCategoryTable;
use Exception;
use Throwable;
use Assets;

class AdminCategoryController extends DboardController
{
    use HasDeleteManyItemsTrait;
    /**
     * @var AdminCategoryInterface
     */
    protected $admincategoryRepository;

    /**
     * AdminCategoryController constructor.
     * @param AdminCategoryInterface $admincategoryRepository
     */
    public function __construct(AdminCategoryInterface $admincategoryRepository)
    {
        $this->admincategoryRepository = $admincategoryRepository;

    }
    protected $photo_path = 'uploads/adminboard/admincategory/';

    /**
     * @param AdminCategoryTable $dataTable
     * @return JsonResponse|View
     *
     * @throws Throwable
     */
//    public function index(AdminCategoryTable $dataTable)
    public function index(FormBuilder $formBuilder,Request $request)
    {
        if (!auth()->user()->can('admincategory_access')) {
            abort(403, 'Unauthorized action.');
        }
        page_title()->setTitle(trans('adminboard::lang.admincategory'));
//
//        return $dataTable->renderTable();
//        $this->pageTitle(trans('plugins/real-estate::category.name'));

        $categories = $this->admincategoryRepository->getAdminCategory(['*'], [
//            'created_at' => 'DESC',
//            'is_default' => 'DESC',
            'order' => 'ASC',
        ]);

        $categories->loadCount(['adminworkshops', 'adminnews', 'adminteams', 'adminnoticeboards', 'adminevents']);
//        dd($categories);

        if ($request->ajax()) {
            $data = view('kamruldashboard::forms.partials.tree-categories', $this->getOptions(compact('categories')))->render();

            return $this
                ->httpResponse()
                ->setData($data);
        }

        Assets::addStylesDirectly(['vendor/Modules/KamrulDashboard/css/tree-category.css'])
            ->addScriptsDirectly(['vendor/Modules/KamrulDashboard/js/tree-category.js']);

        $form = CategoryForm::create(['template' => 'kamruldashboard::forms.form-tree-category']);
//        $form = $formBuilder->create(CategoryForm::class, ['template' => 'kamruldashboard::forms.form-tree-category']);
        $form = $this->setFormOptions($form, null, compact('categories'));

        return $form->renderForm();
    }

    public function updateTree(UpdateTreeCategoryRequest $request, DboardHttpResponse $response)
    {
//        dd($request->validated('data'));
        AdminCategory::updateTree($request->validated('data'));


        return $response
            ->setMessage(trans('kamruldashboard::notices.update_success_message'));
    }
    protected function setFormOptions(FormAbstract $form, AdminCategory $model = null, array $options = [])
    {
        if (! $model) {
            $form->setUrl(route('admincategory.create'));
        }

        if (! Auth::user()->can('admincategory_create') && ! $model) {
            $class = $form->getFormOption('class');
            $form->setFormOption('class', $class . ' d-none');
        }

        $form->setFormOptions($this->getOptions($options));

        return $form;
    }
    protected function getOptions(array $options = [])
    {
        return array_merge([
            'canCreate' => Auth::user()->can('admincategory_create'),
            'canEdit' => Auth::user()->can('admincategory_edit'),
            'canDelete' => Auth::user()->can('admincategory_destroy'),
            'createRoute' => 'admincategory.create',
            'editRoute' => 'admincategory.edit',
            'deleteRoute' => 'admincategory.destroy',
            'updateTreeRoute' => 'admincategory.update-tree',
        ], $options);
    }
    public function import()
    {
        if (!auth()->user()->can('admincategory_import')) {
            abort(403, 'Unauthorized action.');
        }
        page_title()->setTitle(trans('adminboard::lang.admincategory_import'));
        $data = array();
        $data['title']        = 'admincategory_import';
        return view('adminboard::admincategory.create_import',$data);
    }
    public function store_import(Request $request)
    {
        if (!auth()->user()->can('admincategory_import')) {
            abort(403, 'Unauthorized action.');
        }
        $file = $request->file('photo');
        Excel::import(new AdminCategoryImport, $file);
        $response_data['status'] = 1;
        $response_data['message'] =  __('adminboard::lang.record_save_successfully');
        return redirect()->route('admincategory.index')->with('response_data', $response_data);
    }
    public function data()
    {
        if (!auth()->user()->can('admincategory_access')) {
            abort(403, 'Unauthorized action.');
        }
        if(auth()->user()->can('admincategory_list_all')) {
            $custom_table = AdminCategory::all();
        }else {
            $custom_table = AdminCategory::where('user_id', Auth::id())->get();
        }
        return datatables()->of($custom_table)->addColumn('action', function ($row) {
            $html = '';
            if(auth()->user()->can('admincategory_pdf')) {
                $html .= '<a target="_blank" href="' . url('adminboard/admincategory/pdf_show', $row->id) . '" class="btn btn-xs btn-success">' . __('adminboard::lang.pdf') . '</a> ';
            }
            if(auth()->user()->can('admincategory_show')) {
                $html .= '<a href="' . url('adminboard/admincategory/' . $row->id) . '" class="btn btn-xs btn-success">' . __('adminboard::lang.view') . '</a> ';
            }
            if(auth()->user()->can('admincategory_edit')) {
                $html .= '<a  href="' . url('adminboard/admincategory/' . $row->id . "/edit") . '" class="btn btn-xs btn-secondary">' . __('adminboard::lang.edit') . '</a> ';
            }
            if(auth()->user()->can('admincategory_destroy')) {
                $html .= '<form action="' . url('adminboard/admincategory', $row->id) . '" method="POST" style="display: inline-block;">
                            ' . csrf_field() . '
                            ' . method_field("DELETE") . '
                            <button type="submit" class="btn btn-xs btn-danger"
                                onclick="return confirm(\'Are You Sure Want to Delete?\')"
                                style="padding: .0em !important;"><i class="icon-trash"> </i>' . __('adminboard::lang.delete') . '</button>
                            </form>';
            }
            return $html;
        })->addColumn('photo', function ($row) {
            $html = '<img style="height: 100px;width: 100px;" src="' . getImageUrl($row->photo,'adminboard/admincategory') . '" alt="' . $row->name . '" class="img-rounded img-preview">';
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
    public function create(Request $request, DboardHttpResponse $response)
    {
        if (!auth()->user()->can('admincategory_create')) {
            abort(403, 'Unauthorized action.');
        }
        page_title()->setTitle(trans('adminboard::lang.admincategory_create'));
//        $data = array();
//        $data['title']        = 'admincategory_create';
//        return view('adminboard::admincategory.create',$data);
        if ($request->ajax()) {
            return $this
                ->httpResponse()
                ->setData($this->getForm());
        }

        return CategoryForm::create()->renderForm();
    }

    protected function getForm(AdminCategory $model = null)
    {
        $options = ['template' => 'kamruldashboard::forms.form-no-wrap'];

        if ($model) {
            $options['model'] = $model;
        }

        $form = app(FormBuilder::class)->create(CategoryForm::class, $options);

        $form = $this->setFormOptions($form, $model);

        return $form->renderForm();
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param DboardHttpResponse $response
     * @return DboardHttpResponse
     * @return \Illuminate\Http\Response
     */
    public function store(AdminCategoryRequest $request, DboardHttpResponse $response)
    {
        if (!auth()->user()->can('admincategory_create')) {
            abort(403, 'Unauthorized action.');
        }
//        $validated = $request->validate([
//            'name'              => 'bail|required|max:255',
//        ]);

        if ($request->input('is_default')) {
            AdminCategory::query()->where('id', '>', 0)->update(['is_default' => 0]);
        }

//        try {
//            $record = $this->admincategoryRepository->createOrUpdate(array_merge($request->input(), [
//                'user_id' => Auth::id(),
//                'uuid'    => gen_uuid(),
//                'slug'    => checkSlugFunction($request->input('name')),
//            ]));
//
//            $file_name = 'photo';
//            if ($request->hasFile($file_name))
//            {
////                return $file_name;
//                $rules = $request->validate([
//                    "$file_name" => 'mimes:jpeg,jpg,png,gif|max:10000'
//                ]);
//                $path = $this->photo_path;
//                deleteFile($record->$file_name, $path);
//
//                $record->$file_name      = processUpload($request, $record,$file_name, $path);
//                $record->save();
//            }
//            event(new CreatedContentEvent(ADMINCATEGORY_MODULE_SCREEN_NAME, $request, $record));
//
//            return $response
//                ->setPreviousUrl(route('admincategory.index'))
//                ->setNextUrl(route('admincategory.edit', $record->id))
//                ->setMessage(trans('kamruldashboard::notices.create_success_message'));
//        }catch (\Exception $e){
//
//            return $response
//                ->setPreviousUrl(route('admincategory.index'))
//                ->setMessage(trans('kamruldashboard::notices.something_error_please_try_again_later'));
//        }
        $category = AdminCategory::query()->create($request->input());

        event(new CreatedContentEvent(ADMINCATEGORY_MODULE_SCREEN_NAME, $request, $category));

        if ($request->ajax()) {
            $category = AdminCategory::query()->findOrFail($category->getKey());

            if ($request->input('submit') == 'save') {
                $form = $this->getForm();
            } else {
                $form = $this->getForm($category);
            }

            $this
                ->httpResponse()
                ->setData([
                    'model' => $category,
                    'form' => $form,
                ]);
        }

        return $this
            ->httpResponse()
            ->setPreviousUrl(route('admincategory.index'))
            ->setNextUrl(route('admincategory.edit', $category->getKey()))
            ->setMessage(trans('kamruldashboard::notices.create_success_message'));
    }

    /**
     * Show the specified resource.
     * @param  \Modules\AdminBoard\Http\Models\AdminCategory  $admincategory
     * @return \Illuminate\Http\Response
     */
    public function show(AdminCategory $admincategory)
    {
        if (!auth()->user()->can('admincategory_show')) {
            abort(403, 'Unauthorized action.');
        }
        page_title()->setTitle(trans('adminboard::lang.admincategory_show'));
        $data = array();
        $data['admincategory']        = $admincategory;
        $data['title']        = 'admincategory_show';
        return view('adminboard::admincategory.show',$data);
    }
    /**
     * Show the specified resource.
     * @param  \Modules\AdminBoard\Http\Models\AdminCategory  $admincategory
     * @return \Illuminate\Http\Response
     */
    public function pdf(AdminCategory $admincategory)
    {
        if (!auth()->user()->can('admincategory_pdf')) {
            abort(403, 'Unauthorized action.');
        }
        page_title()->setTitle(trans('adminboard::lang.admincategory_show'));
        $data = array();
        $data['admincategory']        = $admincategory;
        $data['title']        = 'admincategory_show';
        return view('adminboard::admincategory.pdf',$data);
    }

    /**
     * Show the form for editing the specified resource.
     * @param  \Modules\AdminBoard\Http\Models\AdminCategory  $admincategory
     * @return \Illuminate\Http\Response
     */
    public function edit(AdminCategory $admincategory, Request $request)
    {
        if (!auth()->user()->can('admincategory_edit')) {
            abort(403, 'Unauthorized action.');
        }
        page_title()->setTitle(trans('adminboard::lang.admincategory_edit'));
//        $data = array();
//        $data['title']        = 'admincategory_edit';
//        $data['record']        = $this->admincategoryRepository->findOrFail($admincategory->id);
//        return view('adminboard::admincategory.create',$data);
        if ($request->ajax()) {
            return $this
                ->httpResponse()
                ->setData($this->getForm($admincategory));
        }

        $this->pageTitle(trans('kamruldashboard::forms.edit_item', ['name' => $admincategory->name]));

        return CategoryForm::createFromModel($admincategory)->renderForm();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Modules\AdminBoard\Http\Models\AdminCategory  $admincategory
     * @param  DboardHttpResponse  $response
     * @return DboardHttpResponse
     * @return \Illuminate\Http\Response
     */
    public function update(AdminCategoryRequest $request, AdminCategory  $admincategory, DboardHttpResponse $response)
    {
        if (!auth()->user()->can('admincategory_edit')) {
            abort(403, 'Unauthorized action.');
        }
//        $validated = $request->validate([
//            'name'              => 'bail|required|max:255',
//        ]);
//
//        $id = $admincategory->id;
//        $admincategory = $this->admincategoryRepository->firstOrNew(compact('id'));
//        $admincategory->fill($request->input());
//        $this->admincategoryRepository->createOrUpdate($admincategory);
//
//        $file_name = 'photo';
//        if ($request->hasFile($file_name))
//        {
////            return $file_name;
//            $rules = $request->validate([
//                "$file_name" => 'mimes:jpeg,jpg,png,gif|max:10000'
//            ]);
//            $path = $this->photo_path;
//            deleteFile($admincategory->$file_name, $path);
//
//            $admincategory->$file_name      = processUpload($request, $admincategory,$file_name,$path);
//            $admincategory->save();
//        }
//
//        event(new UpdatedContentEvent(ADMINCATEGORY_MODULE_SCREEN_NAME, $request, $admincategory));
//
//        return $response
//            ->setPreviousUrl(route('admincategory.index'))
//            ->setMessage(trans('kamruldashboard::notices.update_success_message'));
        if ($request->input('is_default')) {
            AdminCategory::query()->where('id', '!=', $admincategory->getKey())->update(['is_default' => 0]);
        }

        CategoryForm::createFromModel($admincategory)->save();

        $response = $this->httpResponse();

        if ($request->ajax()) {
            if ($response->isSaving()) {
                $form = $this->getForm();
            } else {
                $form = $this->getForm($admincategory);
            }

            $response->setData([
                'model' => $admincategory,
                'form' => $form,
            ]);
        }

        return $response
            ->setPreviousRoute('admincategory.index')
            ->withUpdatedSuccessMessage();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @param int $id
     * @param DboardHttpResponse $response
     * @return DboardHttpResponse
     */
    public function destroy(AdminCategory $admincategory,Request $request)
    {
        if (!auth()->user()->can('admincategory_destroy')) {
            abort(403, 'Unauthorized action.');
        }
//        try{
//
//            $admincategory = $this->admincategoryRepository->findOrFail($id);
//            $this->admincategoryRepository->delete($admincategory);
//            $path = $this->photo_path;
//            deleteFile($admincategory->photo, $path);
//            event(new DeletedContentEvent(ADMINCATEGORY_MODULE_SCREEN_NAME, $request, $admincategory));
//
//            return $response->setMessage(trans('kamruldashboard::notices.delete_success_message'));
//        } catch ( \Exception $e) {
//            return $response
//                ->setError()
//                ->setMessage($e->getMessage());
//        }
        try {
            $admincategory->delete();

            event(new DeletedContentEvent(ADMINCATEGORY_MODULE_SCREEN_NAME, $request, $admincategory));

            return $this
                ->httpResponse()
                ->setMessage(trans('kamruldashboard::notices.delete_success_message'));
        } catch (Exception $exception) {
            return $this
                ->httpResponse()
                ->setError()
                ->setMessage($exception->getMessage());
        }
    }
    /**
     * @param Request $request
     * @param DboardHttpResponse $response
     * @return DboardHttpResponse
     * @throws \Exception
     */
    public function deletes(Request $request, DboardHttpResponse $response)
    {
        return $this->executeDeleteItems($request, $response, $this->admincategoryRepository, ADMINCATEGORY_MODULE_SCREEN_NAME);
    }
}
