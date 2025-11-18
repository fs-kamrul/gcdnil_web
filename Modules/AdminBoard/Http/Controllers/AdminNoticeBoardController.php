<?php

namespace Modules\AdminBoard\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;
use Modules\AdminBoard\Forms\NoticeBoardForm;
use Modules\AdminBoard\Services\StoreNoticeBoardCategoryService;
use Modules\KamrulDashboard\Events\DeletedContentEvent;
use Modules\KamrulDashboard\Events\UpdatedContentEvent;
use Modules\KamrulDashboard\Events\CreatedContentEvent;
use Modules\KamrulDashboard\Http\Responses\DboardHttpResponse;
use Modules\AdminBoard\Http\Models\AdminNoticeBoard;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Modules\KamrulDashboard\Traits\HasDeleteManyItemsTrait;
use Illuminate\Routing\Controller;
use Modules\AdminBoard\Repositories\Interfaces\AdminNoticeBoardInterface;
use Modules\AdminBoard\Http\Imports\AdminNoticeBoardImport;
use Modules\AdminBoard\Tables\AdminNoticeBoardTable;
use mysql_xdevapi\Exception;
use Throwable;

class AdminNoticeBoardController extends Controller
{
    use HasDeleteManyItemsTrait;
    /**
     * @var AdminNoticeBoardInterface
     */
    protected $adminnoticeboardRepository;

    /**
     * AdminNoticeBoardController constructor.
     * @param AdminNoticeBoardInterface $adminnoticeboardRepository
     */
    public function __construct(AdminNoticeBoardInterface $adminnoticeboardRepository)
    {
        $this->adminnoticeboardRepository = $adminnoticeboardRepository;
    }
    protected $photo_path = 'uploads/adminboard/adminnoticeboard/';

    /**
     * @param AdminNoticeBoardTable $dataTable
     * @return JsonResponse|View
     *
     * @throws Throwable
     */
    public function index(AdminNoticeBoardTable $dataTable)
    {
        if (!auth()->user()->can('adminnoticeboard_access')) {
            abort(403, 'Unauthorized action.');
        }
        page_title()->setTitle(trans('adminboard::lang.adminnoticeboard'));

        return $dataTable->renderTable();
    }

