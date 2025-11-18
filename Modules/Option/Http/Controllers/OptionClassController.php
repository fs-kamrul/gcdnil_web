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
use Modules\Option\Http\Models\OptionClass;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Modules\KamrulDashboard\Traits\HasDeleteManyItemsTrait;
use Illuminate\Routing\Controller;
use Modules\Option\Repositories\Interfaces\OptionClassInterface;
use Modules\Option\Http\Imports\OptionClassImport;
use Modules\Option\Tables\OptionClassTable;
use mysql_xdevapi\Exception;
use Throwable;

class OptionClassController extends Controller
{
    use HasDeleteManyItemsTrait;
    /**
     * @var OptionClassInterface
     */
    protected $optionclassRepository;

    /**
     * OptionClassController constructor.
     * @param OptionClassInterface $optionclassRepository
     */
    public function __construct(OptionClassInterface $optionclassRepository)
    {
        $this->optionclassRepository = $optionclassRepository;
    }
    protected $photo_path = 'uploads/option/optionclass/';

    /**
     * @param OptionClassTable $dataTable
     * @return JsonResponse|View
     *
     * @throws Throwable
     */
    public function index(OptionClassTable $dataTable)
    {
        if (!auth()->user()->can('optionclass_access')) {
            abort(403, 'Unauthorized action.');
        }
        page_title()->setTitle(trans('option::lang.optionclass'));

        return $dataTable->renderTable();
    }

