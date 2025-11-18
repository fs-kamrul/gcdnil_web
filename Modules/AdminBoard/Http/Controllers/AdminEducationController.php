<?php

namespace Modules\AdminBoard\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;
use Modules\AdminBoard\Forms\AdminEducationForm;
use Modules\KamrulDashboard\Events\DeletedContentEvent;
use Modules\KamrulDashboard\Events\UpdatedContentEvent;
use Modules\KamrulDashboard\Events\CreatedContentEvent;
use Modules\KamrulDashboard\Http\Responses\DboardHttpResponse;
use Modules\AdminBoard\Http\Models\AdminEducation;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Modules\KamrulDashboard\Traits\HasDeleteManyItemsTrait;
use Illuminate\Routing\Controller;
use Modules\AdminBoard\Repositories\Interfaces\AdminEducationInterface;
use Modules\AdminBoard\Http\Imports\AdminEducationImport;
use Modules\AdminBoard\Tables\AdminEducationTable;
use mysql_xdevapi\Exception;
use Throwable;

class AdminEducationController extends Controller
{
    use HasDeleteManyItemsTrait;
    /**
     * @var AdminEducationInterface
     */
    protected $admineducationRepository;

    /**
     * AdminEducationController constructor.
     * @param AdminEducationInterface $admineducationRepository
     */
    public function __construct(AdminEducationInterface $admineducationRepository)
    {
        $this->admineducationRepository = $admineducationRepository;
    }
    protected $photo_path = 'uploads/adminboard/admineducation/';

    /**
     * @param AdminEducationTable $dataTable
     * @return JsonResponse|View
     *
     * @throws Throwable
     */
    public function index(AdminEducationTable $dataTable)
    {
        if (!auth()->user()->can('admineducation_access')) {
            abort(403, 'Unauthorized action.');
        }
        page_title()->setTitle(trans('adminboard::lang.admineducation'));

        return $dataTable->renderTable();
    }

