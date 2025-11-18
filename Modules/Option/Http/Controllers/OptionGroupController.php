<?php

namespace Modules\Option\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;
use Modules\KamrulDashboard\Events\DeletedContentEvent;
use Modules\KamrulDashboard\Events\UpdatedContentEvent;
use Modules\KamrulDashboard\Events\CreatedContentEvent;
use Modules\KamrulDashboard\Http\Responses\DboardHttpResponse;
use Modules\Option\Http\Models\OptionGroup;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Modules\KamrulDashboard\Traits\HasDeleteManyItemsTrait;
use Illuminate\Routing\Controller;
use Modules\Option\Repositories\Interfaces\OptionGroupInterface;
use Modules\Option\Http\Imports\OptionGroupImport;
use Modules\Option\Tables\OptionGroupTable;
use mysql_xdevapi\Exception;
use Throwable;

class OptionGroupController extends Controller
{
    use HasDeleteManyItemsTrait;
    /**
     * @var OptionGroupInterface
     */
    protected $optiongroupRepository;

    /**
     * OptionGroupController constructor.
     * @param OptionGroupInterface $optiongroupRepository
     */
    public function __construct(OptionGroupInterface $optiongroupRepository)
    {
        $this->optiongroupRepository = $optiongroupRepository;
    }
    protected $photo_path = 'uploads/option/optiongroup/';

    /**
     * @param OptionGroupTable $dataTable
     * @return JsonResponse|View
     *
     * @throws Throwable
     */
    public function index(OptionGroupTable $dataTable)
    {
        if (!auth()->user()->can('optiongroup_access')) {
            abort(403, 'Unauthorized action.');
        }
        page_title()->setTitle(trans('option::lang.optiongroup'));

        return $dataTable->renderTable();
    }

