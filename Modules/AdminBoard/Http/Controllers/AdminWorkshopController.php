<?php

namespace Modules\AdminBoard\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;
use Modules\AdminBoard\Forms\WorkshopForm;
use Modules\AdminBoard\Services\StoreWorkshopCategoryService;
use Modules\KamrulDashboard\Events\DeletedContentEvent;
use Modules\KamrulDashboard\Events\UpdatedContentEvent;
use Modules\KamrulDashboard\Events\CreatedContentEvent;
use Modules\KamrulDashboard\Http\Responses\DboardHttpResponse;
use Modules\AdminBoard\Http\Models\AdminWorkshop;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Modules\KamrulDashboard\Traits\HasDeleteManyItemsTrait;
use Illuminate\Routing\Controller;
use Modules\AdminBoard\Repositories\Interfaces\AdminWorkshopInterface;
use Modules\AdminBoard\Http\Imports\AdminWorkshopImport;
use Modules\AdminBoard\Tables\AdminWorkshopTable;
use mysql_xdevapi\Exception;
use Throwable;

class AdminWorkshopController extends Controller
{
    use HasDeleteManyItemsTrait;
    /**
     * @var AdminWorkshopInterface
     */
    protected $adminworkshopRepository;

    /**
     * AdminWorkshopController constructor.
     * @param AdminWorkshopInterface $adminworkshopRepository
     */
    public function __construct(AdminWorkshopInterface $adminworkshopRepository)
    {
        $this->adminworkshopRepository = $adminworkshopRepository;
    }
    protected $photo_path = 'uploads/adminboard/adminworkshop/';

    /**
     * @param AdminWorkshopTable $dataTable
     * @return JsonResponse|View
     *
     * @throws Throwable
     */
    public function index(AdminWorkshopTable $dataTable)
    {
        if (!auth()->user()->can('adminworkshop_access')) {
            abort(403, 'Unauthorized action.');
        }
        page_title()->setTitle(trans('adminboard::lang.adminworkshop'));

        return $dataTable->renderTable();
    }

