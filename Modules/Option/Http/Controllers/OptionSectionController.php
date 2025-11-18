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
use Modules\Option\Http\Models\OptionSection;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Modules\KamrulDashboard\Traits\HasDeleteManyItemsTrait;
use Illuminate\Routing\Controller;
use Modules\Option\Repositories\Interfaces\OptionSectionInterface;
use Modules\Option\Http\Imports\OptionSectionImport;
use Modules\Option\Tables\OptionSectionTable;
use mysql_xdevapi\Exception;
use Throwable;

class OptionSectionController extends Controller
{
    use HasDeleteManyItemsTrait;
    /**
     * @var OptionSectionInterface
     */
    protected $optionsectionRepository;

    /**
     * OptionSectionController constructor.
     * @param OptionSectionInterface $optionsectionRepository
     */
    public function __construct(OptionSectionInterface $optionsectionRepository)
    {
        $this->optionsectionRepository = $optionsectionRepository;
    }
    protected $photo_path = 'uploads/option/optionsection/';

    /**
     * @param OptionSectionTable $dataTable
     * @return JsonResponse|View
     *
     * @throws Throwable
     */
    public function index(OptionSectionTable $dataTable)
    {
        if (!auth()->user()->can('optionsection_access')) {
            abort(403, 'Unauthorized action.');
        }
        page_title()->setTitle(trans('option::lang.optionsection'));

        return $dataTable->renderTable();
    }