    public function import()
    {
        if (!auth()->user()->can('optiongroup_import')) {
            abort(403, 'Unauthorized action.');
        }
        page_title()->setTitle(trans('option::lang.optiongroup_import'));
        $data = array();
        $data['title']        = 'optiongroup_import';
        return view('option::optiongroup.create_import',$data);
    }
    public function store_import(Request $request)
    {
        if (!auth()->user()->can('optiongroup_import')) {
            abort(403, 'Unauthorized action.');
        }
        $file = $request->file('photo');
        Excel::import(new OptionGroupImport, $file);
        $response_data['status'] = 1;
        $response_data['message'] =  __('option::lang.record_save_successfully');
        return redirect()->route('optiongroup.index')->with('response_data', $response_data);
    }
    public function data()
    {
        if (!auth()->user()->can('optiongroup_access')) {
            abort(403, 'Unauthorized action.');
        }
        if(auth()->user()->can('optiongroup_list_all')) {
            $custom_table = OptionGroup::all();
        }else {
            $custom_table = OptionGroup::where('user_id', Auth::id())->get();
        }
        return datatables()->of($custom_table)->addColumn('action', function ($row) {
            $html = '';
            if(auth()->user()->can('optiongroup_pdf')) {
                $html .= '<a target="_blank" href="' . url('option/optiongroup/pdf_show', $row->id) . '" class="btn btn-xs btn-success">' . __('option::lang.pdf') . '</a> ';
            }
            if(auth()->user()->can('optiongroup_show')) {
                $html .= '<a href="' . url('option/optiongroup/' . $row->id) . '" class="btn btn-xs btn-success">' . __('option::lang.view') . '</a> ';
            }
            if(auth()->user()->can('optiongroup_edit')) {
                $html .= '<a  href="' . url('option/optiongroup/' . $row->id . "/edit") . '" class="btn btn-xs btn-secondary">' . __('option::lang.edit') . '</a> ';
            }
            if(auth()->user()->can('optiongroup_destroy')) {
                $html .= '<form action="' . url('option/optiongroup', $row->id) . '" method="POST" style="display: inline-block;">
                            ' . csrf_field() . '
                            ' . method_field("DELETE") . '
                            <button type="submit" class="btn btn-xs btn-danger"
                                onclick="return confirm(\'Are You Sure Want to Delete?\')"
                                style="padding: .0em !important;"><i class="icon-trash"> </i>' . __('option::lang.delete') . '</button>
                            </form>';
            }
            return $html;
        })->addColumn('photo', function ($row) {
            $html = '<img style="height: 100px;width: 100px;" src="' . getImageUrl($row->photo,'option/optiongroup') . '" alt="' . $row->name . '" class="img-rounded img-preview">';
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
        if (!auth()->user()->can('optiongroup_create')) {
            abort(403, 'Unauthorized action.');
        }
        page_title()->setTitle(trans('option::lang.optiongroup_create'));
        $data = array();
        $data['title']        = 'optiongroup_create';
        return view('option::optiongroup.create',$data);
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
        if (!auth()->user()->can('optiongroup_create')) {
            abort(403, 'Unauthorized action.');
        }
        $validated = $request->validate([
            'name'              => 'bail|required|max:255',
        ]);

        try {
            $record = $this->optiongroupRepository->createOrUpdate(array_merge($request->input(), [
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
            event(new CreatedContentEvent(OPTIONGROUP_MODULE_SCREEN_NAME, $request, $record));

            return $response
                ->setPreviousUrl(route('optiongroup.index'))
                ->setNextUrl(route('optiongroup.edit', $record->id))
                ->setMessage(trans('kamruldashboard::notices.create_success_message'));
        }catch (\Exception $e){

            return $response
                ->setPreviousUrl(route('optiongroup.index'))
                ->setMessage(trans('kamruldashboard::notices.something_error_please_try_again_later'));
        }
    }

    /**
     * Show the specified resource.
     * @param  \Modules\Option\Http\Models\OptionGroup  $optiongroup
     * @return \Illuminate\Http\Response
     */
    public function show(OptionGroup $optiongroup)
    {
        if (!auth()->user()->can('optiongroup_show')) {
            abort(403, 'Unauthorized action.');
        }
        page_title()->setTitle(trans('option::lang.optiongroup_show'));
        $data = array();
        $data['optiongroup']        = $optiongroup;
        $data['title']        = 'optiongroup_show';
        return view('option::optiongroup.show',$data);
    }
    /**
     * Show the specified resource.
     * @param  \Modules\Option\Http\Models\OptionGroup  $optiongroup
     * @return \Illuminate\Http\Response
     */
    public function pdf(OptionGroup $optiongroup)
    {
        if (!auth()->user()->can('optiongroup_pdf')) {
            abort(403, 'Unauthorized action.');
        }
        page_title()->setTitle(trans('option::lang.optiongroup_show'));
        $data = array();
        $data['optiongroup']        = $optiongroup;
        $data['title']        = 'optiongroup_show';
        return view('option::optiongroup.pdf',$data);
    }

    /**
     * Show the form for editing the specified resource.
     * @param  \Modules\Option\Http\Models\OptionGroup  $optiongroup
     * @return \Illuminate\Http\Response
     */
    public function edit(OptionGroup $optiongroup)
    {
        if (!auth()->user()->can('optiongroup_edit')) {
            abort(403, 'Unauthorized action.');
        }
        page_title()->setTitle(trans('option::lang.optiongroup_edit'));
        $data = array();
        $data['title']        = 'optiongroup_edit';
        $data['record']        = $this->optiongroupRepository->findOrFail($optiongroup->id);
        return view('option::optiongroup.create',$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Modules\Option\Http\Models\OptionGroup  $optiongroup
     * @param  DboardHttpResponse  $response
     * @return DboardHttpResponse
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, OptionGroup  $optiongroup, DboardHttpResponse $response)
    {
        if (!auth()->user()->can('optiongroup_edit')) {
            abort(403, 'Unauthorized action.');
        }
        $validated = $request->validate([
            'name'              => 'bail|required|max:255',
        ]);

        $id = $optiongroup->id;
        $optiongroup = $this->optiongroupRepository->firstOrNew(compact('id'));
        $optiongroup->fill($request->input());
        $this->optiongroupRepository->createOrUpdate($optiongroup);

        $file_name = 'photo';
        if ($request->hasFile($file_name))
        {
//            return $file_name;
            $rules = $request->validate([
                "$file_name" => 'mimes:jpeg,jpg,png,gif|max:10000'
            ]);
            $path = $this->photo_path;
            deleteFile($optiongroup->$file_name, $path);

            $optiongroup->$file_name      = processUpload($request, $optiongroup,$file_name,$path);
            $optiongroup->save();
        }

        event(new UpdatedContentEvent(OPTIONGROUP_MODULE_SCREEN_NAME, $request, $optiongroup));

        return $response
            ->setPreviousUrl(route('optiongroup.index'))
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
        if (!auth()->user()->can('optiongroup_destroy')) {
            abort(403, 'Unauthorized action.');
        }
        try{

            $optiongroup = $this->optiongroupRepository->findOrFail($id);
            $this->optiongroupRepository->delete($optiongroup);
            $path = $this->photo_path;
            deleteFile($optiongroup->photo, $path);
            event(new DeletedContentEvent(OPTIONGROUP_MODULE_SCREEN_NAME, $request, $optiongroup));

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
        return $this->executeDeleteItems($request, $response, $this->optiongroupRepository, OPTIONGROUP_MODULE_SCREEN_NAME);
    }
}
