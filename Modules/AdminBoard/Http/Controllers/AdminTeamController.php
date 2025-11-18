<?php

namespace Modules\AdminBoard\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;
use Modules\AdminBoard\Forms\TeamForm;
use Modules\AdminBoard\Services\SaveEducationsService;
use Modules\AdminBoard\Services\StoreTeamCategoryService;
use Modules\KamrulDashboard\Events\DeletedContentEvent;
use Modules\KamrulDashboard\Events\UpdatedContentEvent;
use Modules\KamrulDashboard\Events\CreatedContentEvent;
use Modules\KamrulDashboard\Http\Responses\DboardHttpResponse;
use Modules\AdminBoard\Http\Models\AdminTeam;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Modules\KamrulDashboard\Traits\HasDeleteManyItemsTrait;
use Illuminate\Routing\Controller;
use Modules\AdminBoard\Repositories\Interfaces\AdminTeamInterface;
use Modules\AdminBoard\Http\Imports\AdminTeamImport;
use Modules\AdminBoard\Tables\AdminTeamTable;
use mysql_xdevapi\Exception;
use Assets;
use Throwable;

class AdminTeamController extends Controller
{
    use HasDeleteManyItemsTrait;
    /**
     * @var AdminTeamInterface
     */
    protected $adminteamRepository;

    /**
     * AdminTeamController constructor.
     * @param AdminTeamInterface $adminteamRepository
     */
    public function __construct(AdminTeamInterface $adminteamRepository)
    {
        $this->adminteamRepository = $adminteamRepository;
    }
    protected $photo_path = 'uploads/adminboard/adminteam/';

    /**
     * @param AdminTeamTable $dataTable
     * @return JsonResponse|View
     *
     * @throws Throwable
     */
    public function index(AdminTeamTable $dataTable)
    {
        if (!auth()->user()->can('adminteam_access')) {
            abort(403, 'Unauthorized action.');
        }
        page_title()->setTitle(trans('adminboard::lang.adminteam'));

        return $dataTable->renderTable();
    }

