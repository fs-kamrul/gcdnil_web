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
use Modules\Option\Http\Models\OptionGender;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Modules\KamrulDashboard\Traits\HasDeleteManyItemsTrait;
use Illuminate\Routing\Controller;
use Modules\Option\Repositories\Interfaces\OptionGenderInterface;
use Modules\Option\Http\Imports\OptionGenderImport;
use Modules\Option\Tables\OptionGenderTable;
use mysql_xdevapi\Exception;
use Throwable;

class OptionGenderController extends Controller
{
    use HasDeleteManyItemsTrait;
    /**
     * @var OptionGenderInterface
     */
    protected $optiongenderRepository;

    /**
     * OptionGenderController constructor.
     * @param OptionGenderInterface $optiongenderRepository
     */
    public function __construct(OptionGenderInterface $optiongenderRepository)
    {
        $this->optiongenderRepository = $optiongenderRepository;
    }
    protected $photo_path = 'uploads/option/optiongender/';

    /**
     * @param OptionGenderTable $dataTable
     * @return JsonResponse|View
     *
     * @throws Throwable
     */
    public function index(OptionGenderTable $dataTable)
    {
        if (!auth()->user()->can('optiongender_access')) {
            abort(403, 'Unauthorized action.');
        }
        page_title()->setTitle(trans('option::lang.optiongender'));

        return $dataTable->renderTable();
    }

