<?php

namespace Modules\AwesomeIcon\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;
use Modules\KamrulDashboard\Events\DeletedContentEvent;
use Modules\KamrulDashboard\Events\UpdatedContentEvent;
use Modules\KamrulDashboard\Events\CreatedContentEvent;
use Modules\KamrulDashboard\Http\Responses\DboardHttpResponse;
use Modules\KamrulDashboard\Traits\HasDeleteManyItemsTrait;
use Modules\AwesomeIcon\Http\Models\AwesomeIcon;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\AwesomeIcon\Repositories\Interfaces\AwesomeIconInterface;
use Modules\AwesomeIcon\Http\Imports\AwesomeIconImport;
use Modules\AwesomeIcon\Tables\AwesomeIconTable;
use mysql_xdevapi\Exception;
use Throwable;

class AwesomeIconController extends Controller
{
    use HasDeleteManyItemsTrait;
    /**
     * @var AwesomeIconInterface
     */
    protected $awesomeiconRepository;

    /**
     * AwesomeIconController constructor.
     * @param AwesomeIconInterface $awesomeiconRepository
     */
    public function __construct(AwesomeIconInterface $awesomeiconRepository)
    {
        $this->awesomeiconRepository = $awesomeiconRepository;
    }
    protected $photo_path = 'uploads/awesomeicon/';

    /**
     * @param AwesomeIconTable $dataTable
     * @return JsonResponse|View
     *
     * @throws Throwable
     */
    public function index(AwesomeIconTable $dataTable)
    {
        if (!auth()->user()->can('awesomeicon_access')) {
            abort(403, 'Unauthorized action.');
        }
        page_title()->setTitle(trans('awesomeicon::lang.awesomeicon'));

        return $dataTable->renderTable();
    }
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function geticon()
    {
//        if (!auth()->user()->can('themeicon_access')) {
//            abort(403, 'Unauthorized action.');
//        }
        $icon['message']       = AwesomeIcon::pluck('name')->all();

        return $icon;
    }

