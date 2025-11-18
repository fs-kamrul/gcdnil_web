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
use Modules\Option\Http\Models\OptionSubject;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Modules\KamrulDashboard\Traits\HasDeleteManyItemsTrait;
use Illuminate\Routing\Controller;
use Modules\Option\Http\Requests\OptionSubjectRequest;
use Modules\Option\Repositories\Interfaces\OptionSubjectInterface;
use Modules\Option\Http\Imports\OptionSubjectImport;
use Modules\Option\Tables\OptionSubjectTable;
use mysql_xdevapi\Exception;
use Throwable;

class OptionSubjectController extends Controller
{
    use HasDeleteManyItemsTrait;
    /**
     * @var OptionSubjectInterface
     */
    protected $optionsubjectRepository;

    /**
     * OptionSubjectController constructor.
     * @param OptionSubjectInterface $optionsubjectRepository
     */
    public function __construct(OptionSubjectInterface $optionsubjectRepository)
    {
        $this->optionsubjectRepository = $optionsubjectRepository;
    }
    protected $photo_path = 'uploads/option/optionsubject/';

    /**
     * @param OptionSubjectTable $dataTable
     * @return JsonResponse|View
     *
     * @throws Throwable
     */
    public function index(OptionSubjectTable $dataTable)
    {
        if (!auth()->user()->can('optionsubject_access')) {
            abort(403, 'Unauthorized action.');
        }
        page_title()->setTitle(trans('option::lang.optionsubject'));

        return $dataTable->renderTable();
    }

    public function import()
    {
        if (!auth()->user()->can('optionsubject_import')) {
            abort(403, 'Unauthorized action.');
        }
        page_title()->setTitle(trans('option::lang.optionsubject_import'));
        $data = array();
        $data['title']        = 'optionsubject_import';
        return view('option::optionsubject.create_import',$data);
    }
    public function store_import(Request $request)
    {
        if (!auth()->user()->can('optionsubject_import')) {
            abort(403, 'Unauthorized action.');
        }
        $file = $request->file('photo');
        Excel::import(new OptionSubjectImport, $file);
        $response_data['status'] = 1;
        $response_data['message'] =  __('option::lang.record_save_successfully');
        return redirect()->route('optionsubject.index')->with('response_data', $response_data);
    }
    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        if (!auth()->user()->can('optionsubject_create')) {
            abort(403, 'Unauthorized action.');
        }
        page_title()->setTitle(trans('option::lang.optionsubject_create'));
        $data = array();
        $data['title']        = 'optionsubject_create';
        return view('option::optionsubject.create',$data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param DboardHttpResponse $response
     * @return DboardHttpResponse
     * @return \Illuminate\Http\Response
     */
    public function store(OptionSubjectRequest $request, DboardHttpResponse $response)
    {
        if (!auth()->user()->can('optionsubject_create')) {
            abort(403, 'Unauthorized action.');
        }
//        $validated = $request->validate([
//            'name'              => 'bail|required|max:255',
//        ]);

        try {
            $record = $this->optionsubjectRepository->createOrUpdate(array_merge($request->input(), [
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
            event(new CreatedContentEvent(OPTIONSUBJECT_MODULE_SCREEN_NAME, $request, $record));

            return $response
                ->setPreviousUrl(route('optionsubject.index'))
                ->setNextUrl(route('optionsubject.edit', $record->id))
                ->setMessage(trans('kamruldashboard::notices.create_success_message'));
        }catch (\Exception $e){

            return $response
                ->setPreviousUrl(route('optionsubject.index'))
                ->setMessage(trans('kamruldashboard::notices.something_error_please_try_again_later'));
        }
    }

    /**
     * Show the specified resource.
     * @param  \Modules\Option\Http\Models\OptionSubject  $optionsubject
     * @return \Illuminate\Http\Response
     */
    public function show(OptionSubject $optionsubject)
    {
        if (!auth()->user()->can('optionsubject_show')) {
            abort(403, 'Unauthorized action.');
        }
        page_title()->setTitle(trans('option::lang.optionsubject_show'));
        $data = array();
        $data['optionsubject']        = $optionsubject;
        $data['title']        = 'optionsubject_show';
        return view('option::optionsubject.show',$data);
    }
    /**
     * Show the specified resource.
     * @param  \Modules\Option\Http\Models\OptionSubject  $optionsubject
     * @return \Illuminate\Http\Response
     */
    public function pdf(OptionSubject $optionsubject)
    {
        if (!auth()->user()->can('optionsubject_pdf')) {
            abort(403, 'Unauthorized action.');
        }
        page_title()->setTitle(trans('option::lang.optionsubject_show'));
        $data = array();
        $data['optionsubject']        = $optionsubject;
        $data['title']        = 'optionsubject_show';
        return view('option::optionsubject.pdf',$data);
    }

    /**
     * Show the form for editing the specified resource.
     * @param  \Modules\Option\Http\Models\OptionSubject  $optionsubject
     * @return \Illuminate\Http\Response
     */
    public function edit(OptionSubject $optionsubject)
    {
        if (!auth()->user()->can('optionsubject_edit')) {
            abort(403, 'Unauthorized action.');
        }
        page_title()->setTitle(trans('option::lang.optionsubject_edit'));
        $data = array();
        $data['title']        = 'optionsubject_edit';
        $data['record']        = $this->optionsubjectRepository->findOrFail($optionsubject->id);
        return view('option::optionsubject.create',$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Modules\Option\Http\Models\OptionSubject  $optionsubject
     * @param  DboardHttpResponse  $response
     * @return DboardHttpResponse
     * @return \Illuminate\Http\Response
     */
    public function update(OptionSubjectRequest $request, OptionSubject  $optionsubject, DboardHttpResponse $response)
    {
        if (!auth()->user()->can('optionsubject_edit')) {
            abort(403, 'Unauthorized action.');
        }
//        $validated = $request->validate([
//            'name'              => 'bail|required|max:255',
//        ]);

        $id = $optionsubject->id;
        $optionsubject = $this->optionsubjectRepository->firstOrNew(compact('id'));
        $optionsubject->fill($request->input());
        $this->optionsubjectRepository->createOrUpdate($optionsubject);

        $file_name = 'photo';
        if ($request->hasFile($file_name))
        {
//            return $file_name;
            $rules = $request->validate([
                "$file_name" => 'mimes:jpeg,jpg,png,gif|max:10000'
            ]);
            $path = $this->photo_path;
            deleteFile($optionsubject->$file_name, $path);

            $optionsubject->$file_name      = processUpload($request, $optionsubject,$file_name,$path);
            $optionsubject->save();
        }

        event(new UpdatedContentEvent(OPTIONSUBJECT_MODULE_SCREEN_NAME, $request, $optionsubject));

        return $response
            ->setPreviousUrl(route('optionsubject.index'))
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
        if (!auth()->user()->can('optionsubject_destroy')) {
            abort(403, 'Unauthorized action.');
        }
        try{

            $optionsubject = $this->optionsubjectRepository->findOrFail($id);
            $this->optionsubjectRepository->delete($optionsubject);
            $path = $this->photo_path;
            deleteFile($optionsubject->photo, $path);
            event(new DeletedContentEvent(OPTIONSUBJECT_MODULE_SCREEN_NAME, $request, $optionsubject));

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
        return $this->executeDeleteItems($request, $response, $this->optionsubjectRepository, OPTIONSUBJECT_MODULE_SCREEN_NAME);
    }
}
