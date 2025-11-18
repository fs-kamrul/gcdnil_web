<?php

namespace Modules\Faq\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;
use Modules\Faq\Http\Requests\FaqCategoryRequest;
use Modules\KamrulDashboard\Events\DeletedContentEvent;
use Modules\KamrulDashboard\Events\UpdatedContentEvent;
use Modules\KamrulDashboard\Events\CreatedContentEvent;
use Modules\KamrulDashboard\Http\Responses\DboardHttpResponse;
use Modules\Faq\Http\Models\FaqCategory;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Modules\KamrulDashboard\Traits\HasDeleteManyItemsTrait;
use Illuminate\Routing\Controller;
use Modules\Faq\Repositories\Interfaces\FaqCategoryInterface;
use Modules\Faq\Http\Imports\FaqCategoryImport;
use Modules\Faq\Tables\FaqCategoryTable;
use mysql_xdevapi\Exception;
use Throwable;

class FaqCategoryController extends Controller
{
    use HasDeleteManyItemsTrait;
    /**
     * @var FaqCategoryInterface
     */
    protected $faqcategoryRepository;

    /**
     * FaqCategoryController constructor.
     * @param FaqCategoryInterface $faqcategoryRepository
     */
    public function __construct(FaqCategoryInterface $faqcategoryRepository)
    {
        $this->faqcategoryRepository = $faqcategoryRepository;
    }
    protected $photo_path = 'uploads/faq/faqcategory/';

    /**
     * @param FaqCategoryTable $dataTable
     * @return JsonResponse|View
     *
     * @throws Throwable
     */
    public function index(FaqCategoryTable $dataTable)
    {
        if (!auth()->user()->can('faqcategory_access')) {
            abort(403, 'Unauthorized action.');
        }
        page_title()->setTitle(trans('faq::lang.faqcategory'));

        return $dataTable->renderTable();
    }

