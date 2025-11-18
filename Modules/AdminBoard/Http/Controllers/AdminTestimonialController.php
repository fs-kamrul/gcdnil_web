<?php

namespace Modules\AdminBoard\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;
use Modules\KamrulDashboard\Events\DeletedContentEvent;
use Modules\KamrulDashboard\Events\UpdatedContentEvent;
use Modules\KamrulDashboard\Events\CreatedContentEvent;
use Modules\KamrulDashboard\Http\Responses\DboardHttpResponse;
use Modules\AdminBoard\Http\Models\AdminTestimonial;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Modules\KamrulDashboard\Traits\HasDeleteManyItemsTrait;
use Illuminate\Routing\Controller;
use Modules\AdminBoard\Repositories\Interfaces\AdminTestimonialInterface;
use Modules\AdminBoard\Http\Imports\AdminTestimonialImport;
use Modules\AdminBoard\Tables\AdminTestimonialTable;
use mysql_xdevapi\Exception;
use Throwable;

class AdminTestimonialController extends Controller
{
    use HasDeleteManyItemsTrait;
    /**
     * @var AdminTestimonialInterface
     */
    protected $admintestimonialRepository;

    /**
     * AdminTestimonialController constructor.
     * @param AdminTestimonialInterface $admintestimonialRepository
     */
    public function __construct(AdminTestimonialInterface $admintestimonialRepository)
    {
        $this->admintestimonialRepository = $admintestimonialRepository;
    }
    protected $photo_path = 'uploads/adminboard/admintestimonial/';

    /**
     * @param AdminTestimonialTable $dataTable
     * @return JsonResponse|View
     *
     * @throws Throwable
     */
    public function index(AdminTestimonialTable $dataTable)
    {
        if (!auth()->user()->can('admintestimonial_access')) {
            abort(403, 'Unauthorized action.');
        }
        page_title()->setTitle(trans('adminboard::lang.admintestimonial'));

        return $dataTable->renderTable();
    }

