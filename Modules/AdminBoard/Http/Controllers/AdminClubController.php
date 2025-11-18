<?php

namespace Modules\AdminBoard\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;
use Modules\AdminBoard\Forms\AdminClubForm;
use Modules\KamrulDashboard\Events\DeletedContentEvent;
use Modules\KamrulDashboard\Events\UpdatedContentEvent;
use Modules\KamrulDashboard\Events\CreatedContentEvent;
use Modules\KamrulDashboard\Http\Responses\DboardHttpResponse;
use Modules\AdminBoard\Http\Models\AdminClub;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Modules\KamrulDashboard\Traits\HasDeleteManyItemsTrait;
use Illuminate\Routing\Controller;
use Modules\AdminBoard\Repositories\Interfaces\AdminClubInterface;
use Modules\AdminBoard\Http\Imports\AdminClubImport;
use Modules\AdminBoard\Tables\AdminClubTable;
use mysql_xdevapi\Exception;
use Throwable;

class AdminClubController extends Controller
{
    use HasDeleteManyItemsTrait;
    /**
     * @var AdminClubInterface
     */
    protected $adminclubRepository;

    /**
     * AdminClubController constructor.
     * @param AdminClubInterface $adminclubRepository
     */
    public function __construct(AdminClubInterface $adminclubRepository)
    {
        $this->adminclubRepository = $adminclubRepository;
    }
    protected $photo_path = 'uploads/adminboard/adminclub/';

    /**
     * @param AdminClubTable $dataTable
     * @return JsonResponse|View
     *
     * @throws Throwable
     */
    public function index(AdminClubTable $dataTable)
    {
        if (!auth()->user()->can('adminclub_access')) {
            abort(403, 'Unauthorized action.');
        }
        page_title()->setTitle(trans('adminboard::lang.adminclub'));

        return $dataTable->renderTable();
    }

