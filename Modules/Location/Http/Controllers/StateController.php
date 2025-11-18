<?php

namespace Modules\Location\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;
use Modules\KamrulDashboard\Events\DeletedContentEvent;
use Modules\KamrulDashboard\Events\UpdatedContentEvent;
use Modules\KamrulDashboard\Events\CreatedContentEvent;
use Modules\KamrulDashboard\Http\Responses\DboardHttpResponse;
use Modules\KamrulDashboard\Packages\Supports\DboardStatus;
use Modules\Location\Http\Models\Country;
use Modules\Location\Http\Models\State;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Modules\KamrulDashboard\Traits\HasDeleteManyItemsTrait;
use Illuminate\Routing\Controller;
use Modules\Location\Http\Resources\StateResource;
use Modules\Location\Repositories\Interfaces\StateInterface;
use Modules\Location\Http\Imports\StateImport;
use Modules\Location\Tables\StateTable;
use mysql_xdevapi\Exception;
use Location;
use Throwable;
use DboardHelper;

class StateController extends Controller
{
    use HasDeleteManyItemsTrait;
    /**
     * @var StateInterface
     */
    protected $stateRepository;

    /**
     * StateController constructor.
     * @param StateInterface $stateRepository
     */
    public function __construct(StateInterface $stateRepository)
    {
        $this->stateRepository = $stateRepository;
    }
    protected $photo_path = 'uploads/location/state/';

    /**
     * @param StateTable $dataTable
     * @return JsonResponse|View
     *
     * @throws Throwable
     */
    public function index(StateTable $dataTable)
    {
        if (!auth()->user()->can('state_access')) {
            abort(403, 'Unauthorized action.');
        }
        page_title()->setTitle(trans('location::lang.state'));

        return $dataTable->renderTable();
    }

