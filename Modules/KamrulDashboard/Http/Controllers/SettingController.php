<?php

namespace Modules\KamrulDashboard\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Modules\KamrulDashboard\Events\BeforeEditContentEvent;
use Modules\KamrulDashboard\Http\Models\Setting;
use Modules\KamrulDashboard\Tables\SettingTable;
use ThemeOption;

//use Input;
//use Symfony\Component\Console\Input\Input;
//use Illuminate\Support\Facades\Input;

class SettingController extends Controller
{

    protected $photo_path = 'uploads/settings/';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(SettingTable $dataTable)
    {
        if (!auth()->user()->can('settings_access')) {
            abort(403, 'Unauthorized action.');
        }
        page_title()->setTitle(trans('kamruldashboard::all_lang.settings'));
        $data = array();
        $data['title']        = 'settings';
        return view('kamruldashboard::settings.index',$data);

//        return $dataTable->renderTable();
        //
    }

    public function data()
    {
        if (!auth()->user()->can('settings_access')) {
            abort(403, 'Unauthorized action.');
        }
        $custom_table = Setting::select([ 'title',
            'key', 'description','slug','id', 'updated_at'])
            ->orderBy('updated_at','desc');
        //all();
        return datatables()->of($custom_table)->addColumn('action', function ($row) {
            $html = '';
            if(auth()->user()->can('settings_edit')) {
                $html .= '<a href="' . url('systemsettings/settings/edit', $row->slug) . '" class="btn btn-xs btn-secondary">' . __('kamruldashboard::all_lang.edit') . '</a> ';
            }
            if(auth()->user()->can('settings_show')) {
                $html .= '<a href="' . url('systemsettings/settings/view', $row->slug) . '" class="btn btn-xs btn-secondary">' . __('kamruldashboard::all_lang.view') . '</a> ';
            }
            if(auth()->user()->can('settings_sub_add')) {
                $html .= '<a href="' . url('systemsettings/settings/add-sub-settings', $row->slug) . '" class="btn btn-xs btn-secondary">' . __('kamruldashboard::all_lang.sub_add') . '</a> ';
            }
//            $html .= '<form action="' . route('settings.destroy', $row->id) . '" method="POST">
//                        ' . csrf_field() . '
//                        ' . method_field("DELETE") . '
//                        <button type="submit" class="btn btn-xs btn-danger"
//                            onclick="return confirm(\'Are You Sure Want to Delete?\')"
//                            style="padding: .0em !important;"><i class="icon-trash"> </i>Delete</button>
//                        </form>';
            return $html;
        })->addColumn('title', function ($row) {
            $html = '<a href='. url('systemsettings/settings/view', $row->slug) .'>'.ucwords($row->title).'</a>';
            return $html;
        })->addColumn('description', function ($row) {
            $html = $row->description;
            return $html;
        })->rawColumns(['action','title', 'description'])->toJson();;
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        page_title()->setTitle(trans('kamruldashboard::all_lang.system_settings'));
        if (!auth()->user()->can('settings_create')) {
            abort(403, 'Unauthorized action.');
        }
        $data = array();
        $data['title']        = 'system_settings';
        return view('kamruldashboard::settings.create',$data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!auth()->user()->can('settings_create')) {
            abort(403, 'Unauthorized action.');
        }
        $validated = $request->validate([
            'title'              => 'bail|required|max:255',
            'key'              => 'bail|required|max:255',
        ]);
        $name 					        = $request->key;
        try {
            $record = new Setting();
            $record->slug           = $record->setTitleAttribute($name);
            $record->title          = $request->title;
            $record->key            = $name;
            $record->description    = $request->description;
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
            $response_data['message'] =  __('kamruldashboard::all_lang.record_save_successfully');
            return redirect('systemsettings/settings')->with('response_data', $response_data);
        }catch (Exception $e){

            $response_data['status'] = 0;
            $response_data['message'] =  __('kamruldashboard::all_lang.something_error_please_try_again_later');
            return redirect('systemsettings/settings')->with('response_data', $response_data);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \Modules\KamrulDashboard\Http\Models\Setting  $setting
     * @return \Illuminate\Http\Response
     */
    public function show(Setting $setting)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     */
    public function edit($slug, Request $request)
    {
        page_title()->setTitle(trans('kamruldashboard::all_lang.system_settings'));
        if (!auth()->user()->can('settings_edit')) {
            abort(403, 'Unauthorized action.');
        }
        $data = array();
        $data['title']        = 'system_settings';
        $data['record']       = Setting::where('slug', $slug)->get()->first();
        if($isValid = $this->isValidRecord($data['record'],'systemsettings/settings'))
            return redirect($isValid);

//        event(new BeforeEditContentEvent($request, $page));
        return view('kamruldashboard::settings.create',$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     */
    public function update(Request $request, $slug)
    {
        if (!auth()->user()->can('settings_edit')) {
            abort(403, 'Unauthorized action.');
        }
        $validated = $request->validate([
            'title'              => 'bail|required|max:255',
            'key'              => 'bail|required|max:255',
        ]);
        $name 					        = $request->key;
        $record                 = Setting::where('slug', $slug)->get()->first();

        if($name != $record->key)
            $record->slug = $record->setTitleAttribute($name);
        $record->title                  =$request->title;
        $record->key 			        = $name;
        $record->description 			= $request->description;
        $record->save();

        $file_name = 'photo';
        if ($request->hasFile($file_name))
        {
//            return $file_name;
            $rules = $request->validate([
                "$file_name" => 'mimes:jpeg,jpg,png,gif|max:10000'
            ]);
            $path = $this->photo_path;
            deleteFile($record->photo, $path);

            $record->$file_name      = processUpload($request, $record,$file_name,$path);
            $record->save();
        }

        $response_data['status'] = 1;
        $response_data['message'] =  __('kamruldashboard::all_lang.record_update_successfully');
        return redirect('systemsettings/settings')->with('response_data', $response_data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Modules\KamrulDashboard\Http\Models\Setting  $setting
     * @return \Illuminate\Http\Response
     */
    public function destroy(Setting $setting)
    {
        //
    }


    public function isValidRecord($record, $redirect)
    {
        if ($record === null) {

            $response_data['status'] = 0;
            $response_data['message'] = __('kamruldashboard::all_lang.page_not_found');
            return $redirect;
//            return $this->getRedirectUrl();
        }
        return false;
    }
    public function addSubSettings($slug)
    {
        if (!auth()->user()->can('settings_sub_add')) {
            abort(403, 'Unauthorized action.');
        }
        $data = array();
        $data['title']        = 'sub_settings';
        $record                 = Setting::where('slug', $slug)->get()->first();
        $data['record']				= $record;


        return view('kamruldashboard::settings.sub_index',$data);
        //
    }
    public function addajax(Request $request)
    {
//        @lang(\'all_lang.'. $field .'\')
        $data = '';
        $field = $request->value;
        if( $field=='text' || $field=='password' || $field=='number' || $field=='email' || $field=='file' ) {
            $data = '<div class="form-group col-md-12">
                        <label>' . __('kamruldashboard::all_lang.' . $field) . ' ' . __('kamruldashboard::all_lang.type') . '</label>
                        <input type="' . $field . '" id="key" name="value" value="" class="form-control" placeholder="' . __('kamruldashboard::all_lang.' . $field) . '">
                     </div>';
        }elseif ($field=='checkbox'){
            $data = '<div class="form-check mb-12" style="margin-left: 8%; margin-bottom: 20px; margin-top: 20px;">
                        <input type="checkbox" name="value" class="form-check-input" id="check1" value="" >
                        <label class="form-check-label" for="check1"></label>
                     </div>';
        }elseif ($field=='select'){
            $data = '<div class="form-group col-md-12">
                        <label for="total_options">' . __('kamruldashboard::all_lang.type') . '</label>
                        <input type="number"  id="total_options" name="total_options" value="" class="form-control" onchange="getMessage(this.value,\'#fieldShowSecond\')" placeholder="' . __('kamruldashboard::all_lang.number_of_select_option') . '">
                     </div>';
        }elseif ($field=='textarea'){
            $data = '<div class="form-group col-md-12">
                        <label>' . __('kamruldashboard::all_lang.' . $field) . ' ' . __('kamruldashboard::all_lang.type') . '</label>
                        <textarea class="form-control" name="value" rows="4" id="comment"></textarea>
                     </div>';
        }else{
            for($i=1; $i<=$field; $i++) {
                $data .= '<div class="form-group col-md-4">
                               <label>' . __('kamruldashboard::all_lang.option_value') . ' ' . $i . '</label>
                               <input type="text" id="key" name="option_value[]" value="" class="form-control">
                          </div>
                          <div class="form-group col-md-4">
                               <label>' . __('kamruldashboard::all_lang.option_text') . ' ' . $i . '</label>
                               <input type="text" id="key" name="option_text[]" value="" class="form-control">
                          </div>
                          <div class="form-group col-md-4">
                               <div class="radio">
                                    <label style="margin-top: 35px;" for="radio' . $i . '">
                                    <input type="radio" name="value" id="radio' . $i . '" value="' . $i . '"> ' . __('kamruldashboard::all_lang.make_default') . '
                                </label>
                             </div>
                         </div>';
            }
        }
        return $data;
        $data = array();
        $data['title']        = 'sub_settings';
        $record                 = Setting::where('slug', $slug)->get()->first();
        $data['record']				= $record;


        return view('kamruldashboard::settings.sub_index',$data);
        //
    }
    public function storeSubSettings(Request $request, $slug)
    {

        $record                 = Setting::where('slug', $slug)->get()->first();

        if($isValid = $this->isValidRecord($record,'systemsettings/settings'))
            return redirect($isValid);

        $validation_rules['key'] = 'bail|required|max:50';
        $validation_rules['type'] = 'bail|required';

        if($request->type=='file')
        {
            $validation_rules['value'] = 'bail|mimes:png,jpg,jpeg|max:2048';
        }

        if($request->type=='select')
        {
            $validation_rules['value'] = 'bail|required|integer';
        }

        $this->validate($request, $validation_rules);


        $settings_data = (array) json_decode($record->settings_data);

        $value = '';

        $processed_data = (object)$this->processSettingValue($request);

        $values = array(
            'type'=>$request->type,
            'value'=>$processed_data->value,
            'extra'=>$processed_data->extra,
            'tool_tip'=>$processed_data->tool_tip
        );
        $settings_data[$request->key] = $values;
        $record->settings_data = json_encode($settings_data);

        $record->save();


        $response_data['status'] = 1;
        $response_data['message'] =  __('kamruldashboard::all_lang.record_update_successfully');
        return redirect('systemsettings/settings')->with('response_data', $response_data);
//        flash('success','record_updated_successfully', 'success');
//        return redirect('systemsettings/settings'.$record->slug);

    }

    public function viewSettings($slug)
    {
        $record                 = Setting::where('slug', $slug)->get()->first();

        if($isValid = $this->isValidRecord($record,'systemsettings/settings'))
            return redirect($isValid);
        $data['settings_data']      = getArrayFromJson($record->settings_data);
        $data['record']             = $record;
        $data['title']              = $record->title;
        $data['slug']              = $slug;

        // if($record->key=='site_settings')
        // {
        //     return view('mastersettings.settings.site-settings/add-edit', $data);
        // }

        // return view('mastersettings.settings.sub-list', $data);


        return view('kamruldashboard::settings.sub-list',$data);

//        $view_name = getTheme().'::mastersettings.settings.sub-list';
//        return view($view_name, $data);
    }
    public function processSettingValue(Request $request)
    {
        $value = '';
        $tool_tip = '';
        $extra = array();

        if($request->type=='text'      ||
            $request->type=='number'    ||
            $request->type=='email'     ||
            $request->type=='textarea'
        )
            $value = "";

        if($request->type=='checkbox')
            $value = 0;

        if($request->type=='checkbox'){
            if($request->has('value') == true){
                $value = 1;
            }
        }
        if($request->type=='file') {
            $record_re['id'] = Str::random(15);
            if($request->hasFile('value'))
                $value = processUpload($request,(object)$record_re,'value', $this->photo_path);
        }
        else if($request->type=='select') {

            $extra['total_options'] = $request->total_options;
            $value = '';
            $options = [];
            for($index=0; $index< $extra['total_options']; $index++)
            {
                $options[$request->option_value[$index]] = $request->option_text[$index];
            }

            $extra['options'] = $options;
            $value = $request->option_value[$request->value-1];
        }



        $tool_tip = $request->tool_tip;


        return array('value'=>$value, 'extra'=>$extra, 'tool_tip'=>$tool_tip);
    }
    public function updateSubSettings(Request $request, $slug)
    {

        /**
         * Check if the request is of env varable
         * if yes, update env file
         */

        $record                 = Setting::where('slug', $slug)->get()->first();


        if($isValid = $this->isValidRecord($record,'systemsettings/settings'))
            return redirect($isValid);

        $input_data = $request->all();



        $extra = '';

        foreach ($input_data as $key => $value) {

            if($key=='_token' || $key=='_method' || $value=='')
                continue;
            $submitted_value = (object)$value;
            $value = "";
            if($submitted_value->type == 'checkbox')
                $value = 0;

            if(isset($submitted_value->value))
                $value = $submitted_value->value;

            $old_values = json_decode($record->settings_data);

            /**
             * For File type of settings, first check if the file is changed or not
             * If not changed just keep the old values as it is
             * If file changed, first upload the new file and delete the old file
             * @var [type]
             */
            if($submitted_value->type=='file')
            {
                if($request->hasFile($key)) {
                    $isNew = false;
                    $file_name = 'photo';
                    $record_re['id'] = Str::random(15);
//                    $value = processUpload($request, $key, $isNew);
//                    $value_name = $key . '[\'value\']';
//                    $value = processUpload_update($request, $record,$key, $this->photo_path);
                    $value = processUploadParameters($request,(object)$record_re,$key, $this->photo_path);
                    deleteFile($old_values->$key->value, $this->photo_path);
                }
                else
                {
                    $value = $old_values->$key->value;
                }
            }

            //*** File Answer type end **//

            if($submitted_value->type == 'select')
            {
                $extra = $old_values->$key->extra;
            }

            $data[$key] = array('value'=>$value, 'type'=>$submitted_value->type, 'extra'=>$extra, 'tool_tip'=>$submitted_value->tool_tip);

//            SettingDataF::set($this->getOptionKey($key, $this->getCurrentLocaleCode()), $value);
            if (is_module_active('Theme')) {
                ThemeOption::setOption($key, $value);
            }
        }
        if (is_module_active('Theme')) {
            ThemeOption::saveOptions();
        }


        $record->settings_data = json_encode($data);
        if(!env('DEMO_MODE')) {
            $record->save();

            if($this->isEnvSetting($request))
            {
//
                $data = $this->prepareEnvData($request);
//
                $this->updateEnvironmentFile($data);
            }
        }

        $response_data['status'] = 1;
        $response_data['message'] =  __('kamruldashboard::all_lang.record_update_successfully');
        return redirect('systemsettings/settings/view/'.$slug)->with('response_data', $response_data);


    }

    /**
     * [prepareEnvData description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function prepareEnvData(Request $request)
    {
        $request_data = $request->all();
        $data = array();

        foreach ($request_data as $key => $value) {
            if($key=='_token' || $key=='_method' || $value=='')
                continue;
            if(isset($value['value']))
                $data[strtoupper($key)] = $value['value'];
        }
        return $data;
    }
    /**
     * [prepareEnvData description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function isEnvSetting(Request $request)
    {
        $env_keys = array(
            'mail_driver',
            'system_timezone',
        );

        foreach ($env_keys as $key => $value)
        {
            if($request->has($value))
                return TRUE;
        }

        return FALSE;
    }

    /**
     * This method updates the Environment File which contains all master settings
     * @param  array  $data [description]
     * @return [type]       [description]
     */
    public function updateEnvironmentFile($data = array())
    {
        if(count($data)>0) {
            $env = file_get_contents(base_path() . '/.env');
            $env = preg_split('/\s+/', $env);

            foreach((array)$data as $key => $value){

                // Loop through .env-data
                foreach($env as $env_key => $env_value){

                    // Turn the value into an array and stop after the first split
                    // So it's not possible to split e.g. the App-Key by accident
                    $entry = explode("=", $env_value, 2);

                    // Check, if new key fits the actual .env-key
                    if($entry[0] == $key){
                        // If yes, overwrite it with the new one
                        $env[$env_key] = $key . "=" . $value;
                    } else {
                        // If not, keep the old one
                        $env[$env_key] = $env_value;
                    }
                }
            }
            $env = implode("\n", $env);
            file_put_contents(base_path() . '/.env', $env);
            return TRUE;
        }
        else
        {
            return FALSE;
        }

    }
}
