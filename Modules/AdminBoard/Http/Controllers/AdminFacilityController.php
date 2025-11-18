<?php

namespace Modules\AdminBoard\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;
use Modules\KamrulDashboard\Events\DeletedContentEvent;
use Modules\KamrulDashboard\Events\UpdatedContentEvent;
use Modules\KamrulDashboard\Events\CreatedContentEvent;
use Modules\KamrulDashboard\Http\Responses\DboardHttpResponse;
use Modules\AdminBoard\Http\Models\AdminFacility;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Modules\KamrulDashboard\Traits\HasDeleteManyItemsTrait;
use Illuminate\Routing\Controller;
use Modules\AdminBoard\Repositories\Interfaces\AdminFacilityInterface;
use Modules\AdminBoard\Http\Imports\AdminFacilityImport;
use Modules\AdminBoard\Tables\AdminFacilityTable;
use mysql_xdevapi\Exception;
use Throwable;

class AdminFacilityController extends Controller
{
    use HasDeleteManyItemsTrait;
    /**
     * @var AdminFacilityInterface
     */
    protected $adminfacilityRepository;

    /**
     * AdminFacilityController constructor.
     * @param AdminFacilityInterface $adminfacilityRepository
     */
    public function __construct(AdminFacilityInterface $adminfacilityRepository)
    {
        $this->adminfacilityRepository = $adminfacilityRepository;
    }
    protected $photo_path = 'uploads/adminboard/adminfacility/';

    /**
     * @param AdminFacilityTable $dataTable
     * @return JsonResponse|View
     *
     * @throws Throwable
     */
    public function index(AdminFacilityTable $dataTable)
    {
        if (!auth()->user()->can('adminfacility_access')) {
            abort(403, 'Unauthorized action.');
        }
        page_title()->setTitle(trans('adminboard::lang.adminfacility'));

        return $dataTable->renderTable();
    }

