<?php

namespace Modules\Option\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;
use Modules\Option\Forms\OptionSetForm;
use Modules\KamrulDashboard\Events\DeletedContentEvent;
use Modules\KamrulDashboard\Events\UpdatedContentEvent;
use Modules\KamrulDashboard\Events\CreatedContentEvent;
use Modules\KamrulDashboard\Http\Responses\DboardHttpResponse;
use Modules\Option\Http\Models\OptionSet;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Modules\KamrulDashboard\Traits\HasDeleteManyItemsTrait;
use Illuminate\Routing\Controller;
use Modules\Option\Repositories\Interfaces\OptionSetInterface;
use Modules\Option\Http\Imports\OptionSetImport;
use Modules\Option\Services\StoreSetSubjectService;
use Modules\Option\Tables\OptionSetTable;
use mysql_xdevapi\Exception;
use Throwable;
use Option;

class OptionSetController extends Controller
{
    use HasDeleteManyItemsTrait;
    /**
     * @var OptionSetInterface
     */
    protected $optionsetRepository;

    /**
     * OptionSetController constructor.
     * @param OptionSetInterface $optionsetRepository
     */
    public function __construct(OptionSetInterface $optionsetRepository)
    {
        $this->optionsetRepository = $optionsetRepository;
    }
    protected $photo_path = 'uploads/option/optionset/';

    // OptionController.php
    public function getSetSubjects($classId, $groupId)
    {
        $sets = Option::getSetClassSubject($classId, $groupId);
//        $sets = OptionSet::where('class_id', $classId)
//            ->where('group_id', $groupId)
//            ->where('status', OptionSetStatusEnum::ACTIVE)
//            ->orderBy('order', 'ASC')
//            ->orderBy('id', 'ASC')
//            ->get();

//        dd($sets);
        $data = [];
//        foreach ($sets as $setId => $setName) {
        foreach ($sets as $setId => $value) {
            $subjects = OptionSet::find($value->id)->subjects()->pluck('option_subjects.name', 'option_subjects.id');
            $data[] = [
                'set_id' => $value->id,
                'set_name' => $value->name,
                'subjects' => $subjects,
                'selected_subject_num' => $value->selected_subjects ?? 1
            ];
        }
        return response()->json($data);
    }

    /**
     * @param OptionSetTable $dataTable
     * @return JsonResponse|View
     *
     * @throws Throwable
     */
    public function index(OptionSetTable $dataTable)
    {
        if (!auth()->user()->can('optionset_access')) {
            abort(403, 'Unauthorized action.');
        }
        page_title()->setTitle(trans('option::lang.optionset'));

        return $dataTable->renderTable();
    }

