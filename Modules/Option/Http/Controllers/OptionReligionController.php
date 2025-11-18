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
use Modules\Option\Http\Models\OptionReligion;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Modules\KamrulDashboard\Traits\HasDeleteManyItemsTrait;
use Illuminate\Routing\Controller;
use Modules\Option\Repositories\Interfaces\OptionReligionInterface;
use Modules\Option\Http\Imports\OptionReligionImport;
use Modules\Option\Tables\OptionReligionTable;
use mysql_xdevapi\Exception;
use Throwable;

class OptionReligionController extends Controller
{
    use HasDeleteManyItemsTrait;
    /**
     * @var OptionReligionInterface
     */
    protected $optionreligionRepository;

    /**
     * OptionReligionController constructor.
     * @param OptionReligionInterface $optionreligionRepository
     */
    public function __construct(OptionReligionInterface $optionreligionRepository)
    {
        $this->optionreligionRepository = $optionreligionRepository;
    }
    protected $photo_path = 'uploads/option/optionreligion/';

    /**
     * @param OptionReligionTable $dataTable
     * @return JsonResponse|View
     *
     * @throws Throwable
     */
    public function index(OptionReligionTable $dataTable)
    {
        if (!auth()->user()->can('optionreligion_access')) {
            abort(403, 'Unauthorized action.');
        }
        page_title()->setTitle(trans('option::lang.optionreligion'));

        return $dataTable->renderTable();
    }

