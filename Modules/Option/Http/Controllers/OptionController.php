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
use Modules\KamrulDashboard\Traits\HasDeleteManyItemsTrait;
use Modules\Option\Http\Models\Option;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Option\Repositories\Interfaces\OptionInterface;
use Modules\Option\Http\Imports\OptionImport;
use Modules\Option\Tables\OptionTable;
use mysql_xdevapi\Exception;
use Throwable;

class OptionController extends Controller
{
    use HasDeleteManyItemsTrait;
    /**
     * @var OptionInterface
     */
    protected $optionRepository;

    /**
     * OptionController constructor.
     * @param OptionInterface $optionRepository
     */
    public function __construct(OptionInterface $optionRepository)
    {
        $this->optionRepository = $optionRepository;
    }
    protected $photo_path = 'uploads/option/';

    /**
     * @param OptionTable $dataTable
     * @return JsonResponse|View
     *
     * @throws Throwable
     */
    public function index(OptionTable $dataTable)
    {
        if (!auth()->user()->can('option_access')) {
            abort(403, 'Unauthorized action.');
        }
        page_title()->setTitle(trans('option::lang.option'));

        return $dataTable->renderTable();
    }

    public function import()
    {
        if (!auth()->user()->can('option_import')) {
            abort(403, 'Unauthorized action.');
        }
        page_title()->setTitle(trans('option::lang.option_import'));
        $data = array();
        $data['title']        = 'option_import';
        return view('option::option.create_import',$data);
    }
    public function store_import(Request $request)
    {
        if (!auth()->user()->can('option_import')) {
            abort(403, 'Unauthorized action.');
        }
        $file = $request->file('photo');
        Excel::import(new OptionImport, $file);
        $response_data['status'] = 1;
        $response_data['message'] =  __('option::lang.record_save_successfully');
        return redirect()->route('option.index')->with('response_data', $response_data);
    }
    public function data()
    {
        if (!auth()->user()->can('option_access')) {
            abort(403, 'Unauthorized action.');
        }
        if(auth()->user()->can('option_list_all')) {
            $custom_table = Option::all();
        }else {
            $custom_table = Option::where('user_id', Auth::id())->get();
        }
        return datatables()->of($custom_table)->addColumn('action', function ($row) {
            $html = '';
            if(auth()->user()->can('option_pdf')) {
                $html .= '<a target="_blank" href="' . route('option.pdf_show', $row->id) . '" class="btn btn-xs btn-success">' . __('option::lang.pdf') . '</a> ';
            }
            if(auth()->user()->can('option_show')) {
                $html .= '<a href="' . route('option.show', $row->id) . '" class="btn btn-xs btn-success">' . __('option::lang.view') . '</a> ';
            }
            if(auth()->user()->can('option_edit')) {
                $html .= '<a  href="' . route('option.edit', $row->id) . '" class="btn btn-xs btn-secondary">' . __('option::lang.edit') . '</a> ';
            }
            if(auth()->user()->can('option_destroy')) {
                $html .= '<form action="' . route('option.destroy', $row->id) . '" method="POST" style="display: inline-block;">
                        ' . csrf_field() . '
                        ' . method_field("DELETE") . '
                        <button type="submit" class="btn btn-xs btn-danger"
                            onclick="return confirm(\'Are You Sure Want to Delete?\')"
                            style="padding: .0em !important;"><i class="icon-trash"> </i>' . __('option::lang.delete') . '</button>
                        </form>';
            }
            return $html;
        })->addColumn('photo', function ($row) {
            $html = '<img style="height: 100px;width: 100px;" src="' . getImageUrl($row->photo,'option') . '" alt="' . $row->name . '" class="img-rounded img-preview">';
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
        if (!auth()->user()->can('option_create')) {
            abort(403, 'Unauthorized action.');
        }
        page_title()->setTitle(trans('option::lang.option_create'));
        $data = array();
        $data['title']        = 'option_create';
        return view('option::option.create',$data);
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
        if (!auth()->user()->can('option_create')) {
            abort(403, 'Unauthorized action.');
        }
        $validated = $request->validate([
            'name'              => 'bail|required|max:255',
        ]);

        try {
            $record = $this->optionRepository->createOrUpdate(array_merge($request->input(), [
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
                deleteFile($record->photo, $path);

                $record->$file_name      = processUpload($request, $record,$file_name, $path);
                $record->save();
            }

            event(new CreatedContentEvent(OPTION_MODULE_SCREEN_NAME, $request, $record));

            return $response
                ->setPreviousUrl(route('option.index'))
                ->setNextUrl(route('option.edit', $record->id))
                ->setMessage(trans('kamruldashboard::notices.create_success_message'));
        }catch (\Exception $e){

            return $response
                ->setPreviousUrl(route('option.index'))
                ->setMessage(trans('kamruldashboard::notices.something_error_please_try_again_later'));
        }
    }

    /**
     * Show the specified resource.
     * @param  Option\Http\Models\Option  $option
     * @return \Illuminate\Http\Response
     */
    public function show(Option $option)
    {
        if (!auth()->user()->can('option_show')) {
            abort(403, 'Unauthorized action.');
        }
        page_title()->setTitle(trans('option::lang.option_show'));
        $data = array();
        $data['option']        = $option;
        $data['title']        = 'option_show';
        return view('option::option.show',$data);
    }
    /**
     * Show the specified resource.
     * @param  Option\Http\Models\Option  $option
     * @return \Illuminate\Http\Response
     */
    public function pdf(Option $option)
    {
        if (!auth()->user()->can('option_pdf')) {
            abort(403, 'Unauthorized action.');
        }
        page_title()->setTitle(trans('option::lang.option_show'));
        $data = array();
        $data['option']        = $option;
        $data['title']        = 'option_show';
        return view('option::option.pdf',$data);
    }

    /**
     * Show the form for editing the specified resource.
     * @param  Option\Http\Models\Option  $option
     * @return \Illuminate\Http\Response
     */
    public function edit(Option $option)
    {
        if (!auth()->user()->can('option_edit')) {
            abort(403, 'Unauthorized action.');
        }
        page_title()->setTitle(trans('option::lang.option_edit'));
        $data = array();
        $data['title']        = 'option_edit';
        $data['record']        = $this->optionRepository->findOrFail($option->id);
        return view('option::option.create',$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Modules\Option\Http\Models\Option  $option
     * @param  DboardHttpResponse  $response
     * @return DboardHttpResponse
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Option  $option, DboardHttpResponse $response)
    {
        if (!auth()->user()->can('option_edit')) {
            abort(403, 'Unauthorized action.');
        }
        $validated = $request->validate([
            'name'              => 'bail|required|max:255',
        ]);

        $id = $option->id;
        $option = $this->optionRepository->firstOrNew(compact('id'));
        $option->fill($request->input());
        $option = $this->optionRepository->createOrUpdate($option);

        $file_name = 'photo';
        if ($request->hasFile($file_name))
        {
//            return $file_name;
            $rules = $request->validate([
                "$file_name" => 'mimes:jpeg,jpg,png,gif|max:10000'
            ]);
            $path = $this->photo_path;
            deleteFile($option->$file_name, $path);

            $option->$file_name      = processUpload($request, $option,$file_name,$path);
            $option->save();
        }

        event(new UpdatedContentEvent(OPTION_MODULE_SCREEN_NAME, $request, $option));
        return $response
            ->setPreviousUrl(route('option.index'))
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
        if (!auth()->user()->can('option_destroy')) {
            abort(403, 'Unauthorized action.');
        }
        try{

            $option = $this->optionRepository->findOrFail($id);
            $this->optionRepository->delete($option);

            event(new DeletedContentEvent(OPTION_MODULE_SCREEN_NAME, $request, $option));

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
        return $this->executeDeleteItems($request, $response, $this->optionRepository, OPTION_MODULE_SCREEN_NAME);
    }
}