    public function import()
    {
        if (!auth()->user()->can('adminnoticeboard_import')) {
            abort(403, 'Unauthorized action.');
        }
        page_title()->setTitle(trans('adminboard::lang.adminnoticeboard_import'));
        $data = array();
        $data['title']        = 'adminnoticeboard_import';
        return view('adminboard::adminnoticeboard.create_import',$data);
    }
    public function store_import(Request $request)
    {
        if (!auth()->user()->can('adminnoticeboard_import')) {
            abort(403, 'Unauthorized action.');
        }
        $file = $request->file('photo');
        Excel::import(new AdminNoticeBoardImport, $file);
        $response_data['status'] = 1;
        $response_data['message'] =  __('adminboard::lang.record_save_successfully');
        return redirect()->route('adminnoticeboard.index')->with('response_data', $response_data);
    }
    public function data()
    {
        if (!auth()->user()->can('adminnoticeboard_access')) {
            abort(403, 'Unauthorized action.');
        }
        if(auth()->user()->can('adminnoticeboard_list_all')) {
            $custom_table = AdminNoticeBoard::all();
        }else {
            $custom_table = AdminNoticeBoard::where('user_id', Auth::id())->get();
        }
        return datatables()->of($custom_table)->addColumn('action', function ($row) {
            $html = '';
            if(auth()->user()->can('adminnoticeboard_pdf')) {
                $html .= '<a target="_blank" href="' . url('adminboard/adminnoticeboard/pdf_show', $row->id) . '" class="btn btn-xs btn-success">' . __('adminboard::lang.pdf') . '</a> ';
            }
            if(auth()->user()->can('adminnoticeboard_show')) {
                $html .= '<a href="' . url('adminboard/adminnoticeboard/' . $row->id) . '" class="btn btn-xs btn-success">' . __('adminboard::lang.view') . '</a> ';
            }
            if(auth()->user()->can('adminnoticeboard_edit')) {
                $html .= '<a  href="' . url('adminboard/adminnoticeboard/' . $row->id . "/edit") . '" class="btn btn-xs btn-secondary">' . __('adminboard::lang.edit') . '</a> ';
            }
            if(auth()->user()->can('adminnoticeboard_destroy')) {
                $html .= '<form action="' . url('adminboard/adminnoticeboard', $row->id) . '" method="POST" style="display: inline-block;">
                            ' . csrf_field() . '
                            ' . method_field("DELETE") . '
                            <button type="submit" class="btn btn-xs btn-danger"
                                onclick="return confirm(\'Are You Sure Want to Delete?\')"
                                style="padding: .0em !important;"><i class="icon-trash"> </i>' . __('adminboard::lang.delete') . '</button>
                            </form>';
            }
            return $html;
        })->addColumn('photo', function ($row) {
            $html = '<img style="height: 100px;width: 100px;" src="' . getImageUrl($row->photo,'adminboard/adminnoticeboard') . '" alt="' . $row->name . '" class="img-rounded img-preview">';
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
        if (!auth()->user()->can('adminnoticeboard_create')) {
            abort(403, 'Unauthorized action.');
        }
        page_title()->setTitle(trans('adminboard::lang.adminnoticeboard_create'));
        return NoticeBoardForm::create()->renderForm();
//        $data = array();
//        $data['title']        = 'adminnoticeboard_create';
//        return view('adminboard::adminnoticeboard.create',$data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param DboardHttpResponse $response
     * @return DboardHttpResponse
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, StoreNoticeBoardCategoryService $noticeBoardCategoryService, DboardHttpResponse $response)
    {
        if (!auth()->user()->can('adminnoticeboard_create')) {
            abort(403, 'Unauthorized action.');
        }
        $validated = $request->validate([
            'name'              => 'bail|required|max:255',
        ]);

        try {
            $record = $this->adminnoticeboardRepository->createOrUpdate(array_merge($request->input(), [
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
            $file_name = 'document';
            if ($request->hasFile($file_name))
            {
                $path = $this->photo_path;
                deleteFile($record->$file_name, $path);

                $record->$file_name      = documentProcessUpload($request, $record,$file_name, $path);
                $record->save();
            }
            $noticeBoardCategoryService->execute($request, $record);
            event(new CreatedContentEvent(ADMINNOTICEBOARD_MODULE_SCREEN_NAME, $request, $record));

            return $response
                ->setPreviousUrl(route('adminnoticeboard.index'))
                ->setNextUrl(route('adminnoticeboard.edit', $record->id))
                ->setMessage(trans('kamruldashboard::notices.create_success_message'));
        }catch (\Exception $e){

            return $response
                ->setPreviousUrl(route('adminnoticeboard.index'))
                ->setMessage(trans('kamruldashboard::notices.something_error_please_try_again_later'));
        }
    }

    /**
     * Show the specified resource.
     * @param  \Modules\AdminBoard\Http\Models\AdminNoticeBoard  $adminnoticeboard
     * @return \Illuminate\Http\Response
     */
    public function show(AdminNoticeBoard $adminnoticeboard)
    {
        if (!auth()->user()->can('adminnoticeboard_show')) {
            abort(403, 'Unauthorized action.');
        }
        page_title()->setTitle(trans('adminboard::lang.adminnoticeboard_show'));
        $data = array();
        $data['adminnoticeboard']        = $adminnoticeboard;
        $data['title']        = 'adminnoticeboard_show';
        return view('adminboard::adminnoticeboard.show',$data);
    }
    /**
     * Show the specified resource.
     * @param  \Modules\AdminBoard\Http\Models\AdminNoticeBoard  $adminnoticeboard
     * @return \Illuminate\Http\Response
     */
    public function pdf(AdminNoticeBoard $adminnoticeboard)
    {
        if (!auth()->user()->can('adminnoticeboard_pdf')) {
            abort(403, 'Unauthorized action.');
        }
        page_title()->setTitle(trans('adminboard::lang.adminnoticeboard_show'));
        $data = array();
        $data['adminnoticeboard']        = $adminnoticeboard;
        $data['title']        = 'adminnoticeboard_show';
        return view('adminboard::adminnoticeboard.pdf',$data);
    }

    /**
     * Show the form for editing the specified resource.
     * @param  \Modules\AdminBoard\Http\Models\AdminNoticeBoard  $adminnoticeboard
     * @return \Illuminate\Http\Response
     */
    public function edit(AdminNoticeBoard $adminnoticeboard)
    {
        if (!auth()->user()->can('adminnoticeboard_edit')) {
            abort(403, 'Unauthorized action.');
        }
        page_title()->setTitle(trans('adminboard::lang.adminnoticeboard_edit'));
        return NoticeBoardForm::createFromModel($adminnoticeboard)->renderForm();
//        $data = array();
//        $data['title']        = 'adminnoticeboard_edit';
//        $data['record']        = $this->adminnoticeboardRepository->findOrFail($adminnoticeboard->id);
//        return view('adminboard::adminnoticeboard.create',$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Modules\AdminBoard\Http\Models\AdminNoticeBoard  $adminnoticeboard
     * @param  DboardHttpResponse  $response
     * @return DboardHttpResponse
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AdminNoticeBoard  $adminnoticeboard, StoreNoticeBoardCategoryService $noticeBoardCategoryService, DboardHttpResponse $response)
    {
        if (!auth()->user()->can('adminnoticeboard_edit')) {
            abort(403, 'Unauthorized action.');
        }
        $validated = $request->validate([
            'name'              => 'bail|required|max:255',
        ]);

        $id = $adminnoticeboard->id;
        $adminnoticeboard = $this->adminnoticeboardRepository->firstOrNew(compact('id'));
        $adminnoticeboard->fill($request->input());
        $this->adminnoticeboardRepository->createOrUpdate($adminnoticeboard);

        $file_name = 'photo';
        if ($request->hasFile($file_name))
        {
//            return $file_name;
            $rules = $request->validate([
                "$file_name" => 'mimes:jpeg,jpg,png,gif|max:10000'
            ]);
            $path = $this->photo_path;
            deleteFile($adminnoticeboard->$file_name, $path);

            $adminnoticeboard->$file_name      = processUpload($request, $adminnoticeboard,$file_name,$path);
            $adminnoticeboard->save();
        }
        $file_name = 'document';
        if ($request->hasFile($file_name))
        {
            $path = $this->photo_path;
            deleteFile($adminnoticeboard->$file_name, $path);

            $adminnoticeboard->$file_name      = documentProcessUpload($request, $adminnoticeboard,$file_name, $path);
            $adminnoticeboard->save();
        }

        $noticeBoardCategoryService->execute($request, $adminnoticeboard);
        event(new UpdatedContentEvent(ADMINNOTICEBOARD_MODULE_SCREEN_NAME, $request, $adminnoticeboard));

        return $response
            ->setPreviousUrl(route('adminnoticeboard.index'))
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
        if (!auth()->user()->can('adminnoticeboard_destroy')) {
            abort(403, 'Unauthorized action.');
        }
        try{

            $adminnoticeboard = $this->adminnoticeboardRepository->findOrFail($id);
            $this->adminnoticeboardRepository->delete($adminnoticeboard);
            $path = $this->photo_path;
            deleteFile($adminnoticeboard->photo, $path);
            event(new DeletedContentEvent(ADMINNOTICEBOARD_MODULE_SCREEN_NAME, $request, $adminnoticeboard));

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
        return $this->executeDeleteItems($request, $response, $this->adminnoticeboardRepository, ADMINNOTICEBOARD_MODULE_SCREEN_NAME);
    }
}
