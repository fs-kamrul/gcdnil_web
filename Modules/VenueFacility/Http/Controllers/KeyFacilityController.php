<?php

namespace Modules\VenueFacility\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;
use Modules\KamrulDashboard\Events\DeletedContentEvent;
use Modules\KamrulDashboard\Events\UpdatedContentEvent;
use Modules\KamrulDashboard\Events\CreatedContentEvent;
use Modules\KamrulDashboard\Http\Responses\DboardHttpResponse;
use Modules\VenueFacility\Http\Models\KeyFacility;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Modules\KamrulDashboard\Traits\HasDeleteManyItemsTrait;
use Illuminate\Routing\Controller;
use Modules\VenueFacility\Repositories\Interfaces\KeyFacilityInterface;
use Modules\VenueFacility\Http\Imports\KeyFacilityImport;
use Modules\VenueFacility\Tables\KeyFacilityTable;
use mysql_xdevapi\Exception;
use Throwable;

class KeyFacilityController extends Controller
{
    use HasDeleteManyItemsTrait;
    /**
     * @var KeyFacilityInterface
     */
    protected $keyfacilityRepository;

    /**
     * KeyFacilityController constructor.
     * @param KeyFacilityInterface $keyfacilityRepository
     */
    public function __construct(KeyFacilityInterface $keyfacilityRepository)
    {
        $this->keyfacilityRepository = $keyfacilityRepository;
    }
    protected $photo_path = 'uploads/venuefacility/keyfacility/';

    /**
     * @param KeyFacilityTable $dataTable
     * @return JsonResponse|View
     *
     * @throws Throwable
     */
    public function index(KeyFacilityTable $dataTable)
    {
        if (!auth()->user()->can('keyfacility_access')) {
            abort(403, 'Unauthorized action.');
        }
        page_title()->setTitle(trans('venuefacility::lang.keyfacility'));

        return $dataTable->renderTable();
    }

