<?php

namespace Modules\AdminBoard\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;
use Modules\AdminBoard\Forms\AdminGalleryBoardForm;
use Modules\KamrulDashboard\Events\DeletedContentEvent;
use Modules\KamrulDashboard\Events\UpdatedContentEvent;
use Modules\KamrulDashboard\Events\CreatedContentEvent;
use Modules\KamrulDashboard\Http\Responses\DboardHttpResponse;
use Modules\AdminBoard\Http\Models\AdminGalleryBoard;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Modules\KamrulDashboard\Traits\HasDeleteManyItemsTrait;
use Illuminate\Routing\Controller;
use Modules\AdminBoard\Repositories\Interfaces\AdminGalleryBoardInterface;
use Modules\AdminBoard\Http\Imports\AdminGalleryBoardImport;
use Modules\AdminBoard\Tables\AdminGalleryBoardTable;
use mysql_xdevapi\Exception;
use Throwable;

class AdminGalleryBoardController extends Controller
{
    use HasDeleteManyItemsTrait;
    /**
     * @var AdminGalleryBoardInterface
     */
    protected $admingalleryboardRepository;

    /**
     * AdminGalleryBoardController constructor.
     * @param AdminGalleryBoardInterface $admingalleryboardRepository
     */
    public function __construct(AdminGalleryBoardInterface $admingalleryboardRepository)
    {
        $this->admingalleryboardRepository = $admingalleryboardRepository;
    }
    protected $photo_path = 'uploads/adminboard/admingalleryboard/';

    /**
     * @param AdminGalleryBoardTable $dataTable
     * @return JsonResponse|View
     *
     * @throws Throwable
     */
    public function index(AdminGalleryBoardTable $dataTable)
    {
        if (!auth()->user()->can('admingalleryboard_access')) {
            abort(403, 'Unauthorized action.');
        }
        page_title()->setTitle(trans('adminboard::lang.admingalleryboard'));

        return $dataTable->renderTable();
    }

