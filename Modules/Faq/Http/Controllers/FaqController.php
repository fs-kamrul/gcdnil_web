<?php

namespace Modules\Faq\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;
use Modules\Faq\Http\Requests\FaqRequest;
use Modules\KamrulDashboard\Events\DeletedContentEvent;
use Modules\KamrulDashboard\Events\UpdatedContentEvent;
use Modules\KamrulDashboard\Events\CreatedContentEvent;
use Modules\KamrulDashboard\Http\Responses\DboardHttpResponse;
use Modules\KamrulDashboard\Traits\HasDeleteManyItemsTrait;
use Modules\Faq\Http\Models\Faq;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Faq\Repositories\Interfaces\FaqInterface;
use Modules\Faq\Http\Imports\FaqImport;
use Modules\Faq\Tables\FaqTable;
use mysql_xdevapi\Exception;
use Throwable;

class FaqController extends Controller
{
    use HasDeleteManyItemsTrait;
    /**
     * @var FaqInterface
     */
    protected $faqRepository;

    /**
     * FaqController constructor.
     * @param FaqInterface $faqRepository
     */
    public function __construct(FaqInterface $faqRepository)
    {
        $this->faqRepository = $faqRepository;
    }
    protected $photo_path = 'uploads/faq/';

    /**
     * @param FaqTable $dataTable
     * @return JsonResponse|View
     *
     * @throws Throwable
     */
    public function index(FaqTable $dataTable)
    {
        if (!auth()->user()->can('faq_access')) {
            abort(403, 'Unauthorized action.');
        }
        page_title()->setTitle(trans('faq::lang.faq'));

        return $dataTable->renderTable();
    }