    public function import()
    {
        if (!auth()->user()->can('keyfacility_import')) {
            abort(403, 'Unauthorized action.');
        }
        page_title()->setTitle(trans('venuefacility::lang.keyfacility_import'));
        $data = array();
        $data['title']        = 'keyfacility_import';
        return view('venuefacility::keyfacility.create_import',$data);
    }
    public function store_import(Request $request)
    {
        if (!auth()->user()->can('keyfacility_import')) {
            abort(403, 'Unauthorized action.');
        }
        $file = $request->file('photo');
        Excel::import(new KeyFacilityImport, $file);
        $response_data['status'] = 1;
        $response_data['message'] =  __('venuefacility::lang.record_save_successfully');
        return redirect()->route('keyfacility.index')->with('response_data', $response_data);
    }
    public function data()
    {
        if (!auth()->user()->can('keyfacility_access')) {
            abort(403, 'Unauthorized action.');
        }
        if(auth()->user()->can('keyfacility_list_all')) {
            $custom_table = KeyFacility::all();
        }else {
            $custom_table = KeyFacility::where('user_id', Auth::id())->get();
        }
        return datatables()->of($custom_table)->addColumn('action', function ($row) {
            $html = '';
            if(auth()->user()->can('keyfacility_pdf')) {
                $html .= '<a target="_blank" href="' . url('venuefacility/keyfacility/pdf_show', $row->id) . '" class="btn btn-xs btn-success">' . __('venuefacility::lang.pdf') . '</a> ';
            }
            if(auth()->user()->can('keyfacility_show')) {
                $html .= '<a href="' . url('venuefacility/keyfacility/' . $row->id) . '" class="btn btn-xs btn-success">' . __('venuefacility::lang.view') . '</a> ';
            }
            if(auth()->user()->can('keyfacility_edit')) {
                $html .= '<a  href="' . url('venuefacility/keyfacility/' . $row->id . "/edit") . '" class="btn btn-xs btn-secondary">' . __('venuefacility::lang.edit') . '</a> ';
            }
            if(auth()->user()->can('keyfacility_destroy')) {
                $html .= '<form action="' . url('venuefacility/keyfacility', $row->id) . '" method="POST" style="display: inline-block;">
                            ' . csrf_field() . '
                            ' . method_field("DELETE") . '
                            <button type="submit" class="btn btn-xs btn-danger"
                                onclick="return confirm(\'Are You Sure Want to Delete?\')"
                                style="padding: .0em !important;"><i class="icon-trash"> </i>' . __('venuefacility::lang.delete') . '</button>
                            </form>';
            }
            return $html;
        })->addColumn('photo', function ($row) {
            $html = '<img style="height: 100px;width: 100px;" src="' . getImageUrl($row->photo,'venuefacility/keyfacility') . '" alt="' . $row->name . '" class="img-rounded img-preview">';
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
        if (!auth()->user()->can('keyfacility_create')) {
            abort(403, 'Unauthorized action.');
        }
        page_title()->setTitle(trans('venuefacility::lang.keyfacility_create'));
        $data = array();
        $data['title']        = 'keyfacility_create';
        return view('venuefacility::keyfacility.create',$data);
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
        if (!auth()->user()->can('keyfacility_create')) {
            abort(403, 'Unauthorized action.');
        }
        $validated = $request->validate([
            'name'              => 'bail|required|max:255',
        ]);

        try {
            $record = $this->keyfacilityRepository->createOrUpdate(array_merge($request->input(), [
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
            event(new CreatedContentEvent(KEYFACILITY_MODULE_SCREEN_NAME, $request, $record));

            return $response
                ->setPreviousUrl(route('keyfacility.index'))
                ->setNextUrl(route('keyfacility.edit', $record->id))
                ->setMessage(trans('kamruldashboard::notices.create_success_message'));
        }catch (\Exception $e){

            return $response
                ->setPreviousUrl(route('keyfacility.index'))
                ->setMessage(trans('kamruldashboard::notices.something_error_please_try_again_later'));
        }
    }

    /**
     * Show the specified resource.
     * @param  \Modules\VenueFacility\Http\Models\KeyFacility  $keyfacility
     * @return \Illuminate\Http\Response
     */
    public function show(KeyFacility $keyfacility)
    {
        if (!auth()->user()->can('keyfacility_show')) {
            abort(403, 'Unauthorized action.');
        }
        page_title()->setTitle(trans('venuefacility::lang.keyfacility_show'));
        $data = array();
        $data['keyfacility']        = $keyfacility;
        $data['title']        = 'keyfacility_show';
        return view('venuefacility::keyfacility.show',$data);
    }
    /**
     * Show the specified resource.
     * @param  \Modules\VenueFacility\Http\Models\KeyFacility  $keyfacility
     * @return \Illuminate\Http\Response
     */
    public function pdf(KeyFacility $keyfacility)
    {
        if (!auth()->user()->can('keyfacility_pdf')) {
            abort(403, 'Unauthorized action.');
        }
        page_title()->setTitle(trans('venuefacility::lang.keyfacility_show'));
        $data = array();
        $data['keyfacility']        = $keyfacility;
        $data['title']        = 'keyfacility_show';
        return view('venuefacility::keyfacility.pdf',$data);
    }

    /**
     * Show the form for editing the specified resource.
     * @param  \Modules\VenueFacility\Http\Models\KeyFacility  $keyfacility
     * @return \Illuminate\Http\Response
     */
    public function edit(KeyFacility $keyfacility)
    {
        if (!auth()->user()->can('keyfacility_edit')) {
            abort(403, 'Unauthorized action.');
        }
        page_title()->setTitle(trans('venuefacility::lang.keyfacility_edit'));
        $data = array();
        $data['title']        = 'keyfacility_edit';
        $data['record']        = $this->keyfacilityRepository->findOrFail($keyfacility->id);
        return view('venuefacility::keyfacility.create',$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Modules\VenueFacility\Http\Models\KeyFacility  $keyfacility
     * @param  DboardHttpResponse  $response
     * @return DboardHttpResponse
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, KeyFacility  $keyfacility, DboardHttpResponse $response)
    {
        if (!auth()->user()->can('keyfacility_edit')) {
            abort(403, 'Unauthorized action.');
        }
        $validated = $request->validate([
            'name'              => 'bail|required|max:255',
        ]);

        $id = $keyfacility->id;
        $keyfacility = $this->keyfacilityRepository->firstOrNew(compact('id'));
        $keyfacility->fill($request->input());
        $this->keyfacilityRepository->createOrUpdate($keyfacility);

        $file_name = 'photo';
        if ($request->hasFile($file_name))
        {
//            return $file_name;
            $rules = $request->validate([
                "$file_name" => 'mimes:jpeg,jpg,png,gif|max:10000'
            ]);
            $path = $this->photo_path;
            deleteFile($keyfacility->$file_name, $path);

            $keyfacility->$file_name      = processUpload($request, $keyfacility,$file_name,$path);
            $keyfacility->save();
        }

        event(new UpdatedContentEvent(KEYFACILITY_MODULE_SCREEN_NAME, $request, $keyfacility));

        return $response
            ->setPreviousUrl(route('keyfacility.index'))
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
        if (!auth()->user()->can('keyfacility_destroy')) {
            abort(403, 'Unauthorized action.');
        }
        try{

            $keyfacility = $this->keyfacilityRepository->findOrFail($id);
            $this->keyfacilityRepository->delete($keyfacility);
            $path = $this->photo_path;
            deleteFile($keyfacility->photo, $path);
            event(new DeletedContentEvent(KEYFACILITY_MODULE_SCREEN_NAME, $request, $keyfacility));

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
        return $this->executeDeleteItems($request, $response, $this->keyfacilityRepository, KEYFACILITY_MODULE_SCREEN_NAME);
    }
}