    public function import()
    {
        if (!auth()->user()->can('faqcategory_import')) {
            abort(403, 'Unauthorized action.');
        }
        page_title()->setTitle(trans('faq::lang.faqcategory_import'));
        $data = array();
        $data['title']        = 'faqcategory_import';
        return view('faq::faqcategory.create_import',$data);
    }
    public function store_import(Request $request)
    {
        if (!auth()->user()->can('faqcategory_import')) {
            abort(403, 'Unauthorized action.');
        }
        $file = $request->file('photo');
        Excel::import(new FaqCategoryImport, $file);
        $response_data['status'] = 1;
        $response_data['message'] =  __('faq::lang.record_save_successfully');
        return redirect()->route('faqcategory.index')->with('response_data', $response_data);
    }
    public function data()
    {
        if (!auth()->user()->can('faqcategory_access')) {
            abort(403, 'Unauthorized action.');
        }
        if(auth()->user()->can('faqcategory_list_all')) {
            $custom_table = FaqCategory::all();
        }else {
            $custom_table = FaqCategory::where('user_id', Auth::id())->get();
        }
        return datatables()->of($custom_table)->addColumn('action', function ($row) {
            $html = '';
            if(auth()->user()->can('faqcategory_pdf')) {
                $html .= '<a target="_blank" href="' . url('faq/faqcategory/pdf_show', $row->id) . '" class="btn btn-xs btn-success">' . __('faq::lang.pdf') . '</a> ';
            }
            if(auth()->user()->can('faqcategory_show')) {
                $html .= '<a href="' . url('faq/faqcategory/' . $row->id) . '" class="btn btn-xs btn-success">' . __('faq::lang.view') . '</a> ';
            }
            if(auth()->user()->can('faqcategory_edit')) {
                $html .= '<a  href="' . url('faq/faqcategory/' . $row->id . "/edit") . '" class="btn btn-xs btn-secondary">' . __('faq::lang.edit') . '</a> ';
            }
            if(auth()->user()->can('faqcategory_destroy')) {
                $html .= '<form action="' . url('faq/faqcategory', $row->id) . '" method="POST" style="display: inline-block;">
                            ' . csrf_field() . '
                            ' . method_field("DELETE") . '
                            <button type="submit" class="btn btn-xs btn-danger"
                                onclick="return confirm(\'Are You Sure Want to Delete?\')"
                                style="padding: .0em !important;"><i class="icon-trash"> </i>' . __('faq::lang.delete') . '</button>
                            </form>';
            }
            return $html;
        })->addColumn('photo', function ($row) {
            $html = '<img style="height: 100px;width: 100px;" src="' . getImageUrl($row->photo,'faq/faqcategory') . '" alt="' . $row->name . '" class="img-rounded img-preview">';
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
        if (!auth()->user()->can('faqcategory_create')) {
            abort(403, 'Unauthorized action.');
        }
        page_title()->setTitle(trans('faq::lang.faqcategory_create'));
        $data = array();
        $data['title']        = 'faqcategory_create';
        return view('faq::faqcategory.create',$data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param DboardHttpResponse $response
     * @return DboardHttpResponse
     * @return \Illuminate\Http\Response
     */
    public function store(FaqCategoryRequest $request, DboardHttpResponse $response)
    {
        if (!auth()->user()->can('faqcategory_create')) {
            abort(403, 'Unauthorized action.');
        }

        try {
            $record = $this->faqcategoryRepository->createOrUpdate(array_merge($request->input()));

            event(new CreatedContentEvent(FAQ_CATEGORY_MODULE_SCREEN_NAME, $request, $record));
            return $response
                ->setPreviousUrl(route('faqcategory.index'))
                ->setNextUrl(route('faqcategory.edit', $record->id))
                ->setMessage(trans('kamruldashboard::notices.create_success_message'));
        }catch (\Exception $e){

            return $response
                ->setPreviousUrl(route('faqcategory.index'))
                ->setMessage(trans('kamruldashboard::notices.something_error_please_try_again_later'));
        }
    }

    /**
     * Show the specified resource.
     * @param  \Modules\Faq\Http\Models\FaqCategory  $faqcategory
     * @return \Illuminate\Http\Response
     */
    public function show(FaqCategory $faqcategory)
    {
        if (!auth()->user()->can('faqcategory_show')) {
            abort(403, 'Unauthorized action.');
        }
        page_title()->setTitle(trans('faq::lang.faqcategory_show'));
        $data = array();
        $data['faqcategory']        = $faqcategory;
        $data['title']        = 'faqcategory_show';
        return view('faq::faqcategory.show',$data);
    }
    /**
     * Show the specified resource.
     * @param  \Modules\Faq\Http\Models\FaqCategory  $faqcategory
     * @return \Illuminate\Http\Response
     */
    public function pdf(FaqCategory $faqcategory)
    {
        if (!auth()->user()->can('faqcategory_pdf')) {
            abort(403, 'Unauthorized action.');
        }
        page_title()->setTitle(trans('faq::lang.faqcategory_show'));
        $data = array();
        $data['faqcategory']        = $faqcategory;
        $data['title']        = 'faqcategory_show';
        return view('faq::faqcategory.pdf',$data);
    }

    /**
     * Show the form for editing the specified resource.
     * @param  \Modules\Faq\Http\Models\FaqCategory  $faqcategory
     * @return \Illuminate\Http\Response
     */
    public function edit(FaqCategory $faqcategory)
    {
        if (!auth()->user()->can('faqcategory_edit')) {
            abort(403, 'Unauthorized action.');
        }
//        page_title()->setTitle(trans('faq::lang.faqcategory_edit'));
        $data = array();
        $data['title']        = 'faqcategory_edit';
        $data['record']        = $this->faqcategoryRepository->findOrFail($faqcategory->id);
        page_title()->setTitle(trans('plugins/faq::faq-category.edit') . ' "' . $data['record']->name . '"');
        return view('faq::faqcategory.create',$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Modules\Faq\Http\Models\FaqCategory  $faqcategory
     * @param  DboardHttpResponse  $response
     * @return DboardHttpResponse
     * @return \Illuminate\Http\Response
     */
    public function update(FaqCategoryRequest $request, FaqCategory  $faqcategory, DboardHttpResponse $response)
    {
        if (!auth()->user()->can('faqcategory_edit')) {
            abort(403, 'Unauthorized action.');
        }

        $id = $faqcategory->id;
        $faqcategory = $this->faqcategoryRepository->firstOrNew(compact('id'));
        $faqcategory->fill($request->input());
        $this->faqcategoryRepository->createOrUpdate($faqcategory);

        event(new UpdatedContentEvent(FAQ_CATEGORY_MODULE_SCREEN_NAME, $request, $faqcategory));

        return $response
            ->setPreviousUrl(route('faqcategory.index'))
            ->setMessage(trans('kamruldashboard::notices.update_success_message'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @param int $id
     * @param DboardHttpResponse $response
     * @return DboardHttpResponse
     */
    public function destroy(Request $request, $id, DboardHttpResponse $response)
    {
        if (!auth()->user()->can('faqcategory_destroy')) {
            abort(403, 'Unauthorized action.');
        }
        try{

            $faqcategory = $this->faqcategoryRepository->findOrFail($id);
            $this->faqcategoryRepository->delete($faqcategory);
            $path = $this->photo_path;
            deleteFile($faqcategory->photo, $path);
            event(new DeletedContentEvent(FAQ_CATEGORY_MODULE_SCREEN_NAME, $request, $faqcategory));

            return $response->setMessage(trans('kamruldashboard::notices.delete_success_message'));
        } catch ( \Exception $e) {
            return $response
                ->setError()
                ->setMessage($e->getMessage());
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
//        return $this->executeDeleteItems($request, $response, $this->faqcategoryRepository, FAQ_CATEGORY_MODULE_SCREEN_NAME);

        $ids = $request->input('ids');
        if (empty($ids)) {
            return $response
                ->setError()
                ->setMessage(trans('kamruldashboard::notices.no_select'));
        }

        foreach ($ids as $id) {
            $faqCategory = $this->faqcategoryRepository->findOrFail($id);
            $this->faqcategoryRepository->delete($faqCategory);
            event(new DeletedContentEvent(FAQ_CATEGORY_MODULE_SCREEN_NAME, $request, $faqCategory));
        }

        return $response->setMessage(trans('kamruldashboard::notices.delete_success_message'));
    }
}