    public function import()
    {
        if (!auth()->user()->can('state_import')) {
            abort(403, 'Unauthorized action.');
        }
        page_title()->setTitle(trans('location::lang.state_import'));
        $data = array();
        $data['title']        = 'state_import';
        return view('location::state.create_import',$data);
    }
    public function store_import(Request $request)
    {
        if (!auth()->user()->can('state_import')) {
            abort(403, 'Unauthorized action.');
        }
        $file = $request->file('photo');
        Excel::import(new StateImport, $file);
        $response_data['status'] = 1;
        $response_data['message'] =  __('location::lang.record_save_successfully');
        return redirect()->route('state.index')->with('response_data', $response_data);
    }
    public function data()
    {
        if (!auth()->user()->can('state_access')) {
            abort(403, 'Unauthorized action.');
        }
        if(auth()->user()->can('state_list_all')) {
            $custom_table = State::all();
        }else {
            $custom_table = State::where('user_id', Auth::id())->get();
        }
        return datatables()->of($custom_table)->addColumn('action', function ($row) {
            $html = '';
            if(auth()->user()->can('state_pdf')) {
                $html .= '<a target="_blank" href="' . url('location/state/pdf_show', $row->id) . '" class="btn btn-xs btn-success">' . __('location::lang.pdf') . '</a> ';
            }
            if(auth()->user()->can('state_show')) {
                $html .= '<a href="' . url('location/state/' . $row->id) . '" class="btn btn-xs btn-success">' . __('location::lang.view') . '</a> ';
            }
            if(auth()->user()->can('state_edit')) {
                $html .= '<a  href="' . url('location/state/' . $row->id . "/edit") . '" class="btn btn-xs btn-secondary">' . __('location::lang.edit') . '</a> ';
            }
            if(auth()->user()->can('state_destroy')) {
                $html .= '<form action="' . url('location/state', $row->id) . '" method="POST" style="display: inline-block;">
                            ' . csrf_field() . '
                            ' . method_field("DELETE") . '
                            <button type="submit" class="btn btn-xs btn-danger"
                                onclick="return confirm(\'Are You Sure Want to Delete?\')"
                                style="padding: .0em !important;"><i class="icon-trash"> </i>' . __('location::lang.delete') . '</button>
                            </form>';
            }
            return $html;
        })->addColumn('photo', function ($row) {
            $html = '<img style="height: 100px;width: 100px;" src="' . getImageUrl($row->photo,'location/state') . '" alt="' . $row->name . '" class="img-rounded img-preview">';
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
        if (!auth()->user()->can('state_create')) {
            abort(403, 'Unauthorized action.');
        }
        page_title()->setTitle(trans('location::lang.state_create'));
        $data = array();
        $data['title']        = 'state_create';
        $data['country']      = Location::getCountry();
        return view('location::state.create',$data);
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
        if (!auth()->user()->can('state_create')) {
            abort(403, 'Unauthorized action.');
        }
        $validated = $request->validate([
            'name'              => 'bail|required|max:255',
        ]);

        try {
            $record = $this->stateRepository->createOrUpdate(array_merge($request->input()));
            event(new CreatedContentEvent(STATE_MODULE_SCREEN_NAME, $request, $record));

            return $response
                ->setPreviousUrl(route('state.index'))
                ->setNextUrl(route('state.edit', $record->id))
                ->setMessage(trans('kamruldashboard::notices.create_success_message'));
        }catch (\Exception $e){

            return $response
                ->setPreviousUrl(route('state.index'))
                ->setMessage(trans('kamruldashboard::notices.something_error_please_try_again_later'));
        }
    }

    /**
     * Show the specified resource.
     * @param  \Modules\Location\Http\Models\State  $state
     * @return \Illuminate\Http\Response
     */
    public function show(State $state)
    {
        if (!auth()->user()->can('state_show')) {
            abort(403, 'Unauthorized action.');
        }
        page_title()->setTitle(trans('location::lang.state_show'));
        $data = array();
        $data['state']        = $state;
        $data['title']        = 'state_show';
        return view('location::state.show',$data);
    }
    /**
     * Show the specified resource.
     * @param  \Modules\Location\Http\Models\State  $state
     * @return \Illuminate\Http\Response
     */
    public function pdf(State $state)
    {
        if (!auth()->user()->can('state_pdf')) {
            abort(403, 'Unauthorized action.');
        }
        page_title()->setTitle(trans('location::lang.state_show'));
        $data = array();
        $data['state']        = $state;
        $data['title']        = 'state_show';
        return view('location::state.pdf',$data);
    }

    /**
     * Show the form for editing the specified resource.
     * @param  \Modules\Location\Http\Models\State  $state
     * @return \Illuminate\Http\Response
     */
    public function edit(State $state)
    {
        if (!auth()->user()->can('state_edit')) {
            abort(403, 'Unauthorized action.');
        }
        page_title()->setTitle(trans('location::lang.state_edit'));
        $data = array();
        $data['title']        = 'state_edit';
        $data['country']      = Location::getCountry();
        $data['record']        = $this->stateRepository->findOrFail($state->id);
        return view('location::state.create',$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Modules\Location\Http\Models\State  $state
     * @param  DboardHttpResponse  $response
     * @return DboardHttpResponse
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, State  $state, DboardHttpResponse $response)
    {
        if (!auth()->user()->can('state_edit')) {
            abort(403, 'Unauthorized action.');
        }
        $validated = $request->validate([
            'name'              => 'bail|required|max:255',
        ]);

        $id = $state->id;
        $state = $this->stateRepository->firstOrNew(compact('id'));
        $state->fill($request->input());
        $this->stateRepository->createOrUpdate($state);

        $file_name = 'photo';
        if ($request->hasFile($file_name))
        {
//            return $file_name;
            $rules = $request->validate([
                "$file_name" => 'mimes:jpeg,jpg,png,gif|max:10000'
            ]);
            $path = $this->photo_path;
            deleteFile($state->$file_name, $path);

            $state->$file_name      = processUpload($request, $state,$file_name,$path);
            $state->save();
        }

        event(new UpdatedContentEvent(STATE_MODULE_SCREEN_NAME, $request, $state));

        return $response
            ->setPreviousUrl(route('state.index'))
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
        if (!auth()->user()->can('state_destroy')) {
            abort(403, 'Unauthorized action.');
        }
        try{

            $state = $this->stateRepository->findOrFail($id);
            $this->stateRepository->delete($state);
            $path = $this->photo_path;
            deleteFile($state->photo, $path);
            event(new DeletedContentEvent(STATE_MODULE_SCREEN_NAME, $request, $state));

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
        return $this->executeDeleteItems($request, $response, $this->stateRepository, STATE_MODULE_SCREEN_NAME);
    }
    public function getList(Request $request, DboardHttpResponse $response)
    {
        $keyword = DboardHelper::stringify($request->input('q'));

        if (! $keyword) {
            return $response->setData([]);
        }

        $data = $this->stateRepository->advancedGet([
            'condition' => [
                ['states.name', 'LIKE', '%' . $keyword . '%'],
            ],
            'select' => ['states.id', 'states.name'],
            'take' => 10,
            'order_by' => ['order' => 'ASC', 'name' => 'ASC'],
        ]);

        $data->prepend(new State(['id' => 0, 'name' => trans('location::city.select_state')]));

        return $response->setData(StateResource::collection($data));
    }

    public function ajaxGetStates(Request $request, DboardHttpResponse $response)
    {
        $params = [
            'select' => ['states.id', 'states.name'],
            'condition' => [
                'states.status' => DboardStatus::PUBLISHED,
            ],
            'order_by' => ['order' => 'ASC', 'name' => 'ASC'],
        ];

        if ($request->input('country_id') && $request->input('country_id') != 'null') {
            $params['condition']['states.country_id'] = $request->input('country_id');
        }

        $data = $this->stateRepository->advancedGet($params);

        $data->prepend(new State(['id' => 0, 'name' => trans('location::city.select_state')]));

        return $response->setData(StateResource::collection($data));
    }
}