    public function import()
    {
        if (!auth()->user()->can('optionclass_import')) {
            abort(403, 'Unauthorized action.');
        }
        page_title()->setTitle(trans('option::lang.optionclass_import'));
        $data = array();
        $data['title']        = 'optionclass_import';
        return view('option::optionclass.create_import',$data);
    }
    public function store_import(Request $request)
    {
        if (!auth()->user()->can('optionclass_import')) {
            abort(403, 'Unauthorized action.');
        }
        $file = $request->file('photo');
        Excel::import(new OptionClassImport, $file);
        $response_data['status'] = 1;
        $response_data['message'] =  __('option::lang.record_save_successfully');
        return redirect()->route('optionclass.index')->with('response_data', $response_data);
    }
    public function data()
    {
        if (!auth()->user()->can('optionclass_access')) {
            abort(403, 'Unauthorized action.');
        }
        if(auth()->user()->can('optionclass_list_all')) {
            $custom_table = OptionClass::all();
        }else {
            $custom_table = OptionClass::where('user_id', Auth::id())->get();
        }
        return datatables()->of($custom_table)->addColumn('action', function ($row) {
            $html = '';
            if(auth()->user()->can('optionclass_pdf')) {
                $html .= '<a target="_blank" href="' . url('option/optionclass/pdf_show', $row->id) . '" class="btn btn-xs btn-success">' . __('option::lang.pdf') . '</a> ';
            }
            if(auth()->user()->can('optionclass_show')) {
                $html .= '<a href="' . url('option/optionclass/' . $row->id) . '" class="btn btn-xs btn-success">' . __('option::lang.view') . '</a> ';
            }
            if(auth()->user()->can('optionclass_edit')) {
                $html .= '<a  href="' . url('option/optionclass/' . $row->id . "/edit") . '" class="btn btn-xs btn-secondary">' . __('option::lang.edit') . '</a> ';
            }
            if(auth()->user()->can('optionclass_destroy')) {
                $html .= '<form action="' . url('option/optionclass', $row->id) . '" method="POST" style="display: inline-block;">
                            ' . csrf_field() . '
                            ' . method_field("DELETE") . '
                            <button type="submit" class="btn btn-xs btn-danger"
                                onclick="return confirm(\'Are You Sure Want to Delete?\')"
                                style="padding: .0em !important;"><i class="icon-trash"> </i>' . __('option::lang.delete') . '</button>
                            </form>';
            }
            return $html;
        })->addColumn('photo', function ($row) {
            $html = '<img style="height: 100px;width: 100px;" src="' . getImageUrl($row->photo,'option/optionclass') . '" alt="' . $row->name . '" class="img-rounded img-preview">';
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
        if (!auth()->user()->can('optionclass_create')) {
            abort(403, 'Unauthorized action.');
        }
        page_title()->setTitle(trans('option::lang.optionclass_create'));
        $data = array();
        $data['title']        = 'optionclass_create';
        return view('option::optionclass.create',$data);
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
        if (!auth()->user()->can('optionclass_create')) {
            abort(403, 'Unauthorized action.');
        }
        $validated = $request->validate([
            'name'              => 'bail|required|max:255',
        ]);

        try {
            $record = $this->optionclassRepository->createOrUpdate(array_merge($request->input(), [
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
            event(new CreatedContentEvent(OPTIONCLASS_MODULE_SCREEN_NAME, $request, $record));

            return $response
                ->setPreviousUrl(route('optionclass.index'))
                ->setNextUrl(route('optionclass.edit', $record->id))
                ->setMessage(trans('kamruldashboard::notices.create_success_message'));
        }catch (\Exception $e){

            return $response
                ->setPreviousUrl(route('optionclass.index'))
                ->setMessage(trans('kamruldashboard::notices.something_error_please_try_again_later'));
        }
    }

    /**
     * Show the specified resource.
     * @param  \Modules\Option\Http\Models\OptionClass  $optionclass
     * @return \Illuminate\Http\Response
     */
    public function show(OptionClass $optionclass)
    {
        if (!auth()->user()->can('optionclass_show')) {
            abort(403, 'Unauthorized action.');
        }
        page_title()->setTitle(trans('option::lang.optionclass_show'));
        $data = array();
        $data['optionclass']        = $optionclass;
        $data['title']        = 'optionclass_show';
        return view('option::optionclass.show',$data);
    }
    /**
     * Show the specified resource.
     * @param  \Modules\Option\Http\Models\OptionClass  $optionclass
     * @return \Illuminate\Http\Response
     */
    public function pdf(OptionClass $optionclass)
    {
        if (!auth()->user()->can('optionclass_pdf')) {
            abort(403, 'Unauthorized action.');
        }
        page_title()->setTitle(trans('option::lang.optionclass_show'));
        $data = array();
        $data['optionclass']        = $optionclass;
        $data['title']        = 'optionclass_show';
        return view('option::optionclass.pdf',$data);
    }

    /**
     * Show the form for editing the specified resource.
     * @param  \Modules\Option\Http\Models\OptionClass  $optionclass
     * @return \Illuminate\Http\Response
     */
    public function edit(OptionClass $optionclass)
    {
        if (!auth()->user()->can('optionclass_edit')) {
            abort(403, 'Unauthorized action.');
        }
        page_title()->setTitle(trans('option::lang.optionclass_edit'));
        $data = array();
        $data['title']        = 'optionclass_edit';
        $data['record']        = $this->optionclassRepository->findOrFail($optionclass->id);
        return view('option::optionclass.create',$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Modules\Option\Http\Models\OptionClass  $optionclass
     * @param  DboardHttpResponse  $response
     * @return DboardHttpResponse
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, OptionClass  $optionclass, DboardHttpResponse $response)
    {
        if (!auth()->user()->can('optionclass_edit')) {
            abort(403, 'Unauthorized action.');
        }
        $validated = $request->validate([
            'name'              => 'bail|required|max:255',
        ]);

        $id = $optionclass->id;
        $optionclass = $this->optionclassRepository->firstOrNew(compact('id'));
        $optionclass->fill($request->input());
        $this->optionclassRepository->createOrUpdate($optionclass);

        $file_name = 'photo';
        if ($request->hasFile($file_name))
        {
//            return $file_name;
            $rules = $request->validate([
                "$file_name" => 'mimes:jpeg,jpg,png,gif|max:10000'
            ]);
            $path = $this->photo_path;
            deleteFile($optionclass->$file_name, $path);

            $optionclass->$file_name      = processUpload($request, $optionclass,$file_name,$path);
            $optionclass->save();
        }

        event(new UpdatedContentEvent(OPTIONCLASS_MODULE_SCREEN_NAME, $request, $optionclass));

        return $response
            ->setPreviousUrl(route('optionclass.index'))
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
        if (!auth()->user()->can('optionclass_destroy')) {
            abort(403, 'Unauthorized action.');
        }
        try{

            $optionclass = $this->optionclassRepository->findOrFail($id);
            $this->optionclassRepository->delete($optionclass);
            $path = $this->photo_path;
            deleteFile($optionclass->photo, $path);
            event(new DeletedContentEvent(OPTIONCLASS_MODULE_SCREEN_NAME, $request, $optionclass));

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
        return $this->executeDeleteItems($request, $response, $this->optionclassRepository, OPTIONCLASS_MODULE_SCREEN_NAME);
    }
}
