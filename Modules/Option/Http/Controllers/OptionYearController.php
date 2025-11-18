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
use Modules\Option\Http\Models\OptionYear;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Modules\KamrulDashboard\Traits\HasDeleteManyItemsTrait;
use Illuminate\Routing\Controller;
use Modules\Option\Repositories\Interfaces\OptionYearInterface;
use Modules\Option\Http\Imports\OptionYearImport;
use Modules\Option\Tables\OptionYearTable;
use mysql_xdevapi\Exception;
use Throwable;

class OptionYearController extends Controller
{
    use HasDeleteManyItemsTrait;
    /**
     * @var OptionYearInterface
     */
    protected $optionyearRepository;

    /**
     * OptionYearController constructor.
     * @param OptionYearInterface $optionyearRepository
     */
    public function __construct(OptionYearInterface $optionyearRepository)
    {
        $this->optionyearRepository = $optionyearRepository;
    }
    protected $photo_path = 'uploads/option/optionyear/';

    /**
     * @param OptionYearTable $dataTable
     * @return JsonResponse|View
     *
     * @throws Throwable
     */
    public function index(OptionYearTable $dataTable)
    {
        if (!auth()->user()->can('optionyear_access')) {
            abort(403, 'Unauthorized action.');
        }
        page_title()->setTitle(trans('option::lang.optionyear'));

        return $dataTable->renderTable();
    }

