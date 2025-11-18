<?php

namespace Modules\AdminBoard\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;
use Modules\AdminBoard\Forms\NewsForm;
use Modules\AdminBoard\Services\StoreNewsCategoryService;
use Modules\KamrulDashboard\Events\DeletedContentEvent;
use Modules\KamrulDashboard\Events\UpdatedContentEvent;
use Modules\KamrulDashboard\Events\CreatedContentEvent;
use Modules\KamrulDashboard\Http\Responses\DboardHttpResponse;
use Modules\AdminBoard\Http\Models\AdminNews;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Modules\KamrulDashboard\Traits\HasDeleteManyItemsTrait;
use Illuminate\Routing\Controller;
use Modules\AdminBoard\Repositories\Interfaces\AdminNewsInterface;
use Modules\AdminBoard\Http\Imports\AdminNewsImport;
use Modules\AdminBoard\Tables\AdminNewsTable;
use mysql_xdevapi\Exception;
use Throwable;

class AdminNewsController extends Controller
{
    use HasDeleteManyItemsTrait;
    /**
     * @var AdminNewsInterface
     */
    protected $adminnewsRepository;

    /**
     * AdminNewsController constructor.
     * @param AdminNewsInterface $adminnewsRepository
     */
    public function __construct(AdminNewsInterface $adminnewsRepository)
    {
        $this->adminnewsRepository = $adminnewsRepository;
    }
    protected $photo_path = 'uploads/adminboard/adminnews/';

    /**
     * @param AdminNewsTable $dataTable
     * @return JsonResponse|View
     *
     * @throws Throwable
     */
    public function index(AdminNewsTable $dataTable)
    {
        if (!auth()->user()->can('adminnews_access')) {
            abort(403, 'Unauthorized action.');
        }
        page_title()->setTitle(trans('adminboard::lang.adminnews'));

        return $dataTable->renderTable();
    }

