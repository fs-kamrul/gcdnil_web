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
use Modules\AdminBoard\Http\Models\AdminPartner;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Modules\KamrulDashboard\Traits\HasDeleteManyItemsTrait;
use Illuminate\Routing\Controller;
use Modules\AdminBoard\Repositories\Interfaces\AdminPartnerInterface;
use Modules\AdminBoard\Http\Imports\AdminPartnerImport;
use Modules\AdminBoard\Tables\AdminPartnerTable;
use mysql_xdevapi\Exception;
use Throwable;

class AdminPartnerController extends Controller
{
    use HasDeleteManyItemsTrait;
    /**
     * @var AdminPartnerInterface
     */
    protected $adminpartnerRepository;

    /**
     * AdminPartnerController constructor.
     * @param AdminPartnerInterface $adminpartnerRepository
     */
    public function __construct(AdminPartnerInterface $adminpartnerRepository)
    {
        $this->adminpartnerRepository = $adminpartnerRepository;
    }
    protected $photo_path = 'uploads/adminboard/adminpartner/';

    /**
     * @param AdminPartnerTable $dataTable
     * @return JsonResponse|View
     *
     * @throws Throwable
     */
    public function index(AdminPartnerTable $dataTable)
    {
        if (!auth()->user()->can('adminpartner_access')) {
            abort(403, 'Unauthorized action.');
        }
        page_title()->setTitle(trans('adminboard::lang.adminpartner'));

        return $dataTable->renderTable();
    }