    public function import()
    {
        if (!auth()->user()->can('adminclub_import')) {
            abort(403, 'Unauthorized action.');
        }
        page_title()->setTitle(trans('adminboard::lang.adminclub_import'));
        $data = array();
        $data['title']        = 'adminclub_import';
        return view('adminboard::adminclub.create_import',$data);
    }
    public function store_import(Request $request)
    {
        if (!auth()->user()->can('adminclub_import')) {
            abort(403, 'Unauthorized action.');
        }
        $file = $request->file('photo');
        Excel::import(new AdminClubImport, $file);
        $response_data['status'] = 1;
        $response_data['message'] =  __('adminboard::lang.record_save_successfully');
        return redirect()->route('adminclub.index')->with('response_data', $response_data);
    }
    public function data()
    {
        if (!auth()->user()->can('adminclub_access')) {
            abort(403, 'Unauthorized action.');
        }
        if(auth()->user()->can('adminclub_list_all')) {
            $custom_table = AdminClub::all();
        }else {
            $custom_table = AdminClub::where('user_id', Auth::id())->get();
        }
        return datatables()->of($custom_table)->addColumn('action', function ($row) {
            $html = '';
            if(auth()->user()->can('adminclub_pdf')) {
                $html .= '<a target="_blank" href="' . url('adminboard/adminclub/pdf_show', $row->id) . '" class="btn btn-xs btn-success">' . __('adminboard::lang.pdf') . '</a> ';
            }
            if(auth()->user()->can('adminclub_show')) {
                $html .= '<a href="' . url('adminboard/adminclub/' . $row->id) . '" class="btn btn-xs btn-success">' . __('adminboard::lang.view') . '</a> ';
            }
            if(auth()->user()->can('adminclub_edit')) {
                $html .= '<a  href="' . url('adminboard/adminclub/' . $row->id . "/edit") . '" class="btn btn-xs btn-secondary">' . __('adminboard::lang.edit') . '</a> ';
            }
            if(auth()->user()->can('adminclub_destroy')) {
                $html .= '<form action="' . url('adminboard/adminclub', $row->id) . '" method="POST" style="display: inline-block;">
                            ' . csrf_field() . '
                            ' . method_field("DELETE") . '
                            <button type="submit" class="btn btn-xs btn-danger"
                                onclick="return confirm(\'Are You Sure Want to Delete?\')"
                                style="padding: .0em !important;"><i class="icon-trash"> </i>' . __('adminboard::lang.delete') . '</button>
                            </form>';
            }
            return $html;
        })->addColumn('photo', function ($row) {
            $html = '<img style="height: 100px;width: 100px;" src="' . getImageUrl($row->photo,'adminboard/adminclub') . '" alt="' . $row->name . '" class="img-rounded img-preview">';
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
        if (!auth()->user()->can('adminclub_create')) {
            abort(403, 'Unauthorized action.');
        }
        page_title()->setTitle(trans('adminboard::lang.adminclub_create'));

        return AdminClubForm::create()->renderForm();
        //$data = array();
        //$data['title']        = 'adminclub_create';
        //return view('adminboard::adminclub.create',$data);
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
        if (!auth()->user()->can('adminclub_create')) {
            abort(403, 'Unauthorized action.');
        }
        $validated = $request->validate([
            'name'              => 'bail|required|max:255',
        ]);

        try {
            $record = $this->adminclubRepository->createOrUpdate(array_merge($request->input(), [
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
            event(new CreatedContentEvent(ADMINCLUB_MODULE_SCREEN_NAME, $request, $record));

            return $response
                ->setPreviousUrl(route('adminclub.index'))
                ->setNextUrl(route('adminclub.edit', $record->id))
                ->setMessage(trans('kamruldashboard::notices.create_success_message'));
        }catch (\Exception $e){

            return $response
                ->setPreviousUrl(route('adminclub.index'))
                ->setMessage(trans('kamruldashboard::notices.something_error_please_try_again_later'));
        }
    }

    /**
     * Show the specified resource.
     * @param  \Modules\AdminBoard\Http\Models\AdminClub  $adminclub
     * @return \Illuminate\Http\Response
     */
    public function show(AdminClub $adminclub)
    {
        if (!auth()->user()->can('adminclub_show')) {
            abort(403, 'Unauthorized action.');
        }
        page_title()->setTitle(trans('adminboard::lang.adminclub_show'));
        $data = array();
        $data['adminclub']        = $adminclub;
        $data['title']        = 'adminclub_show';
        return view('adminboard::adminclub.show',$data);
    }
    /**
     * Show the specified resource.
     * @param  \Modules\AdminBoard\Http\Models\AdminClub  $adminclub
     * @return \Illuminate\Http\Response
     */
    public function pdf(AdminClub $adminclub)
    {
        if (!auth()->user()->can('adminclub_pdf')) {
            abort(403, 'Unauthorized action.');
        }
        page_title()->setTitle(trans('adminboard::lang.adminclub_show'));
        $data = array();
        $data['adminclub']        = $adminclub;
        $data['title']        = 'adminclub_show';
        return view('adminboard::adminclub.pdf',$data);
    }

    /**
     * Show the form for editing the specified resource.
     * @param  \Modules\AdminBoard\Http\Models\AdminClub  $adminclub
     * @return \Illuminate\Http\Response
     */
    public function edit(AdminClub $adminclub)
    {
        if (!auth()->user()->can('adminclub_edit')) {
            abort(403, 'Unauthorized action.');
        }
        page_title()->setTitle(trans('adminboard::lang.adminclub_edit'));

        return AdminClubForm::createFromModel($adminclub)->renderForm();
     //   $data = array();
      //  $data['title']        = 'adminclub_edit';
     //   $data['record']        = $this->adminclubRepository->findOrFail($adminclub->id);
      //  return view('adminboard::adminclub.create',$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Modules\AdminBoard\Http\Models\AdminClub  $adminclub
     * @param  DboardHttpResponse  $response
     * @return DboardHttpResponse
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AdminClub  $adminclub, DboardHttpResponse $response)
    {
        if (!auth()->user()->can('adminclub_edit')) {
            abort(403, 'Unauthorized action.');
        }
        $validated = $request->validate([
            'name'              => 'bail|required|max:255',
        ]);

        $id = $adminclub->id;
        $adminclub = $this->adminclubRepository->firstOrNew(compact('id'));
        $adminclub->fill($request->input());
        $this->adminclubRepository->createOrUpdate($adminclub);

        $file_name = 'photo';
        if ($request->hasFile($file_name))
        {
//            return $file_name;
            $rules = $request->validate([
                "$file_name" => 'mimes:jpeg,jpg,png,gif|max:10000'
            ]);
            $path = $this->photo_path;
            deleteFile($adminclub->$file_name, $path);

            $adminclub->$file_name      = processUpload($request, $adminclub,$file_name,$path);
            $adminclub->save();
        }

        event(new UpdatedContentEvent(ADMINCLUB_MODULE_SCREEN_NAME, $request, $adminclub));

        return $response
            ->setPreviousUrl(route('adminclub.index'))
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
        if (!auth()->user()->can('adminclub_destroy')) {
            abort(403, 'Unauthorized action.');
        }
        try{

            $adminclub = $this->adminclubRepository->findOrFail($id);
            $this->adminclubRepository->delete($adminclub);
            $path = $this->photo_path;
            deleteFile($adminclub->photo, $path);
            event(new DeletedContentEvent(ADMINCLUB_MODULE_SCREEN_NAME, $request, $adminclub));

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
        return $this->executeDeleteItems($request, $response, $this->adminclubRepository, ADMINCLUB_MODULE_SCREEN_NAME);
    }
}