    public function import()
    {
        if (!auth()->user()->can('optiongender_import')) {
            abort(403, 'Unauthorized action.');
        }
        page_title()->setTitle(trans('option::lang.optiongender_import'));
        $data = array();
        $data['title']        = 'optiongender_import';
        return view('option::optiongender.create_import',$data);
    }
    public function store_import(Request $request)
    {
        if (!auth()->user()->can('optiongender_import')) {
            abort(403, 'Unauthorized action.');
        }
        $file = $request->file('photo');
        Excel::import(new OptionGenderImport, $file);
        $response_data['status'] = 1;
        $response_data['message'] =  __('option::lang.record_save_successfully');
        return redirect()->route('optiongender.index')->with('response_data', $response_data);
    }
    public function data()
    {
        if (!auth()->user()->can('optiongender_access')) {
            abort(403, 'Unauthorized action.');
        }
        if(auth()->user()->can('optiongender_list_all')) {
            $custom_table = OptionGender::all();
        }else {
            $custom_table = OptionGender::where('user_id', Auth::id())->get();
        }
        return datatables()->of($custom_table)->addColumn('action', function ($row) {
            $html = '';
            if(auth()->user()->can('optiongender_pdf')) {
                $html .= '<a target="_blank" href="' . url('option/optiongender/pdf_show', $row->id) . '" class="btn btn-xs btn-success">' . __('option::lang.pdf') . '</a> ';
            }
            if(auth()->user()->can('optiongender_show')) {
                $html .= '<a href="' . url('option/optiongender/' . $row->id) . '" class="btn btn-xs btn-success">' . __('option::lang.view') . '</a> ';
            }
            if(auth()->user()->can('optiongender_edit')) {
                $html .= '<a  href="' . url('option/optiongender/' . $row->id . "/edit") . '" class="btn btn-xs btn-secondary">' . __('option::lang.edit') . '</a> ';
            }
            if(auth()->user()->can('optiongender_destroy')) {
                $html .= '<form action="' . url('option/optiongender', $row->id) . '" method="POST" style="display: inline-block;">
                            ' . csrf_field() . '
                            ' . method_field("DELETE") . '
                            <button type="submit" class="btn btn-xs btn-danger"
                                onclick="return confirm(\'Are You Sure Want to Delete?\')"
                                style="padding: .0em !important;"><i class="icon-trash"> </i>' . __('option::lang.delete') . '</button>
                            </form>';
            }
            return $html;
        })->addColumn('photo', function ($row) {
            $html = '<img style="height: 100px;width: 100px;" src="' . getImageUrl($row->photo,'option/optiongender') . '" alt="' . $row->name . '" class="img-rounded img-preview">';
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
        if (!auth()->user()->can('optiongender_create')) {
            abort(403, 'Unauthorized action.');
        }
        page_title()->setTitle(trans('option::lang.optiongender_create'));
        $data = array();
        $data['title']        = 'optiongender_create';
        return view('option::optiongender.create',$data);
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
        if (!auth()->user()->can('optiongender_create')) {
            abort(403, 'Unauthorized action.');
        }
        $validated = $request->validate([
            'name'              => 'bail|required|max:255',
        ]);

        try {
            $record = $this->optiongenderRepository->createOrUpdate(array_merge($request->input(), [
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
            event(new CreatedContentEvent(OPTIONGENDER_MODULE_SCREEN_NAME, $request, $record));

            return $response
                ->setPreviousUrl(route('optiongender.index'))
                ->setNextUrl(route('optiongender.edit', $record->id))
                ->setMessage(trans('kamruldashboard::notices.create_success_message'));
        }catch (\Exception $e){

            return $response
                ->setPreviousUrl(route('optiongender.index'))
                ->setMessage(trans('kamruldashboard::notices.something_error_please_try_again_later'));
        }
    }

    /**
     * Show the specified resource.
     * @param  \Modules\Option\Http\Models\OptionGender  $optiongender
     * @return \Illuminate\Http\Response
     */
    public function show(OptionGender $optiongender)
    {
        if (!auth()->user()->can('optiongender_show')) {
            abort(403, 'Unauthorized action.');
        }
        page_title()->setTitle(trans('option::lang.optiongender_show'));
        $data = array();
        $data['optiongender']        = $optiongender;
        $data['title']        = 'optiongender_show';
        return view('option::optiongender.show',$data);
    }
    /**
     * Show the specified resource.
     * @param  \Modules\Option\Http\Models\OptionGender  $optiongender
     * @return \Illuminate\Http\Response
     */
    public function pdf(OptionGender $optiongender)
    {
        if (!auth()->user()->can('optiongender_pdf')) {
            abort(403, 'Unauthorized action.');
        }
        page_title()->setTitle(trans('option::lang.optiongender_show'));
        $data = array();
        $data['optiongender']        = $optiongender;
        $data['title']        = 'optiongender_show';
        return view('option::optiongender.pdf',$data);
    }

    /**
     * Show the form for editing the specified resource.
     * @param  \Modules\Option\Http\Models\OptionGender  $optiongender
     * @return \Illuminate\Http\Response
     */
    public function edit(OptionGender $optiongender)
    {
        if (!auth()->user()->can('optiongender_edit')) {
            abort(403, 'Unauthorized action.');
        }
        page_title()->setTitle(trans('option::lang.optiongender_edit'));
        $data = array();
        $data['title']        = 'optiongender_edit';
        $data['record']        = $this->optiongenderRepository->findOrFail($optiongender->id);
        return view('option::optiongender.create',$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Modules\Option\Http\Models\OptionGender  $optiongender
     * @param  DboardHttpResponse  $response
     * @return DboardHttpResponse
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, OptionGender  $optiongender, DboardHttpResponse $response)
    {
        if (!auth()->user()->can('optiongender_edit')) {
            abort(403, 'Unauthorized action.');
        }
        $validated = $request->validate([
            'name'              => 'bail|required|max:255',
        ]);

        $id = $optiongender->id;
        $optiongender = $this->optiongenderRepository->firstOrNew(compact('id'));
        $optiongender->fill($request->input());
        $this->optiongenderRepository->createOrUpdate($optiongender);

        $file_name = 'photo';
        if ($request->hasFile($file_name))
        {
//            return $file_name;
            $rules = $request->validate([
                "$file_name" => 'mimes:jpeg,jpg,png,gif|max:10000'
            ]);
            $path = $this->photo_path;
            deleteFile($optiongender->$file_name, $path);

            $optiongender->$file_name      = processUpload($request, $optiongender,$file_name,$path);
            $optiongender->save();
        }

        event(new UpdatedContentEvent(OPTIONGENDER_MODULE_SCREEN_NAME, $request, $optiongender));

        return $response
            ->setPreviousUrl(route('optiongender.index'))
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
        if (!auth()->user()->can('optiongender_destroy')) {
            abort(403, 'Unauthorized action.');
        }
        try{

            $optiongender = $this->optiongenderRepository->findOrFail($id);
            $this->optiongenderRepository->delete($optiongender);
            $path = $this->photo_path;
            deleteFile($optiongender->photo, $path);
            event(new DeletedContentEvent(OPTIONGENDER_MODULE_SCREEN_NAME, $request, $optiongender));

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
        return $this->executeDeleteItems($request, $response, $this->optiongenderRepository, OPTIONGENDER_MODULE_SCREEN_NAME);
    }
}