    public function import()
    {
        if (!auth()->user()->can('awesomeicon_import')) {
            abort(403, 'Unauthorized action.');
        }
        page_title()->setTitle(trans('awesomeicon::lang.awesomeicon_import'));
        $data = array();
        $data['title']        = 'awesomeicon_import';
        return view('awesomeicon::awesomeicon.create_import',$data);
    }
    public function store_import(Request $request)
    {
        if (!auth()->user()->can('awesomeicon_import')) {
            abort(403, 'Unauthorized action.');
        }
        $file = $request->file('photo');
        Excel::import(new AwesomeIconImport, $file);
        $response_data['status'] = 1;
        $response_data['message'] =  __('awesomeicon::lang.record_save_successfully');
        return redirect()->route('awesomeicon.index')->with('response_data', $response_data);
    }
    public function data()
    {
        if (!auth()->user()->can('awesomeicon_access')) {
            abort(403, 'Unauthorized action.');
        }
        if(auth()->user()->can('awesomeicon_list_all')) {
            $custom_table = AwesomeIcon::all();
        }else {
            $custom_table = AwesomeIcon::where('user_id', Auth::id())->get();
        }
        return datatables()->of($custom_table)->addColumn('action', function ($row) {
            $html = '';
            if(auth()->user()->can('awesomeicon_pdf')) {
                $html .= '<a target="_blank" href="' . route('awesomeicon.pdf_show', $row->id) . '" class="btn btn-xs btn-success">' . __('awesomeicon::lang.pdf') . '</a> ';
            }
            if(auth()->user()->can('awesomeicon_show')) {
                $html .= '<a href="' . route('awesomeicon.show', $row->id) . '" class="btn btn-xs btn-success">' . __('awesomeicon::lang.view') . '</a> ';
            }
            if(auth()->user()->can('awesomeicon_edit')) {
                $html .= '<a  href="' . route('awesomeicon.edit', $row->id) . '" class="btn btn-xs btn-secondary">' . __('awesomeicon::lang.edit') . '</a> ';
            }
            if(auth()->user()->can('awesomeicon_destroy')) {
                $html .= '<form action="' . route('awesomeicon.destroy', $row->id) . '" method="POST" style="display: inline-block;">
                        ' . csrf_field() . '
                        ' . method_field("DELETE") . '
                        <button type="submit" class="btn btn-xs btn-danger"
                            onclick="return confirm(\'Are You Sure Want to Delete?\')"
                            style="padding: .0em !important;"><i class="icon-trash"> </i>' . __('awesomeicon::lang.delete') . '</button>
                        </form>';
            }
            return $html;
        })->addColumn('photo', function ($row) {
            $html = '<img style="height: 100px;width: 100px;" src="' . getImageUrl($row->photo,'awesomeicon') . '" alt="' . $row->name . '" class="img-rounded img-preview">';
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
        if (!auth()->user()->can('awesomeicon_create')) {
            abort(403, 'Unauthorized action.');
        }
        page_title()->setTitle(trans('awesomeicon::lang.awesomeicon_create'));
        $data = array();
        $data['title']        = 'awesomeicon_create';
        return view('awesomeicon::awesomeicon.create',$data);
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
        if (!auth()->user()->can('awesomeicon_create')) {
            abort(403, 'Unauthorized action.');
        }
        $validated = $request->validate([
            'name'              => 'bail|required|max:255',
        ]);

        try {
            $record = $this->awesomeiconRepository->createOrUpdate(array_merge($request->input(), [
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

            event(new CreatedContentEvent(AWESOMEICON_MODULE_SCREEN_NAME, $request, $record));

            return $response
                ->setPreviousUrl(route('awesomeicon.index'))
                ->setNextUrl(route('awesomeicon.edit', $record->id))
                ->setMessage(trans('kamruldashboard::notices.create_success_message'));
        }catch (\Exception $e){

            return $response
                ->setPreviousUrl(route('awesomeicon.index'))
                ->setMessage(trans('kamruldashboard::notices.something_error_please_try_again_later'));
        }
    }

    /**
     * Show the specified resource.
     * @param  AwesomeIcon\Http\Models\AwesomeIcon  $awesomeicon
     * @return \Illuminate\Http\Response
     */
    public function show(AwesomeIcon $awesomeicon)
    {
        if (!auth()->user()->can('awesomeicon_show')) {
            abort(403, 'Unauthorized action.');
        }
        page_title()->setTitle(trans('awesomeicon::lang.awesomeicon_show'));
        $data = array();
        $data['awesomeicon']        = $awesomeicon;
        $data['title']        = 'awesomeicon_show';
        return view('awesomeicon::awesomeicon.show',$data);
    }
    /**
     * Show the specified resource.
     * @param  AwesomeIcon\Http\Models\AwesomeIcon  $awesomeicon
     * @return \Illuminate\Http\Response
     */
    public function pdf(AwesomeIcon $awesomeicon)
    {
        if (!auth()->user()->can('awesomeicon_pdf')) {
            abort(403, 'Unauthorized action.');
        }
        page_title()->setTitle(trans('awesomeicon::lang.awesomeicon_show'));
        $data = array();
        $data['awesomeicon']        = $awesomeicon;
        $data['title']        = 'awesomeicon_show';
        return view('awesomeicon::awesomeicon.pdf',$data);
    }

    /**
     * Show the form for editing the specified resource.
     * @param  AwesomeIcon\Http\Models\AwesomeIcon  $awesomeicon
     * @return \Illuminate\Http\Response
     */
    public function edit(AwesomeIcon $awesomeicon)
    {
        if (!auth()->user()->can('awesomeicon_edit')) {
            abort(403, 'Unauthorized action.');
        }
        page_title()->setTitle(trans('awesomeicon::lang.awesomeicon_edit'));
        $data = array();
        $data['title']        = 'awesomeicon_edit';
        $data['record']        = $this->awesomeiconRepository->findOrFail($awesomeicon->id);
        return view('awesomeicon::awesomeicon.create',$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Modules\AwesomeIcon\Http\Models\AwesomeIcon  $awesomeicon
     * @param  DboardHttpResponse  $response
     * @return DboardHttpResponse
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AwesomeIcon  $awesomeicon, DboardHttpResponse $response)
    {
        if (!auth()->user()->can('awesomeicon_edit')) {
            abort(403, 'Unauthorized action.');
        }
        $validated = $request->validate([
            'name'              => 'bail|required|max:255',
        ]);

        $id = $awesomeicon->id;
        $awesomeicon = $this->awesomeiconRepository->firstOrNew(compact('id'));
        $awesomeicon->fill($request->input());
        $awesomeicon = $this->awesomeiconRepository->createOrUpdate($awesomeicon);

        $file_name = 'photo';
        if ($request->hasFile($file_name))
        {
//            return $file_name;
            $rules = $request->validate([
                "$file_name" => 'mimes:jpeg,jpg,png,gif|max:10000'
            ]);
            $path = $this->photo_path;
            deleteFile($awesomeicon->$file_name, $path);

            $awesomeicon->$file_name      = processUpload($request, $awesomeicon,$file_name,$path);
            $awesomeicon->save();
        }

        event(new UpdatedContentEvent(AWESOMEICON_MODULE_SCREEN_NAME, $request, $awesomeicon));
        return $response
            ->setPreviousUrl(route('awesomeicon.index'))
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
        if (!auth()->user()->can('awesomeicon_destroy')) {
            abort(403, 'Unauthorized action.');
        }
        try{

            $awesomeicon = $this->awesomeiconRepository->findOrFail($id);
            $this->awesomeiconRepository->delete($awesomeicon);

            event(new DeletedContentEvent(AWESOMEICON_MODULE_SCREEN_NAME, $request, $awesomeicon));

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
        return $this->executeDeleteItems($request, $response, $this->awesomeiconRepository, AWESOMEICON_MODULE_SCREEN_NAME);
    }
}
