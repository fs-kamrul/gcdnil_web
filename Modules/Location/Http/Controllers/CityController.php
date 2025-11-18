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
use Modules\Location\Http\Models\City;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Modules\KamrulDashboard\Traits\HasDeleteManyItemsTrait;
use Illuminate\Routing\Controller;
use Modules\Location\Http\Resources\CityResource;
use Modules\Location\Repositories\Interfaces\CityInterface;
use Modules\Location\Http\Imports\CityImport;
use Modules\Location\Tables\CityTable;
use Throwable;
use Location;
use DboardHelper;

class CityController extends Controller
{
    use HasDeleteManyItemsTrait;
    /**
     * @var CityInterface
     */
    protected $cityRepository;

    /**
     * CityController constructor.
     * @param CityInterface $cityRepository
     */
    public function __construct(CityInterface $cityRepository)
    {
        $this->cityRepository = $cityRepository;
    }
    protected $photo_path = 'uploads/location/city/';

    /**
     * @param CityTable $dataTable
     * @return JsonResponse|View
     *
     * @throws Throwable
     */
    public function index(CityTable $dataTable)
    {
        if (!auth()->user()->can('city_access')) {
            abort(403, 'Unauthorized action.');
        }
        page_title()->setTitle(trans('location::lang.city'));

        return $dataTable->renderTable();
    }