    public function import()
    {
        if (!auth()->user()->can('adminteam_import')) {
            abort(403, 'Unauthorized action.');
        }
        page_title()->setTitle(trans('adminboard::lang.adminteam_import'));
        $data = array();
        $data['title']        = 'adminteam_import';
        return view('adminboard::adminteam.create_import',$data);
    }
    public function store_import(Request $request)
    {
        if (!auth()->user()->can('adminteam_import')) {
            abort(403, 'Unauthorized action.');
        }
        $file = $request->file('photo');
        Excel::import(new AdminTeamImport, $file);
        $response_data['status'] = 1;
        $response_data['message'] =  __('adminboard::lang.record_save_successfully');
        return redirect()->route('adminteam.index')->with('response_data', $response_data);
    }
    public function data()
    {
        if (!auth()->user()->can('adminteam_access')) {
            abort(403, 'Unauthorized action.');
        }
        if(auth()->user()->can('adminteam_list_all')) {
            $custom_table = AdminTeam::all();
        }else {
            $custom_table = AdminTeam::where('user_id', Auth::id())->get();
        }
        return datatables()->of($custom_table)->addColumn('action', function ($row) {
            $html = '';
            if(auth()->user()->can('adminteam_pdf')) {
                $html .= '<a target="_blank" href="' . url('adminboard/adminteam/pdf_show', $row->id) . '" class="btn btn-xs btn-success">' . __('adminboard::lang.pdf') . '</a> ';
            }
            if(auth()->user()->can('adminteam_show')) {
                $html .= '<a href="' . url('adminboard/adminteam/' . $row->id) . '" class="btn btn-xs btn-success">' . __('adminboard::lang.view') . '</a> ';
            }
            if(auth()->user()->can('adminteam_edit')) {
                $html .= '<a  href="' . url('adminboard/adminteam/' . $row->id . "/edit") . '" class="btn btn-xs btn-secondary">' . __('adminboard::lang.edit') . '</a> ';
            }
            if(auth()->user()->can('adminteam_destroy')) {
                $html .= '<form action="' . url('adminboard/adminteam', $row->id) . '" method="POST" style="display: inline-block;">
                            ' . csrf_field() . '
                            ' . method_field("DELETE") . '
                            <button type="submit" class="btn btn-xs btn-danger"
                                onclick="return confirm(\'Are You Sure Want to Delete?\')"
                                style="padding: .0em !important;"><i class="icon-trash"> </i>' . __('adminboard::lang.delete') . '</button>
                            </form>';
            }
            return $html;
        })->addColumn('photo', function ($row) {
            $html = '<img style="height: 100px;width: 100px;" src="' . getImageUrl($row->photo,'adminboard/adminteam') . '" alt="' . $row->name . '" class="img-rounded img-preview">';
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
        if (!auth()->user()->can('adminteam_create')) {
            abort(403, 'Unauthorized action.');
        }
        page_title()->setTitle(trans('adminboard::lang.adminteam_create'));

        Assets::addScriptsDirectly('vendor/Modules/AdminBoard/js/components.js');
        Assets::usingVueJS();

        return TeamForm::create()->renderForm();
//        $data = array();
//        $data['title']        = 'adminteam_create';
//        return view('adminboard::adminteam.create',$data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param DboardHttpResponse $response
     * @return DboardHttpResponse
     * @return \Illuminate\Http\Response
     */
    public function store(
        Request $request,
        StoreTeamCategoryService $tamCategoryService,
        DboardHttpResponse $response,
        SaveEducationsService $saveEducationsService
    ){
        if (!auth()->user()->can('adminteam_create')) {
            abort(403, 'Unauthorized action.');
        }
        $validated = $request->validate([
            'name'              => 'bail|required|max:255',
        ]);

        try {
            $record = $this->adminteamRepository->createOrUpdate(array_merge($request->input(), [
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

            $saveEducationsService->execute($record, $request->input('educations', []));
            $tamCategoryService->execute($request, $record);
            event(new CreatedContentEvent(ADMINTEAM_MODULE_SCREEN_NAME, $request, $record));

            return $response
                ->setPreviousUrl(route('adminteam.index'))
                ->setNextUrl(route('adminteam.edit', $record->id))
                ->setMessage(trans('kamruldashboard::notices.create_success_message'));
        }catch (\Exception $e){

            return $response
                ->setPreviousUrl(route('adminteam.index'))
                ->setMessage(trans('kamruldashboard::notices.something_error_please_try_again_later'));
        }
    }

    /**
     * Show the specified resource.
     * @param  \Modules\AdminBoard\Http\Models\AdminTeam  $adminteam
     * @return \Illuminate\Http\Response
     */
    public function show(AdminTeam $adminteam)
    {
        if (!auth()->user()->can('adminteam_show')) {
            abort(403, 'Unauthorized action.');
        }
        page_title()->setTitle(trans('adminboard::lang.adminteam_show'));
        $data = array();
        $data['adminteam']        = $adminteam;
        $data['title']        = 'adminteam_show';
        return view('adminboard::adminteam.show',$data);
    }
    /**
     * Show the specified resource.
     * @param  \Modules\AdminBoard\Http\Models\AdminTeam  $adminteam
     * @return \Illuminate\Http\Response
     */
    public function pdf(AdminTeam $adminteam)
    {
        if (!auth()->user()->can('adminteam_pdf')) {
            abort(403, 'Unauthorized action.');
        }
        page_title()->setTitle(trans('adminboard::lang.adminteam_show'));
        $data = array();
        $data['adminteam']        = $adminteam;
        $data['title']        = 'adminteam_show';
        return view('adminboard::adminteam.pdf',$data);
    }

    /**
     * Show the form for editing the specified resource.
     * @param  \Modules\AdminBoard\Http\Models\AdminTeam  $adminteam
     * @return \Illuminate\Http\Response
     */
    public function edit(AdminTeam $adminteam)
    {
        if (!auth()->user()->can('adminteam_edit')) {
            abort(403, 'Unauthorized action.');
        }
        page_title()->setTitle(trans('adminboard::lang.adminteam_edit'));

        Assets::addScriptsDirectly('vendor/Modules/AdminBoard/js/components.js');
        Assets::usingVueJS();

        return TeamForm::createFromModel($adminteam)->renderForm();
//        $data = array();
//        $data['title']        = 'adminteam_edit';
//        $data['record']        = $this->adminteamRepository->findOrFail($adminteam->id);
//        return view('adminboard::adminteam.create',$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Modules\AdminBoard\Http\Models\AdminTeam  $adminteam
     * @param  DboardHttpResponse  $response
     * @return DboardHttpResponse
     * @return \Illuminate\Http\Response
     */
    public function update(
        Request $request,
        AdminTeam  $adminteam,
        StoreTeamCategoryService $tamCategoryService,
        DboardHttpResponse $response,
        SaveEducationsService $saveEducationsService
    ){
        if (!auth()->user()->can('adminteam_edit')) {
            abort(403, 'Unauthorized action.');
        }
        $validated = $request->validate([
            'name'              => 'bail|required|max:255',
        ]);
//        dd($request);

        $id = $adminteam->id;
        $adminteam = $this->adminteamRepository->firstOrNew(compact('id'));
        $adminteam->fill($request->input());
        $this->adminteamRepository->createOrUpdate($adminteam);

        $file_name = 'photo';
        if ($request->hasFile($file_name))
        {
//            return $file_name;
            $rules = $request->validate([
                "$file_name" => 'mimes:jpeg,jpg,png,gif|max:10000'
            ]);
            $path = $this->photo_path;
            deleteFile($adminteam->$file_name, $path);

            $adminteam->$file_name      = processUpload($request, $adminteam,$file_name,$path);
            $adminteam->save();
        }

        $saveEducationsService->execute($adminteam, $request->input('educations', []));
        $tamCategoryService->execute($request, $adminteam);

        event(new UpdatedContentEvent(ADMINTEAM_MODULE_SCREEN_NAME, $request, $adminteam));

        return $response
            ->setPreviousUrl(route('adminteam.index'))
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
        if (!auth()->user()->can('adminteam_destroy')) {
            abort(403, 'Unauthorized action.');
        }
        try{

            $adminteam = $this->adminteamRepository->findOrFail($id);
            $this->adminteamRepository->delete($adminteam);
            $path = $this->photo_path;
            deleteFile($adminteam->photo, $path);
            event(new DeletedContentEvent(ADMINTEAM_MODULE_SCREEN_NAME, $request, $adminteam));

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
        return $this->executeDeleteItems($request, $response, $this->adminteamRepository, ADMINTEAM_MODULE_SCREEN_NAME);
    }
}
