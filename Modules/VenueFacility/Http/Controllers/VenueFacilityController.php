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
use Modules\KamrulDashboard\Traits\HasDeleteManyItemsTrait;
use Modules\VenueFacility\Http\Models\VenueFacility;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\VenueFacility\Repositories\Interfaces\VenueFacilityInterface;
use Modules\VenueFacility\Http\Imports\VenueFacilityImport;
use Modules\VenueFacility\Tables\VenueFacilityTable;
use mysql_xdevapi\Exception;
use Throwable;

class VenueFacilityController extends Controller
{
    use HasDeleteManyItemsTrait;
    /**
     * @var VenueFacilityInterface
     */
    protected $venuefacilityRepository;

    /**
     * VenueFacilityController constructor.
     * @param VenueFacilityInterface $venuefacilityRepository
     */
    public function __construct(VenueFacilityInterface $venuefacilityRepository)
    {
        $this->venuefacilityRepository = $venuefacilityRepository;
    }
    protected $photo_path = 'uploads/venuefacility/';

    /**
     * @param VenueFacilityTable $dataTable
     * @return JsonResponse|View
     *
     * @throws Throwable
     */
    public function index(VenueFacilityTable $dataTable)
    {
        if (!auth()->user()->can('venuefacility_access')) {
            abort(403, 'Unauthorized action.');
        }
        page_title()->setTitle(trans('venuefacility::lang.venuefacility'));

        return $dataTable->renderTable();
    }

