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
use Modules\Location\Http\Models\Country;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Modules\KamrulDashboard\Traits\HasDeleteManyItemsTrait;
use Illuminate\Routing\Controller;
use Modules\Location\Repositories\Interfaces\CountryInterface;
use Modules\Location\Http\Imports\CountryImport;
use Modules\Location\Tables\CountryTable;
use mysql_xdevapi\Exception;
use Throwable;

class CountryController extends Controller
{
    use HasDeleteManyItemsTrait;
    /**
     * @var CountryInterface
     */
    protected $countryRepository;

    /**
     * CountryController constructor.
     * @param CountryInterface $countryRepository
     */
    public function __construct(CountryInterface $countryRepository)
    {
        $this->countryRepository = $countryRepository;
    }
    protected $photo_path = 'uploads/location/country/';

    /**
     * @param CountryTable $dataTable
     * @return JsonResponse|View
     *
     * @throws Throwable
     */
    public function index(CountryTable $dataTable)
    {
        if (!auth()->user()->can('country_access')) {
            abort(403, 'Unauthorized action.');
        }
        page_title()->setTitle(trans('location::lang.country'));

        return $dataTable->renderTable();
    }

    public function import()
    {
        if (!auth()->user()->can('country_import')) {
            abort(403, 'Unauthorized action.');
        }
        page_title()->setTitle(trans('location::lang.country_import'));
        $data = array();
        $data['title']        = 'country_import';
        return view('location::country.create_import',$data);
    }
    public function store_import(Request $request)
    {
        if (!auth()->user()->can('country_import')) {
            abort(403, 'Unauthorized action.');
        }
        $file = $request->file('photo');
        Excel::import(new CountryImport, $file);
        $response_data['status'] = 1;
        $response_data['message'] =  __('location::lang.record_save_successfully');
        return redirect()->route('country.index')->with('response_data', $response_data);
    }
    public function data()
    {
        if (!auth()->user()->can('country_access')) {
            abort(403, 'Unauthorized action.');
        }
        if(auth()->user()->can('country_list_all')) {
            $custom_table = Country::all();
        }else {
            $custom_table = Country::where('user_id', Auth::id())->get();
        }
        return datatables()->of($custom_table)->addColumn('action', function ($row) {
            $html = '';
            if(auth()->user()->can('country_pdf')) {
                $html .= '<a target="_blank" href="' . url('location/country/pdf_show', $row->id) . '" class="btn btn-xs btn-success">' . __('location::lang.pdf') . '</a> ';
            }
            if(auth()->user()->can('country_show')) {
                $html .= '<a href="' . url('location/country/' . $row->id) . '" class="btn btn-xs btn-success">' . __('location::lang.view') . '</a> ';
            }
            if(auth()->user()->can('country_edit')) {
                $html .= '<a  href="' . url('location/country/' . $row->id . "/edit") . '" class="btn btn-xs btn-secondary">' . __('location::lang.edit') . '</a> ';
            }
            if(auth()->user()->can('country_destroy')) {
                $html .= '<form action="' . url('location/country', $row->id) . '" method="POST" style="display: inline-block;">
                            ' . csrf_field() . '
                            ' . method_field("DELETE") . '
                            <button type="submit" class="btn btn-xs btn-danger"
                                onclick="return confirm(\'Are You Sure Want to Delete?\')"
                                style="padding: .0em !important;"><i class="icon-trash"> </i>' . __('location::lang.delete') . '</button>
                            </form>';
            }
            return $html;
        })->addColumn('photo', function ($row) {
            $html = '<img style="height: 100px;width: 100px;" src="' . getImageUrl($row->photo,'location/country') . '" alt="' . $row->name . '" class="img-rounded img-preview">';
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
        if (!auth()->user()->can('country_create')) {
            abort(403, 'Unauthorized action.');
        }
        page_title()->setTitle(trans('location::lang.country_create'));
        $data = array();
        $data['title']        = 'country_create';
        return view('location::country.create',$data);
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
        if (!auth()->user()->can('country_create')) {
            abort(403, 'Unauthorized action.');
        }
        $validated = $request->validate([
            'name'              => 'bail|required|max:255',
            'nationality'              => 'bail|required|max:120',
        ]);

        try {
            $record = $this->countryRepository->createOrUpdate(array_merge($request->input()));

            event(new CreatedContentEvent(COUNTRY_MODULE_SCREEN_NAME, $request, $record));

            return $response
                ->setPreviousUrl(route('country.index'))
                ->setNextUrl(route('country.edit', $record->id))
                ->setMessage(trans('kamruldashboard::notices.create_success_message'));
        }catch (\Exception $e){
            return $response
                ->setPreviousUrl(route('country.index'))
                ->setMessage(trans('kamruldashboard::notices.something_error_please_try_again_later'));
        }
    }

    /**
     * Show the specified resource.
     * @param  \Modules\Location\Http\Models\Country  $country
     * @return \Illuminate\Http\Response
     */
    public function show(Country $country)
    {
        if (!auth()->user()->can('country_show')) {
            abort(403, 'Unauthorized action.');
        }
        page_title()->setTitle(trans('location::lang.country_show'));
        $data = array();
        $data['country']        = $country;
        $data['title']        = 'country_show';
        return view('location::country.show',$data);
    }
    /**
     * Show the specified resource.
     * @param  \Modules\Location\Http\Models\Country  $country
     * @return \Illuminate\Http\Response
     */
    public function pdf(Country $country)
    {
        if (!auth()->user()->can('country_pdf')) {
            abort(403, 'Unauthorized action.');
        }
        page_title()->setTitle(trans('location::lang.country_show'));
        $data = array();
        $data['country']        = $country;
        $data['title']        = 'country_show';
        return view('location::country.pdf',$data);
    }

    /**
     * Show the form for editing the specified resource.
     * @param  \Modules\Location\Http\Models\Country  $country
     * @return \Illuminate\Http\Response
     */
    public function edit(Country $country)
    {
        if (!auth()->user()->can('country_edit')) {
            abort(403, 'Unauthorized action.');
        }
        page_title()->setTitle(trans('location::lang.country_edit'));
        $data = array();
        $data['title']        = 'country_edit';
        $data['record']        = $this->countryRepository->findOrFail($country->id);
        return view('location::country.create',$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Modules\Location\Http\Models\Country  $country
     * @param  DboardHttpResponse  $response
     * @return DboardHttpResponse
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Country  $country, DboardHttpResponse $response)
    {
        if (!auth()->user()->can('country_edit')) {
            abort(403, 'Unauthorized action.');
        }
        $validated = $request->validate([
            'name'              => 'bail|required|max:255',
            'nationality'              => 'bail|required|max:120',
        ]);

        $id = $country->id;
        $country = $this->countryRepository->firstOrNew(compact('id'));
        $country->fill($request->input());
        $this->countryRepository->createOrUpdate($country);

        event(new UpdatedContentEvent(COUNTRY_MODULE_SCREEN_NAME, $request, $country));

        return $response
            ->setPreviousUrl(route('country.index'))
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
        if (!auth()->user()->can('country_destroy')) {
            abort(403, 'Unauthorized action.');
        }
        try{

            $country = $this->countryRepository->findOrFail($id);
            $this->countryRepository->delete($country);
            $path = $this->photo_path;
            deleteFile($country->photo, $path);
            event(new DeletedContentEvent(COUNTRY_MODULE_SCREEN_NAME, $request, $country));

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
        return $this->executeDeleteItems($request, $response, $this->countryRepository, COUNTRY_MODULE_SCREEN_NAME);
    }
}