    public function import()
    {
        if (!auth()->user()->can('faq_import')) {
            abort(403, 'Unauthorized action.');
        }
        page_title()->setTitle(trans('faq::lang.faq_import'));
        $data = array();
        $data['title']        = 'faq_import';
        return view('faq::faq.create_import',$data);
    }
    public function store_import(Request $request)
    {
        if (!auth()->user()->can('faq_import')) {
            abort(403, 'Unauthorized action.');
        }
        $file = $request->file('photo');
        Excel::import(new FaqImport, $file);
        $response_data['status'] = 1;
        $response_data['message'] =  __('faq::lang.record_save_successfully');
        return redirect()->route('faq.index')->with('response_data', $response_data);
    }
    public function data()
    {
        if (!auth()->user()->can('faq_access')) {
            abort(403, 'Unauthorized action.');
        }
        if(auth()->user()->can('faq_list_all')) {
            $custom_table = Faq::all();
        }else {
            $custom_table = Faq::where('user_id', Auth::id())->get();
        }
        return datatables()->of($custom_table)->addColumn('action', function ($row) {
            $html = '';
            if(auth()->user()->can('faq_pdf')) {
                $html .= '<a target="_blank" href="' . route('faq.pdf_show', $row->id) . '" class="btn btn-xs btn-success">' . __('faq::lang.pdf') . '</a> ';
            }
            if(auth()->user()->can('faq_show')) {
                $html .= '<a href="' . route('faq.show', $row->id) . '" class="btn btn-xs btn-success">' . __('faq::lang.view') . '</a> ';
            }
            if(auth()->user()->can('faq_edit')) {
                $html .= '<a  href="' . route('faq.edit', $row->id) . '" class="btn btn-xs btn-secondary">' . __('faq::lang.edit') . '</a> ';
            }
            if(auth()->user()->can('faq_destroy')) {
                $html .= '<form action="' . route('faq.destroy', $row->id) . '" method="POST" style="display: inline-block;">
                        ' . csrf_field() . '
                        ' . method_field("DELETE") . '
                        <button type="submit" class="btn btn-xs btn-danger"
                            onclick="return confirm(\'Are You Sure Want to Delete?\')"
                            style="padding: .0em !important;"><i class="icon-trash"> </i>' . __('faq::lang.delete') . '</button>
                        </form>';
            }
            return $html;
        })->addColumn('photo', function ($row) {
            $html = '<img style="height: 100px;width: 100px;" src="' . getImageUrl($row->photo,'faq') . '" alt="' . $row->name . '" class="img-rounded img-preview">';
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
        if (!auth()->user()->can('faq_create')) {
            abort(403, 'Unauthorized action.');
        }
        page_title()->setTitle(trans('faq::lang.faq_create'));
        $data = array();
        $data['title']        = 'faq_create';
        return view('faq::faq.create',$data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param DboardHttpResponse $response
     * @return DboardHttpResponse
     * @return \Illuminate\Http\Response
     */
    public function store(FaqRequest $request, DboardHttpResponse $response)
    {
        if (!auth()->user()->can('faq_create')) {
            abort(403, 'Unauthorized action.');
        }
        try {
            $record = $this->faqRepository->createOrUpdate(array_merge($request->input()));


            event(new CreatedContentEvent(FAQ_MODULE_SCREEN_NAME, $request, $record));

            return $response
                ->setPreviousUrl(route('faq.index'))
                ->setNextUrl(route('faq.edit', $record->id))
                ->setMessage(trans('kamruldashboard::notices.create_success_message'));
        }catch (\Exception $e){

            return $response
                ->setPreviousUrl(route('faq.index'))
                ->setMessage(trans('kamruldashboard::notices.something_error_please_try_again_later'));
        }
    }

    /**
     * Show the specified resource.
     * @param  Faq\Http\Models\Faq  $faq
     * @return \Illuminate\Http\Response
     */
    public function show(Faq $faq)
    {
        if (!auth()->user()->can('faq_show')) {
            abort(403, 'Unauthorized action.');
        }
        page_title()->setTitle(trans('faq::lang.faq_show'));
        $data = array();
        $data['faq']        = $faq;
        $data['title']        = 'faq_show';
        return view('faq::faq.show',$data);
    }
    /**
     * Show the specified resource.
     * @param  Faq\Http\Models\Faq  $faq
     * @return \Illuminate\Http\Response
     */
    public function pdf(Faq $faq)
    {
        if (!auth()->user()->can('faq_pdf')) {
            abort(403, 'Unauthorized action.');
        }
        page_title()->setTitle(trans('faq::lang.faq_show'));
        $data = array();
        $data['faq']        = $faq;
        $data['title']        = 'faq_show';
        return view('faq::faq.pdf',$data);
    }

    /**
     * Show the form for editing the specified resource.
     * @param  Faq\Http\Models\Faq  $faq
     * @return \Illuminate\Http\Response
     */
    public function edit(Faq $faq)
    {
        if (!auth()->user()->can('faq_edit')) {
            abort(403, 'Unauthorized action.');
        }
        $data = array();
        $data['title']        = 'faq_edit';
        $data['record']        = $this->faqRepository->findOrFail($faq->id);
//        page_title()->setTitle(trans('faq::lang.faq_edit'));
        page_title()->setTitle(trans('faq::faq.edit') . ' "' . $data['record']->question . '"');
        return view('faq::faq.create',$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Modules\Faq\Http\Models\Faq  $faq
     * @param  DboardHttpResponse  $response
     * @return DboardHttpResponse
     * @return \Illuminate\Http\Response
     */
    public function update(FaqRequest $request, Faq  $faq, DboardHttpResponse $response)
    {
        if (!auth()->user()->can('faq_edit')) {
            abort(403, 'Unauthorized action.');
        }

        $id = $faq->id;
        $faq = $this->faqRepository->firstOrNew(compact('id'));
        $faq->fill($request->input());
        $faq = $this->faqRepository->createOrUpdate($faq);

        event(new UpdatedContentEvent(FAQ_MODULE_SCREEN_NAME, $request, $faq));
        return $response
            ->setPreviousUrl(route('faq.index'))
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
        if (!auth()->user()->can('faq_destroy')) {
            abort(403, 'Unauthorized action.');
        }
        try{

            $faq = $this->faqRepository->findOrFail($id);
            $this->faqRepository->delete($faq);

            event(new DeletedContentEvent(FAQ_MODULE_SCREEN_NAME, $request, $faq));

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
        return $this->executeDeleteItems($request, $response, $this->faqRepository, FAQ_MODULE_SCREEN_NAME);
    }
}
