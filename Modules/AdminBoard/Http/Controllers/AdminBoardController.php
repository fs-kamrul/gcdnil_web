<?php

namespace Modules\AdminBoard\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;
use Modules\AdminBoard\Http\Models\AdminGallery;
use Modules\AdminBoard\Http\Models\AdminGalleryBoard;
use Modules\AdminBoard\Http\Models\AdminGalleryParameter;
//use Modules\AdminBoard\Http\Models\AdminWorkshop;
use Modules\KamrulDashboard\Events\DeletedContentEvent;
use Modules\KamrulDashboard\Events\UpdatedContentEvent;
use Modules\KamrulDashboard\Events\CreatedContentEvent;
use Modules\KamrulDashboard\Http\Models\DboardModel;
use Modules\KamrulDashboard\Http\Responses\DboardHttpResponse;
use Modules\KamrulDashboard\Traits\HasDeleteManyItemsTrait;
use Modules\AdminBoard\Http\Models\AdminBoard;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\AdminBoard\Repositories\Interfaces\AdminBoardInterface;
use Modules\AdminBoard\Http\Imports\AdminBoardImport;
use Modules\AdminBoard\Tables\AdminBoardTable;
use mysql_xdevapi\Exception;
use Throwable;

class AdminBoardController extends Controller
{
    use HasDeleteManyItemsTrait;
    /**
     * @var AdminBoardInterface
     */
    protected $adminboardRepository;

    /**
     * AdminBoardController constructor.
     * @param AdminBoardInterface $adminboardRepository
     */
    public function __construct(AdminBoardInterface $adminboardRepository)
    {
        $this->adminboardRepository = $adminboardRepository;
    }
    protected $photo_path = 'uploads/adminboard/';
    protected $photo_path_shortcode = 'uploads/adminboard/shortcode/';

    /**
     * @param AdminBoardTable $dataTable
     * @return JsonResponse|View
     *
     * @throws Throwable
     */
    public function index(AdminBoardTable $dataTable)
    {
        if (!auth()->user()->can('adminboard_access')) {
            abort(403, 'Unauthorized action.');
        }
        page_title()->setTitle(trans('adminboard::lang.adminboard'));

        return $dataTable->renderTable();
    }

