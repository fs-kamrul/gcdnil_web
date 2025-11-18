<?php

namespace Modules\Post\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;
use Modules\KamrulDashboard\Http\Responses\DboardHttpResponse;
use Modules\KamrulDashboard\Traits\HasDeleteManyItemsTrait;
use Modules\Post\Http\Models\PageTemplate;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Post\Http\Imports\PageTemplateImport;
use Modules\Post\Repositories\Interfaces\PageTemplateInterface;
use Modules\Post\Tables\TemplateTable;
use mysql_xdevapi\Exception;
use Throwable;

class PageTemplateController extends Controller
{

    use HasDeleteManyItemsTrait;
    protected $photo_path = 'uploads/post/pagetemplate/';

    /**
     * @var PageTemplateInterface
     */
    protected $pageTemplateRepository;

    /**
     * PageController constructor.
     * @param PageTemplateInterface $pageTemplateRepository
     */
    public function __construct(PageTemplateInterface $pageTemplateRepository)
    {
        $this->pageTemplateRepository = $pageTemplateRepository;
    }
    /**
     * @param TemplateTable $dataTable
     * @return JsonResponse|View
     *
     * @throws Throwable
     */
    public function index(TemplateTable $dataTable)
    {
        if (!auth()->user()->can('pagetemplate_access')) {
            abort(403, 'Unauthorized action.');
        }
        page_title()->setTitle(trans('post::lang.pagetemplate'));

        return $dataTable->renderTable();
//        $data = array();
//        $data['title']        = 'pagetemplate';
//        return view('post::pagetemplate.index',$data);
    }