    public function import()
    {
        if (!auth()->user()->can('optionyear_import')) {
            abort(403, 'Unauthorized action.');
        }
        page_title()->setTitle(trans('option::lang.optionyear_import'));
        $data = array();
        $data['title']        = 'optionyear_import';
        return view('option::optionyear.create_import',$data);
    }
    public function store_import(Request $request)
    {
        if (!auth()->user()->can('optionyear_import')) {
            abort(403, 'Unauthorized action.');
        }
        $file = $request->file('photo');
        Excel::import(new OptionYearImport, $file);
        $response_data['status'] = 1;
        $response_data['message'] =  __('option::lang.record_save_successfully');
        return redirect()->route('optionyear.index')->with('response_data', $response_data);
    }
    public function data()
    {
        if (!auth()->user()->can('optionyear_access')) {
            abort(403, 'Unauthorized action.');
        }
        if(auth()->user()->can('optionyear_list_all')) {
            $custom_table = OptionYear::all();
        }else {
            $custom_table = OptionYear::where('user_id', Auth::id())->get();
        }
        return datatables()->of($custom_table)->addColumn('action', function ($row) {
            $html = '';
            if(auth()->user()->can('optionyear_pdf')) {
                $html .= '<a target="_blank" href="' . url('option/optionyear/pdf_show', $row->id) . '" class="btn btn-xs btn-success">' . __('option::lang.pdf') . '</a> ';
            }
            if(auth()->user()->can('optionyear_show')) {
                $html .= '<a href="' . url('option/optionyear/' . $row->id) . '" class="btn btn-xs btn-success">' . __('option::lang.view') . '</a> ';
            }
            if(auth()->user()->can('optionyear_edit')) {
                $html .= '<a  href="' . url('option/optionyear/' . $row->id . "/edit") . '" class="btn btn-xs btn-secondary">' . __('option::lang.edit') . '</a> ';
            }
            if(auth()->user()->can('optionyear_destroy')) {
                $html .= '<form action="' . url('option/optionyear', $row->id) . '" method="POST" style="display: inline-block;">
                            ' . csrf_field() . '
                            ' . method_field("DELETE") . '
                            <button type="submit" class="btn btn-xs btn-danger"
                                onclick="return confirm(\'Are You Sure Want to Delete?\')"
                                style="padding: .0em !important;"><i class="icon-trash"> </i>' . __('option::lang.delete') . '</button>
                            </form>';
            }
            return $html;
        })->addColumn('photo', function ($row) {
            $html = '<img style="height: 100px;width: 100px;" src="' . getImageUrl($row->photo,'option/optionyear') . '" alt="' . $row->name . '" class="img-rounded img-preview">';
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
        if (!auth()->user()->can('optionyear_create')) {
            abort(403, 'Unauthorized action.');
        }
        page_title()->setTitle(trans('option::lang.optionyear_create'));
        $data = array();
        $data['title']        = 'optionyear_create';
        return view('option::optionyear.create',$data);
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
        if (!auth()->user()->can('optionyear_create')) {
            abort(403, 'Unauthorized action.');
        }
        $validated = $request->validate([
            'name'              => 'bail|required|max:255',
        ]);

        try {
            $record = $this->optionyearRepository->createOrUpdate(array_merge($request->input(), [
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
            event(new CreatedContentEvent(OPTIONYEAR_MODULE_SCREEN_NAME, $request, $record));

            return $response
                ->setPreviousUrl(route('optionyear.index'))
                ->setNextUrl(route('optionyear.edit', $record->id))
                ->setMessage(trans('kamruldashboard::notices.create_success_message'));
        }catch (\Exception $e){

            return $response
                ->setPreviousUrl(route('optionyear.index'))
                ->setMessage(trans('kamruldashboard::notices.something_error_please_try_again_later'));
        }
    }

    /**
     * Show the specified resource.
     * @param  \Modules\Option\Http\Models\OptionYear  $optionyear
     * @return \Illuminate\Http\Response
     */
    public function show(OptionYear $optionyear)
    {
        if (!auth()->user()->can('optionyear_show')) {
            abort(403, 'Unauthorized action.');
        }
        page_title()->setTitle(trans('option::lang.optionyear_show'));
        $data = array();
        $data['optionyear']        = $optionyear;
        $data['title']        = 'optionyear_show';
        return view('option::optionyear.show',$data);
    }
    /**
     * Show the specified resource.
     * @param  \Modules\Option\Http\Models\OptionYear  $optionyear
     * @return \Illuminate\Http\Response
     */
    public function pdf(OptionYear $optionyear)
    {
        if (!auth()->user()->can('optionyear_pdf')) {
            abort(403, 'Unauthorized action.');
        }
        page_title()->setTitle(trans('option::lang.optionyear_show'));
        $data = array();
        $data['optionyear']        = $optionyear;
        $data['title']        = 'optionyear_show';
        return view('option::optionyear.pdf',$data);
    }

    /**
     * Show the form for editing the specified resource.
     * @param  \Modules\Option\Http\Models\OptionYear  $optionyear
     * @return \Illuminate\Http\Response
     */
    public function edit(OptionYear $optionyear)
    {
        if (!auth()->user()->can('optionyear_edit')) {
            abort(403, 'Unauthorized action.');
        }
        page_title()->setTitle(trans('option::lang.optionyear_edit'));
        $data = array();
        $data['title']        = 'optionyear_edit';
        $data['record']        = $this->optionyearRepository->findOrFail($optionyear->id);
        return view('option::optionyear.create',$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Modules\Option\Http\Models\OptionYear  $optionyear
     * @param  DboardHttpResponse  $response
     * @return DboardHttpResponse
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, OptionYear  $optionyear, DboardHttpResponse $response)
    {
        if (!auth()->user()->can('optionyear_edit')) {
            abort(403, 'Unauthorized action.');
        }
        $validated = $request->validate([
            'name'              => 'bail|required|max:255',
        ]);

        $id = $optionyear->id;
        $optionyear = $this->optionyearRepository->firstOrNew(compact('id'));
        $optionyear->fill($request->input());
        $this->optionyearRepository->createOrUpdate($optionyear);

        $file_name = 'photo';
        if ($request->hasFile($file_name))
        {
//            return $file_name;
            $rules = $request->validate([
                "$file_name" => 'mimes:jpeg,jpg,png,gif|max:10000'
            ]);
            $path = $this->photo_path;
            deleteFile($optionyear->$file_name, $path);

            $optionyear->$file_name      = processUpload($request, $optionyear,$file_name,$path);
            $optionyear->save();
        }

        event(new UpdatedContentEvent(OPTIONYEAR_MODULE_SCREEN_NAME, $request, $optionyear));

        return $response
            ->setPreviousUrl(route('optionyear.index'))
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
        if (!auth()->user()->can('optionyear_destroy')) {
            abort(403, 'Unauthorized action.');
        }
        try{

            $optionyear = $this->optionyearRepository->findOrFail($id);
            $this->optionyearRepository->delete($optionyear);
            $path = $this->photo_path;
            deleteFile($optionyear->photo, $path);
            event(new DeletedContentEvent(OPTIONYEAR_MODULE_SCREEN_NAME, $request, $optionyear));

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
        return $this->executeDeleteItems($request, $response, $this->optionyearRepository, OPTIONYEAR_MODULE_SCREEN_NAME);
    }
}