    public function import()
    {
        if (!auth()->user()->can('venuefacility_import')) {
            abort(403, 'Unauthorized action.');
        }
        page_title()->setTitle(trans('venuefacility::lang.venuefacility_import'));
        $data = array();
        $data['title']        = 'venuefacility_import';
        return view('venuefacility::venuefacility.create_import',$data);
    }
    public function store_import(Request $request)
    {
        if (!auth()->user()->can('venuefacility_import')) {
            abort(403, 'Unauthorized action.');
        }
        $file = $request->file('photo');
        Excel::import(new VenueFacilityImport, $file);
        $response_data['status'] = 1;
        $response_data['message'] =  __('venuefacility::lang.record_save_successfully');
        return redirect()->route('venuefacility.index')->with('response_data', $response_data);
    }
    public function data()
    {
        if (!auth()->user()->can('venuefacility_access')) {
            abort(403, 'Unauthorized action.');
        }
        if(auth()->user()->can('venuefacility_list_all')) {
            $custom_table = VenueFacility::all();
        }else {
            $custom_table = VenueFacility::where('user_id', Auth::id())->get();
        }
        return datatables()->of($custom_table)->addColumn('action', function ($row) {
            $html = '';
            if(auth()->user()->can('venuefacility_pdf')) {
                $html .= '<a target="_blank" href="' . route('venuefacility.pdf_show', $row->id) . '" class="btn btn-xs btn-success">' . __('venuefacility::lang.pdf') . '</a> ';
            }
            if(auth()->user()->can('venuefacility_show')) {
                $html .= '<a href="' . route('venuefacility.show', $row->id) . '" class="btn btn-xs btn-success">' . __('venuefacility::lang.view') . '</a> ';
            }
            if(auth()->user()->can('venuefacility_edit')) {
                $html .= '<a  href="' . route('venuefacility.edit', $row->id) . '" class="btn btn-xs btn-secondary">' . __('venuefacility::lang.edit') . '</a> ';
            }
            if(auth()->user()->can('venuefacility_destroy')) {
                $html .= '<form action="' . route('venuefacility.destroy', $row->id) . '" method="POST" style="display: inline-block;">
                        ' . csrf_field() . '
                        ' . method_field("DELETE") . '
                        <button type="submit" class="btn btn-xs btn-danger"
                            onclick="return confirm(\'Are You Sure Want to Delete?\')"
                            style="padding: .0em !important;"><i class="icon-trash"> </i>' . __('venuefacility::lang.delete') . '</button>
                        </form>';
            }
            return $html;
        })->addColumn('photo', function ($row) {
            $html = '<img style="height: 100px;width: 100px;" src="' . getImageUrl($row->photo,'venuefacility') . '" alt="' . $row->name . '" class="img-rounded img-preview">';
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
        if (!auth()->user()->can('venuefacility_create')) {
            abort(403, 'Unauthorized action.');
        }
        page_title()->setTitle(trans('venuefacility::lang.venuefacility_create'));
        $data = array();
        $data['title']        = 'venuefacility_create';
        return view('venuefacility::venuefacility.create',$data);
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
        if (!auth()->user()->can('venuefacility_create')) {
            abort(403, 'Unauthorized action.');
        }
        $validated = $request->validate([
            'name'              => 'bail|required|max:255',
        ]);

        try {
            $record = $this->venuefacilityRepository->createOrUpdate(array_merge($request->input(), [
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

            event(new CreatedContentEvent(VENUEFACILITY_MODULE_SCREEN_NAME, $request, $record));

            return $response
                ->setPreviousUrl(route('venuefacility.index'))
                ->setNextUrl(route('venuefacility.edit', $record->id))
                ->setMessage(trans('kamruldashboard::notices.create_success_message'));
        }catch (\Exception $e){

            return $response
                ->setPreviousUrl(route('venuefacility.index'))
                ->setMessage(trans('kamruldashboard::notices.something_error_please_try_again_later'));
        }
    }

    /**
     * Show the specified resource.
     * @param  VenueFacility\Http\Models\VenueFacility  $venuefacility
     * @return \Illuminate\Http\Response
     */
    public function show(VenueFacility $venuefacility)
    {
        if (!auth()->user()->can('venuefacility_show')) {
            abort(403, 'Unauthorized action.');
        }
        page_title()->setTitle(trans('venuefacility::lang.venuefacility_show'));
        $data = array();
        $data['venuefacility']        = $venuefacility;
        $data['title']        = 'venuefacility_show';
        return view('venuefacility::venuefacility.show',$data);
    }
    /**
     * Show the specified resource.
     * @param  VenueFacility\Http\Models\VenueFacility  $venuefacility
     * @return \Illuminate\Http\Response
     */
    public function pdf(VenueFacility $venuefacility)
    {
        if (!auth()->user()->can('venuefacility_pdf')) {
            abort(403, 'Unauthorized action.');
        }
        page_title()->setTitle(trans('venuefacility::lang.venuefacility_show'));
        $data = array();
        $data['venuefacility']        = $venuefacility;
        $data['title']        = 'venuefacility_show';
        return view('venuefacility::venuefacility.pdf',$data);
    }

    /**
     * Show the form for editing the specified resource.
     * @param  VenueFacility\Http\Models\VenueFacility  $venuefacility
     * @return \Illuminate\Http\Response
     */
    public function edit(VenueFacility $venuefacility)
    {
        if (!auth()->user()->can('venuefacility_edit')) {
            abort(403, 'Unauthorized action.');
        }
        page_title()->setTitle(trans('venuefacility::lang.venuefacility_edit'));
        $data = array();
        $data['title']        = 'venuefacility_edit';
        $data['record']        = $this->venuefacilityRepository->findOrFail($venuefacility->id);
        return view('venuefacility::venuefacility.create',$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Modules\VenueFacility\Http\Models\VenueFacility  $venuefacility
     * @param  DboardHttpResponse  $response
     * @return DboardHttpResponse
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, VenueFacility  $venuefacility, DboardHttpResponse $response)
    {
        if (!auth()->user()->can('venuefacility_edit')) {
            abort(403, 'Unauthorized action.');
        }
        $validated = $request->validate([
            'name'              => 'bail|required|max:255',
        ]);

        $id = $venuefacility->id;
        $venuefacility = $this->venuefacilityRepository->firstOrNew(compact('id'));
        $venuefacility->fill($request->input());
        $venuefacility = $this->venuefacilityRepository->createOrUpdate($venuefacility);

        $file_name = 'photo';
        if ($request->hasFile($file_name))
        {
//            return $file_name;
            $rules = $request->validate([
                "$file_name" => 'mimes:jpeg,jpg,png,gif|max:10000'
            ]);
            $path = $this->photo_path;
            deleteFile($venuefacility->$file_name, $path);

            $venuefacility->$file_name      = processUpload($request, $venuefacility,$file_name,$path);
            $venuefacility->save();
        }

        event(new UpdatedContentEvent(VENUEFACILITY_MODULE_SCREEN_NAME, $request, $venuefacility));
        return $response
            ->setPreviousUrl(route('venuefacility.index'))
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
        if (!auth()->user()->can('venuefacility_destroy')) {
            abort(403, 'Unauthorized action.');
        }
        try{

            $venuefacility = $this->venuefacilityRepository->findOrFail($id);
            $this->venuefacilityRepository->delete($venuefacility);

            event(new DeletedContentEvent(VENUEFACILITY_MODULE_SCREEN_NAME, $request, $venuefacility));

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
        return $this->executeDeleteItems($request, $response, $this->venuefacilityRepository, VENUEFACILITY_MODULE_SCREEN_NAME);
    }
}
