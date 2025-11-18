<?php

namespace Modules\Option\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;
use Modules\Option\Forms\OptionBloodGroupForm;
use Modules\KamrulDashboard\Events\DeletedContentEvent;
use Modules\KamrulDashboard\Events\UpdatedContentEvent;
use Modules\KamrulDashboard\Events\CreatedContentEvent;
use Modules\KamrulDashboard\Http\Responses\DboardHttpResponse;
use Modules\Option\Http\Models\OptionBloodGroup;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Modules\KamrulDashboard\Traits\HasDeleteManyItemsTrait;
use Illuminate\Routing\Controller;
use Modules\Option\Repositories\Interfaces\OptionBloodGroupInterface;
use Modules\Option\Http\Imports\OptionBloodGroupImport;
use Modules\Option\Tables\OptionBloodGroupTable;
use mysql_xdevapi\Exception;
use Throwable;

class OptionBloodGroupController extends Controller
{
    use HasDeleteManyItemsTrait;
    /**
     * @var OptionBloodGroupInterface
     */
    protected $optionbloodgroupRepository;

    /**
     * OptionBloodGroupController constructor.
     * @param OptionBloodGroupInterface $optionbloodgroupRepository
     */
    public function __construct(OptionBloodGroupInterface $optionbloodgroupRepository)
    {
        $this->optionbloodgroupRepository = $optionbloodgroupRepository;
    }
    protected $photo_path = 'uploads/option/optionbloodgroup/';

    /**
     * @param OptionBloodGroupTable $dataTable
     * @return JsonResponse|View
     *
     * @throws Throwable
     */
    public function index(OptionBloodGroupTable $dataTable)
    {
        if (!auth()->user()->can('optionbloodgroup_access')) {
            abort(403, 'Unauthorized action.');
        }
        page_title()->setTitle(trans('option::lang.optionbloodgroup'));

        return $dataTable->renderTable();
    }