    public function import()
    {
        if (!auth()->user()->can('admineducation_import')) {
            abort(403, 'Unauthorized action.');
        }
        page_title()->setTitle(trans('adminboard::lang.admineducation_import'));
        $data = array();
        $data['title']        = 'admineducation_import';
        return view('adminboard::admineducation.create_import',$data);
    }
    public function store_import(Request $request)
    {
        if (!auth()->user()->can('admineducation_import')) {
            abort(403, 'Unauthorized action.');
        }
        $file = $request->file('photo');
        Excel::import(new AdminEducationImport, $file);
        $response_data['status'] = 1;
        $response_data['message'] =  __('adminboard::lang.record_save_successfully');
        return redirect()->route('admineducation.index')->with('response_data', $response_data);
    }
    public function data()
    {
        if (!auth()->user()->can('admineducation_access')) {
            abort(403, 'Unauthorized action.');
        }
        if(auth()->user()->can('admineducation_list_all')) {
            $custom_table = AdminEducation::all();
        }else {
            $custom_table = AdminEducation::where('user_id', Auth::id())->get();
        }
        return datatables()->of($custom_table)->addColumn('action', function ($row) {
            $html = '';
            if(auth()->user()->can('admineducation_pdf')) {
                $html .= '<a target="_blank" href="' . url('adminboard/admineducation/pdf_show', $row->id) . '" class="btn btn-xs btn-success">' . __('adminboard::lang.pdf') . '</a> ';
            }
            if(auth()->user()->can('admineducation_show')) {
                $html .= '<a href="' . url('adminboard/admineducation/' . $row->id) . '" class="btn btn-xs btn-success">' . __('adminboard::lang.view') . '</a> ';
            }
            if(auth()->user()->can('admineducation_edit')) {
                $html .= '<a  href="' . url('adminboard/admineducation/' . $row->id . "/edit") . '" class="btn btn-xs btn-secondary">' . __('adminboard::lang.edit') . '</a> ';
            }
            if(auth()->user()->can('admineducation_destroy')) {
                $html .= '<form action="' . url('adminboard/admineducation', $row->id) . '" method="POST" style="display: inline-block;">
                            ' . csrf_field() . '
                            ' . method_field("DELETE") . '
                            <button type="submit" class="btn btn-xs btn-danger"
                                onclick="return confirm(\'Are You Sure Want to Delete?\')"
                                style="padding: .0em !important;"><i class="icon-trash"> </i>' . __('adminboard::lang.delete') . '</button>
                            </form>';
            }
            return $html;
        })->addColumn('photo', function ($row) {
            $html = '<img style="height: 100px;width: 100px;" src="' . getImageUrl($row->photo,'adminboard/admineducation') . '" alt="' . $row->name . '" class="img-rounded img-preview">';
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
        if (!auth()->user()->can('admineducation_create')) {
            abort(403, 'Unauthorized action.');
        }
        page_title()->setTitle(trans('adminboard::lang.admineducation_create'));

        return AdminEducationForm::create()->renderForm();
        //$data = array();
        //$data['title']        = 'admineducation_create';
        //return view('adminboard::admineducation.create',$data);
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
        if (!auth()->user()->can('admineducation_create')) {
            abort(403, 'Unauthorized action.');
        }
        $validated = $request->validate([
            'name'              => 'bail|required|max:255',
        ]);

        try {
            $record = $this->admineducationRepository->createOrUpdate(array_merge($request->input(), [
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
            event(new CreatedContentEvent(ADMINEDUCATION_MODULE_SCREEN_NAME, $request, $record));

            return $response
                ->setPreviousUrl(route('admineducation.index'))
                ->setNextUrl(route('admineducation.edit', $record->id))
                ->setMessage(trans('kamruldashboard::notices.create_success_message'));
        }catch (\Exception $e){

            return $response
                ->setPreviousUrl(route('admineducation.index'))
                ->setMessage(trans('kamruldashboard::notices.something_error_please_try_again_later'));
        }
    }

    /**
     * Show the specified resource.
     * @param  \Modules\AdminBoard\Http\Models\AdminEducation  $admineducation
     * @return \Illuminate\Http\Response
     */
    public function show(AdminEducation $admineducation)
    {
        if (!auth()->user()->can('admineducation_show')) {
            abort(403, 'Unauthorized action.');
        }
        page_title()->setTitle(trans('adminboard::lang.admineducation_show'));
        $data = array();
        $data['admineducation']        = $admineducation;
        $data['title']        = 'admineducation_show';
        return view('adminboard::admineducation.show',$data);
    }
    /**
     * Show the specified resource.
     * @param  \Modules\AdminBoard\Http\Models\AdminEducation  $admineducation
     * @return \Illuminate\Http\Response
     */
    public function pdf(AdminEducation $admineducation)
    {
        if (!auth()->user()->can('admineducation_pdf')) {
            abort(403, 'Unauthorized action.');
        }
        page_title()->setTitle(trans('adminboard::lang.admineducation_show'));
        $data = array();
        $data['admineducation']        = $admineducation;
        $data['title']        = 'admineducation_show';
        return view('adminboard::admineducation.pdf',$data);
    }

    /**
     * Show the form for editing the specified resource.
     * @param  \Modules\AdminBoard\Http\Models\AdminEducation  $admineducation
     * @return \Illuminate\Http\Response
     */
    public function edit(AdminEducation $admineducation)
    {
        if (!auth()->user()->can('admineducation_edit')) {
            abort(403, 'Unauthorized action.');
        }
        page_title()->setTitle(trans('adminboard::lang.admineducation_edit'));

        return AdminEducationForm::createFromModel($admineducation)->renderForm();
     //   $data = array();
      //  $data['title']        = 'admineducation_edit';
     //   $data['record']        = $this->admineducationRepository->findOrFail($admineducation->id);
      //  return view('adminboard::admineducation.create',$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Modules\AdminBoard\Http\Models\AdminEducation  $admineducation
     * @param  DboardHttpResponse  $response
     * @return DboardHttpResponse
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AdminEducation  $admineducation, DboardHttpResponse $response)
    {
        if (!auth()->user()->can('admineducation_edit')) {
            abort(403, 'Unauthorized action.');
        }
        $validated = $request->validate([
            'name'              => 'bail|required|max:255',
        ]);

        $id = $admineducation->id;
        $admineducation = $this->admineducationRepository->firstOrNew(compact('id'));
        $admineducation->fill($request->input());
        $this->admineducationRepository->createOrUpdate($admineducation);

        $file_name = 'photo';
        if ($request->hasFile($file_name))
        {
//            return $file_name;
            $rules = $request->validate([
                "$file_name" => 'mimes:jpeg,jpg,png,gif|max:10000'
            ]);
            $path = $this->photo_path;
            deleteFile($admineducation->$file_name, $path);

            $admineducation->$file_name      = processUpload($request, $admineducation,$file_name,$path);
            $admineducation->save();
        }

        event(new UpdatedContentEvent(ADMINEDUCATION_MODULE_SCREEN_NAME, $request, $admineducation));

        return $response
            ->setPreviousUrl(route('admineducation.index'))
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
        if (!auth()->user()->can('admineducation_destroy')) {
            abort(403, 'Unauthorized action.');
        }
        try{

            $admineducation = $this->admineducationRepository->findOrFail($id);
            $this->admineducationRepository->delete($admineducation);
            $path = $this->photo_path;
            deleteFile($admineducation->photo, $path);
            event(new DeletedContentEvent(ADMINEDUCATION_MODULE_SCREEN_NAME, $request, $admineducation));

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
        return $this->executeDeleteItems($request, $response, $this->admineducationRepository, ADMINEDUCATION_MODULE_SCREEN_NAME);
    }
}