    public function import()
    {
        if (!auth()->user()->can('adminfacility_import')) {
            abort(403, 'Unauthorized action.');
        }
        page_title()->setTitle(trans('adminboard::lang.adminfacility_import'));
        $data = array();
        $data['title']        = 'adminfacility_import';
        return view('adminboard::adminfacility.create_import',$data);
    }
    public function store_import(Request $request)
    {
        if (!auth()->user()->can('adminfacility_import')) {
            abort(403, 'Unauthorized action.');
        }
        $file = $request->file('photo');
        Excel::import(new AdminFacilityImport, $file);
        $response_data['status'] = 1;
        $response_data['message'] =  __('adminboard::lang.record_save_successfully');
        return redirect()->route('adminfacility.index')->with('response_data', $response_data);
    }
    public function data()
    {
        if (!auth()->user()->can('adminfacility_access')) {
            abort(403, 'Unauthorized action.');
        }
        if(auth()->user()->can('adminfacility_list_all')) {
            $custom_table = AdminFacility::all();
        }else {
            $custom_table = AdminFacility::where('user_id', Auth::id())->get();
        }
        return datatables()->of($custom_table)->addColumn('action', function ($row) {
            $html = '';
            if(auth()->user()->can('adminfacility_pdf')) {
                $html .= '<a target="_blank" href="' . url('adminboard/adminfacility/pdf_show', $row->id) . '" class="btn btn-xs btn-success">' . __('adminboard::lang.pdf') . '</a> ';
            }
            if(auth()->user()->can('adminfacility_show')) {
                $html .= '<a href="' . url('adminboard/adminfacility/' . $row->id) . '" class="btn btn-xs btn-success">' . __('adminboard::lang.view') . '</a> ';
            }
            if(auth()->user()->can('adminfacility_edit')) {
                $html .= '<a  href="' . url('adminboard/adminfacility/' . $row->id . "/edit") . '" class="btn btn-xs btn-secondary">' . __('adminboard::lang.edit') . '</a> ';
            }
            if(auth()->user()->can('adminfacility_destroy')) {
                $html .= '<form action="' . url('adminboard/adminfacility', $row->id) . '" method="POST" style="display: inline-block;">
                            ' . csrf_field() . '
                            ' . method_field("DELETE") . '
                            <button type="submit" class="btn btn-xs btn-danger"
                                onclick="return confirm(\'Are You Sure Want to Delete?\')"
                                style="padding: .0em !important;"><i class="icon-trash"> </i>' . __('adminboard::lang.delete') . '</button>
                            </form>';
            }
            return $html;
        })->addColumn('photo', function ($row) {
            $html = '<img style="height: 100px;width: 100px;" src="' . getImageUrl($row->photo,'adminboard/adminfacility') . '" alt="' . $row->name . '" class="img-rounded img-preview">';
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
        if (!auth()->user()->can('adminfacility_create')) {
            abort(403, 'Unauthorized action.');
        }
        page_title()->setTitle(trans('adminboard::lang.adminfacility_create'));
        $data = array();
        $data['title']        = 'adminfacility_create';
        return view('adminboard::adminfacility.create',$data);
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
        if (!auth()->user()->can('adminfacility_create')) {
            abort(403, 'Unauthorized action.');
        }
        $validated = $request->validate([
            'name'              => 'bail|required|max:255',
        ]);

        try {
            $record = $this->adminfacilityRepository->createOrUpdate(array_merge($request->input(), [
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
            event(new CreatedContentEvent(ADMINFACILITY_MODULE_SCREEN_NAME, $request, $record));

            return $response
                ->setPreviousUrl(route('adminfacility.index'))
                ->setNextUrl(route('adminfacility.edit', $record->id))
                ->setMessage(trans('kamruldashboard::notices.create_success_message'));
        }catch (\Exception $e){

            return $response
                ->setPreviousUrl(route('adminfacility.index'))
                ->setMessage(trans('kamruldashboard::notices.something_error_please_try_again_later'));
        }
    }

    /**
     * Show the specified resource.
     * @param  \Modules\AdminBoard\Http\Models\AdminFacility  $adminfacility
     * @return \Illuminate\Http\Response
     */
    public function show(AdminFacility $adminfacility)
    {
        if (!auth()->user()->can('adminfacility_show')) {
            abort(403, 'Unauthorized action.');
        }
        page_title()->setTitle(trans('adminboard::lang.adminfacility_show'));
        $data = array();
        $data['adminfacility']        = $adminfacility;
        $data['title']        = 'adminfacility_show';
        return view('adminboard::adminfacility.show',$data);
    }
    /**
     * Show the specified resource.
     * @param  \Modules\AdminBoard\Http\Models\AdminFacility  $adminfacility
     * @return \Illuminate\Http\Response
     */
    public function pdf(AdminFacility $adminfacility)
    {
        if (!auth()->user()->can('adminfacility_pdf')) {
            abort(403, 'Unauthorized action.');
        }
        page_title()->setTitle(trans('adminboard::lang.adminfacility_show'));
        $data = array();
        $data['adminfacility']        = $adminfacility;
        $data['title']        = 'adminfacility_show';
        return view('adminboard::adminfacility.pdf',$data);
    }

    /**
     * Show the form for editing the specified resource.
     * @param  \Modules\AdminBoard\Http\Models\AdminFacility  $adminfacility
     * @return \Illuminate\Http\Response
     */
    public function edit(AdminFacility $adminfacility)
    {
        if (!auth()->user()->can('adminfacility_edit')) {
            abort(403, 'Unauthorized action.');
        }
        page_title()->setTitle(trans('adminboard::lang.adminfacility_edit'));
        $data = array();
        $data['title']        = 'adminfacility_edit';
        $data['record']        = $this->adminfacilityRepository->findOrFail($adminfacility->id);
        return view('adminboard::adminfacility.create',$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Modules\AdminBoard\Http\Models\AdminFacility  $adminfacility
     * @param  DboardHttpResponse  $response
     * @return DboardHttpResponse
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AdminFacility  $adminfacility, DboardHttpResponse $response)
    {
        if (!auth()->user()->can('adminfacility_edit')) {
            abort(403, 'Unauthorized action.');
        }
        $validated = $request->validate([
            'name'              => 'bail|required|max:255',
        ]);

        $id = $adminfacility->id;
        $adminfacility = $this->adminfacilityRepository->firstOrNew(compact('id'));
        $adminfacility->fill($request->input());
        $this->adminfacilityRepository->createOrUpdate($adminfacility);

        $file_name = 'photo';
        if ($request->hasFile($file_name))
        {
//            return $file_name;
            $rules = $request->validate([
                "$file_name" => 'mimes:jpeg,jpg,png,gif|max:10000'
            ]);
            $path = $this->photo_path;
            deleteFile($adminfacility->$file_name, $path);

            $adminfacility->$file_name      = processUpload($request, $adminfacility,$file_name,$path);
            $adminfacility->save();
        }

        event(new UpdatedContentEvent(ADMINFACILITY_MODULE_SCREEN_NAME, $request, $adminfacility));

        return $response
            ->setPreviousUrl(route('adminfacility.index'))
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
        if (!auth()->user()->can('adminfacility_destroy')) {
            abort(403, 'Unauthorized action.');
        }
        try{

            $adminfacility = $this->adminfacilityRepository->findOrFail($id);
            $this->adminfacilityRepository->delete($adminfacility);
            $path = $this->photo_path;
            deleteFile($adminfacility->photo, $path);
            event(new DeletedContentEvent(ADMINFACILITY_MODULE_SCREEN_NAME, $request, $adminfacility));

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
        return $this->executeDeleteItems($request, $response, $this->adminfacilityRepository, ADMINFACILITY_MODULE_SCREEN_NAME);
    }
}