    public function import()
    {
        if (!auth()->user()->can('adminpartner_import')) {
            abort(403, 'Unauthorized action.');
        }
        page_title()->setTitle(trans('adminboard::lang.adminpartner_import'));
        $data = array();
        $data['title']        = 'adminpartner_import';
        return view('adminboard::adminpartner.create_import',$data);
    }
    public function store_import(Request $request)
    {
        if (!auth()->user()->can('adminpartner_import')) {
            abort(403, 'Unauthorized action.');
        }
        $file = $request->file('photo');
        Excel::import(new AdminPartnerImport, $file);
        $response_data['status'] = 1;
        $response_data['message'] =  __('adminboard::lang.record_save_successfully');
        return redirect()->route('adminpartner.index')->with('response_data', $response_data);
    }
    public function data()
    {
        if (!auth()->user()->can('adminpartner_access')) {
            abort(403, 'Unauthorized action.');
        }
        if(auth()->user()->can('adminpartner_list_all')) {
            $custom_table = AdminPartner::all();
        }else {
            $custom_table = AdminPartner::where('user_id', Auth::id())->get();
        }
        return datatables()->of($custom_table)->addColumn('action', function ($row) {
            $html = '';
            if(auth()->user()->can('adminpartner_pdf')) {
                $html .= '<a target="_blank" href="' . url('adminboard/adminpartner/pdf_show', $row->id) . '" class="btn btn-xs btn-success">' . __('adminboard::lang.pdf') . '</a> ';
            }
            if(auth()->user()->can('adminpartner_show')) {
                $html .= '<a href="' . url('adminboard/adminpartner/' . $row->id) . '" class="btn btn-xs btn-success">' . __('adminboard::lang.view') . '</a> ';
            }
            if(auth()->user()->can('adminpartner_edit')) {
                $html .= '<a  href="' . url('adminboard/adminpartner/' . $row->id . "/edit") . '" class="btn btn-xs btn-secondary">' . __('adminboard::lang.edit') . '</a> ';
            }
            if(auth()->user()->can('adminpartner_destroy')) {
                $html .= '<form action="' . url('adminboard/adminpartner', $row->id) . '" method="POST" style="display: inline-block;">
                            ' . csrf_field() . '
                            ' . method_field("DELETE") . '
                            <button type="submit" class="btn btn-xs btn-danger"
                                onclick="return confirm(\'Are You Sure Want to Delete?\')"
                                style="padding: .0em !important;"><i class="icon-trash"> </i>' . __('adminboard::lang.delete') . '</button>
                            </form>';
            }
            return $html;
        })->addColumn('photo', function ($row) {
            $html = '<img style="height: 100px;width: 100px;" src="' . getImageUrl($row->photo,'adminboard/adminpartner') . '" alt="' . $row->name . '" class="img-rounded img-preview">';
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
        if (!auth()->user()->can('adminpartner_create')) {
            abort(403, 'Unauthorized action.');
        }
        page_title()->setTitle(trans('adminboard::lang.adminpartner_create'));
        $data = array();
        $data['title']        = 'adminpartner_create';
        return view('adminboard::adminpartner.create',$data);
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
        if (!auth()->user()->can('adminpartner_create')) {
            abort(403, 'Unauthorized action.');
        }
        $validated = $request->validate([
            'name'              => 'bail|required|max:255',
        ]);

        try {
            $record = $this->adminpartnerRepository->createOrUpdate(array_merge($request->input(), [
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
            event(new CreatedContentEvent(ADMINPARTNER_MODULE_SCREEN_NAME, $request, $record));

            return $response
                ->setPreviousUrl(route('adminpartner.index'))
                ->setNextUrl(route('adminpartner.edit', $record->id))
                ->setMessage(trans('kamruldashboard::notices.create_success_message'));
        }catch (\Exception $e){

            return $response
                ->setPreviousUrl(route('adminpartner.index'))
                ->setMessage(trans('kamruldashboard::notices.something_error_please_try_again_later'));
        }
    }

    /**
     * Show the specified resource.
     * @param  \Modules\AdminBoard\Http\Models\AdminPartner  $adminpartner
     * @return \Illuminate\Http\Response
     */
    public function show(AdminPartner $adminpartner)
    {
        if (!auth()->user()->can('adminpartner_show')) {
            abort(403, 'Unauthorized action.');
        }
        page_title()->setTitle(trans('adminboard::lang.adminpartner_show'));
        $data = array();
        $data['adminpartner']        = $adminpartner;
        $data['title']        = 'adminpartner_show';
        return view('adminboard::adminpartner.show',$data);
    }
    /**
     * Show the specified resource.
     * @param  \Modules\AdminBoard\Http\Models\AdminPartner  $adminpartner
     * @return \Illuminate\Http\Response
     */
    public function pdf(AdminPartner $adminpartner)
    {
        if (!auth()->user()->can('adminpartner_pdf')) {
            abort(403, 'Unauthorized action.');
        }
        page_title()->setTitle(trans('adminboard::lang.adminpartner_show'));
        $data = array();
        $data['adminpartner']        = $adminpartner;
        $data['title']        = 'adminpartner_show';
        return view('adminboard::adminpartner.pdf',$data);
    }

    /**
     * Show the form for editing the specified resource.
     * @param  \Modules\AdminBoard\Http\Models\AdminPartner  $adminpartner
     * @return \Illuminate\Http\Response
     */
    public function edit(AdminPartner $adminpartner)
    {
        if (!auth()->user()->can('adminpartner_edit')) {
            abort(403, 'Unauthorized action.');
        }
        page_title()->setTitle(trans('adminboard::lang.adminpartner_edit'));
        $data = array();
        $data['title']        = 'adminpartner_edit';
        $data['record']        = $this->adminpartnerRepository->findOrFail($adminpartner->id);
        return view('adminboard::adminpartner.create',$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Modules\AdminBoard\Http\Models\AdminPartner  $adminpartner
     * @param  DboardHttpResponse  $response
     * @return DboardHttpResponse
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AdminPartner  $adminpartner, DboardHttpResponse $response)
    {
        if (!auth()->user()->can('adminpartner_edit')) {
            abort(403, 'Unauthorized action.');
        }
        $validated = $request->validate([
            'name'              => 'bail|required|max:255',
        ]);

        $id = $adminpartner->id;
        $adminpartner = $this->adminpartnerRepository->firstOrNew(compact('id'));
        $adminpartner->fill($request->input());
        $this->adminpartnerRepository->createOrUpdate($adminpartner);

        $file_name = 'photo';
        if ($request->hasFile($file_name))
        {
//            return $file_name;
            $rules = $request->validate([
                "$file_name" => 'mimes:jpeg,jpg,png,gif|max:10000'
            ]);
            $path = $this->photo_path;
            deleteFile($adminpartner->$file_name, $path);

            $adminpartner->$file_name      = processUpload($request, $adminpartner,$file_name,$path);
            $adminpartner->save();
        }

        event(new UpdatedContentEvent(ADMINPARTNER_MODULE_SCREEN_NAME, $request, $adminpartner));

        return $response
            ->setPreviousUrl(route('adminpartner.index'))
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
        if (!auth()->user()->can('adminpartner_destroy')) {
            abort(403, 'Unauthorized action.');
        }
        try{

            $adminpartner = $this->adminpartnerRepository->findOrFail($id);
            $this->adminpartnerRepository->delete($adminpartner);
            $path = $this->photo_path;
            deleteFile($adminpartner->photo, $path);
            event(new DeletedContentEvent(ADMINPARTNER_MODULE_SCREEN_NAME, $request, $adminpartner));

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
        return $this->executeDeleteItems($request, $response, $this->adminpartnerRepository, ADMINPARTNER_MODULE_SCREEN_NAME);
    }
}