    public function import()
    {
        if (!auth()->user()->can('optionreligion_import')) {
            abort(403, 'Unauthorized action.');
        }
        page_title()->setTitle(trans('option::lang.optionreligion_import'));
        $data = array();
        $data['title']        = 'optionreligion_import';
        return view('option::optionreligion.create_import',$data);
    }
    public function store_import(Request $request)
    {
        if (!auth()->user()->can('optionreligion_import')) {
            abort(403, 'Unauthorized action.');
        }
        $file = $request->file('photo');
        Excel::import(new OptionReligionImport, $file);
        $response_data['status'] = 1;
        $response_data['message'] =  __('option::lang.record_save_successfully');
        return redirect()->route('optionreligion.index')->with('response_data', $response_data);
    }
    public function data()
    {
        if (!auth()->user()->can('optionreligion_access')) {
            abort(403, 'Unauthorized action.');
        }
        if(auth()->user()->can('optionreligion_list_all')) {
            $custom_table = OptionReligion::all();
        }else {
            $custom_table = OptionReligion::where('user_id', Auth::id())->get();
        }
        return datatables()->of($custom_table)->addColumn('action', function ($row) {
            $html = '';
            if(auth()->user()->can('optionreligion_pdf')) {
                $html .= '<a target="_blank" href="' . url('option/optionreligion/pdf_show', $row->id) . '" class="btn btn-xs btn-success">' . __('option::lang.pdf') . '</a> ';
            }
            if(auth()->user()->can('optionreligion_show')) {
                $html .= '<a href="' . url('option/optionreligion/' . $row->id) . '" class="btn btn-xs btn-success">' . __('option::lang.view') . '</a> ';
            }
            if(auth()->user()->can('optionreligion_edit')) {
                $html .= '<a  href="' . url('option/optionreligion/' . $row->id . "/edit") . '" class="btn btn-xs btn-secondary">' . __('option::lang.edit') . '</a> ';
            }
            if(auth()->user()->can('optionreligion_destroy')) {
                $html .= '<form action="' . url('option/optionreligion', $row->id) . '" method="POST" style="display: inline-block;">
                            ' . csrf_field() . '
                            ' . method_field("DELETE") . '
                            <button type="submit" class="btn btn-xs btn-danger"
                                onclick="return confirm(\'Are You Sure Want to Delete?\')"
                                style="padding: .0em !important;"><i class="icon-trash"> </i>' . __('option::lang.delete') . '</button>
                            </form>';
            }
            return $html;
        })->addColumn('photo', function ($row) {
            $html = '<img style="height: 100px;width: 100px;" src="' . getImageUrl($row->photo,'option/optionreligion') . '" alt="' . $row->name . '" class="img-rounded img-preview">';
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
        if (!auth()->user()->can('optionreligion_create')) {
            abort(403, 'Unauthorized action.');
        }
        page_title()->setTitle(trans('option::lang.optionreligion_create'));
        $data = array();
        $data['title']        = 'optionreligion_create';
        return view('option::optionreligion.create',$data);
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
        if (!auth()->user()->can('optionreligion_create')) {
            abort(403, 'Unauthorized action.');
        }
        $validated = $request->validate([
            'name'              => 'bail|required|max:255',
        ]);

        try {
            $record = $this->optionreligionRepository->createOrUpdate(array_merge($request->input(), [
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
            event(new CreatedContentEvent(OPTIONRELIGION_MODULE_SCREEN_NAME, $request, $record));

            return $response
                ->setPreviousUrl(route('optionreligion.index'))
                ->setNextUrl(route('optionreligion.edit', $record->id))
                ->setMessage(trans('kamruldashboard::notices.create_success_message'));
        }catch (\Exception $e){

            return $response
                ->setPreviousUrl(route('optionreligion.index'))
                ->setMessage(trans('kamruldashboard::notices.something_error_please_try_again_later'));
        }
    }

    /**
     * Show the specified resource.
     * @param  \Modules\Option\Http\Models\OptionReligion  $optionreligion
     * @return \Illuminate\Http\Response
     */
    public function show(OptionReligion $optionreligion)
    {
        if (!auth()->user()->can('optionreligion_show')) {
            abort(403, 'Unauthorized action.');
        }
        page_title()->setTitle(trans('option::lang.optionreligion_show'));
        $data = array();
        $data['optionreligion']        = $optionreligion;
        $data['title']        = 'optionreligion_show';
        return view('option::optionreligion.show',$data);
    }
    /**
     * Show the specified resource.
     * @param  \Modules\Option\Http\Models\OptionReligion  $optionreligion
     * @return \Illuminate\Http\Response
     */
    public function pdf(OptionReligion $optionreligion)
    {
        if (!auth()->user()->can('optionreligion_pdf')) {
            abort(403, 'Unauthorized action.');
        }
        page_title()->setTitle(trans('option::lang.optionreligion_show'));
        $data = array();
        $data['optionreligion']        = $optionreligion;
        $data['title']        = 'optionreligion_show';
        return view('option::optionreligion.pdf',$data);
    }

    /**
     * Show the form for editing the specified resource.
     * @param  \Modules\Option\Http\Models\OptionReligion  $optionreligion
     * @return \Illuminate\Http\Response
     */
    public function edit(OptionReligion $optionreligion)
    {
        if (!auth()->user()->can('optionreligion_edit')) {
            abort(403, 'Unauthorized action.');
        }
        page_title()->setTitle(trans('option::lang.optionreligion_edit'));
        $data = array();
        $data['title']        = 'optionreligion_edit';
        $data['record']        = $this->optionreligionRepository->findOrFail($optionreligion->id);
        return view('option::optionreligion.create',$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Modules\Option\Http\Models\OptionReligion  $optionreligion
     * @param  DboardHttpResponse  $response
     * @return DboardHttpResponse
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, OptionReligion  $optionreligion, DboardHttpResponse $response)
    {
        if (!auth()->user()->can('optionreligion_edit')) {
            abort(403, 'Unauthorized action.');
        }
        $validated = $request->validate([
            'name'              => 'bail|required|max:255',
        ]);

        $id = $optionreligion->id;
        $optionreligion = $this->optionreligionRepository->firstOrNew(compact('id'));
        $optionreligion->fill($request->input());
        $this->optionreligionRepository->createOrUpdate($optionreligion);

        $file_name = 'photo';
        if ($request->hasFile($file_name))
        {
//            return $file_name;
            $rules = $request->validate([
                "$file_name" => 'mimes:jpeg,jpg,png,gif|max:10000'
            ]);
            $path = $this->photo_path;
            deleteFile($optionreligion->$file_name, $path);

            $optionreligion->$file_name      = processUpload($request, $optionreligion,$file_name,$path);
            $optionreligion->save();
        }

        event(new UpdatedContentEvent(OPTIONRELIGION_MODULE_SCREEN_NAME, $request, $optionreligion));

        return $response
            ->setPreviousUrl(route('optionreligion.index'))
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
        if (!auth()->user()->can('optionreligion_destroy')) {
            abort(403, 'Unauthorized action.');
        }
        try{

            $optionreligion = $this->optionreligionRepository->findOrFail($id);
            $this->optionreligionRepository->delete($optionreligion);
            $path = $this->photo_path;
            deleteFile($optionreligion->photo, $path);
            event(new DeletedContentEvent(OPTIONRELIGION_MODULE_SCREEN_NAME, $request, $optionreligion));

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
        return $this->executeDeleteItems($request, $response, $this->optionreligionRepository, OPTIONRELIGION_MODULE_SCREEN_NAME);
    }
}