    public function import()
    {
        if (!auth()->user()->can('adminnews_import')) {
            abort(403, 'Unauthorized action.');
        }
        page_title()->setTitle(trans('adminboard::lang.adminnews_import'));
        $data = array();
        $data['title']        = 'adminnews_import';
        return view('adminboard::adminnews.create_import',$data);
    }
    public function store_import(Request $request)
    {
        if (!auth()->user()->can('adminnews_import')) {
            abort(403, 'Unauthorized action.');
        }
        $file = $request->file('photo');
        Excel::import(new AdminNewsImport, $file);
        $response_data['status'] = 1;
        $response_data['message'] =  __('adminboard::lang.record_save_successfully');
        return redirect()->route('adminnews.index')->with('response_data', $response_data);
    }
    public function data()
    {
        if (!auth()->user()->can('adminnews_access')) {
            abort(403, 'Unauthorized action.');
        }
        if(auth()->user()->can('adminnews_list_all')) {
            $custom_table = AdminNews::all();
        }else {
            $custom_table = AdminNews::where('user_id', Auth::id())->get();
        }
        return datatables()->of($custom_table)->addColumn('action', function ($row) {
            $html = '';
            if(auth()->user()->can('adminnews_pdf')) {
                $html .= '<a target="_blank" href="' . url('adminboard/adminnews/pdf_show', $row->id) . '" class="btn btn-xs btn-success">' . __('adminboard::lang.pdf') . '</a> ';
            }
            if(auth()->user()->can('adminnews_show')) {
                $html .= '<a href="' . url('adminboard/adminnews/' . $row->id) . '" class="btn btn-xs btn-success">' . __('adminboard::lang.view') . '</a> ';
            }
            if(auth()->user()->can('adminnews_edit')) {
                $html .= '<a  href="' . url('adminboard/adminnews/' . $row->id . "/edit") . '" class="btn btn-xs btn-secondary">' . __('adminboard::lang.edit') . '</a> ';
            }
            if(auth()->user()->can('adminnews_destroy')) {
                $html .= '<form action="' . url('adminboard/adminnews', $row->id) . '" method="POST" style="display: inline-block;">
                            ' . csrf_field() . '
                            ' . method_field("DELETE") . '
                            <button type="submit" class="btn btn-xs btn-danger"
                                onclick="return confirm(\'Are You Sure Want to Delete?\')"
                                style="padding: .0em !important;"><i class="icon-trash"> </i>' . __('adminboard::lang.delete') . '</button>
                            </form>';
            }
            return $html;
        })->addColumn('photo', function ($row) {
            $html = '<img style="height: 100px;width: 100px;" src="' . getImageUrl($row->photo,'adminboard/adminnews') . '" alt="' . $row->name . '" class="img-rounded img-preview">';
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
        if (!auth()->user()->can('adminnews_create')) {
            abort(403, 'Unauthorized action.');
        }
        page_title()->setTitle(trans('adminboard::lang.adminnews_create'));
//        $data = array();
//        $data['title']        = 'adminnews_create';
//        return view('adminboard::adminnews.create',$data);
        return NewsForm::create()->renderForm();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param DboardHttpResponse $response
     * @return DboardHttpResponse
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, StoreNewsCategoryService $newsCategoryService, DboardHttpResponse $response)
    {
        if (!auth()->user()->can('adminnews_create')) {
            abort(403, 'Unauthorized action.');
        }
        $validated = $request->validate([
            'name'              => 'bail|required|max:255',
        ]);

        try {
            $record = $this->adminnewsRepository->createOrUpdate(array_merge($request->input(), [
                'user_id' => Auth::id(),
                'uuid'    => gen_uuid(),
                'slug'    => checkSlugFunction($request->input('name')),
            ]));

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
            $newsCategoryService->execute($request, $record);
            event(new CreatedContentEvent(ADMINNEWS_MODULE_SCREEN_NAME, $request, $record));

            return $response
                ->setPreviousUrl(route('adminnews.index'))
                ->setNextUrl(route('adminnews.edit', $record->id))
                ->setMessage(trans('kamruldashboard::notices.create_success_message'));
        }catch (\Exception $e){

            return $response
                ->setPreviousUrl(route('adminnews.index'))
                ->setMessage(trans('kamruldashboard::notices.something_error_please_try_again_later'));
        }
    }

    /**
     * Show the specified resource.
     * @param  \Modules\AdminBoard\Http\Models\AdminNews  $adminnews
     * @return \Illuminate\Http\Response
     */
    public function show(AdminNews $adminnews)
    {
        if (!auth()->user()->can('adminnews_show')) {
            abort(403, 'Unauthorized action.');
        }
        page_title()->setTitle(trans('adminboard::lang.adminnews_show'));
        $data = array();
        $data['adminnews']        = $adminnews;
        $data['title']        = 'adminnews_show';
        return view('adminboard::adminnews.show',$data);
    }
    /**
     * Show the specified resource.
     * @param  \Modules\AdminBoard\Http\Models\AdminNews  $adminnew
     * @return \Illuminate\Http\Response
     */
    public function pdf(AdminNews $adminnew)
    {
        if (!auth()->user()->can('adminnews_pdf')) {
            abort(403, 'Unauthorized action.');
        }
        page_title()->setTitle(trans('adminboard::lang.adminnews_show'));
        $data = array();
        $data['adminnews']        = $adminnew;
        $data['title']        = 'adminnews_show';
        return view('adminboard::adminnews.pdf',$data);
    }

    /**
     * Show the form for editing the specified resource.
     * @param  \Modules\AdminBoard\Http\Models\AdminNews  $adminnews
     * @return \Illuminate\Http\Response
     */
    public function edit(AdminNews $adminnews)
    {
        if (!auth()->user()->can('adminnews_edit')) {
            abort(403, 'Unauthorized action.');
        }
        page_title()->setTitle(trans('adminboard::lang.adminnews_edit'));
//        $data = array();
//        $data['title']        = 'adminnews_edit';
//        $data['record']        = $this->adminnewsRepository->findOrFail($adminnews->id);
//        return view('adminboard::adminnews.create',$data);
        return NewsForm::createFromModel($adminnews)->renderForm();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Modules\AdminBoard\Http\Models\AdminNews  $adminnews
     * @param  DboardHttpResponse  $response
     * @return DboardHttpResponse
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AdminNews  $adminnews, StoreNewsCategoryService $newsCategoryService, DboardHttpResponse $response)
    {
        if (!auth()->user()->can('adminnews_edit')) {
            abort(403, 'Unauthorized action.');
        }
        $validated = $request->validate([
            'name'              => 'bail|required|max:255',
        ]);

        $id = $adminnews->id;
        $adminnews = $this->adminnewsRepository->firstOrNew(compact('id'));
        $adminnews->fill($request->input());
        $this->adminnewsRepository->createOrUpdate($adminnews);

        $file_name = 'photo';
        if ($request->hasFile($file_name))
        {
//            return $file_name;
            $rules = $request->validate([
                "$file_name" => 'mimes:jpeg,jpg,png,gif|max:10000'
            ]);
            $path = $this->photo_path;
            deleteFile($adminnews->$file_name, $path);

            $adminnews->$file_name      = processUpload($request, $adminnews,$file_name,$path);
            $adminnews->save();
        }

        $newsCategoryService->execute($request, $adminnews);
        event(new UpdatedContentEvent(ADMINNEWS_MODULE_SCREEN_NAME, $request, $adminnews));

        return $response
            ->setPreviousUrl(route('adminnews.index'))
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
        if (!auth()->user()->can('adminnews_destroy')) {
            abort(403, 'Unauthorized action.');
        }
        try{

            $adminnews = $this->adminnewsRepository->findOrFail($id);
            $this->adminnewsRepository->delete($adminnews);
            $path = $this->photo_path;
            deleteFile($adminnews->photo, $path);
            event(new DeletedContentEvent(ADMINNEWS_MODULE_SCREEN_NAME, $request, $adminnews));

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
        return $this->executeDeleteItems($request, $response, $this->adminnewsRepository, ADMINNEWS_MODULE_SCREEN_NAME);
    }
}