    public function import()
    {
        if (!auth()->user()->can('pagetemplate_import')) {
            abort(403, 'Unauthorized action.');
        }
        $data = array();
        $data['title']        = 'pagetemplate_import';
        return view('post::pagetemplate.create_import',$data);
    }
    public function store_import(Request $request)
    {
        if (!auth()->user()->can('pagetemplate_import')) {
            abort(403, 'Unauthorized action.');
        }
        $file = $request->file('photo');
        Excel::import(new PageTemplateImport, $file);
        $response_data['status'] = 1;
        $response_data['message'] =  __('post::lang.record_save_successfully');
        return redirect()->route('pagetemplate.index')->with('response_data', $response_data);
    }
    public function data()
    {
        if (!auth()->user()->can('pagetemplate_access')) {
            abort(403, 'Unauthorized action.');
        }
        if(auth()->user()->can('pagetemplate_list_all')) {
            $custom_table = PageTemplate::all();
        }else {
            $custom_table = PageTemplate::where('user_id', Auth::id())->get();
        }
        return datatables()->of($custom_table)->addColumn('action', function ($row) {
            $html = '';
            if(auth()->user()->can('pagetemplate_pdf')) {
                $html .= '<a target="_blank" href="' . route('pagetemplate.pdf_show', $row->id) . '" class="btn btn-xs btn-success">' . __('post::lang.pdf') . '</a> ';
            }
            if(auth()->user()->can('pagetemplate_show')) {
                $html .= '<a href="' . route('pagetemplate.show', $row->id) . '" class="btn btn-xs btn-success">' . __('post::lang.view') . '</a> ';
            }
            if(auth()->user()->can('pagetemplate_edit')) {
//                $html .= '<a  href="' . route('pagetemplate.edit', $row->id) . '" class="btn btn-xs btn-secondary">' . __('post::lang.edit') . '</a> ';
            }
            if(auth()->user()->can('pagetemplate_destroy')) {
//                $html .= '<form action="' . route('pagetemplate.destroy', $row->id) . '" method="POST" style="display: inline-block;">
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
        if (!auth()->user()->can('pagetemplate_create')) {
            abort(403, 'Unauthorized action.');
        }
        $data = array();
        $data['title']        = 'pagetemplate_create';
        return view('post::pagetemplate.create',$data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!auth()->user()->can('pagetemplate_create')) {
            abort(403, 'Unauthorized action.');
        }
        $validated = $request->validate([
            'name'              => 'bail|required|max:255',
        ]);

        try {
            $record = new PageTemplate();
            $record->name           = $request->name;
            $record->slug           = $record->createSlug($request->name);
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
            return redirect()->route('pagetemplate.index')->with('response_data', $response_data);
        }catch (Exception $e){

            $response_data['status'] = 0;
            $response_data['message'] =  __('post::lang.something_error_please_try_again_later');
            return redirect()->route('pagetemplate.index')->with('response_data', $response_data);
        }
    }

    /**
     * Show the specified resource.
     * @param  PageTemplate\Http\Models\PageTemplate  $pagetemplate
     * @return \Illuminate\Http\Response
     */
    public function show(PageTemplate $pagetemplate)
    {
        if (!auth()->user()->can('pagetemplate_show')) {
            abort(403, 'Unauthorized action.');
        }
        $data = array();
        $data['pagetemplate']        = $pagetemplate;
        $data['title']        = 'pagetemplate_show';
        return view('post::pagetemplate.show',$data);
    }
    /**
     * Show the specified resource.
     * @param  PageTemplate\Http\Models\PageTemplate  $pagetemplate
     * @return \Illuminate\Http\Response
     */
    public function pdf(PageTemplate $pagetemplate)
    {
        if (!auth()->user()->can('pagetemplate_pdf')) {
            abort(403, 'Unauthorized action.');
        }
        $data = array();
        $data['pagetemplate']        = $pagetemplate;
        $data['title']        = 'pagetemplate_show';
        return view('post::pagetemplate.pdf',$data);
    }

    /**
     * Show the form for editing the specified resource.
     * @param  PageTemplate\Http\Models\PageTemplate  $pagetemplate
     * @return \Illuminate\Http\Response
     */
    public function edit(PageTemplate $pagetemplate)
    {
        if (!auth()->user()->can('pagetemplate_edit')) {
            abort(403, 'Unauthorized action.');
        }
        $data = array();
        $data['title']        = 'pagetemplate_edit';
        $data['record']        = $pagetemplate;
        return view('post::pagetemplate.create',$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  PageTemplate\Http\Models\PageTemplate  $pagetemplate
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PageTemplate  $pagetemplate)
    {
        if (!auth()->user()->can('pagetemplate_edit')) {
            abort(403, 'Unauthorized action.');
        }
        $validated = $request->validate([
            'name'              => 'bail|required|max:255',
        ]);

        $pagetemplate->name             = $request->name;
        $pagetemplate->description      = $request->description;
        $pagetemplate->status           = $request->status;
        $pagetemplate->save();

        $file_name = 'photo';
        if ($request->hasFile($file_name))
        {
//            return $file_name;
            $rules = $request->validate([
                "$file_name" => 'mimes:jpeg,jpg,png,gif|max:10000'
            ]);
            $path = $this->photo_path;
            deleteFile($pagetemplate->photo, $path);

            $pagetemplate->$file_name      = processUpload($request, $pagetemplate,$file_name,$path);
            $pagetemplate->save();
        }

        $response_data['status'] = 1;
        $response_data['message'] =  __('post::lang.record_update_successfully');
        return redirect()->route('pagetemplate.index')->with('response_data', $response_data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  PageTemplate\Http\Models\PageTemplate  $pagetemplate
     * @return \Illuminate\Http\Response
     */
    public function destroy(PageTemplate  $pagetemplate)
    {
        if (!auth()->user()->can('pagetemplate_destroy')) {
            abort(403, 'Unauthorized action.');
        }
        try{
            $pagetemplate->delete();
            $path = $this->photo_path;
            deleteFile($pagetemplate->photo, $path);
            $response_data['status'] = 1;
            $response_data['message'] =  __('post::lang.record_deleted_successfully');
        } catch ( \Exception $e) {
            $response_data['status'] = 0;
            $response_data['message'] =  __('post::lang.this_record_is_in_use_in_other_modules');
        }
        return redirect()->route('pagetemplate.index')->with('response_data', $response_data);
    }
    /**
     * @param Request $request
     * @param DboardHttpResponse $response
     * @return DboardHttpResponse
     * @throws \Exception
     */
    public function deletes(Request $request, DboardHttpResponse $response)
    {
        return $this->executeDeleteItems($request, $response, $this->pageTemplateRepository, PAGE_MODULE_SCREEN_NAME);
    }
}