    public function import()
    {
        if (!auth()->user()->can('admintestimonial_import')) {
            abort(403, 'Unauthorized action.');
        }
        page_title()->setTitle(trans('adminboard::lang.admintestimonial_import'));
        $data = array();
        $data['title']        = 'admintestimonial_import';
        return view('adminboard::admintestimonial.create_import',$data);
    }
    public function store_import(Request $request)
    {
        if (!auth()->user()->can('admintestimonial_import')) {
            abort(403, 'Unauthorized action.');
        }
        $file = $request->file('photo');
        Excel::import(new AdminTestimonialImport, $file);
        $response_data['status'] = 1;
        $response_data['message'] =  __('adminboard::lang.record_save_successfully');
        return redirect()->route('admintestimonial.index')->with('response_data', $response_data);
    }
    public function data()
    {
        if (!auth()->user()->can('admintestimonial_access')) {
            abort(403, 'Unauthorized action.');
        }
        if(auth()->user()->can('admintestimonial_list_all')) {
            $custom_table = AdminTestimonial::all();
        }else {
            $custom_table = AdminTestimonial::where('user_id', Auth::id())->get();
        }
        return datatables()->of($custom_table)->addColumn('action', function ($row) {
            $html = '';
            if(auth()->user()->can('admintestimonial_pdf')) {
                $html .= '<a target="_blank" href="' . url('adminboard/admintestimonial/pdf_show', $row->id) . '" class="btn btn-xs btn-success">' . __('adminboard::lang.pdf') . '</a> ';
            }
            if(auth()->user()->can('admintestimonial_show')) {
                $html .= '<a href="' . url('adminboard/admintestimonial/' . $row->id) . '" class="btn btn-xs btn-success">' . __('adminboard::lang.view') . '</a> ';
            }
            if(auth()->user()->can('admintestimonial_edit')) {
                $html .= '<a  href="' . url('adminboard/admintestimonial/' . $row->id . "/edit") . '" class="btn btn-xs btn-secondary">' . __('adminboard::lang.edit') . '</a> ';
            }
            if(auth()->user()->can('admintestimonial_destroy')) {
                $html .= '<form action="' . url('adminboard/admintestimonial', $row->id) . '" method="POST" style="display: inline-block;">
                            ' . csrf_field() . '
                            ' . method_field("DELETE") . '
                            <button type="submit" class="btn btn-xs btn-danger"
                                onclick="return confirm(\'Are You Sure Want to Delete?\')"
                                style="padding: .0em !important;"><i class="icon-trash"> </i>' . __('adminboard::lang.delete') . '</button>
                            </form>';
            }
            return $html;
        })->addColumn('photo', function ($row) {
            $html = '<img style="height: 100px;width: 100px;" src="' . getImageUrl($row->photo,'adminboard/admintestimonial') . '" alt="' . $row->name . '" class="img-rounded img-preview">';
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
        if (!auth()->user()->can('admintestimonial_create')) {
            abort(403, 'Unauthorized action.');
        }
        page_title()->setTitle(trans('adminboard::lang.admintestimonial_create'));
        $data = array();
        $data['title']        = 'admintestimonial_create';
        return view('adminboard::admintestimonial.create',$data);
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
        if (!auth()->user()->can('admintestimonial_create')) {
            abort(403, 'Unauthorized action.');
        }
        $validated = $request->validate([
            'name'              => 'bail|required|max:255',
        ]);

        try {
            $record = $this->admintestimonialRepository->createOrUpdate(array_merge($request->input(), [
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
            event(new CreatedContentEvent(ADMINTESTIMONIAL_MODULE_SCREEN_NAME, $request, $record));

            return $response
                ->setPreviousUrl(route('admintestimonial.index'))
                ->setNextUrl(route('admintestimonial.edit', $record->id))
                ->setMessage(trans('kamruldashboard::notices.create_success_message'));
        }catch (\Exception $e){

            return $response
                ->setPreviousUrl(route('admintestimonial.index'))
                ->setMessage(trans('kamruldashboard::notices.something_error_please_try_again_later'));
        }
    }

    /**
     * Show the specified resource.
     * @param  \Modules\AdminBoard\Http\Models\AdminTestimonial  $admintestimonial
     * @return \Illuminate\Http\Response
     */
    public function show(AdminTestimonial $admintestimonial)
    {
        if (!auth()->user()->can('admintestimonial_show')) {
            abort(403, 'Unauthorized action.');
        }
        page_title()->setTitle(trans('adminboard::lang.admintestimonial_show'));
        $data = array();
        $data['admintestimonial']        = $admintestimonial;
        $data['title']        = 'admintestimonial_show';
        return view('adminboard::admintestimonial.show',$data);
    }
    /**
     * Show the specified resource.
     * @param  \Modules\AdminBoard\Http\Models\AdminTestimonial  $admintestimonial
     * @return \Illuminate\Http\Response
     */
    public function pdf(AdminTestimonial $admintestimonial)
    {
        if (!auth()->user()->can('admintestimonial_pdf')) {
            abort(403, 'Unauthorized action.');
        }
        page_title()->setTitle(trans('adminboard::lang.admintestimonial_show'));
        $data = array();
        $data['admintestimonial']        = $admintestimonial;
        $data['title']        = 'admintestimonial_show';
        return view('adminboard::admintestimonial.pdf',$data);
    }

    /**
     * Show the form for editing the specified resource.
     * @param  \Modules\AdminBoard\Http\Models\AdminTestimonial  $admintestimonial
     * @return \Illuminate\Http\Response
     */
    public function edit(AdminTestimonial $admintestimonial)
    {
        if (!auth()->user()->can('admintestimonial_edit')) {
            abort(403, 'Unauthorized action.');
        }
        page_title()->setTitle(trans('adminboard::lang.admintestimonial_edit'));
        $data = array();
        $data['title']        = 'admintestimonial_edit';
        $data['record']        = $this->admintestimonialRepository->findOrFail($admintestimonial->id);
        return view('adminboard::admintestimonial.create',$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Modules\AdminBoard\Http\Models\AdminTestimonial  $admintestimonial
     * @param  DboardHttpResponse  $response
     * @return DboardHttpResponse
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AdminTestimonial  $admintestimonial, DboardHttpResponse $response)
    {
        if (!auth()->user()->can('admintestimonial_edit')) {
            abort(403, 'Unauthorized action.');
        }
        $validated = $request->validate([
            'name'              => 'bail|required|max:255',
        ]);

        $id = $admintestimonial->id;
        $admintestimonial = $this->admintestimonialRepository->firstOrNew(compact('id'));
        $admintestimonial->fill($request->input());
        $this->admintestimonialRepository->createOrUpdate($admintestimonial);

        $file_name = 'photo';
        if ($request->hasFile($file_name))
        {
//            return $file_name;
            $rules = $request->validate([
                "$file_name" => 'mimes:jpeg,jpg,png,gif|max:10000'
            ]);
            $path = $this->photo_path;
            deleteFile($admintestimonial->$file_name, $path);

            $admintestimonial->$file_name      = processUpload($request, $admintestimonial,$file_name,$path);
            $admintestimonial->save();
        }

        event(new UpdatedContentEvent(ADMINTESTIMONIAL_MODULE_SCREEN_NAME, $request, $admintestimonial));

        return $response
            ->setPreviousUrl(route('admintestimonial.index'))
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
        if (!auth()->user()->can('admintestimonial_destroy')) {
            abort(403, 'Unauthorized action.');
        }
        try{

            $admintestimonial = $this->admintestimonialRepository->findOrFail($id);
            $this->admintestimonialRepository->delete($admintestimonial);
            $path = $this->photo_path;
            deleteFile($admintestimonial->photo, $path);
            event(new DeletedContentEvent(ADMINTESTIMONIAL_MODULE_SCREEN_NAME, $request, $admintestimonial));

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
        return $this->executeDeleteItems($request, $response, $this->admintestimonialRepository, ADMINTESTIMONIAL_MODULE_SCREEN_NAME);
    }
}