    public function import()
    {
        if (!auth()->user()->can('optionsection_import')) {
            abort(403, 'Unauthorized action.');
        }
        page_title()->setTitle(trans('option::lang.optionsection_import'));
        $data = array();
        $data['title']        = 'optionsection_import';
        return view('option::optionsection.create_import',$data);
    }
    public function store_import(Request $request)
    {
        if (!auth()->user()->can('optionsection_import')) {
            abort(403, 'Unauthorized action.');
        }
        $file = $request->file('photo');
        Excel::import(new OptionSectionImport, $file);
        $response_data['status'] = 1;
        $response_data['message'] =  __('option::lang.record_save_successfully');
        return redirect()->route('optionsection.index')->with('response_data', $response_data);
    }
    public function data()
    {
        if (!auth()->user()->can('optionsection_access')) {
            abort(403, 'Unauthorized action.');
        }
        if(auth()->user()->can('optionsection_list_all')) {
            $custom_table = OptionSection::all();
        }else {
            $custom_table = OptionSection::where('user_id', Auth::id())->get();
        }
        return datatables()->of($custom_table)->addColumn('action', function ($row) {
            $html = '';
            if(auth()->user()->can('optionsection_pdf')) {
                $html .= '<a target="_blank" href="' . url('option/optionsection/pdf_show', $row->id) . '" class="btn btn-xs btn-success">' . __('option::lang.pdf') . '</a> ';
            }
            if(auth()->user()->can('optionsection_show')) {
                $html .= '<a href="' . url('option/optionsection/' . $row->id) . '" class="btn btn-xs btn-success">' . __('option::lang.view') . '</a> ';
            }
            if(auth()->user()->can('optionsection_edit')) {
                $html .= '<a  href="' . url('option/optionsection/' . $row->id . "/edit") . '" class="btn btn-xs btn-secondary">' . __('option::lang.edit') . '</a> ';
            }
            if(auth()->user()->can('optionsection_destroy')) {
                $html .= '<form action="' . url('option/optionsection', $row->id) . '" method="POST" style="display: inline-block;">
                            ' . csrf_field() . '
                            ' . method_field("DELETE") . '
                            <button type="submit" class="btn btn-xs btn-danger"
                                onclick="return confirm(\'Are You Sure Want to Delete?\')"
                                style="padding: .0em !important;"><i class="icon-trash"> </i>' . __('option::lang.delete') . '</button>
                            </form>';
            }
            return $html;
        })->addColumn('photo', function ($row) {
            $html = '<img style="height: 100px;width: 100px;" src="' . getImageUrl($row->photo,'option/optionsection') . '" alt="' . $row->name . '" class="img-rounded img-preview">';
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
        if (!auth()->user()->can('optionsection_create')) {
            abort(403, 'Unauthorized action.');
        }
        page_title()->setTitle(trans('option::lang.optionsection_create'));
        $data = array();
        $data['title']        = 'optionsection_create';
        return view('option::optionsection.create',$data);
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
        if (!auth()->user()->can('optionsection_create')) {
            abort(403, 'Unauthorized action.');
        }
        $validated = $request->validate([
            'name'              => 'bail|required|max:255',
        ]);

        try {
            $record = $this->optionsectionRepository->createOrUpdate(array_merge($request->input(), [
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
            event(new CreatedContentEvent(OPTIONSECTION_MODULE_SCREEN_NAME, $request, $record));

            return $response
                ->setPreviousUrl(route('optionsection.index'))
                ->setNextUrl(route('optionsection.edit', $record->id))
                ->setMessage(trans('kamruldashboard::notices.create_success_message'));
        }catch (\Exception $e){

            return $response
                ->setPreviousUrl(route('optionsection.index'))
                ->setMessage(trans('kamruldashboard::notices.something_error_please_try_again_later'));
        }
    }

    /**
     * Show the specified resource.
     * @param  \Modules\Option\Http\Models\OptionSection  $optionsection
     * @return \Illuminate\Http\Response
     */
    public function show(OptionSection $optionsection)
    {
        if (!auth()->user()->can('optionsection_show')) {
            abort(403, 'Unauthorized action.');
        }
        page_title()->setTitle(trans('option::lang.optionsection_show'));
        $data = array();
        $data['optionsection']        = $optionsection;
        $data['title']        = 'optionsection_show';
        return view('option::optionsection.show',$data);
    }
    /**
     * Show the specified resource.
     * @param  \Modules\Option\Http\Models\OptionSection  $optionsection
     * @return \Illuminate\Http\Response
     */
    public function pdf(OptionSection $optionsection)
    {
        if (!auth()->user()->can('optionsection_pdf')) {
            abort(403, 'Unauthorized action.');
        }
        page_title()->setTitle(trans('option::lang.optionsection_show'));
        $data = array();
        $data['optionsection']        = $optionsection;
        $data['title']        = 'optionsection_show';
        return view('option::optionsection.pdf',$data);
    }

    /**
     * Show the form for editing the specified resource.
     * @param  \Modules\Option\Http\Models\OptionSection  $optionsection
     * @return \Illuminate\Http\Response
     */
    public function edit(OptionSection $optionsection)
    {
        if (!auth()->user()->can('optionsection_edit')) {
            abort(403, 'Unauthorized action.');
        }
        page_title()->setTitle(trans('option::lang.optionsection_edit'));
        $data = array();
        $data['title']        = 'optionsection_edit';
        $data['record']        = $this->optionsectionRepository->findOrFail($optionsection->id);
        return view('option::optionsection.create',$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Modules\Option\Http\Models\OptionSection  $optionsection
     * @param  DboardHttpResponse  $response
     * @return DboardHttpResponse
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, OptionSection  $optionsection, DboardHttpResponse $response)
    {
        if (!auth()->user()->can('optionsection_edit')) {
            abort(403, 'Unauthorized action.');
        }
        $validated = $request->validate([
            'name'              => 'bail|required|max:255',
        ]);

        $id = $optionsection->id;
        $optionsection = $this->optionsectionRepository->firstOrNew(compact('id'));
        $optionsection->fill($request->input());
        $this->optionsectionRepository->createOrUpdate($optionsection);

        $file_name = 'photo';
        if ($request->hasFile($file_name))
        {
//            return $file_name;
            $rules = $request->validate([
                "$file_name" => 'mimes:jpeg,jpg,png,gif|max:10000'
            ]);
            $path = $this->photo_path;
            deleteFile($optionsection->$file_name, $path);

            $optionsection->$file_name      = processUpload($request, $optionsection,$file_name,$path);
            $optionsection->save();
        }

        event(new UpdatedContentEvent(OPTIONSECTION_MODULE_SCREEN_NAME, $request, $optionsection));

        return $response
            ->setPreviousUrl(route('optionsection.index'))
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
        if (!auth()->user()->can('optionsection_destroy')) {
            abort(403, 'Unauthorized action.');
        }
        try{

            $optionsection = $this->optionsectionRepository->findOrFail($id);
            $this->optionsectionRepository->delete($optionsection);
            $path = $this->photo_path;
            deleteFile($optionsection->photo, $path);
            event(new DeletedContentEvent(OPTIONSECTION_MODULE_SCREEN_NAME, $request, $optionsection));

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
        return $this->executeDeleteItems($request, $response, $this->optionsectionRepository, OPTIONSECTION_MODULE_SCREEN_NAME);
    }
}
