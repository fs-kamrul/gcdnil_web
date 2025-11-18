<?php

namespace Modules\Theme\Http\Controllers;

use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Modules\KamrulDashboard\Http\Responses\DboardHttpResponse;
use Modules\Theme\Http\Models\Theme;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Theme\Http\Imports\ThemeImport;
use Modules\Theme\Services\ThemeService;
use Illuminate\Support\Arr;
//use mysql_xdevapi\Exception;
use Exception;
use Assets;
use ThemeOption;

class ThemeController extends Controller
{

    protected $photo_path = 'uploads/theme/';

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function getOptions()
    {
        page_title()->setTitle(trans('theme::lang.theme_setting'));
        if (!auth()->user()->can('theme_access')) {
            abort(403, 'Unauthorized action.');
        }
        $data = array();
        $data['title']        = 'theme';
        Assets::addStylesDirectly([
                'vendor/Modules/Theme/css/theme-options.css',
            ])
            ->addScriptsDirectly([
                'vendor/Modules/Theme/js/theme-options.js',
            ]);

        do_action(RENDERING_THEME_OPTIONS_PAGE);
        return view('theme::theme.options', $data);
    }

    /**
     * @param Request $request
     * @param DboardHttpResponse $response
     * @return DboardHttpResponse
     */
    public function postUpdate(Request $request, DboardHttpResponse $response)
    {
        foreach ($request->except(['_token', 'ref_lang']) as $key => $value) {
            if (is_array($value)) {
                $value = json_encode($value);

                $field = ThemeOption::getField($key);

                if ($field && Arr::get($field, 'clean_tags', true)) {
                    $value = clean(strip_tags($value));
                }
            }

            ThemeOption::setOption($key, $value);
        }

        ThemeOption::saveOptions();

        $response_data['status'] = 1;
        $response_data['message'] =  __('theme::lang.update_success_message');
        return $response->setMessage(trans('theme::lang.update_success_message'));
//        return redirect('theme.setting')->with('response_data', $response_data);
//        return $response->setMessage(trans('shortcodes::notices.update_success_message'));
    }
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        page_title()->setTitle(trans('theme::lang.theme'));
        if (!auth()->user()->can('theme_access')) {
            abort(403, 'Unauthorized action.');
        }
        $data = array();
        $data['title']        = 'theme';
        return view('theme::theme.index',$data);
    }

    /**
     * @param Request $request
     * @param DboardHttpResponse $response
     * @param ThemeService $themeService
     * @throws FileNotFoundException
     */
    public function postActivateTheme(Request $request, DboardHttpResponse $response, ThemeService $themeService)
    {
        if (!config('theme.display_theme_manager_in_admin_panel', true)) {
            abort(404);
        }

        $result = $themeService->activate($request->input('theme'));

        if ($result['error']) {
            return $response->setError()->setMessage($result['message']);
        }
        return $response
            ->setMessage(trans('theme::theme.active_success'));
    }
    /**
     * @param Request $request
     * @param DboardHttpResponse $response
     * @param ThemeService $themeService
     * @throws FileNotFoundException
     */
    public function clear_cache(Request $request, DboardHttpResponse $response)
    {
        if (!auth()->user()->can('theme_access')) {
            abort(403, 'Unauthorized action.');
        }
        Artisan::call('optimize');
        return $response
            ->setMessage(trans('theme::lang.clear_all_cache'));
    }

    /**
     * Remove theme
     *
     * @param Request $request
     * @param DboardHttpResponse $response
     * @param ThemeService $themeService
     * @return mixed
     */
    public function postRemoveTheme(Request $request, DboardHttpResponse $response, ThemeService $themeService)
    {
        if (!config('packages.theme.general.display_theme_manager_in_admin_panel', true)) {
            abort(404);
        }

//        $theme = strtolower($request->input('theme'));
        $theme = $request->input('theme');

        if (in_array($theme, scan_folder(theme_path()))) {
            try {
                $result = $themeService->remove($theme);

                if ($result['error']) {
                    return $response->setError()->setMessage($result['message']);
                }

                return $response->setMessage(trans('theme::theme.remove_theme_success'));
            } catch (Exception $exception) {
                return $response
                    ->setError()
                    ->setMessage($exception->getMessage());
            }
        }

        return $response
            ->setError()
            ->setMessage(trans('theme::theme.theme_is_not_existed'));
    }
    public function import()
    {
        if (!auth()->user()->can('theme_import')) {
            abort(403, 'Unauthorized action.');
        }
        $data = array();
        $data['title']        = 'theme_import';
        return view('theme::theme.create_import',$data);
    }
    public function store_import(Request $request)
    {
        if (!auth()->user()->can('theme_import')) {
            abort(403, 'Unauthorized action.');
        }
        $file = $request->file('photo');
        Excel::import(new ThemeImport, $file);
        $response_data['status'] = 1;
        $response_data['message'] =  __('theme::lang.record_save_successfully');
        return redirect('theme')->with('response_data', $response_data);
    }
    public function data()
    {
        if (!auth()->user()->can('theme_access')) {
            abort(403, 'Unauthorized action.');
        }
        if(auth()->user()->can('theme_list_all')) {
            $custom_table = Theme::all();
        }else {
            $custom_table = Theme::where('user_id', Auth::id())->get();
        }
        return datatables()->of($custom_table)->addColumn('action', function ($row) {
            $html = '';
            if(auth()->user()->can('theme_pdf')) {
                $html .= '<a target="_blank" href="' . route('theme.pdf_show', $row->id) . '" class="btn btn-xs btn-success">' . __('theme::lang.pdf') . '</a> ';
            }
            if(auth()->user()->can('theme_show')) {
                $html .= '<a href="' . route('theme.show', $row->id) . '" class="btn btn-xs btn-success">' . __('theme::lang.view') . '</a> ';
            }
            if(auth()->user()->can('theme_edit')) {
                $html .= '<a  href="' . route('theme.edit', $row->id) . '" class="btn btn-xs btn-secondary">' . __('theme::lang.edit') . '</a> ';
            }
            if(auth()->user()->can('theme_destroy')) {
                $html .= '<form action="' . route('theme.destroy', $row->id) . '" method="POST" style="display: inline-block;">
                        ' . csrf_field() . '
                        ' . method_field("DELETE") . '
                        <button type="submit" class="btn btn-xs btn-danger"
                            onclick="return confirm(\'Are You Sure Want to Delete?\')"
                            style="padding: .0em !important;"><i class="icon-trash"> </i>' . __('theme::lang.delete') . '</button>
                        </form>';
            }
            return $html;
        })->addColumn('photo', function ($row) {
            if($row->photo == ''){
                $photo = 'vendor/kamruldashboard/images/image-not-found.jpg';
            }else{
                $photo = $this->photo_path . $row->photo;
            }
            $html = '<img style="height: 100px;width: 100px;" src="' . url($photo) . '" alt="' . $row->photo . '" class="img-rounded img-preview">';
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
        if (!auth()->user()->can('theme_create')) {
            abort(403, 'Unauthorized action.');
        }
        $data = array();
        $data['title']        = 'theme_create';
        return view('theme::theme.create',$data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!auth()->user()->can('theme_create')) {
            abort(403, 'Unauthorized action.');
        }
        $validated = $request->validate([
            'name'              => 'bail|required|max:255',
        ]);

        try {
            $record = new Theme();
            $record->name           = $request->name;
            $record->description    = $request->description;
            $record->status         = $request->status;
            $record->uuid           = gen_uuid();
            $record->user_id        = Auth::id();
            $record->save();

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

            $response_data['status'] = 1;
            $response_data['message'] =  __('theme::lang.record_save_successfully');
            return redirect('theme')->with('response_data', $response_data);
        }catch (Exception $e){

            $response_data['status'] = 0;
            $response_data['message'] =  __('theme::lang.something_error_please_try_again_later');
            return redirect('theme')->with('response_data', $response_data);
        }
    }

    /**
     * Show the specified resource.
     * @param  Theme\Http\Models\Theme  $theme
     * @return \Illuminate\Http\Response
     */
    public function show(Theme $theme)
    {
        if (!auth()->user()->can('theme_show')) {
            abort(403, 'Unauthorized action.');
        }
        $data = array();
        $data['theme']        = $theme;
        $data['title']        = 'theme_show';
        return view('theme::theme.show',$data);
    }
    /**
     * Show the specified resource.
     * @param  Theme\Http\Models\Theme  $theme
     * @return \Illuminate\Http\Response
     */
    public function pdf(Theme $theme)
    {
        if (!auth()->user()->can('theme_pdf')) {
            abort(403, 'Unauthorized action.');
        }
        $data = array();
        $data['theme']        = $theme;
        $data['title']        = 'theme_show';
        return view('theme::theme.pdf',$data);
    }

    /**
     * Show the form for editing the specified resource.
     * @param  Theme\Http\Models\Theme  $theme
     * @return \Illuminate\Http\Response
     */
    public function edit(Theme $theme)
    {
        if (!auth()->user()->can('theme_edit')) {
            abort(403, 'Unauthorized action.');
        }
        $data = array();
        $data['title']        = 'theme_edit';
        $data['record']        = $theme;
        return view('theme::theme.create',$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Theme\Http\Models\Theme  $theme
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Theme  $theme)
    {
        if (!auth()->user()->can('theme_edit')) {
            abort(403, 'Unauthorized action.');
        }
        $validated = $request->validate([
            'name'              => 'bail|required|max:255',
        ]);

        $theme->name             = $request->name;
        $theme->description      = $request->description;
        $theme->status           = $request->status;
        $theme->save();

        $file_name = 'photo';
        if ($request->hasFile($file_name))
        {
//            return $file_name;
            $rules = $request->validate([
                "$file_name" => 'mimes:jpeg,jpg,png,gif|max:10000'
            ]);
            $path = $this->photo_path;
            deleteFile($theme->photo, $path);

            $theme->$file_name      = processUpload($request, $theme,$file_name,$path);
            $theme->save();
        }

        $response_data['status'] = 1;
        $response_data['message'] =  __('theme::lang.record_update_successfully');
        return redirect('theme')->with('response_data', $response_data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Theme\Http\Models\Theme  $theme
     * @return \Illuminate\Http\Response
     */
    public function destroy(Theme  $theme)
    {
        if (!auth()->user()->can('theme_destroy')) {
            abort(403, 'Unauthorized action.');
        }
        try{
            $theme->delete();
            $path = $this->photo_path;
            deleteFile($theme->photo, $path);
            $response_data['status'] = 1;
            $response_data['message'] =  __('theme::lang.record_deleted_successfully');
        } catch ( \Exception $e) {
            $response_data['status'] = 0;
            $response_data['message'] =  __('theme::lang.this_record_is_in_use_in_other_modules');
        }
        return redirect('theme')->with('response_data', $response_data);
    }
}