    public function import()
    {
        if (!auth()->user()->can('admingalleryboard_import')) {
            abort(403, 'Unauthorized action.');
        }
        page_title()->setTitle(trans('adminboard::lang.admingalleryboard_import'));
        $data = array();
        $data['title']        = 'admingalleryboard_import';
        return view('adminboard::admingalleryboard.create_import',$data);
    }
    public function store_import(Request $request)
    {
        if (!auth()->user()->can('admingalleryboard_import')) {
            abort(403, 'Unauthorized action.');
        }
        $file = $request->file('photo');
        Excel::import(new AdminGalleryBoardImport, $file);
        $response_data['status'] = 1;
        $response_data['message'] =  __('adminboard::lang.record_save_successfully');
        return redirect()->route('admingalleryboard.index')->with('response_data', $response_data);
    }
    public function data()
    {
        if (!auth()->user()->can('admingalleryboard_access')) {
            abort(403, 'Unauthorized action.');
        }
        if(auth()->user()->can('admingalleryboard_list_all')) {
            $custom_table = AdminGalleryBoard::all();
        }else {
            $custom_table = AdminGalleryBoard::where('user_id', Auth::id())->get();
        }
        return datatables()->of($custom_table)->addColumn('action', function ($row) {
            $html = '';
            if(auth()->user()->can('admingalleryboard_pdf')) {
                $html .= '<a target="_blank" href="' . url('adminboard/admingalleryboard/pdf_show', $row->id) . '" class="btn btn-xs btn-success">' . __('adminboard::lang.pdf') . '</a> ';
            }
            if(auth()->user()->can('admingalleryboard_show')) {
                $html .= '<a href="' . url('adminboard/admingalleryboard/' . $row->id) . '" class="btn btn-xs btn-success">' . __('adminboard::lang.view') . '</a> ';
            }
            if(auth()->user()->can('admingalleryboard_edit')) {
                $html .= '<a  href="' . url('adminboard/admingalleryboard/' . $row->id . "/edit") . '" class="btn btn-xs btn-secondary">' . __('adminboard::lang.edit') . '</a> ';
            }
            if(auth()->user()->can('admingalleryboard_destroy')) {
                $html .= '<form action="' . url('adminboard/admingalleryboard', $row->id) . '" method="POST" style="display: inline-block;">
                            ' . csrf_field() . '
                            ' . method_field("DELETE") . '
                            <button type="submit" class="btn btn-xs btn-danger"
                                onclick="return confirm(\'Are You Sure Want to Delete?\')"
                                style="padding: .0em !important;"><i class="icon-trash"> </i>' . __('adminboard::lang.delete') . '</button>
                            </form>';
            }
            return $html;
        })->addColumn('photo', function ($row) {
            $html = '<img style="height: 100px;width: 100px;" src="' . getImageUrl($row->photo,'adminboard/admingalleryboard') . '" alt="' . $row->name . '" class="img-rounded img-preview">';
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
        if (!auth()->user()->can('admingalleryboard_create')) {
            abort(403, 'Unauthorized action.');
        }
        page_title()->setTitle(trans('adminboard::lang.admingalleryboard_create'));

        return AdminGalleryBoardForm::create()->renderForm();
        //$data = array();
        //$data['title']        = 'admingalleryboard_create';
        //return view('adminboard::admingalleryboard.create',$data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param DboardHttpResponse $response
     * @return DboardHttpResponse
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, DboardHttpResponse $response)
    {
        if (!auth()->user()->can('admingalleryboard_create')) {
            abort(403, 'Unauthorized action.');
        }
        $validated = $request->validate([
            'name'              => 'bail|required|max:255',
        ]);

        try {
            $record = $this->admingalleryboardRepository->createOrUpdate(array_merge($request->input(), [
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

            $AdminGalleryParameter = $request->pics_file;
            if (!empty($AdminGalleryParameter) && is_array($AdminGalleryParameter)) {
                $syncData = [];
                foreach ($AdminGalleryParameter as $galleryId) {
                    $syncData[$galleryId] = ['reference_id' => $record->id,'reference_type' => AdminGalleryBoard::class];
                }
                $record->AdminGalleryParameter()->sync($syncData);
            }
            event(new CreatedContentEvent(ADMINGALLERYBOARD_MODULE_SCREEN_NAME, $request, $record));

            return $response
                ->setPreviousUrl(route('admingalleryboard.index'))
                ->setNextUrl(route('admingalleryboard.edit', $record->id))
                ->setMessage(trans('kamruldashboard::notices.create_success_message'));
        }catch (\Exception $e){

            return $response
                ->setPreviousUrl(route('admingalleryboard.index'))
                ->setMessage(trans('kamruldashboard::notices.something_error_please_try_again_later'));
        }
    }

    /**
     * Show the specified resource.
     * @param  \Modules\AdminBoard\Http\Models\AdminGalleryBoard  $admingalleryboard
     * @return \Illuminate\Http\Response
     */
    public function show(AdminGalleryBoard $admingalleryboard)
    {
        if (!auth()->user()->can('admingalleryboard_show')) {
            abort(403, 'Unauthorized action.');
        }
        page_title()->setTitle(trans('adminboard::lang.admingalleryboard_show'));
        $data = array();
        $data['admingalleryboard']        = $admingalleryboard;
        $data['title']        = 'admingalleryboard_show';
        return view('adminboard::admingalleryboard.show',$data);
    }
    /**
     * Show the specified resource.
     * @param  \Modules\AdminBoard\Http\Models\AdminGalleryBoard  $admingalleryboard
     * @return \Illuminate\Http\Response
     */
    public function pdf(AdminGalleryBoard $admingalleryboard)
    {
        if (!auth()->user()->can('admingalleryboard_pdf')) {
            abort(403, 'Unauthorized action.');
        }
        page_title()->setTitle(trans('adminboard::lang.admingalleryboard_show'));
        $data = array();
        $data['admingalleryboard']        = $admingalleryboard;
        $data['title']        = 'admingalleryboard_show';
        return view('adminboard::admingalleryboard.pdf',$data);
    }

    /**
     * Show the form for editing the specified resource.
     * @param  \Modules\AdminBoard\Http\Models\AdminGalleryBoard  $admingalleryboard
     * @return \Illuminate\Http\Response
     */
    public function edit(AdminGalleryBoard $admingalleryboard)
    {
        if (!auth()->user()->can('admingalleryboard_edit')) {
            abort(403, 'Unauthorized action.');
        }
        page_title()->setTitle(trans('adminboard::lang.admingalleryboard_edit'));

        return AdminGalleryBoardForm::createFromModel($admingalleryboard)->renderForm();
     //   $data = array();
      //  $data['title']        = 'admingalleryboard_edit';
     //   $data['record']        = $this->admingalleryboardRepository->findOrFail($admingalleryboard->id);
      //  return view('adminboard::admingalleryboard.create',$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Modules\AdminBoard\Http\Models\AdminGalleryBoard  $admingalleryboard
     * @param  DboardHttpResponse  $response
     * @return DboardHttpResponse
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AdminGalleryBoard  $admingalleryboard, DboardHttpResponse $response)
    {
        if (!auth()->user()->can('admingalleryboard_edit')) {
            abort(403, 'Unauthorized action.');
        }
        $validated = $request->validate([
            'name'              => 'bail|required|max:255',
        ]);

        $id = $admingalleryboard->id;
        $admingalleryboard = $this->admingalleryboardRepository->firstOrNew(compact('id'));
        $admingalleryboard->fill($request->input());
        $this->admingalleryboardRepository->createOrUpdate($admingalleryboard);

        $file_name = 'photo';
        if ($request->hasFile($file_name))
        {
//            return $file_name;
            $rules = $request->validate([
                "$file_name" => 'mimes:jpeg,jpg,png,gif|max:10000'
            ]);
            $path = $this->photo_path;
            deleteFile($admingalleryboard->$file_name, $path);

            $admingalleryboard->$file_name      = processUpload($request, $admingalleryboard,$file_name,$path);
            $admingalleryboard->save();
        }

        $AdminGalleryParameter = $request->pics_file;
        if (!empty($AdminGalleryParameter) && is_array($AdminGalleryParameter)) {
            $syncData = [];
            foreach ($AdminGalleryParameter as $galleryId) {
                $syncData[$galleryId] = ['reference_id' => $admingalleryboard->id,'reference_type' => AdminGalleryBoard::class];
            }
            $admingalleryboard->AdminGalleryParameter()->sync($syncData);
        }
        event(new UpdatedContentEvent(ADMINGALLERYBOARD_MODULE_SCREEN_NAME, $request, $admingalleryboard));

        return $response
            ->setPreviousUrl(route('admingalleryboard.index'))
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
        if (!auth()->user()->can('admingalleryboard_destroy')) {
            abort(403, 'Unauthorized action.');
        }
        try{

            $admingalleryboard = $this->admingalleryboardRepository->findOrFail($id);
            $this->admingalleryboardRepository->delete($admingalleryboard);
            $path = $this->photo_path;
            deleteFile($admingalleryboard->photo, $path);
            event(new DeletedContentEvent(ADMINGALLERYBOARD_MODULE_SCREEN_NAME, $request, $admingalleryboard));

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
        return $this->executeDeleteItems($request, $response, $this->admingalleryboardRepository, ADMINGALLERYBOARD_MODULE_SCREEN_NAME);
    }
}
