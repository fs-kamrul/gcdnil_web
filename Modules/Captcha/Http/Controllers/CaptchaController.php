<?php

namespace Modules\Captcha\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;
use Modules\KamrulDashboard\Events\DeletedContentEvent;
use Modules\KamrulDashboard\Events\UpdatedContentEvent;
use Modules\KamrulDashboard\Events\CreatedContentEvent;
use Modules\KamrulDashboard\Http\Responses\DboardHttpResponse;
use Modules\KamrulDashboard\Traits\HasDeleteManyItemsTrait;
use Modules\Captcha\Http\Models\Captcha;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Captcha\Repositories\Interfaces\CaptchaInterface;
use Modules\Captcha\Http\Imports\CaptchaImport;
use Modules\Captcha\Tables\CaptchaTable;
use mysql_xdevapi\Exception;
use Throwable;

class CaptchaController extends Controller
{
    use HasDeleteManyItemsTrait;
    /**
     * @var CaptchaInterface
     */
    protected $captchaRepository;

    /**
     * CaptchaController constructor.
     * @param CaptchaInterface $captchaRepository
     */
    public function __construct(CaptchaInterface $captchaRepository)
    {
        $this->captchaRepository = $captchaRepository;
    }
    protected $photo_path = 'uploads/captcha/';

    /**
     * @param CaptchaTable $dataTable
     * @return JsonResponse|View
     *
     * @throws Throwable
     */
    public function index(CaptchaTable $dataTable)
    {
        if (!auth()->user()->can('captcha_access')) {
            abort(403, 'Unauthorized action.');
        }
        page_title()->setTitle(trans('captcha::lang.captcha'));

        return $dataTable->renderTable();
    }