    public function import()
    {
        if (!auth()->user()->can('adminworkshop_import')) {
            abort(403, 'Unauthorized action.');
        }
        page_title()->setTitle(trans('adminboard::lang.adminworkshop_import'));
        $data = array();
        $data['title']        = 'adminworkshop_import';
        return view('adminboard::adminworkshop.create_import',$data);
    }
    public function store_import(Request $request)
    {
        if (!auth()->user()->can('adminworkshop_import')) {
            abort(403, 'Unauthorized action.');
        }
        $file = $request->file('photo');
        Excel::import(new AdminWorkshopImport, $file);
        $response_data['status'] = 1;
        $response_data['message'] =  __('adminboard::lang.record_save_successfully');
        return redirect()->route('adminworkshop.index')->with('response_data', $response_data);
    }
    public function data()
    {
        if (!auth()->user()->can('adminworkshop_access')) {
            abort(403, 'Unauthorized action.');
        }
        if(auth()->user()->can('adminworkshop_list_all')) {
            $custom_table = AdminWorkshop::all();
        }else {
            $custom_table = AdminWorkshop::where('user_id', Auth::id())->get();
        }
        return datatables()->of($custom_table)->addColumn('action', function ($row) {
            $html = '';
            if(auth()->user()->can('adminworkshop_pdf')) {
                $html .= '<a target="_blank" href="' . url('adminboard/adminworkshop/pdf_show', $row->id) . '" class="btn btn-xs btn-success">' . __('adminboard::lang.pdf') . '</a> ';
            }
            if(auth()->user()->can('adminworkshop_show')) {
                $html .= '<a href="' . url('adminboard/adminworkshop/' . $row->id) . '" class="btn btn-xs btn-success">' . __('adminboard::lang.view') . '</a> ';
            }
            if(auth()->user()->can('adminworkshop_edit')) {
                $html .= '<a  href="' . url('adminboard/adminworkshop/' . $row->id . "/edit") . '" class="btn btn-xs btn-secondary">' . __('adminboard::lang.edit') . '</a> ';
            }
            if(auth()->user()->can('adminworkshop_destroy')) {
                $html .= '<form action="' . url('adminboard/adminworkshop', $row->id) . '" method="POST" style="display: inline-block;">
                            ' . csrf_field() . '
                            ' . method_field("DELETE") . '
                            <button type="submit" class="btn btn-xs btn-danger"
                                onclick="return confirm(\'Are You Sure Want to Delete?\')"
                                style="padding: .0em !important;"><i class="icon-trash"> </i>' . __('adminboard::lang.delete') . '</button>
                            </form>';
            }
            return $html;
        })->addColumn('photo', function ($row) {
            $html = '<img style="height: 100px;width: 100px;" src="' . getImageUrl($row->photo,'adminboard/adminworkshop') . '" alt="' . $row->name . '" class="img-rounded img-preview">';
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
        if (!auth()->user()->can('adminworkshop_create')) {
            abort(403, 'Unauthorized action.');
        }
        page_title()->setTitle(trans('adminboard::lang.adminworkshop_create'));
        return WorkshopForm::create()->renderForm();
//        $data = array();
//        $data['title']        = 'adminworkshop_create';
//        return view('adminboard::adminworkshop.create',$data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param DboardHttpResponse $response
     * @return DboardHttpResponse
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, StoreWorkshopCategoryService $WorkshopCategoryService, DboardHttpResponse $response)
    {
        if (!auth()->user()->can('adminworkshop_create')) {
            abort(403, 'Unauthorized action.');
        }
        $validated = $request->validate([
            'name'              => 'bail|required|max:255',
        ]);

        try {
            $record = $this->adminworkshopRepository->createOrUpdate(array_merge($request->input(), [
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
                    $syncData[$galleryId] = ['reference_id' => $record->id,'reference_type' => AdminWorkshop::class];
                }
                $record->AdminGalleryParameter()->sync($syncData);
            }
            $WorkshopCategoryService->execute($request, $record);
            event(new CreatedContentEvent(ADMINWORKSHOP_MODULE_SCREEN_NAME, $request, $record));

            return $response
                ->setPreviousUrl(route('adminworkshop.index'))
                ->setNextUrl(route('adminworkshop.edit', $record->id))
                ->setMessage(trans('kamruldashboard::notices.create_success_message'));
        }catch (\Exception $e){

            return $response
                ->setPreviousUrl(route('adminworkshop.index'))
                ->setMessage(trans('kamruldashboard::notices.something_error_please_try_again_later'));
        }
    }

    /**
     * Show the specified resource.
     * @param  \Modules\AdminBoard\Http\Models\AdminWorkshop  $adminworkshop
     * @return \Illuminate\Http\Response
     */
    public function show(AdminWorkshop $adminworkshop)
    {
        if (!auth()->user()->can('adminworkshop_show')) {
            abort(403, 'Unauthorized action.');
        }
        page_title()->setTitle(trans('adminboard::lang.adminworkshop_show'));
        $data = array();
        $data['adminworkshop']        = $adminworkshop;
        $data['title']        = 'adminworkshop_show';
        return view('adminboard::adminworkshop.show',$data);
    }
    /**
     * Show the specified resource.
     * @param  \Modules\AdminBoard\Http\Models\AdminWorkshop  $adminworkshop
     * @return \Illuminate\Http\Response
     */
    public function pdf(AdminWorkshop $adminworkshop)
    {
        if (!auth()->user()->can('adminworkshop_pdf')) {
            abort(403, 'Unauthorized action.');
        }
        page_title()->setTitle(trans('adminboard::lang.adminworkshop_show'));
        $data = array();
        $data['adminworkshop']        = $adminworkshop;
        $data['title']        = 'adminworkshop_show';
        return view('adminboard::adminworkshop.pdf',$data);
    }

    /**
     * Show the form for editing the specified resource.
     * @param  \Modules\AdminBoard\Http\Models\AdminWorkshop  $adminworkshop
     * @return \Illuminate\Http\Response
     */
    public function edit(AdminWorkshop $adminworkshop)
    {
        if (!auth()->user()->can('adminworkshop_edit')) {
            abort(403, 'Unauthorized action.');
        }
        page_title()->setTitle(trans('adminboard::lang.adminworkshop_edit'));
        return WorkshopForm::createFromModel($adminworkshop)->renderForm();
//        $data = array();
//        $data['title']        = 'adminworkshop_edit';
//        $data['record']        = $this->adminworkshopRepository->findOrFail($adminworkshop->id);
//        return view('adminboard::adminworkshop.create',$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Modules\AdminBoard\Http\Models\AdminWorkshop  $adminworkshop
     * @param  DboardHttpResponse  $response
     * @return DboardHttpResponse
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AdminWorkshop  $adminworkshop, StoreWorkshopCategoryService $WorkshopCategoryService, DboardHttpResponse $response)
    {
        if (!auth()->user()->can('adminworkshop_edit')) {
            abort(403, 'Unauthorized action.');
        }
        $validated = $request->validate([
            'name'              => 'bail|required|max:255',
        ]);

        $id = $adminworkshop->id;
        $adminworkshop = $this->adminworkshopRepository->firstOrNew(compact('id'));
        $adminworkshop->fill($request->input());
        $this->adminworkshopRepository->createOrUpdate($adminworkshop);

        $file_name = 'photo';
        if ($request->hasFile($file_name))
        {
//            return $file_name;
            $rules = $request->validate([
                "$file_name" => 'mimes:jpeg,jpg,png,gif|max:10000'
            ]);
            $path = $this->photo_path;
            deleteFile($adminworkshop->$file_name, $path);

            $adminworkshop->$file_name      = processUpload($request, $adminworkshop,$file_name,$path);
            $adminworkshop->save();
        }

        $AdminGalleryParameter = $request->pics_file;
        if (!empty($AdminGalleryParameter) && is_array($AdminGalleryParameter)) {
            $syncData = [];
            foreach ($AdminGalleryParameter as $galleryId) {
                $syncData[$galleryId] = ['reference_id' => $adminworkshop->id,'reference_type' => AdminWorkshop::class];
            }
            $adminworkshop->AdminGalleryParameter()->sync($syncData);
        }
        $WorkshopCategoryService->execute($request, $adminworkshop);
        event(new UpdatedContentEvent(ADMINWORKSHOP_MODULE_SCREEN_NAME, $request, $adminworkshop));

        return $response
            ->setPreviousUrl(route('adminworkshop.index'))
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
        if (!auth()->user()->can('adminworkshop_destroy')) {
            abort(403, 'Unauthorized action.');
        }
        try{

            $adminworkshop = $this->adminworkshopRepository->findOrFail($id);
            $this->adminworkshopRepository->delete($adminworkshop);
            $path = $this->photo_path;
            deleteFile($adminworkshop->photo, $path);
            event(new DeletedContentEvent(ADMINWORKSHOP_MODULE_SCREEN_NAME, $request, $adminworkshop));

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
        return $this->executeDeleteItems($request, $response, $this->adminworkshopRepository, ADMINWORKSHOP_MODULE_SCREEN_NAME);
    }
}