    public function import()
    {
        if (!auth()->user()->can('city_import')) {
            abort(403, 'Unauthorized action.');
        }
        page_title()->setTitle(trans('location::lang.city_import'));
        $data = array();
        $data['title']        = 'city_import';
        return view('location::city.create_import',$data);
    }
    public function store_import(Request $request)
    {
        if (!auth()->user()->can('city_import')) {
            abort(403, 'Unauthorized action.');
        }
        $file = $request->file('photo');
        Excel::import(new CityImport, $file);
        $response_data['status'] = 1;
        $response_data['message'] =  __('location::lang.record_save_successfully');
        return redirect()->route('city.index')->with('response_data', $response_data);
    }
    public function data()
    {
        if (!auth()->user()->can('city_access')) {
            abort(403, 'Unauthorized action.');
        }
        if(auth()->user()->can('city_list_all')) {
            $custom_table = City::all();
        }else {
            $custom_table = City::where('user_id', Auth::id())->get();
        }
        return datatables()->of($custom_table)->addColumn('action', function ($row) {
            $html = '';
            if(auth()->user()->can('city_pdf')) {
                $html .= '<a target="_blank" href="' . url('location/city/pdf_show', $row->id) . '" class="btn btn-xs btn-success">' . __('location::lang.pdf') . '</a> ';
            }
            if(auth()->user()->can('city_show')) {
                $html .= '<a href="' . url('location/city/' . $row->id) . '" class="btn btn-xs btn-success">' . __('location::lang.view') . '</a> ';
            }
            if(auth()->user()->can('city_edit')) {
                $html .= '<a  href="' . url('location/city/' . $row->id . "/edit") . '" class="btn btn-xs btn-secondary">' . __('location::lang.edit') . '</a> ';
            }
            if(auth()->user()->can('city_destroy')) {
                $html .= '<form action="' . url('location/city', $row->id) . '" method="POST" style="display: inline-block;">
                            ' . csrf_field() . '
                            ' . method_field("DELETE") . '
                            <button type="submit" class="btn btn-xs btn-danger"
                                onclick="return confirm(\'Are You Sure Want to Delete?\')"
                                style="padding: .0em !important;"><i class="icon-trash"> </i>' . __('location::lang.delete') . '</button>
                            </form>';
            }
            return $html;
        })->addColumn('photo', function ($row) {
            $html = '<img style="height: 100px;width: 100px;" src="' . getImageUrl($row->photo,'location/city') . '" alt="' . $row->name . '" class="img-rounded img-preview">';
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
        if (!auth()->user()->can('city_create')) {
            abort(403, 'Unauthorized action.');
        }
        page_title()->setTitle(trans('location::lang.city_create'));
        $data = array();
        $data['title']        = 'city_create';
        $data['country']      = Location::getCountry();
        $data['state']        = Location::getStates();
        return view('location::city.create',$data);
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
        if (!auth()->user()->can('city_create')) {
            abort(403, 'Unauthorized action.');
        }
        $validated = $request->validate([
            'name'              => 'bail|required|max:255',
        ]);

        try {
            $record = $this->cityRepository->createOrUpdate(array_merge($request->input()));

            event(new CreatedContentEvent(CITY_MODULE_SCREEN_NAME, $request, $record));

            return $response
                ->setPreviousUrl(route('city.index'))
                ->setNextUrl(route('city.edit', $record->id))
                ->setMessage(trans('kamruldashboard::notices.create_success_message'));
        }catch (\Exception $e){

            return $response
                ->setPreviousUrl(route('city.index'))
                ->setMessage(trans('kamruldashboard::notices.something_error_please_try_again_later'));
        }
    }

    /**
     * Show the specified resource.
     * @param  \Modules\Location\Http\Models\City  $city
     * @return \Illuminate\Http\Response
     */
    public function show(City $city)
    {
        if (!auth()->user()->can('city_show')) {
            abort(403, 'Unauthorized action.');
        }
        page_title()->setTitle(trans('location::lang.city_show'));
        $data = array();
        $data['city']        = $city;
        $data['title']        = 'city_show';
        return view('location::city.show',$data);
    }
    /**
     * Show the specified resource.
     * @param  \Modules\Location\Http\Models\City  $city
     * @return \Illuminate\Http\Response
     */
    public function pdf(City $city)
    {
        if (!auth()->user()->can('city_pdf')) {
            abort(403, 'Unauthorized action.');
        }
        page_title()->setTitle(trans('location::lang.city_show'));
        $data = array();
        $data['city']        = $city;
        $data['title']        = 'city_show';
        return view('location::city.pdf',$data);
    }

    /**
     * Show the form for editing the specified resource.
     * @param  \Modules\Location\Http\Models\City  $city
     * @return \Illuminate\Http\Response
     */
    public function edit(City $city)
    {
        if (!auth()->user()->can('city_edit')) {
            abort(403, 'Unauthorized action.');
        }
        page_title()->setTitle(trans('location::lang.city_edit'));
        $data = array();
        $data['title']        = 'city_edit';
        $data['country']      = Location::getCountry();
        $data['state']        = Location::getStates();
        $data['record']        = $this->cityRepository->findOrFail($city->id);
        return view('location::city.create',$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Modules\Location\Http\Models\City  $city
     * @param  DboardHttpResponse  $response
     * @return DboardHttpResponse
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, City  $city, DboardHttpResponse $response)
    {
        if (!auth()->user()->can('city_edit')) {
            abort(403, 'Unauthorized action.');
        }
        $validated = $request->validate([
            'name'              => 'bail|required|max:255',
        ]);

        $id = $city->id;
        $city = $this->cityRepository->firstOrNew(compact('id'));
        $city->fill($request->input());
        $this->cityRepository->createOrUpdate($city);

        $file_name = 'photo';
        if ($request->hasFile($file_name))
        {
//            return $file_name;
            $rules = $request->validate([
                "$file_name" => 'mimes:jpeg,jpg,png,gif|max:10000'
            ]);
            $path = $this->photo_path;
            deleteFile($city->$file_name, $path);

            $city->$file_name      = processUpload($request, $city,$file_name,$path);
            $city->save();
        }

        event(new UpdatedContentEvent(CITY_MODULE_SCREEN_NAME, $request, $city));

        return $response
            ->setPreviousUrl(route('city.index'))
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
        if (!auth()->user()->can('city_destroy')) {
            abort(403, 'Unauthorized action.');
        }
        try{

            $city = $this->cityRepository->findOrFail($id);
            $this->cityRepository->delete($city);
            $path = $this->photo_path;
            deleteFile($city->photo, $path);
            event(new DeletedContentEvent(CITY_MODULE_SCREEN_NAME, $request, $city));

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
        return $this->executeDeleteItems($request, $response, $this->cityRepository, CITY_MODULE_SCREEN_NAME);
    }
    public function getList(Request $request, DboardHttpResponse $response)
    {
        $keyword = DboardHelper::stringify($request->input('q'));

        if (! $keyword) {
            return $response->setData([]);
        }

        $data = $this->cityRepository->advancedGet([
            'condition' => [
                ['cities.name', 'LIKE', '%' . $keyword . '%'],
            ],
            'select' => ['cities.id', 'cities.name'],
            'take' => 10,
            'order_by' => ['order' => 'ASC', 'name' => 'ASC'],
        ]);

        $data->prepend(new City(['id' => 0, 'name' => trans('location::city.select_city')]));

        return $response->setData(CityResource::collection($data));
    }

    public function ajaxGetCities(Request $request, DboardHttpResponse $response)
    {
        $params = [
            'select' => ['cities.id', 'cities.name'],
            'condition' => [
                'cities.status' => DboardStatus::PUBLISHED,
            ],
            'order_by' => ['order' => 'ASC', 'name' => 'ASC'],
        ];

        if ($request->input('state_id') && $request->input('state_id') != 'null') {
            $params['condition']['cities.state_id'] = $request->input('state_id');
        }

        $data = $this->cityRepository->advancedGet($params);

        $data->prepend(new City(['id' => 0, 'name' => trans('location::city.select_city')]));

        return $response->setData(CityResource::collection($data));
    }
}