    public function import()
    {
        if (!auth()->user()->can('captcha_import')) {
            abort(403, 'Unauthorized action.');
        }
        page_title()->setTitle(trans('captcha::lang.captcha_import'));
        $data = array();
        $data['title']        = 'captcha_import';
        return view('captcha::captcha.create_import',$data);
    }
    public function store_import(Request $request)
    {
        if (!auth()->user()->can('captcha_import')) {
            abort(403, 'Unauthorized action.');
        }
        $file = $request->file('photo');
        Excel::import(new CaptchaImport, $file);
        $response_data['status'] = 1;
        $response_data['message'] =  __('captcha::lang.record_save_successfully');
        return redirect()->route('captcha.index')->with('response_data', $response_data);
    }
    public function data()
    {
        if (!auth()->user()->can('captcha_access')) {
            abort(403, 'Unauthorized action.');
        }
        if(auth()->user()->can('captcha_list_all')) {
            $custom_table = Captcha::all();
        }else {
            $custom_table = Captcha::where('user_id', Auth::id())->get();
        }
        return datatables()->of($custom_table)->addColumn('action', function ($row) {
            $html = '';
            if(auth()->user()->can('captcha_pdf')) {
                $html .= '<a target="_blank" href="' . route('captcha.pdf_show', $row->id) . '" class="btn btn-xs btn-success">' . __('captcha::lang.pdf') . '</a> ';
            }
            if(auth()->user()->can('captcha_show')) {
                $html .= '<a href="' . route('captcha.show', $row->id) . '" class="btn btn-xs btn-success">' . __('captcha::lang.view') . '</a> ';
            }
            if(auth()->user()->can('captcha_edit')) {
                $html .= '<a  href="' . route('captcha.edit', $row->id) . '" class="btn btn-xs btn-secondary">' . __('captcha::lang.edit') . '</a> ';
            }
            if(auth()->user()->can('captcha_destroy')) {
                $html .= '<form action="' . route('captcha.destroy', $row->id) . '" method="POST" style="display: inline-block;">
                        ' . csrf_field() . '
                        ' . method_field("DELETE") . '
                        <button type="submit" class="btn btn-xs btn-danger"
                            onclick="return confirm(\'Are You Sure Want to Delete?\')"
                            style="padding: .0em !important;"><i class="icon-trash"> </i>' . __('captcha::lang.delete') . '</button>
                        </form>';
            }
            return $html;
        })->addColumn('photo', function ($row) {
            $html = '<img style="height: 100px;width: 100px;" src="' . getImageUrl($row->photo,'captcha') . '" alt="' . $row->name . '" class="img-rounded img-preview">';
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
        if (!auth()->user()->can('captcha_create')) {
            abort(403, 'Unauthorized action.');
        }
        page_title()->setTitle(trans('captcha::lang.captcha_create'));
        $data = array();
        $data['title']        = 'captcha_create';
        return view('captcha::captcha.create',$data);
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
        if (!auth()->user()->can('captcha_create')) {
            abort(403, 'Unauthorized action.');
        }
        $validated = $request->validate([
            'name'              => 'bail|required|max:255',
        ]);

        try {
            $record = $this->captchaRepository->createOrUpdate(array_merge($request->input(), [
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

            event(new CreatedContentEvent(CAPTCHA_MODULE_SCREEN_NAME, $request, $record));

            return $response
                ->setPreviousUrl(route('captcha.index'))
                ->setNextUrl(route('captcha.edit', $record->id))
                ->setMessage(trans('kamruldashboard::notices.create_success_message'));
        }catch (\Exception $e){

            return $response
                ->setPreviousUrl(route('captcha.index'))
                ->setMessage(trans('kamruldashboard::notices.something_error_please_try_again_later'));
        }
    }

    /**
     * Show the specified resource.
     * @param  Captcha\Http\Models\Captcha  $captcha
     * @return \Illuminate\Http\Response
     */
    public function show(Captcha $captcha)
    {
        if (!auth()->user()->can('captcha_show')) {
            abort(403, 'Unauthorized action.');
        }
        page_title()->setTitle(trans('captcha::lang.captcha_show'));
        $data = array();
        $data['captcha']        = $captcha;
        $data['title']        = 'captcha_show';
        return view('captcha::captcha.show',$data);
    }
    /**
     * Show the specified resource.
     * @param  Captcha\Http\Models\Captcha  $captcha
     * @return \Illuminate\Http\Response
     */
    public function pdf(Captcha $captcha)
    {
        if (!auth()->user()->can('captcha_pdf')) {
            abort(403, 'Unauthorized action.');
        }
        page_title()->setTitle(trans('captcha::lang.captcha_show'));
        $data = array();
        $data['captcha']        = $captcha;
        $data['title']        = 'captcha_show';
        return view('captcha::captcha.pdf',$data);
    }

    /**
     * Show the form for editing the specified resource.
     * @param  Captcha\Http\Models\Captcha  $captcha
     * @return \Illuminate\Http\Response
     */
    public function edit(Captcha $captcha)
    {
        if (!auth()->user()->can('captcha_edit')) {
            abort(403, 'Unauthorized action.');
        }
        page_title()->setTitle(trans('captcha::lang.captcha_edit'));
        $data = array();
        $data['title']        = 'captcha_edit';
        $data['record']        = $this->captchaRepository->findOrFail($captcha->id);
        return view('captcha::captcha.create',$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Modules\Captcha\Http\Models\Captcha  $captcha
     * @param  DboardHttpResponse  $response
     * @return DboardHttpResponse
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Captcha  $captcha, DboardHttpResponse $response)
    {
        if (!auth()->user()->can('captcha_edit')) {
            abort(403, 'Unauthorized action.');
        }
        $validated = $request->validate([
            'name'              => 'bail|required|max:255',
        ]);

        $id = $captcha->id;
        $captcha = $this->captchaRepository->firstOrNew(compact('id'));
        $captcha->fill($request->input());
        $captcha = $this->captchaRepository->createOrUpdate($captcha);

        $file_name = 'photo';
        if ($request->hasFile($file_name))
        {
//            return $file_name;
            $rules = $request->validate([
                "$file_name" => 'mimes:jpeg,jpg,png,gif|max:10000'
            ]);
            $path = $this->photo_path;
            deleteFile($captcha->$file_name, $path);

            $captcha->$file_name      = processUpload($request, $captcha,$file_name,$path);
            $captcha->save();
        }

        event(new UpdatedContentEvent(CAPTCHA_MODULE_SCREEN_NAME, $request, $captcha));
        return $response
            ->setPreviousUrl(route('captcha.index'))
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
        if (!auth()->user()->can('captcha_destroy')) {
            abort(403, 'Unauthorized action.');
        }
        try{

            $captcha = $this->captchaRepository->findOrFail($id);
            $this->captchaRepository->delete($captcha);

            event(new DeletedContentEvent(CAPTCHA_MODULE_SCREEN_NAME, $request, $captcha));

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
        return $this->executeDeleteItems($request, $response, $this->captchaRepository, CAPTCHA_MODULE_SCREEN_NAME);
    }
}