    public function import()
    {
        if (!auth()->user()->can('optionset_import')) {
            abort(403, 'Unauthorized action.');
        }
        page_title()->setTitle(trans('option::lang.optionset_import'));
        $data = array();
        $data['title']        = 'optionset_import';
        return view('option::optionset.create_import',$data);
    }
    public function store_import(Request $request)
    {
        if (!auth()->user()->can('optionset_import')) {
            abort(403, 'Unauthorized action.');
        }
        $file = $request->file('photo');
        Excel::import(new OptionSetImport, $file);
        $response_data['status'] = 1;
        $response_data['message'] =  __('option::lang.record_save_successfully');
        return redirect()->route('optionset.index')->with('response_data', $response_data);
    }
    public function data()
    {
        if (!auth()->user()->can('optionset_access')) {
            abort(403, 'Unauthorized action.');
        }
        if(auth()->user()->can('optionset_list_all')) {
            $custom_table = OptionSet::all();
        }else {
            $custom_table = OptionSet::where('user_id', Auth::id())->get();
        }
        return datatables()->of($custom_table)->addColumn('action', function ($row) {
            $html = '';
            if(auth()->user()->can('optionset_pdf')) {
                $html .= '<a target="_blank" href="' . url('option/optionset/pdf_show', $row->id) . '" class="btn btn-xs btn-success">' . __('option::lang.pdf') . '</a> ';
            }
            if(auth()->user()->can('optionset_show')) {
                $html .= '<a href="' . url('option/optionset/' . $row->id) . '" class="btn btn-xs btn-success">' . __('option::lang.view') . '</a> ';
            }
            if(auth()->user()->can('optionset_edit')) {
                $html .= '<a  href="' . url('option/optionset/' . $row->id . "/edit") . '" class="btn btn-xs btn-secondary">' . __('option::lang.edit') . '</a> ';
            }
            if(auth()->user()->can('optionset_destroy')) {
                $html .= '<form action="' . url('option/optionset', $row->id) . '" method="POST" style="display: inline-block;">
                            ' . csrf_field() . '
                            ' . method_field("DELETE") . '
                            <button type="submit" class="btn btn-xs btn-danger"
                                onclick="return confirm(\'Are You Sure Want to Delete?\')"
                                style="padding: .0em !important;"><i class="icon-trash"> </i>' . __('option::lang.delete') . '</button>
                            </form>';
            }
            return $html;
        })->addColumn('photo', function ($row) {
            $html = '<img style="height: 100px;width: 100px;" src="' . getImageUrl($row->photo,'option/optionset') . '" alt="' . $row->name . '" class="img-rounded img-preview">';
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
        if (!auth()->user()->can('optionset_create')) {
            abort(403, 'Unauthorized action.');
        }
        page_title()->setTitle(trans('option::lang.optionset_create'));

        return OptionSetForm::create()->renderForm();
        //$data = array();
        //$data['title']        = 'optionset_create';
        //return view('option::optionset.create',$data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param DboardHttpResponse $response
     * @return DboardHttpResponse
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, DboardHttpResponse $response, StoreSetSubjectService  $storeSetSubjectService)
    {
        if (!auth()->user()->can('optionset_create')) {
            abort(403, 'Unauthorized action.');
        }
        $validated = $request->validate([
            'name'              => 'bail|required|max:255',
        ]);

        try {
            $record = $this->optionsetRepository->createOrUpdate(array_merge($request->input(), [
                'user_id' => Auth::id(),
//                'uuid'    => gen_uuid(),
//                'slug'    => checkSlugFunction($request->input('name')),
            ]));

//            $file_name = 'photo';
//            if ($request->hasFile($file_name))
//            {
////                return $file_name;
//                $rules = $request->validate([
//                    "$file_name" => 'mimes:jpeg,jpg,png,gif|max:10000'
//                ]);
//                $path = $this->photo_path;
//                deleteFile($record->$file_name, $path);
//
//                $record->$file_name      = processUpload($request, $record,$file_name, $path);
//                $record->save();
//            }
            $storeSetSubjectService->execute($request, $record);

            event(new CreatedContentEvent(OPTIONSET_MODULE_SCREEN_NAME, $request, $record));

            return $response
                ->setPreviousUrl(route('optionset.index'))
                ->setNextUrl(route('optionset.edit', $record->id))
                ->setMessage(trans('kamruldashboard::notices.create_success_message'));
        }catch (\Exception $e){

            return $response
                ->setPreviousUrl(route('optionset.index'))
                ->setMessage(trans('kamruldashboard::notices.something_error_please_try_again_later'));
        }
    }

    /**
     * Show the specified resource.
     * @param  \Modules\Option\Http\Models\OptionSet  $optionset
     * @return \Illuminate\Http\Response
     */
    public function show(OptionSet $optionset)
    {
        if (!auth()->user()->can('optionset_show')) {
            abort(403, 'Unauthorized action.');
        }
        page_title()->setTitle(trans('option::lang.optionset_show'));
        $data = array();
        $data['optionset']        = $optionset;
        $data['title']        = 'optionset_show';
        return view('option::optionset.show',$data);
    }
    /**
     * Show the specified resource.
     * @param  \Modules\Option\Http\Models\OptionSet  $optionset
     * @return \Illuminate\Http\Response
     */
    public function pdf(OptionSet $optionset)
    {
        if (!auth()->user()->can('optionset_pdf')) {
            abort(403, 'Unauthorized action.');
        }
        page_title()->setTitle(trans('option::lang.optionset_show'));
        $data = array();
        $data['optionset']        = $optionset;
        $data['title']        = 'optionset_show';
        return view('option::optionset.pdf',$data);
    }

    /**
     * Show the form for editing the specified resource.
     * @param  \Modules\Option\Http\Models\OptionSet  $optionset
     * @return \Illuminate\Http\Response
     */
    public function edit(OptionSet $optionset)
    {
        if (!auth()->user()->can('optionset_edit')) {
            abort(403, 'Unauthorized action.');
        }
        page_title()->setTitle(trans('option::lang.optionset_edit'));

        return OptionSetForm::createFromModel($optionset)->renderForm();
     //   $data = array();
      //  $data['title']        = 'optionset_edit';
     //   $data['record']        = $this->optionsetRepository->findOrFail($optionset->id);
      //  return view('option::optionset.create',$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Modules\Option\Http\Models\OptionSet  $optionset
     * @param  DboardHttpResponse  $response
     * @return DboardHttpResponse
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, OptionSet  $optionset, DboardHttpResponse $response, StoreSetSubjectService  $storeSetSubjectService)
    {
        if (!auth()->user()->can('optionset_edit')) {
            abort(403, 'Unauthorized action.');
        }
        $validated = $request->validate([
            'name'              => 'bail|required|max:255',
        ]);

        $id = $optionset->id;
        $optionset = $this->optionsetRepository->firstOrNew(compact('id'));
        $optionset->fill($request->input());
        $this->optionsetRepository->createOrUpdate($optionset);

//        $file_name = 'photo';
//        if ($request->hasFile($file_name))
//        {
////            return $file_name;
//            $rules = $request->validate([
//                "$file_name" => 'mimes:jpeg,jpg,png,gif|max:10000'
//            ]);
//            $path = $this->photo_path;
//            deleteFile($optionset->$file_name, $path);
//
//            $optionset->$file_name      = processUpload($request, $optionset,$file_name,$path);
//            $optionset->save();
//        }
        $storeSetSubjectService->execute($request, $optionset);

        event(new UpdatedContentEvent(OPTIONSET_MODULE_SCREEN_NAME, $request, $optionset));

        return $response
            ->setPreviousUrl(route('optionset.index'))
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
        if (!auth()->user()->can('optionset_destroy')) {
            abort(403, 'Unauthorized action.');
        }
        try{

            $optionset = $this->optionsetRepository->findOrFail($id);
            $this->optionsetRepository->delete($optionset);
            $path = $this->photo_path;
            deleteFile($optionset->photo, $path);
            event(new DeletedContentEvent(OPTIONSET_MODULE_SCREEN_NAME, $request, $optionset));

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
        return $this->executeDeleteItems($request, $response, $this->optionsetRepository, OPTIONSET_MODULE_SCREEN_NAME);
    }
}
