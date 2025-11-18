<?php

namespace Modules\AdminBoard\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;
use Modules\KamrulDashboard\Events\DeletedContentEvent;
use Modules\KamrulDashboard\Events\UpdatedContentEvent;
use Modules\KamrulDashboard\Events\CreatedContentEvent;
use Modules\KamrulDashboard\Http\Controllers\DboardController;
use Modules\KamrulDashboard\Http\Responses\DboardHttpResponse;
use Modules\AdminBoard\Http\Models\AdminCareerNavigator;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Modules\KamrulDashboard\Traits\HasDeleteManyItemsTrait;
use Illuminate\Routing\Controller;
use Modules\AdminBoard\Repositories\Interfaces\AdminCareerNavigatorInterface;
use Modules\AdminBoard\Http\Imports\AdminCareerNavigatorImport;
use Modules\AdminBoard\Tables\AdminCareerNavigatorTable;
use mysql_xdevapi\Exception;
use Throwable;

class AdminCareerNavigatorController extends DboardController
{
    use HasDeleteManyItemsTrait;
    /**
     * @var AdminCareerNavigatorInterface
     */
    protected $admincareernavigatorRepository;

    /**
     * AdminCareerNavigatorController constructor.
     * @param AdminCareerNavigatorInterface $admincareernavigatorRepository
     */
    public function __construct(AdminCareerNavigatorInterface $admincareernavigatorRepository)
    {
        $this->admincareernavigatorRepository = $admincareernavigatorRepository;
    }
    protected $photo_path = 'uploads/adminboard/admincareernavigator/';

    /**
     * @param AdminCareerNavigatorTable $dataTable
     * @return JsonResponse|View
     *
     * @throws Throwable
     */
    public function index(AdminCareerNavigatorTable $dataTable)
    {
        if (!auth()->user()->can('admincareernavigator_access')) {
            abort(403, 'Unauthorized action.');
        }
        page_title()->setTitle(trans('adminboard::lang.admincareernavigator'));

        return $dataTable->renderTable();
    }

