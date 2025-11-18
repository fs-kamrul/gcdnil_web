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
use Modules\KamrulDashboard\Forms\FormBuilder;
use Modules\KamrulDashboard\Http\Models\Slug;
use Modules\KamrulDashboard\Http\Responses\DboardHttpResponse;
use Modules\KamrulDashboard\Traits\HasDeleteManyItemsTrait;
use Modules\Post\Forms\PageForm;
use Modules\Post\Http\Models\Page;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Post\Http\Imports\PageImport;
use Modules\Post\Http\Models\PageTemplate;
use Modules\Post\Http\Requests\PageRequest;
use Modules\Post\Repositories\Interfaces\PageInterface;
use Modules\Post\Tables\PageTable;
use mysql_xdevapi\Exception;
use SlugHelper;
use Throwable;

class PageController extends Controller
{

    use HasDeleteManyItemsTrait;
    protected $photo_path = 'uploads/post/page/';


    /**
     * @var PageInterface
     */
    protected $pageRepository;

    /**
     * PageController constructor.
     * @param PageInterface $pageRepository
     */
    public function __construct(PageInterface $pageRepository)
    {
        $this->pageRepository = $pageRepository;
    }

    /**
     * @param PageTable $dataTable
     * @return JsonResponse|View
     *
     * @throws Throwable
     */
    public function index(PageTable $dataTable)
    {
        if (!auth()->user()->can('page_access')) {
            abort(403, 'Unauthorized action.');
        }
        page_title()->setTitle(trans('post::lang.page'));

        return $dataTable->renderTable();
//        $data = array();
//        $data['title']        = 'page';
//        return view('post::page.index',$data);
    }