    public function import()
    {
        if (!auth()->user()->can('adminboard_import')) {
            abort(403, 'Unauthorized action.');
        }
        page_title()->setTitle(trans('adminboard::lang.adminboard_import'));
        $data = array();
        $data['title']        = 'adminboard_import';
        return view('adminboard::adminboard.create_import',$data);
    }
    public function store_import(Request $request)
    {
        if (!auth()->user()->can('adminboard_import')) {
            abort(403, 'Unauthorized action.');
        }
        $file = $request->file('photo');
        Excel::import(new AdminBoardImport, $file);
        $response_data['status'] = 1;
        $response_data['message'] =  __('adminboard::lang.record_save_successfully');
        return redirect()->route('adminboard.index')->with('response_data', $response_data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function uploadFile(Request $request)
    {
//        return $request;
        $file_name = 'file';
//        if ($request->hasFile($file_name))
//        {
//            return $file_name;
        $rules = $request->validate([
            //mimes:jpeg,jpg,png,gif|
//                "firstname" => 'bail|required|max:255',
            "file" => 'mimes:jpeg,jpg,png,gif|max:20000'
        ]);
        $path = $this->photo_path_shortcode;
//        $image = $request->file('file');
//        $fileInfo = $image->getClientOriginalName();
//        $filename = pathinfo($fileInfo, PATHINFO_FILENAME);
//        $extension = pathinfo($fileInfo, PATHINFO_EXTENSION);
//        $file_name= $filename.'-'.time().'.'.$extension;
//        $image->move($path,$file_name);
        $file_name = processUpload($request, '', $file_name, $path);

        $imageUpload                = new AdminGallery();
        $imageUpload->name          = $file_name;
        $imageUpload->user_id       = Auth::id();
        $imageUpload->save();

//        return response()->json(['success'=>$imageUpload->id]);
        return response()->json(['success'=>$file_name,'photo_data'=>$imageUpload->id]);
    }
    public function destroy_uploadFile(Request $request)
    {
        $path = $this->photo_path_shortcode;
        $filename =  $request->get('filename');
//        return $filename;
        AdminGallery::where('name',$filename)->delete();
        $path = $path.$filename;
        if (file_exists($path)) {
            unlink($path);
        }
        return response()->json(['success'=>$filename]);
    }
    public function getImages($id, $model)
    {
        $images = array();
        $data = array();
        $obj = array();
        $tableImages = array();
        $path = $this->photo_path_shortcode;
//        $images = PostGallery::all()->toArray();
        $image_data = AdminGalleryParameter::where('reference_id', $id)->where('reference_type', $model)->get();
//        dd($image_data);
//        $images = PostGalleryParameter::where('post_id', 49)->get()->toArray();
        if($image_data && $id!=0) {
            foreach ($image_data as $key => $image_to) {
                $images[$key] = $image_to->AdminGallery->toArray();
            }
//            dd($images);
            foreach ($images as $image) {
                $tableImages[] = $image['name'];
            }
//            dd($tableImages);
            foreach ($tableImages as $tableImage) {
                $file_path = public_path($path) . $tableImage;
                if(file_exists($file_path)){
                    $obj['name'] = $tableImage;
                    $obj['size'] = filesize($file_path);
                    $obj['path'] = url($path . $tableImage);
                    $data[] = $obj;
                }
            }
//            dd($tableImage);
//            dd($data);
        }
        return response()->json($data);
    }
    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        if (!auth()->user()->can('adminboard_create')) {
            abort(403, 'Unauthorized action.');
        }
        page_title()->setTitle(trans('adminboard::lang.adminboard_create'));
        $data = array();
        $data['title']        = 'adminboard_create';
        return view('adminboard::adminboard.create',$data);
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
        if (!auth()->user()->can('adminboard_create')) {
            abort(403, 'Unauthorized action.');
        }
        $validated = $request->validate([
            'name'              => 'bail|required|max:255',
        ]);

        try {
            $record = $this->adminboardRepository->createOrUpdate(array_merge($request->input(), [
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

            event(new CreatedContentEvent(ADMINBOARD_MODULE_SCREEN_NAME, $request, $record));

            return $response
                ->setPreviousUrl(route('adminboard.index'))
                ->setNextUrl(route('adminboard.edit', $record->id))
                ->setMessage(trans('kamruldashboard::notices.create_success_message'));
        }catch (\Exception $e){

            return $response
                ->setPreviousUrl(route('adminboard.index'))
                ->setMessage(trans('kamruldashboard::notices.something_error_please_try_again_later'));
        }
    }

    /**
     * Show the specified resource.
     * @param  AdminBoard\Http\Models\AdminBoard  $adminboard
     * @return \Illuminate\Http\Response
     */
    public function show(AdminBoard $adminboard)
    {
        if (!auth()->user()->can('adminboard_show')) {
            abort(403, 'Unauthorized action.');
        }
        page_title()->setTitle(trans('adminboard::lang.adminboard_show'));
        $data = array();
        $data['adminboard']        = $adminboard;
        $data['title']        = 'adminboard_show';
        return view('adminboard::adminboard.show',$data);
    }
    /**
     * Show the specified resource.
     * @param  AdminBoard\Http\Models\AdminBoard  $adminboard
     * @return \Illuminate\Http\Response
     */
    public function pdf(AdminBoard $adminboard)
    {
        if (!auth()->user()->can('adminboard_pdf')) {
            abort(403, 'Unauthorized action.');
        }
        page_title()->setTitle(trans('adminboard::lang.adminboard_show'));
        $data = array();
        $data['adminboard']        = $adminboard;
        $data['title']        = 'adminboard_show';
        return view('adminboard::adminboard.pdf',$data);
    }

    /**
     * Show the form for editing the specified resource.
     * @param  AdminBoard\Http\Models\AdminBoard  $adminboard
     * @return \Illuminate\Http\Response
     */
    public function edit(AdminBoard $adminboard)
    {
        if (!auth()->user()->can('adminboard_edit')) {
            abort(403, 'Unauthorized action.');
        }
        page_title()->setTitle(trans('adminboard::lang.adminboard_edit'));
        $data = array();
        $data['title']        = 'adminboard_edit';
        $data['record']        = $this->adminboardRepository->findOrFail($adminboard->id);
        return view('adminboard::adminboard.create',$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Modules\AdminBoard\Http\Models\AdminBoard  $adminboard
     * @param  DboardHttpResponse  $response
     * @return DboardHttpResponse
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AdminBoard  $adminboard, DboardHttpResponse $response)
    {
        if (!auth()->user()->can('adminboard_edit')) {
            abort(403, 'Unauthorized action.');
        }
        $validated = $request->validate([
            'name'              => 'bail|required|max:255',
        ]);

        $id = $adminboard->id;
        $adminboard = $this->adminboardRepository->firstOrNew(compact('id'));
        $adminboard->fill($request->input());
        $adminboard = $this->adminboardRepository->createOrUpdate($adminboard);

        $file_name = 'photo';
        if ($request->hasFile($file_name))
        {
//            return $file_name;
            $rules = $request->validate([
                "$file_name" => 'mimes:jpeg,jpg,png,gif|max:10000'
            ]);
            $path = $this->photo_path;
            deleteFile($adminboard->$file_name, $path);

            $adminboard->$file_name      = processUpload($request, $adminboard,$file_name,$path);
            $adminboard->save();
        }

        event(new UpdatedContentEvent(ADMINBOARD_MODULE_SCREEN_NAME, $request, $adminboard));
        return $response
            ->setPreviousUrl(route('adminboard.index'))
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
        if (!auth()->user()->can('adminboard_destroy')) {
            abort(403, 'Unauthorized action.');
        }
        try{

            $adminboard = $this->adminboardRepository->findOrFail($id);
            $this->adminboardRepository->delete($adminboard);

            event(new DeletedContentEvent(ADMINBOARD_MODULE_SCREEN_NAME, $request, $adminboard));

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
        return $this->executeDeleteItems($request, $response, $this->adminboardRepository, ADMINBOARD_MODULE_SCREEN_NAME);
    }
}