    public function import()
    {
        if (!auth()->user()->can('admincareernavigator_import')) {
            abort(403, 'Unauthorized action.');
        }
        page_title()->setTitle(trans('adminboard::lang.admincareernavigator_import'));
        $data = array();
        $data['title']        = 'admincareernavigator_import';
        return view('adminboard::admincareernavigator.create_import',$data);
    }
    public function store_import(Request $request)
    {
        if (!auth()->user()->can('admincareernavigator_import')) {
            abort(403, 'Unauthorized action.');
        }
        $file = $request->file('photo');
        Excel::import(new AdminCareerNavigatorImport, $file);
        $response_data['status'] = 1;
        $response_data['message'] =  __('adminboard::lang.record_save_successfully');
        return redirect()->route('admincareernavigator.index')->with('response_data', $response_data);
    }
    public function data()
    {
        if (!auth()->user()->can('admincareernavigator_access')) {
            abort(403, 'Unauthorized action.');
        }
        if(auth()->user()->can('admincareernavigator_list_all')) {
            $custom_table = AdminCareerNavigator::all();
        }else {
            $custom_table = AdminCareerNavigator::where('user_id', Auth::id())->get();
        }
        return datatables()->of($custom_table)->addColumn('action', function ($row) {
            $html = '';
            if(auth()->user()->can('admincareernavigator_pdf')) {
                $html .= '<a target="_blank" href="' . url('adminboard/admincareernavigator/pdf_show', $row->id) . '" class="btn btn-xs btn-success">' . __('adminboard::lang.pdf') . '</a> ';
            }
            if(auth()->user()->can('admincareernavigator_show')) {
                $html .= '<a href="' . url('adminboard/admincareernavigator/' . $row->id) . '" class="btn btn-xs btn-success">' . __('adminboard::lang.view') . '</a> ';
            }
            if(auth()->user()->can('admincareernavigator_edit')) {
                $html .= '<a  href="' . url('adminboard/admincareernavigator/' . $row->id . "/edit") . '" class="btn btn-xs btn-secondary">' . __('adminboard::lang.edit') . '</a> ';
            }
            if(auth()->user()->can('admincareernavigator_destroy')) {
                $html .= '<form action="' . url('adminboard/admincareernavigator', $row->id) . '" method="POST" style="display: inline-block;">
                            ' . csrf_field() . '
                            ' . method_field("DELETE") . '
                            <button type="submit" class="btn btn-xs btn-danger"
                                onclick="return confirm(\'Are You Sure Want to Delete?\')"
                                style="padding: .0em !important;"><i class="icon-trash"> </i>' . __('adminboard::lang.delete') . '</button>
                            </form>';
            }
            return $html;
        })->addColumn('photo', function ($row) {
            $html = '<img style="height: 100px;width: 100px;" src="' . getImageUrl($row->photo,'adminboard/admincareernavigator') . '" alt="' . $row->name . '" class="img-rounded img-preview">';
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
        if (!auth()->user()->can('admincareernavigator_create')) {
            abort(403, 'Unauthorized action.');
        }
        page_title()->setTitle(trans('adminboard::lang.admincareernavigator_create'));
        $data = array();
        $data['title']        = 'admincareernavigator_create';
        return view('adminboard::admincareernavigator.create',$data);
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
        if (!auth()->user()->can('admincareernavigator_create')) {
            abort(403, 'Unauthorized action.');
        }
        $validated = $request->validate([
            'name'              => 'bail|required|max:255',
        ]);

        try {
            $record = $this->admincareernavigatorRepository->createOrUpdate(array_merge($request->input(), [
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
//                return $file_name;
//                $rules = $request->validate([
//                    "$file_name" => 'mimes:jpeg,jpg,png,gif|max:10000'
//                ]);
                $path = $this->photo_path;
                deleteFile($record->$file_name, $path);

                $record->$file_name      = documentProcessUpload($request, $record,$file_name, $path);
                $record->save();
            }
            event(new CreatedContentEvent(ADMINCAREERNAVIGATOR_MODULE_SCREEN_NAME, $request, $record));

            return $response
                ->setPreviousUrl(route('admincareernavigator.index'))
                ->setNextUrl(route('admincareernavigator.edit', $record->id))
                ->setMessage(trans('kamruldashboard::notices.create_success_message'));
        }catch (\Exception $e){

            return $response
                ->setPreviousUrl(route('admincareernavigator.index'))
                ->setMessage(trans('kamruldashboard::notices.something_error_please_try_again_later'));
        }
    }

    /**
     * Show the specified resource.
     * @param  \Modules\AdminBoard\Http\Models\AdminCareerNavigator  $admincareernavigator
     * @return \Illuminate\Http\Response
     */
    public function show(AdminCareerNavigator $admincareernavigator)
    {
        if (!auth()->user()->can('admincareernavigator_show')) {
            abort(403, 'Unauthorized action.');
        }
        page_title()->setTitle(trans('adminboard::lang.admincareernavigator_show'));
        $data = array();
        $data['admincareernavigator']        = $admincareernavigator;
        $data['title']        = 'admincareernavigator_show';
        return view('adminboard::admincareernavigator.show',$data);
    }
    /**
     * Show the specified resource.
     * @param  \Modules\AdminBoard\Http\Models\AdminCareerNavigator  $admincareernavigator
     * @return \Illuminate\Http\Response
     */
    public function pdf(AdminCareerNavigator $admincareernavigator)
    {
        if (!auth()->user()->can('admincareernavigator_pdf')) {
            abort(403, 'Unauthorized action.');
        }
        page_title()->setTitle(trans('adminboard::lang.admincareernavigator_show'));
        $data = array();
        $data['admincareernavigator']        = $admincareernavigator;
        $data['title']        = 'admincareernavigator_show';
        return view('adminboard::admincareernavigator.pdf',$data);
    }

    /**
     * Show the form for editing the specified resource.
     * @param  \Modules\AdminBoard\Http\Models\AdminCareerNavigator  $admincareernavigator
     * @return \Illuminate\Http\Response
     */
    public function edit(AdminCareerNavigator $admincareernavigator)
    {
        if (!auth()->user()->can('admincareernavigator_edit')) {
            abort(403, 'Unauthorized action.');
        }
        page_title()->setTitle(trans('adminboard::lang.admincareernavigator_edit'));
        $data = array();
        $data['title']        = 'admincareernavigator_edit';
        $data['record']        = $this->admincareernavigatorRepository->findOrFail($admincareernavigator->id);
        return view('adminboard::admincareernavigator.create',$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Modules\AdminBoard\Http\Models\AdminCareerNavigator  $admincareernavigator
     * @param  DboardHttpResponse  $response
     * @return DboardHttpResponse
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AdminCareerNavigator  $admincareernavigator, DboardHttpResponse $response)
    {
        if (!auth()->user()->can('admincareernavigator_edit')) {
            abort(403, 'Unauthorized action.');
        }
        $validated = $request->validate([
            'name'              => 'bail|required|max:255',
        ]);

        $id = $admincareernavigator->id;
        $admincareernavigator = $this->admincareernavigatorRepository->firstOrNew(compact('id'));
        $admincareernavigator->fill($request->input());
        $this->admincareernavigatorRepository->createOrUpdate($admincareernavigator);

        $file_name = 'photo';
        if ($request->hasFile($file_name))
        {
//            return $file_name;
            $rules = $request->validate([
                "$file_name" => 'mimes:jpeg,jpg,png,gif|max:10000'
            ]);
            $path = $this->photo_path;
            deleteFile($admincareernavigator->$file_name, $path);

            $admincareernavigator->$file_name      = processUpload($request, $admincareernavigator,$file_name,$path);
            $admincareernavigator->save();
        }
        $file_name = 'document';
        if ($request->hasFile($file_name))
        {
//                return $file_name;
//                $rules = $request->validate([
//                    "$file_name" => 'mimes:jpeg,jpg,png,gif|max:10000'
//                ]);
            $path = $this->photo_path;
            deleteFile($admincareernavigator->$file_name, $path);

            $admincareernavigator->$file_name      = documentProcessUpload($request, $admincareernavigator,$file_name, $path);
            $admincareernavigator->save();
        }
        event(new UpdatedContentEvent(ADMINCAREERNAVIGATOR_MODULE_SCREEN_NAME, $request, $admincareernavigator));

        return $response
            ->setPreviousUrl(route('admincareernavigator.index'))
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
        if (!auth()->user()->can('admincareernavigator_destroy')) {
            abort(403, 'Unauthorized action.');
        }
        try{

            $admincareernavigator = $this->admincareernavigatorRepository->findOrFail($id);
            $this->admincareernavigatorRepository->delete($admincareernavigator);
            $path = $this->photo_path;
            deleteFile($admincareernavigator->photo, $path);
            event(new DeletedContentEvent(ADMINCAREERNAVIGATOR_MODULE_SCREEN_NAME, $request, $admincareernavigator));

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
        return $this->executeDeleteItems($request, $response, $this->admincareernavigatorRepository, ADMINCAREERNAVIGATOR_MODULE_SCREEN_NAME);
    }
}