    public function import()
    {
        if (!auth()->user()->can('page_import')) {
            abort(403, 'Unauthorized action.');
        }
        page_title()->setTitle(trans('post::lang.page_import'));
        $data = array();
        $data['title']        = 'page_import';
        return view('post::page.create_import',$data);
    }
    public function store_import(Request $request)
    {
        if (!auth()->user()->can('page_import')) {
            abort(403, 'Unauthorized action.');
        }
        $file = $request->file('photo');
        Excel::import(new PageImport, $file);
        $response_data['status'] = 1;
        $response_data['message'] =  __('post::lang.record_save_successfully');
        return redirect('post/page')->with('response_data', $response_data);
    }
    public function data()
    {
        if (!auth()->user()->can('page_access')) {
            abort(403, 'Unauthorized action.');
        }
        if(auth()->user()->can('page_list_all')) {
            $custom_table = Page::all();
        }else {
            $custom_table = Page::where('user_id', Auth::id())->get();
        }
        return datatables()->of($custom_table)->addColumn('action', function ($row) {
            $html = '';
            if(auth()->user()->can('page_pdf')) {
                $html .= '<a target="_blank" href="' . route('post.page.pdf_show', $row->id) . '" class="btn btn-xs btn-success">' . __('post::lang.pdf') . '</a> ';
            }
            if(auth()->user()->can('page_show')) {
                $html .= '<a href="' . route('page.show', $row->id) . '" class="btn btn-xs btn-success">' . __('post::lang.view') . '</a> ';
            }
            if(auth()->user()->can('page_edit')) {
                $html .= '<a  href="' . route('page.edit', $row->id) . '" class="btn btn-xs btn-secondary">' . __('post::lang.edit') . '</a> ';
            }
            if(auth()->user()->can('page_destroy')) {
                $html .= '<form action="' . route('page.destroy', $row->id) . '" method="POST" style="display: inline-block;">
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
        })->addColumn('template', function ($row) {
            if($row->page_templates != null) {
                $html = $row->page_templates->name;
            }else{
                $html = '';
            }
            return $html;
        })->rawColumns(['action','status','photo','user','template'])->toJson();;
    }
    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        if (!auth()->user()->can('page_create')) {
            abort(403, 'Unauthorized action.');
        }
        page_title()->setTitle(trans('post::page_create'));

//        return $formBuilder->create(PageForm::class)->renderForm();
        $data = array();
        $data['title']        = 'page_create';
        $data['page_templates']   = PageTemplate::get();
        return view('post::page.create',$data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  PageRequest  $request
     * @param DboardHttpResponse $response
     * @return DboardHttpResponse
     * @return \Illuminate\Http\Response
     */
    public function store(PageRequest $request, DboardHttpResponse $response)
    {
        if (!auth()->user()->can('page_create')) {
            abort(403, 'Unauthorized action.');
        }
        try {
            $record = $this->pageRepository->createOrUpdate(array_merge($request->input(), [
                'user_id' => Auth::id(),
                'uuid'    => gen_uuid(),
                'slug'    => checkSlugFunction($request->input('name')),
            ]));
//            slugs_data_set($record->slug, $record->id,Page::class,SlugHelper::getPrefix(Page::class));
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
            event(new CreatedContentEvent(PAGE_MODULE_SCREEN_NAME, $request, $record));

            return $response
                ->setPreviousUrl(route('page.index'))
                ->setNextUrl(route('page.edit', $record->id))
                ->setMessage(trans('kamruldashboard::notices.create_success_message'));
        }catch (\Exception $e){

            return $response
                ->setPreviousUrl(route('page.index'))
                ->setMessage(trans('kamruldashboard::notices.something_error_please_try_again_later'));
        }
    }

    /**
     * Show the specified resource.
     * @param  Page $page
     * @return \Illuminate\Http\Response
     */
    public function show(Page $page)
    {
        if (!auth()->user()->can('page_show')) {
            abort(403, 'Unauthorized action.');
        }
        page_title()->setTitle(trans('post::lang.page_show'));
        $data = array();
        $data['page']        = $page;
        $data['title']        = 'page_show';
        return view('post::page.show',$data);
    }
    /**
     * Show the specified resource.
     * @param  Page $page
     * @return \Illuminate\Http\Response
     */
    public function pdf(Page $page)
    {
        if (!auth()->user()->can('page_pdf')) {
            abort(403, 'Unauthorized action.');
        }
        page_title()->setTitle(trans('post::lang.page_show'));
        $data = array();
        $data['page']        = $page;
        $data['title']        = 'page_show';
        return view('post::page.pdf',$data);
    }

    /**
     * Show the form for editing the specified resource.
     * @param Request $request
     * @param  Page  $page
     * @return \Illuminate\Http\Response
     */
    public function edit(Page $page, Request $request)
    {
        if (!auth()->user()->can('page_edit')) {
            abort(403, 'Unauthorized action.');
        }
        page_title()->setTitle(trans('post::lang.page_edit'));
        $data = array();
        $page = $this->pageRepository->findOrFail($page->id);
        $data['title']        = 'page_edit';
        $data['record']        = $page;
        $data['page_templates']   = PageTemplate::get();

        event(new BeforeEditContentEvent($request, $page));
        return view('post::page.create',$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  PageRequest  $request
     * @param  \Modules\Post\Http\Models\Page  $page
     * @param  DboardHttpResponse  $response
     * @return DboardHttpResponse
     * @return \Illuminate\Http\Response
     */
    public function update(PageRequest $request, Page  $page, DboardHttpResponse $response)
    {
        if (!auth()->user()->can('page_edit')) {
            abort(403, 'Unauthorized action.');
        }

        $page1 = $this->pageRepository->findOrFail($page->id);
        $page1->fill($request->input());
        $page1 = $this->pageRepository->createOrUpdate($page1);

        event(new UpdatedContentEvent(PAGE_MODULE_SCREEN_NAME, $request, $page1));

        $file_name = 'photo';
        if ($request->hasFile($file_name))
        {
//            return $file_name;
            $rules = $request->validate([
                "$file_name" => 'mimes:jpeg,jpg,png,gif|max:10000'
            ]);
            $path = $this->photo_path;
            deleteFile($page->photo, $path);

            $page->$file_name      = processUpload($request, $page,$file_name,$path);
            $page->save();
        }

        return $response
            ->setPreviousUrl(route('page.index'))
            ->setMessage(trans('kamruldashboard::notices.update_success_message'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @param  Page\Http\Models\Page  $page
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Page  $page)
    {
        if (!auth()->user()->can('page_destroy')) {
            abort(403, 'Unauthorized action.');
        }
        try{
            event(new DeletedContentEvent(PAGE_MODULE_SCREEN_NAME, $request, $page));
            Slug::where('key',$page->slug)->where('reference_id',$page->id)->where('reference_type',Page::class)->delete();
            $page->delete();
            $path = $this->photo_path;
            deleteFile($page->photo, $path);
            $response_data['status'] = 1;
            $response_data['message'] =  __('post::lang.record_deleted_successfully');
        } catch ( \Exception $e) {
            $response_data['status'] = 0;
            $response_data['message'] =  __('post::lang.this_record_is_in_use_in_other_modules');
        }
        return redirect()->route('page.index')->with('response_data', $response_data);
    }

    /**
     * @param Request $request
     * @param DboardHttpResponse $response
     * @return DboardHttpResponse
     * @throws \Exception
     */
    public function deletes(Request $request, DboardHttpResponse $response)
    {
        return $this->executeDeleteItems($request, $response, $this->pageRepository, PAGE_MODULE_SCREEN_NAME);
    }
}