    public function import()
    {
        if (!auth()->user()->can('optionbloodgroup_import')) {
            abort(403, 'Unauthorized action.');
        }
        page_title()->setTitle(trans('option::lang.optionbloodgroup_import'));
        $data = array();
        $data['title']        = 'optionbloodgroup_import';
        return view('option::optionbloodgroup.create_import',$data);
    }
    public function store_import(Request $request)
    {
        if (!auth()->user()->can('optionbloodgroup_import')) {
            abort(403, 'Unauthorized action.');
        }
        $file = $request->file('photo');
        Excel::import(new OptionBloodGroupImport, $file);
        $response_data['status'] = 1;
        $response_data['message'] =  __('option::lang.record_save_successfully');
        return redirect()->route('optionbloodgroup.index')->with('response_data', $response_data);
    }
    public function data()
    {
        if (!auth()->user()->can('optionbloodgroup_access')) {
            abort(403, 'Unauthorized action.');
        }
        if(auth()->user()->can('optionbloodgroup_list_all')) {
            $custom_table = OptionBloodGroup::all();
        }else {
            $custom_table = OptionBloodGroup::where('user_id', Auth::id())->get();
        }
        return datatables()->of($custom_table)->addColumn('action', function ($row) {
            $html = '';
            if(auth()->user()->can('optionbloodgroup_pdf')) {
                $html .= '<a target="_blank" href="' . url('option/optionbloodgroup/pdf_show', $row->id) . '" class="btn btn-xs btn-success">' . __('option::lang.pdf') . '</a> ';
            }
            if(auth()->user()->can('optionbloodgroup_show')) {
                $html .= '<a href="' . url('option/optionbloodgroup/' . $row->id) . '" class="btn btn-xs btn-success">' . __('option::lang.view') . '</a> ';
            }
            if(auth()->user()->can('optionbloodgroup_edit')) {
                $html .= '<a  href="' . url('option/optionbloodgroup/' . $row->id . "/edit") . '" class="btn btn-xs btn-secondary">' . __('option::lang.edit') . '</a> ';
            }
            if(auth()->user()->can('optionbloodgroup_destroy')) {
                $html .= '<form action="' . url('option/optionbloodgroup', $row->id) . '" method="POST" style="display: inline-block;">
                            ' . csrf_field() . '
                            ' . method_field("DELETE") . '
                            <button type="submit" class="btn btn-xs btn-danger"
                                onclick="return confirm(\'Are You Sure Want to Delete?\')"
                                style="padding: .0em !important;"><i class="icon-trash"> </i>' . __('option::lang.delete') . '</button>
                            </form>';
            }
            return $html;
        })->addColumn('photo', function ($row) {
            $html = '<img style="height: 100px;width: 100px;" src="' . getImageUrl($row->photo,'option/optionbloodgroup') . '" alt="' . $row->name . '" class="img-rounded img-preview">';
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
        if (!auth()->user()->can('optionbloodgroup_create')) {
            abort(403, 'Unauthorized action.');
        }
        page_title()->setTitle(trans('option::lang.optionbloodgroup_create'));

        return OptionBloodGroupForm::create()->renderForm();
        //$data = array();
        //$data['title']        = 'optionbloodgroup_create';
        //return view('option::optionbloodgroup.create',$data);
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
        if (!auth()->user()->can('optionbloodgroup_create')) {
            abort(403, 'Unauthorized action.');
        }
        $validated = $request->validate([
            'name'              => 'bail|required|max:255',
        ]);

        try {
            $record = $this->optionbloodgroupRepository->createOrUpdate(array_merge($request->input(), [
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
            event(new CreatedContentEvent(OPTIONBLOODGROUP_MODULE_SCREEN_NAME, $request, $record));

            return $response
                ->setPreviousUrl(route('optionbloodgroup.index'))
                ->setNextUrl(route('optionbloodgroup.edit', $record->id))
                ->setMessage(trans('kamruldashboard::notices.create_success_message'));
        }catch (\Exception $e){

            return $response
                ->setPreviousUrl(route('optionbloodgroup.index'))
                ->setMessage(trans('kamruldashboard::notices.something_error_please_try_again_later'));
        }
    }

    /**
     * Show the specified resource.
     * @param  \Modules\Option\Http\Models\OptionBloodGroup  $optionbloodgroup
     * @return \Illuminate\Http\Response
     */
    public function show(OptionBloodGroup $optionbloodgroup)
    {
        if (!auth()->user()->can('optionbloodgroup_show')) {
            abort(403, 'Unauthorized action.');
        }
        page_title()->setTitle(trans('option::lang.optionbloodgroup_show'));
        $data = array();
        $data['optionbloodgroup']        = $optionbloodgroup;
        $data['title']        = 'optionbloodgroup_show';
        return view('option::optionbloodgroup.show',$data);
    }
    /**
     * Show the specified resource.
     * @param  \Modules\Option\Http\Models\OptionBloodGroup  $optionbloodgroup
     * @return \Illuminate\Http\Response
     */
    public function pdf(OptionBloodGroup $optionbloodgroup)
    {
        if (!auth()->user()->can('optionbloodgroup_pdf')) {
            abort(403, 'Unauthorized action.');
        }
        page_title()->setTitle(trans('option::lang.optionbloodgroup_show'));
        $data = array();
        $data['optionbloodgroup']        = $optionbloodgroup;
        $data['title']        = 'optionbloodgroup_show';
        return view('option::optionbloodgroup.pdf',$data);
    }

    /**
     * Show the form for editing the specified resource.
     * @param  \Modules\Option\Http\Models\OptionBloodGroup  $optionbloodgroup
     * @return \Illuminate\Http\Response
     */
    public function edit(OptionBloodGroup $optionbloodgroup)
    {
        if (!auth()->user()->can('optionbloodgroup_edit')) {
            abort(403, 'Unauthorized action.');
        }
        page_title()->setTitle(trans('option::lang.optionbloodgroup_edit'));

        return OptionBloodGroupForm::createFromModel($optionbloodgroup)->renderForm();
     //   $data = array();
      //  $data['title']        = 'optionbloodgroup_edit';
     //   $data['record']        = $this->optionbloodgroupRepository->findOrFail($optionbloodgroup->id);
      //  return view('option::optionbloodgroup.create',$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Modules\Option\Http\Models\OptionBloodGroup  $optionbloodgroup
     * @param  DboardHttpResponse  $response
     * @return DboardHttpResponse
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, OptionBloodGroup  $optionbloodgroup, DboardHttpResponse $response)
    {
        if (!auth()->user()->can('optionbloodgroup_edit')) {
            abort(403, 'Unauthorized action.');
        }
        $validated = $request->validate([
            'name'              => 'bail|required|max:255',
        ]);

        $id = $optionbloodgroup->id;
        $optionbloodgroup = $this->optionbloodgroupRepository->firstOrNew(compact('id'));
        $optionbloodgroup->fill($request->input());
        $this->optionbloodgroupRepository->createOrUpdate($optionbloodgroup);

        $file_name = 'photo';
        if ($request->hasFile($file_name))
        {
//            return $file_name;
            $rules = $request->validate([
                "$file_name" => 'mimes:jpeg,jpg,png,gif|max:10000'
            ]);
            $path = $this->photo_path;
            deleteFile($optionbloodgroup->$file_name, $path);

            $optionbloodgroup->$file_name      = processUpload($request, $optionbloodgroup,$file_name,$path);
            $optionbloodgroup->save();
        }

        event(new UpdatedContentEvent(OPTIONBLOODGROUP_MODULE_SCREEN_NAME, $request, $optionbloodgroup));

        return $response
            ->setPreviousUrl(route('optionbloodgroup.index'))
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
        if (!auth()->user()->can('optionbloodgroup_destroy')) {
            abort(403, 'Unauthorized action.');
        }
        try{

            $optionbloodgroup = $this->optionbloodgroupRepository->findOrFail($id);
            $this->optionbloodgroupRepository->delete($optionbloodgroup);
            $path = $this->photo_path;
            deleteFile($optionbloodgroup->photo, $path);
            event(new DeletedContentEvent(OPTIONBLOODGROUP_MODULE_SCREEN_NAME, $request, $optionbloodgroup));

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
        return $this->executeDeleteItems($request, $response, $this->optionbloodgroupRepository, OPTIONBLOODGROUP_MODULE_SCREEN_NAME);
    }
}
