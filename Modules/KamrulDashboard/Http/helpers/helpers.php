<?php


use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
//use Intervention\Image\Facades\Image;
use Modules\KamrulDashboard\Http\Models\Setting;
use Modules\KamrulDashboard\Http\Models\Slug;
use Modules\KamrulDashboard\Packages\Supports\DboardStatus;
use Modules\Menus\Http\Models\MenusNode;
use Modules\KamrulDashboard\Packages\Facades\PageTitleFacade;
use Modules\KamrulDashboard\Packages\Supports\PageTitle;
use Modules\Post\Http\Models\PostGallery;
use Modules\Post\Repositories\Interfaces\PostInterface;
use Modules\Post\Repositories\Interfaces\CategoryInterface;
use Modules\KamrulDashboard\Packages\Supports\SortItemsWithChildrenHelper;

//use DboardHelper;
//use Modules\KamrulDashboard\Http\Models\SettingData;
if (!defined('BASE_FILTER_BEFORE_GET_FRONT_PAGE_ITEM')) {
    define('BASE_FILTER_BEFORE_GET_FRONT_PAGE_ITEM', 'before_get_front_page_item');
}

if (! defined('BASE_FILTER_BEFORE_SAVE_FORM')) {
    define('BASE_FILTER_BEFORE_SAVE_FORM', 'base_filter_before_save_form');
}
if (! defined('BASE_FILTER_AFTER_SAVE_FORM')) {
    define('BASE_FILTER_AFTER_SAVE_FORM', 'base_filter_after_save_form');
}
if (! defined('BASE_FILTER_EXTENDED_FORM')) {
    define('BASE_FILTER_EXTENDED_FORM', 'base_filter_extended_form');
}
if (! defined('BASE_FILTER_AFTER_RENDER_FORM')) {
    define('BASE_FILTER_AFTER_RENDER_FORM', 'base_filter_after_render_form');
}
if (!defined('BASE_FILTER_BEFORE_GET_SINGLE')) {
    define('BASE_FILTER_BEFORE_GET_SINGLE', 'before_get_home_page_data_single');
}
if (!defined('KAMRULDASHBOARD_MODULE_SCREEN_NAME')) {
    define('KAMRULDASHBOARD_MODULE_SCREEN_NAME', 'KamrulDashboard');
}
if (!defined('BASE_FILTER_BEFORE_GET_ADMIN_LIST_ITEM')) {
    define('BASE_FILTER_BEFORE_GET_ADMIN_LIST_ITEM', 'before_get_admin_list_item');
}

if (! defined('BASE_FILTER_AFTER_SETTING_CONTENT')) {
    define('BASE_FILTER_AFTER_SETTING_CONTENT', 'base-filter-after-setting-content');
}

if (!defined('BASE_FILTER_BEFORE_GET_ADMIN_SINGLE_ITEM')) {
    define('BASE_FILTER_BEFORE_GET_ADMIN_SINGLE_ITEM', 'before_get_admin_single_item');
}if (!defined('BASE_ACTION_INIT')) {
    define('BASE_ACTION_INIT', 'init');
}
if (!defined('BASE_ACTION_META_BOXES')) {
    define('BASE_ACTION_META_BOXES', 'meta_boxes');
}

if (!defined('BASE_FILTER_PUBLIC_SINGLE_DATA')) {
    define('BASE_FILTER_PUBLIC_SINGLE_DATA', 'filter_public_single_data');
}

if (!defined('BASE_ACTION_PUBLIC_RENDER_SINGLE')) {
    define('BASE_ACTION_PUBLIC_RENDER_SINGLE', 'base_action_public_render_single');
}
if (!defined('FILTER_GROUP_PUBLIC_ROUTE')) {
    define('FILTER_GROUP_PUBLIC_ROUTE', 'group_public_route');
}

if (!defined('BACKUP_MODULE_SCREEN_NAME')) {
    define('BACKUP_MODULE_SCREEN_NAME', 'backup');
}

if (!defined('BACKUP_ACTION_AFTER_BACKUP')) {
    define('BACKUP_ACTION_AFTER_BACKUP', 'action_after_backup');
}

if (!defined('BACKUP_ACTION_AFTER_RESTORE')) {
    define('BACKUP_ACTION_AFTER_RESTORE', 'action_after_restore');
}

if (!defined('BASE_ACTION_BEFORE_EDIT_CONTENT')) {
    define('BASE_ACTION_BEFORE_EDIT_CONTENT', 'before_edit_content');
}

if (!defined('BASE_ACTION_AFTER_CREATE_CONTENT')) {
    define('BASE_ACTION_AFTER_CREATE_CONTENT', 'after_create_content');
}

if (!defined('BASE_ACTION_AFTER_DELETE_CONTENT')) {
    define('BASE_ACTION_AFTER_DELETE_CONTENT', 'after_delete_content');
}

if (!defined('BASE_ACTION_AFTER_UPDATE_CONTENT')) {
    define('BASE_ACTION_AFTER_UPDATE_CONTENT', 'after_update_content');
}

if (!defined('BASE_FILTER_GET_LIST_DATA')) {
    define('BASE_FILTER_GET_LIST_DATA', 'get_list_data');
}

if (!defined('BASE_FILTER_TABLE_HEADINGS')) {
    define('BASE_FILTER_TABLE_HEADINGS', 'table_headings');
}

if (!defined('THEME_OPTIONS_ACTION_META_BOXES')) {
    define('THEME_OPTIONS_ACTION_META_BOXES', 'theme-options-action-meta-boxes');
}

if (!defined('BASE_FILTER_BEFORE_RENDER_FORM')) {
    define('BASE_FILTER_BEFORE_RENDER_FORM', 'base_filter_before_render_form');
}

if (!defined('MENU_FILTER_NODE_URL')) {
    define('MENU_FILTER_NODE_URL', 'menu_node_url');
}

if (!defined('DASHBOARD_FILTER_ADMIN_LIST')) {
    define('DASHBOARD_FILTER_ADMIN_LIST', 'admin_dashboard_list');
}

if (!defined('DASHBOARD_ACTION_REGISTER_SCRIPTS')) {
    define('DASHBOARD_ACTION_REGISTER_SCRIPTS', 'dashboard_register_scripts');
}


if (!defined('DASHBOARD_FILTER_ADMIN_NOTIFICATIONS')) {
    define('DASHBOARD_FILTER_ADMIN_NOTIFICATIONS', 'admin_dashboard_notifications');
}

if (!defined('DASHBOARD_FILTER_TOP_BLOCKS')) {
    define('DASHBOARD_FILTER_TOP_BLOCKS', 'admin_dashboard_top_blocks');
}
if (!defined('FILTER_SLUG_PREFIX')) {
    define('FILTER_SLUG_PREFIX', 'slug-prefix-filter');
}

if (!defined('FILTER_SLUG_EXISTED_STRING')) {
    define('FILTER_SLUG_EXISTED_STRING', 'slug-existed-string');
}
if (!defined('FILTER_SLUG_STRING')) {
    define('FILTER_SLUG_STRING', 'slug-string');
}
if (!defined('BASE_ACTION_TOP_FORM_CONTENT_NOTIFICATION')) {
    define('BASE_ACTION_TOP_FORM_CONTENT_NOTIFICATION', 'base_top_form_content_notification');
}

if (!defined('BASE_LANGUAGE_FLAG_PATH')) {
    define('BASE_LANGUAGE_FLAG_PATH', '/vendor/kamruldashboard/images/flags/');
}
if (!defined('BASE_FILTER_TABLE_BUTTONS')) {
    define('BASE_FILTER_TABLE_BUTTONS', 'base_filter_table_buttons');
}
if (!defined('BASE_FILTER_TABLE_QUERY')) {
    define('BASE_FILTER_TABLE_QUERY', 'base_filter_table_query');
}
if (!defined('BASE_FILTER_SITE_LANGUAGE_DIRECTION')) {
    define('BASE_FILTER_SITE_LANGUAGE_DIRECTION', 'base_filter_site_language_direction');
}
if (! defined('BASE_FILTER_ADMIN_LANGUAGE_DIRECTION')) {
    define('BASE_FILTER_ADMIN_LANGUAGE_DIRECTION', 'base_filter_admin_language_direction');
}

if (! defined('BASE_FILTER_AVAILABLE_EDITORS')) {
    define('BASE_FILTER_AVAILABLE_EDITORS', 'base_filter_available_editors');
}
if (! defined('BASE_FILTER_ENUM_LABEL')) {
    define('BASE_FILTER_ENUM_LABEL', 'base_filter_enum_label');
}
if (! defined('BASE_FILTER_ENUM_HTML')) {
    define('BASE_FILTER_ENUM_HTML', 'base_filter_enum_html');
}
if (!defined('IS_IN_ADMIN_FILTER')) {
    define('IS_IN_ADMIN_FILTER', 'is_in_admin');
}
if (!defined('BASE_FILTER_REGISTER_CONTENT_TABS')) {
    define('BASE_FILTER_REGISTER_CONTENT_TABS', 'register_platform_content_tabs');
}
if (!defined('BASE_FILTER_SLUG_AREA')) {
    define('BASE_FILTER_SLUG_AREA', 'slug-area');
}
if (!defined('BASE_FILTER_ENUM_ARRAY')) {
    define('BASE_FILTER_ENUM_ARRAY', 'base_filter_enum_array');
}
if (!defined('BASE_ACTION_ENQUEUE_SCRIPTS')) {
    define('BASE_ACTION_ENQUEUE_SCRIPTS', 'base_action_enqueue_scripts');
}

if (!defined('BASE_FILTER_FOOTER_LAYOUT_TEMPLATE')) {
    define('BASE_FILTER_FOOTER_LAYOUT_TEMPLATE', 'base_filter_footer_layout_template');
}

if (!defined('BASE_FILTER_FORM_EDITOR_BUTTONS')) {
    define('BASE_FILTER_FORM_EDITOR_BUTTONS', 'base_filter_form_editor_buttons');
}
if (! defined('BASE_FILTER_FORM_EDITOR_BUTTONS_HEADER')) {
    define('BASE_FILTER_FORM_EDITOR_BUTTONS_HEADER', 'base_filter_form_editor_buttons_header');
}
if (! defined('BASE_FILTER_FORM_EDITOR_BUTTONS_FOOTER')) {
    define('BASE_FILTER_FORM_EDITOR_BUTTONS_FOOTER', 'base_filter_form_editor_buttons_footer');
}
if (!defined('BASE_FILTER_AFTER_FORM_CREATED')) {
    define('BASE_FILTER_AFTER_FORM_CREATED', 'base_filter_after_form_created');
}
if (!defined('BASE_FILTER_REGISTER_CONTENT_TAB_INSIDE')) {
    define('BASE_FILTER_REGISTER_CONTENT_TAB_INSIDE', 'register_platform_content_tab_inside');
}
if (!defined('BASE_ACTION_FORM_ACTIONS_TITLE')) {
    define('BASE_ACTION_FORM_ACTIONS_TITLE', 'base_form_actions_title');
}
if (!defined('BASE_ACTION_FORM_ACTIONS')) {
    define('BASE_ACTION_FORM_ACTIONS', 'base_form_actions');
}
if (!defined('KAMRULDASHBOARD_FILTER_USER_TABLE_ACTIONS')) {
    define('KAMRULDASHBOARD_FILTER_USER_TABLE_ACTIONS', 'user_table_actions');
}
if (!defined('SITE_MODULE_SCREEN_NAME')) {
    define('SITE_MODULE_SCREEN_NAME', 'site');
}

if (! defined('SLUG_VARIABLES')) {
    define('SLUG_VARIABLES', 'cms_slug_variables');
}

if (! defined('BASE_FILTER_EMAIL_TEMPLATE')) {
    define('BASE_FILTER_EMAIL_TEMPLATE', 'base_filter_email_template');
}
if (! defined('BASE_FILTER_EMAIL_TEMPLATE_HEADER')) {
    define('BASE_FILTER_EMAIL_TEMPLATE_HEADER', 'base_filter_email_template_header');
}
if (! defined('BASE_FILTER_EMAIL_TEMPLATE_FOOTER')) {
    define('BASE_FILTER_EMAIL_TEMPLATE_FOOTER', 'base_filter_email_template_footer');
}
if (! defined('BASE_FILTER_PUBLIC_COMMENT_AREA')) {
    define('BASE_FILTER_PUBLIC_COMMENT_AREA', 'filter_public_comment_area');
}

if (! defined('BASE_FILTER_AFTER_SETTING_EMAIL_CONTENT')) {
    define('BASE_FILTER_AFTER_SETTING_EMAIL_CONTENT', 'base-filter-after-setting-email-content');
}
if (! defined('BASE_FILTER_TOP_HEADER_LAYOUT')) {
    define('BASE_FILTER_TOP_HEADER_LAYOUT', 'base_filter_top_header_layout');
}
if (! defined('BASE_FILTER_APPEND_MENU_NAME')) {
    define('BASE_FILTER_APPEND_MENU_NAME', 'base_filter_append_menu_name');
}
if (! defined('BASE_FILTER_MENU_ITEMS_COUNT')) {
    define('BASE_FILTER_MENU_ITEMS_COUNT', 'base_filter_menu_items_count');
}

if (!function_exists('get_cms_version')) {
    /**
     * @return string
     */
    function get_cms_version(): string
    {
        $version = '2.2.1';

        try {
            $core = get_file_data(core_path('module.json'));

            return Arr::get($core, 'version', $version);
        } catch (Exception $exception) {
            return $version;
        }
    }
}

if (!function_exists('page_title')) {
    /**
     * @return PageTitle
     */
    function page_title()
    {
        return PageTitleFacade::getFacadeRoot();
    }
}
if(! function_exists('gen_uuid')) {
    function gen_uuid()
    {
        return sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            // 32 bits for "time_low"
            mt_rand(0, 0xffff), mt_rand(0, 0xffff),

            // 16 bits for "time_mid"
            mt_rand(0, 0xffff),

            // 16 bits for "time_hi_and_version",
            // four most significant bits holds version number 4
            mt_rand(0, 0x0fff) | 0x4000,

            // 16 bits, 8 bits for "clk_seq_hi_res",
            // 8 bits for "clk_seq_low",
            // two most significant bits holds zero and one for variant DCE1.1
            mt_rand(0, 0x3fff) | 0x8000,

            // 48 bits for "node"
            mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
        );
    }
}

if (!function_exists('save_file_data')) {
    /**
     * @param string $path
     * @param array|string $data
     * @param bool $json
     * @return bool|mixed
     */
    function save_file_data($path, $data, $json = true)
    {
        return DboardHelper::saveFileData($path, $data, $json);
    }
}

if (!function_exists('get_array_replace')) {
    function get_array_replace($charToReplace, $replacementChar, $array)
    {
        foreach ($array as &$string) {
            $string = str_replace($charToReplace, $replacementChar, $string);
        }
        return $array;
    }
}
if (!function_exists('is_module_active')) {
    /**
     * @param string $alias
     * @return bool
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    function is_module_active($alias)
    {
        return \Module::collections()->has($alias);
    }
}

if (!function_exists('language_flag')) {
    /**
     * @param string $flag
     * @param string $name
     * @return string
     */
    function language_flag(string $flag, ?string $name = null): string
    {
        return Html::image(asset(BASE_LANGUAGE_FLAG_PATH . $flag . '.svg'), $name, ['title' => $name, 'width' => 16]);
    }
}
if (!function_exists('human_file_size')) {
    /**
     * @param int $bytes
     * @param int $precision
     * @return string
     */
    function human_file_size($bytes, $precision = 2): string
    {
        return DboardHelper::humanFilesize($bytes, $precision);
    }
}

if (!function_exists('get_backup_size')) {
    /**
     * @param string $key
     * @return int
     */
    function get_backup_size($key)
    {
        $size = 0;

        foreach (File::allFiles(storage_path('app/backup/' . $key)) as $file) {
            $size += $file->getSize();
        }

        return $size;
    }
}
if (!function_exists('plugin_path')) {
    /**
     * @return string
     */
    function plugin_path($path = null)
    {
        return platform_path('Modules' . DIRECTORY_SEPARATOR . $path);
    }
}

if (!function_exists('is_plugin_active')) {
    /**
     * @param string $alias
     * @return bool
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    function is_plugin_active($alias)
    {
        if (!in_array($alias, get_active_plugins())) {
            return false;
        }

        $path = plugin_path($alias);

        return File::isDirectory($path) && File::exists($path . '/module.json');
    }
}

if (!function_exists('get_active_plugins')) {
    /**
     * @return array
     */
    function get_active_plugins()
    {
        try {
            return array_unique(json_decode(setting('activated_plugins', '[]'), true));
        } catch (Exception $exception) {
            return [];
        }
    }
}

//if (!function_exists('get_active_modules')) {
//    /**
//     * @return array
//     */
//    function get_active_modules()
//    {
//        try {
//            return array_unique(json_decode(setting('activated_plugins', '[]'), true));
//        } catch (Exception $exception) {
//            return [];
//        }
//    }
//}
if (!function_exists('platform_path')) {
    /**
     * @param string|null $path
     * @return string
     */
    function platform_path($path = null): string
    {
        return base_path('' . $path);
    }
}

if (!function_exists('get_file_data')) {
    /**
     * @param string $file
     * @param bool $toArray
     * @return bool|mixed
     */
    function get_file_data($file, $toArray = true)
    {
        return DboardHelper::getFileData($file, $toArray);
    }
}
if (!function_exists('getImageUrl')) {
    /**
     * @param string $file
     * @param bool $toArray
     * @return bool|mixed
     */
    function getImageUrl($photo, $path = 'post')
    {
        $path_post = 'uploads/' . $path . '/';
        if($photo == ''){
            $photo_url = 'vendor/kamruldashboard/images/image-not-found.jpg';
        }else{
            $photo_url = $path_post . $photo;
        }
        return url($photo_url);
    }
}
if (!function_exists('getImageUrlById')) {
    /**
     * @param string $file
     * @param bool $toArray
     * @return bool|mixed
     */
    function getImageUrlById($photo, $path = 'post')
    {
        $path_post = 'uploads/' . $path . '/';
        if($photo == ''){
            $photo_url = 'vendor/kamruldashboard/images/image-not-found.jpg';
        }else{
            $get_photo = PostGallery::where('id', $photo)->first();
            if(!$get_photo)
                $photo_url = 'vendor/kamruldashboard/images/image-not-found.jpg';
            else
                $photo_url = $path_post . $get_photo->name;
        }
        return url($photo_url);
    }
}
if (!function_exists('getDefaultImage')) {
    /**
     * @param string $file
     * @param bool $toArray
     * @return bool|mixed
     */
    function getDefaultImage()
    {
        $photo_url = 'vendor/kamruldashboard/images/image-not-found.jpg';
        return url($photo_url);
    }
}
if (!function_exists('getRealPath')) {
    function getRealPath(string $url): string
    {
        $default = config('filesystems.default');
        switch ($default) {
            case 'local':
            case 'public':
                return Storage::path($url);
            default:
                return Storage::url($url);
        }
    }
}
if (!function_exists('isUsingCloud')) {

    function isUsingCloud(): bool
    {
        return ! in_array(config('filesystems.default'), ['local', 'public']);
    }
}

if (!function_exists('get_image_table')) {
    /**
     * @param string $file
     * @param bool $toArray
     * @return bool|mixed
     */
    function get_image_table($id)
    {
        $photo = \Modules\Post\Http\Models\PostGallery::where('id', $id)->first();
        if($photo){
            return $photo->name;
        }else{
            return null;
        }

    }
}
if (!function_exists('slugs_data_set')) {
    /**
     * @param string|null $path
     * @return string
     */
    function slugs_data_set($key = null, $reference_id = null, $reference_type = null, $prefix = null): string
    {
        $slug                   = new Slug();
        $slug->key              = $key;
        $slug->reference_id     = $reference_id;
        $slug->reference_type   = $reference_type;
        $slug->prefix           = $prefix;
        $slug->save();
        return $slug;
    }
}
if (!function_exists('update_slug_table')) {
    /**
     * @param string|null $path
     * @return string
     */
    function update_slug_table($key = null, $reference_id = null, $reference_type = null, $prefix = null): string
    {
        $avoid_slug = Slug::where('reference_id', $reference_id)->Where('reference_type',$reference_type)->first();
        $check_slug = Slug::where('key', $key)
            ->where('id', '<>', $avoid_slug->id)
            ->first();
        if($check_slug == null){
            $slug                   = $key;
            $avoid_slug->key        = $slug;
            $avoid_slug->save();
        }else{
            $slug                   = $avoid_slug->createSlug($key);
            $avoid_slug->key        = $slug;
            $avoid_slug->save();
        }
        $menu_slug = MenusNode::where('reference_id', $reference_id)->Where('reference_type',$reference_type)->first();
        if($menu_slug){
            $menu_slug->url = $slug;
            $menu_slug->save();
        }
        return $slug;
    }
}

if (!function_exists('get_slug_table_data')) {
    /**
     * @param string|null $key
     * @param string $model
     * @param string $prefix
     * @return mixed
     */
    function get_slug_table_data($key = null, $model = null, $referenceId = null, $prefix = null)
    {
        $slug = SlugHelper::getSlug($key, SlugHelper::getPrefix($prefix),$model,$referenceId);

        return $slug;
    }
}
if (!function_exists('core_path')) {
    /**
     * @param string|null $path
     * @return string
     */
    function core_path($path = null): string
    {
        return platform_path('Modules/' . $path);
    }
}

if (!function_exists('getUploadPath')) {
    function getUploadPath(): string
    {
        return is_link(public_path('storage')) ? storage_path('app/public') : public_path('storage');
    }
}

if (!function_exists('setting')) {
    /**
     * Get the setting instance.
     *
     * @param string|null $key
     * @param string|null $default
     * @return array|\Modules\KamrulDashboard\Packages\Supports\SettingStore|string|null
     */
    function setting($key = null, $default = null)
    {
        if (!empty($key)) {
//            return $key;
//            return SettingDataF::get($key, $default);
            try {
//                return app(\Modules\KamrulDashboard\Packages\Supports\SettingStore::class)->get($key, $default);
                return SettingDataF::get($key, $default);
            } catch (Exception $exception) {
//                return $exception;
                return $default;
            }
        }

        return \Modules\KamrulDashboard\Packages\Facades\SettingFacade::getFacadeRoot();
    }
}

if (!function_exists('is_in_admin')) {
    /**
     * @param bool $force
     * @return bool
     */
    function is_in_admin($force = false): bool
    {
        $prefix = DboardHelper::getAdminPrefix();
        $segments = array_slice(request()->segments(), 0, count(explode('/', $prefix)));
        $isInAdmin = implode('/', $segments) === $prefix;
        return $force ? $isInAdmin : apply_filters(IS_IN_ADMIN_FILTER, $isInAdmin);
    }
}
if(! function_exists('scanFolder')) {
    function scanFolder($path, array $ignoreFiles = [])
    {
        try {
            if (File::isDirectory($path)) {
                $data = array_diff(scandir($path), array_merge(['.', '..', '.DS_Store'], $ignoreFiles));
                natsort($data);
                return $data;
            }

            return [];
        } catch (Exception $exception) {
            return [];
        }
    }
}
if(! function_exists('isAuthData')) {
    function isAuthData($data)
    {
        $get_data = Auth::user()->$data;
        return $get_data;
    }
}
if(! function_exists('get_user_role_user')) {
    function get_user_role_user()
    {
        $role = isAuthData('role');
        if ($role == 'user') {
            return 1;
        } else {
            return 0;
        }
    }
}
if(! function_exists('isDemo')) {
    function isDemo()
    {
        if (env('DEMO_MODE')) {
//        if ( in_array( GetIP(), [ '183.82.114.32', '171.49.252.45' ] ) ) {
//            return false;
//        } else {
            return true;
//        }
        } else {
            return false;
        }
    }
}
if(! function_exists('flash')) {
    function flash($title = null, $text = null, $type = 'info')
    {
        $flash = app('App\Http\Flash');

        if (func_num_args() == 0) {
            return $flash;
        }
        return $flash->$type($title, $text);
    }
}
if(! function_exists('getValidationError')) {
    function getValidationError($message)
    {
        $data = '<div id="val-username-error" class="invalid-feedback animated fadeInUp" style="display: block;">'. $message .'</div>';
        return $data;
    }
}
if(! function_exists('getValidationMessage')) {
    function getValidationMessage($key = 'required')
    {
//        return $key;
//    $message = '<div class="alert alert-danger" style="margin-top: 15px;">'. __('users::all_lang.this_field_is_required').'</div>';
        $message = '<div id="val-username-error" class="invalid-feedback animated fadeInUp" style="display: block;">' . __('kamruldashboard::all_lang.this_field_is_required') . '</div>';

        if ($key === 'required')
            return $message;
//    $message = '<div class="alert alert-danger" style="margin-top: 15px;">'
        switch ($key) {
            case 'minlength' :
                $message = '<div id="val-username-error" class="invalid-feedback animated fadeInUp" style="display: block;">'
                    . __('kamruldashboard::all_lang.the_text_is_too_short')
                    . '</div>';
                break;
            case 'maxlength' :
                $message = '<div id="val-username-error" class="invalid-feedback animated fadeInUp" style="display: block;">'
                    . __('kamruldashboard::all_lang.the_text_is_too_long')
                    . '</div>';
                break;
            case 'pattern' :
                $message = '<div id="val-username-error" class="invalid-feedback animated fadeInUp" style="display: block;">'
                    . __('kamruldashboard::all_lang.invalid_input')
                    . '</div>';
                break;
            case 'image' :
                $message = '<div id="val-username-error" class="invalid-feedback animated fadeInUp" style="display: block;">'
                    . __('kamruldashboard::all_lang.please_upload_valid_image_type')
                    . '</div>';
                break;
            case 'email' :
                $message = '<div id="val-username-error" class="invalid-feedback animated fadeInUp" style="display: block;">'
                    . __('kamruldashboard::all_lang.please_enter_valid_email')
                    . '</div>';
                break;
            case 'email_already' :
                $message = '<div id="val-username-error" class="invalid-feedback animated fadeInUp" style="display: block;">'
                    . __('kamruldashboard::all_lang.the_email_has_already_been_taken')
                    . '</div>';
                break;

            case 'number' :
                $message = '<div id="val-username-error" class="invalid-feedback animated fadeInUp" style="display: block;">'
                    . __('kamruldashboard::all_lang.please_enter_valid_number')
                    . '</div>';
                break;

            case 'confirmPassword' :
                $message = '<div id="val-username-error" class="invalid-feedback animated fadeInUp" style="display: block;">'
                    . __('kamruldashboard::all_lang.password_and_confirm_password_does_not_match')
                    . '</div>';
                break;
            case 'password' :
                $message = '<div id="val-username-error" class="invalid-feedback animated fadeInUp" style="display: block;">'
                    . __('kamruldashboard::all_lang.the_password_is_too_short')
                    . '</div>';
                break;
            case 'phone' :
                $message = '<div id="val-username-error" class="invalid-feedback animated fadeInUp" style="display: block;">'
                    . __('kamruldashboard::all_lang.please_enter_valid_phone_number')
                    . '</div>';
                break;
        }
        return $message;
    }
}
if(! function_exists('array_pluck')) {
    function array_pluck($array, $value, $key = null)
    {
        return Arr::pluck($array, $value, $key);
    }
}
if(! function_exists('array_status')) {
    function array_status(): array
    {
        $status = array(1 => 'Active', 0 => 'Inactive');
        return $status;
    }
}
if(! function_exists('payment_design_status')) {
    function payment_design_status(): array
    {
        $status = array('due' => 'Due', 'paid' => 'Paid');
        return $status;
    }
}
if(! function_exists('status_enum')) {
    function status_enum($set_data): array
    {
//        $status = array(1 => 'Active', 0 => 'Inactive');
        return $set_data::values();
    }
}
if(! function_exists('amount_type_select')) {
    function amount_type_select(): array
    {
        $status = array(1 => 'percentage', 2 => 'fixed_amount', 3 => 'code_line');
        return $status;
    }
}

if (! function_exists('get_status_design')) {
    function get_status_design(): array
    {
        return array(
            0 => Html::tag('span', __('In active'), ['class' => 'label-warning status-label'])->toHtml(),
            1 => Html::tag('span', __('Active'), ['class' => 'label-success status-label'])->toHtml(),
            2 => Html::tag('span', __('Pending'), ['class' => 'label-info status-label'])->toHtml(),
        );
    }
}
if (! function_exists('get_payment_status_design')) {
    function get_payment_status_design(): array
    {
        return array(
            'due' => Html::tag('span', __('Due'), ['class' => 'label-warning status-label'])->toHtml(),
            'paid' => Html::tag('span', __('Paid'), ['class' => 'label-success status-label'])->toHtml(),
        );
    }
}
if (! function_exists('get_is_default')) {
    function get_is_default(): array
    {
        return array(
            0 => Html::tag('span', __('UnDefault'), ['class' => 'label-warning status-label'])->toHtml(),
            1 => Html::tag('span', __('Default'), ['class' => 'label-success status-label'])->toHtml(),
        );
    }
}
if(! function_exists('amount_type_select_data')) {
    function amount_type_select_data($id , $lang = null)
    {
        $status = array(1 => 'percentage', 2 => 'fixed_amount', 3 => 'code_line');
        if($lang == null){
            return $status[$id];
        }else {
            return __('' . $lang . '::lang.' . $status[$id] . '');
        }
    }
}
if(! function_exists('array_select_field')) {
    function array_select_field($select = 1, $data = array(), $name, $md = 6, $level, $lang = 'kamruldeshboard', $multiple = '')
    {
//        $status = array_status();
        $id = str_replace("[","",$name);
        $id = str_replace("]","",$id);
        $html = '<div class="form-group col-md-' . $md . '">';
        $html .= '<label>' . $level . '</label>';
        $html .= '<select id="'.$id.'" name="'.$name.'" ' . $multiple . ' class="form-control">';
        if(is_array($select)){
            $select_data = array();
            foreach ($select as $value2){
                $select_data[$value2['id']] = $value2['id'];
            }
        }
        foreach ($data as $key => $value) {
            if(is_array($select)){
                $selected_data = array_search($key,$select_data);
                if($selected_data == $key){
                    $selected = 'selected';
                }else{
                    $selected = '';
                }
            }else{
                if ($select == $key) {
                    $selected = 'selected';
                } else {
                    $selected = '';
                }
            }

            $html .= '<option value="' . $key . '" ' . $selected . '>' . __($lang.$value) . '</option>';
        }
        $html .= '</select>';
        $html .= '</div>';
        return $html;
    }
}
if(! function_exists('select_category_code')) {
    function select_category_code($value='BASIC')
    {
//        $status = array(1 => 'percentage', 2 => 'fixed_amount', 3 => 'code_line');
        return $value;
    }
}
if(! function_exists('select_contract_code')) {
    function select_contract_code($value='BASIC')
    {
//        $status = array(1 => 'percentage', 2 => 'fixed_amount', 3 => 'code_line');
        return $value;
    }
}
if(! function_exists('status_design_html')) {
    function status_design_html($select = 1, $md = 6, $lang = 'Status')
    {
        $status = array_status();

//        dd($select);
        // If $select is an object of AdminWorkshopStatusEnum, extract the value
        if (is_object($select) && method_exists($select, 'value')) {
            $select = $select->value();
        }

        $html = '<div class="form-group col-md-' . $md . '">';
        $html .= '<label>' . $lang . '</label>';
        $html .= '<select id="status" name="status" class="form-control">';

        foreach ($status as $key => $value) {
            $selected = ($select == $key) ? 'selected' : '';
            $html .= '<option value="' . $key . '" ' . $selected . '>' . $value . '</option>';
        }

        $html .= '</select>';
        $html .= '</div>';

        return $html;
    }
}
if(! function_exists('status_admin_enum')) {
    function status_admin_enum($select = 1, $md = 6, $lang = null, $enum_status = '')
    {
//        $tes = \Modules\AdminBoard\Enums\AdminWorkshopStatusEnum::values();
//        dd($tes);
        $status = $enum_status::labels();
//        dd($status);
        // If $select is an object of AdminWorkshopStatusEnum, extract the value
        if (is_object($select) && method_exists($select, 'value')) {
            $select = $select->value();
        }

        $html = '<div class="form-group col-md-' . $md . '">';
        if($lang != null) {
            $html .= '<label>' . __($lang . '.status') . '</label>';
        }
        $html .= '<select id="status" name="status" class="form-control">';

        foreach ($status as $key => $value) {
            $selected = ($select == $key) ? 'selected' : '';
            $html .= '<option value="' . $key . '" ' . $selected . '>' . $value . '</option>';
        }

        $html .= '</select>';
        $html .= '</div>';

        return $html;
    }
}
if(! function_exists('epmlpyee_list_html')) {
    function epmlpyee_list_html($emp_list)
    {
//        $emp_lists = json_decode($emp_list);
        $html = '';
        foreach ($emp_list as $key => $value) {
            $epmlpyee = \Modules\Employee\Http\Models\Employee::where('id',$value)->first();
            $html .= '<div class="row" id="' . $value . '">' .
                '<div class=" col-md-5">' .
                '<input type="hidden" name="emp_data_list[]" value="' . $value . '">' .
                $epmlpyee->name . '</div>' .
                '<div class=" col-md-5">' .
                $epmlpyee->email . '</div>' .
                '<div class=" col-md-2">' .
                '<i class="fa fa-trash" style="color: red;" onclick="trashTable(' . $value . ')"></i>' .
                '</div>' .
                '</div>';
        }
        return $html;
    }
}
if(! function_exists('check_odd_even')) {
    function check_odd_even($number){
        if($number % 2 == 0){
            return "Even";
        }
        else{
            return "Odd";
        }
    }
}
if(! function_exists('select_design_html')) {
    function select_design_html($select = 1, $data = array(), $name, $md = 6, $lang = 'Status')
    {
//    $status = array_status();
        $html = '<div class="form-group col-md-' . $md . '">';
        $html .= '<label>' . $lang . '</label>';
        $html .= '<select id="' . $name . '" name="' . $name . '" class="form-control">';
        $array_list = [
            '1' => 'role_id',
            '2' => 'salary_rule_categories_id',
            '3' => 'employee_id',
            '4' => 'bank_id',
            '5' => 'designation_id',
            '6' => 'department_id',
            '7' => 'employee_category_id',
            '8' => 'salary_structure_id',
            '9' => 'post_types_id',
            '10' => 'page_templates_id',
        ];
        if(!array_search($name,$array_list)) {
            $html .= '<option value="0">' . __('kamruldashboard::lang.none') . '</option>';
        }
        foreach ($data as $key => $value) {
            if ($select == $value->id) {
                $selected = 'selected';
            } else {
                $selected = '';
            }
            $html .= '<option value="' . $value->id . '" ' . $selected . '>' . $value->name . '</option>';
        }
        $html .= '</select>';
        $html .= '</div>';
        return $html;
    }
}
if(! function_exists('checkbox_design_html')) {
    function checkbox_design_html($select, $data = array(), $name, $md = 6, $lang = 'Status')
    {
        $selected = 0;
        $selectedp = array();

        if(!empty($select)) {
            if (is_array($select)) {
//                dd($select);
                foreach ($select as $key1 => $value1) {
                    $selectedp[$value1] = $value1;
                }
            } else {
                foreach ($select as $key1 => $value1) {
                    $selectedp[$value1->id] = $value1->id;
                }
            }
        }
        $check = ' checked ';
        $html = '';
        $html .= '<div class="form-group col-md-' . $md . '">';
        if (is_array($data)) {

            foreach ($data as $key => $value) {
                $selected_data = array_search($key,$selectedp);
                if($selected_data == $key){
                    $selected = 1;
                }else{
                    $selected = 0;
                }
                $html .= '<div class="checkbox">
                      <label>';
                $html .= '<input type="checkbox" name="' . $name . '" value="' . $key . '" class="input-icheck" '. (($selected != 0) ? $check : '') .' > ' . $value . '';
                $html .= '    </label>
                  </div>';
            }
        } else {

            foreach ($data as $key => $value) {
                $selected_data = array_search($value->id,$selectedp);
                if($selected_data == $value->id){
                    $selected = 1;
                }else{
                    $selected = 0;
                }
                $html .= '<div class="checkbox">
                      <label>';
                $html .= '<input type="checkbox" name="' . $name . '" value="' . $value->id . '" class="input-icheck" '. (($selected != 0) ? $check : '') .' > ' . $value->name . '';
                $html .= '    </label>
                  </div>';
            }
        }
        $html .= '</div>';
        return $html;
    }
}

if (! function_exists('get_blog_with_children')) {
    function get_blog_with_children($post_type = 'None'): array
    {
        $categories = app(CategoryInterface::class)
            ->allBy(['status' => DboardStatus::PUBLISHED], [], ['id', 'name', 'parent_id']);

        return app(SortItemsWithChildrenHelper::class)
            ->setChildrenProperty('child_cats')
            ->setItems($categories)
            ->sort();
    }
}
if (!function_exists('convert_options_to_attributes')) {
    /**
     * Convert an associative array to HTML attributes.
     *
     * @param array $options
     * @return string
     */
    function convert_options_to_attributes(array $options): string
    {
        $attributes = '';
        foreach ($options as $key => $value) {
            $attributes .= $key . '="' . $value . '" ';
        }

        return rtrim($attributes);
    }
}
if (!function_exists('getBlogRecentPosts')) {
    function getBlogRecentPosts($post, $limit=5)
    {

        $posts = app(PostInterface::class)->advancedGet([
            'condition' => ['status' => DboardStatus::PUBLISHED,'post_types_id'=>$post->post_types_id],
            'with' => ['slugable'],
            'order_by' => ['created_at' => 'desc'],
            'paginate' => [
                'per_page' => $limit,
                'current_paged' => 1,
            ],
        ]);

        return $posts->reject(function ($item) use ($post) {
            return $item->id == $post->id;
        }); //->skip(1)
    }
}
if (! function_exists('render_editor')) {
    function render_editor(
        string $name,
        ?string $value = null,
        bool $withShortCode = false,
        array $attributes = []
    ): string {
        return (new Editor())->registerAssets()->render($name, $value, $withShortCode, $attributes);
    }
}
if(! function_exists('pluralize')) {
    function pluralize($singular, $plural = null)
    {
        if (!strlen($singular)) return $singular;
        if ($plural !== null) return $plural;

        $singular = singularize($singular);
        $last_letter = strtolower($singular[strlen($singular) - 1]);

        if ($last_letter === 's' || $last_letter === 'x' || $last_letter === 'z' || $last_letter === 'o') {
            return $singular . 'es';
        }
        if (substr($singular, -2) === 'ch' || substr($singular, -2) === 'sh') {
            return $singular . 'es';
        }
        if ($last_letter === 'y') {
            return substr($singular, 0, -1) . 'ies';
        }
        return $singular . 's';
    }
}
if(! function_exists('lara_models')) {
    function lara_models($string)
    {
        $new_value = '';
        $pieces = preg_split('/(?=[A-Z])/', $string);
        foreach ($pieces as $key => $piece) {
            if ($key != 0)
                $new_value .= '_' . $piece;
        }
        $new_value = substr($new_value, 1);
        return $new_value;
    }
}
if(! function_exists('singularize')) {
    function singularize($plural, $singular = null)
    {
        if (!strlen($plural)) return $plural;
        if ($singular !== null) return $singular;

        $lan = strlen($plural);
        $last_letter = strtolower(substr($plural, $lan - 3));
        $last_letter1 = strtolower(substr($plural, $lan - 1));
        switch ($last_letter) {
            case 'ies':
                return substr($plural, 0, -3) . 'y';
            case 'ses':
                return substr($plural, 0, -2);
            default:
                if ($last_letter1 == 's')
                    return substr($plural, 0, -1);
                return $plural;
        }
    }
}
if(! function_exists('status_design_html_disable')) {
    function status_design_html_disable($select = 1, $md = 6)
    {
        $status = array_status();
        $html = '<div class="form-group col-md-' . $md . '">';
        $html .= '<label>' . __('kamruldashboard::all_lang.status') . '</label>';
        $html .= '<select id="status" name="status" class="form-control" readonly>';
//    foreach ($status as $key => $value){
//        if($select == $key){
//            $selected = 'selected';
//        }else{
//            $selected = '';
//        }
        $html .= '<option value="1">Active</option>';
//    }
        $html .= '</select>';
        $html .= '</div>';
        return $html;
    }
}
if(! function_exists('input_design_html')) {
    function input_design_html($name, $record = null, $md = 6, $type = 'input', $lang = '')
    {
        if ($record != null) {
            $selected = $record->$name;
        } else {
            $selected = old($name);
        }
        if ($lang == '') {
            $lang = $name;
        }
//        else {
//            $lang = $lang;
//        }
        $status = array_status();
        $html = '<div class="form-group col-md-' . $md . '" id="' . $name . '">';
        $html .= '<label>' . $lang . '</label>';
        if ($type == 'input') {
            $html .= '<input type="text" id="' . $name . '" name="' . $name . '" value="' . $selected . '" class="form-control" placeholder="' . $lang . '">';
        } elseif ($type == 'file') {
            $html .= '<div class="custom-file">';
            $html .= '<input id="' . $name . '" name="' . $name . '" type="file" class="custom-file-input" value="' . $selected . '"><label class="custom-file-label">Choose file</label>';
            $html .= '</div>';
        } else {
            $html .= '<input type="text" id="' . $name . '" name="' . $name . '" value="' . $selected . '" class="form-control" placeholder="' . $lang . '">';
        }
//    $validator = Session::get($name);
//    if($validator->fails()) {
//        getValidationMessage();
//    }
   $html .=  '</div>';
        return $html;
    }
}
if(! function_exists('array_condition_disign')) {
    function array_condition_disign($select)
    {
        if ($select == 'section_one') {
            $status_set = '<a href="javascript:void(\'#\')" class="badge badge-rounded badge-dark">Section One</a>';
        } elseif ($select == 'section_video') {
            $status_set = '<a href="javascript:void(\'#\')" class="badge badge-rounded badge-dark">Section Video</a>';
        } elseif ($select == 'section_tutorial') {
            $status_set = '<a href="javascript:void(\'#\')" class="badge badge-rounded badge-dark">Section Tutorial</a>';
        } else {
            $status_set = '<a href="javascript:void(\'#\')" class="badge badge-rounded badge-warning">Null</a>';
        }
        return $status_set;
    }
}
if(! function_exists('array_status_disign')) {
    function array_status_disign($status)
    {
        if ($status == 1) {
            $status_set = '<a href="javascript:void(\'#\')" class="badge badge-rounded badge-primary">Active</a>';
        } elseif ($status == 0) {
            $status_set = '<a href="javascript:void(\'#\')" class="badge badge-rounded badge-danger">Inactive</a>';
        } else {
            $status_set = '<a href="javascript:void(\'#\')" class="badge badge-rounded badge-warning">Inactive</a>';
        }
        return $status_set;
    }
}
if(! function_exists('array_status_set_value')) {
    function array_status_set_value($status,$data)
    {
        foreach ($data as $key => $value) {
            if ($status == $value) {
                $status_set = '<a href="javascript:void(\'#\')" class="badge badge-rounded badge-primary">'.$value.'</a>';
                return $status_set;
            }else{
                $status_set = '<a href="javascript:void(\'#\')" class="badge badge-rounded badge-warning">'.$value.'</a>';
                return $status_set;
            }
        }
//        if ($status == 1) {
//            $status_set = '<a href="javascript:void(\'#\')" class="badge badge-rounded badge-primary">Active</a>';
//        } elseif ($status == 0) {
//            $status_set = '<a href="javascript:void(\'#\')" class="badge badge-rounded badge-danger">Inactive</a>';
//        } else {
//            $status_set = '<a href="javascript:void(\'#\')" class="badge badge-rounded badge-warning">Inactive</a>';
//        }
//        return $status_set;
    }
}
if(! function_exists('array_status_disign_v2')) {
    function array_status_disign_v2($status)
    {
        if ($status == 1) {
            $status_set = '<a href="javascript:void(\'#\')" class="badge badge-rounded badge-primary">Successfully</a>';
        } elseif ($status == 0) {
            $status_set = '<a href="javascript:void(\'#\')" class="badge badge-rounded badge-warning">Pending</a>';
        } else {
            $status_set = '<a href="javascript:void(\'#\')" class="badge badge-rounded badge-danger">Cancel</a>';
        }
        return $status_set;
    }
}
if(! function_exists('array_status_disign_name')) {
    function array_status_disign_name($status)
    {
        if ($status == 1) {
            $status_set = 'Active';
        } elseif ($status == 0) {
            $status_set = 'Inactive';
        } else {
            $status_set = 'Inactive';
        }
        return $status_set;
    }
}
if(! function_exists('array_status_disign_name_v2')) {
    function array_status_disign_name_v2($status)
    {
        if ($status == 1) {
            $status_set = 'Successfully';
        } elseif ($status == 0) {
            $status_set = 'Pending';
        } else {
            $status_set = 'Cancel';
        }
        return $status_set;
    }
}
if(! function_exists('site_information')) {
    function site_information($row, $file = '')
    {
//    $get_info = \Kamrul\Settings\Models\Settings::where('id',1)->first();
        if ($file == 'file') {
            return '#';
//        return 'uploads/settings/'.$get_info->$row;
        } else {
            return 'Kamrul';
//        return $get_info->$row;
        }
    }
}
//function photo_url($row, $path, $table, $photo)
//{
////    $get_info = DB::table($table)->find($id);
//    return 'uploads/'. $path. '/' . $photo;
//}
if(! function_exists('photo_url')) {
    function photo_url($path, $photo)
    {
//    $get_info = DB::table($table)->find($id);
        return 'uploads/' . $path . '/' . $photo;
    }
}
if(! function_exists('string_capital')) {
    function string_capital($key)
    {
        if (env('DEMO_MODE')) {
            return;
        }
        $key = ucwords($key, "_");
        $key = Str::replace('_', ' ', $key);
        return $key;
    }
}
if(! function_exists('deleteFile')) {
    function deleteFile($record, $path, $is_array = FALSE)
    {
        if (env('DEMO_MODE')) {
            return;
        }

        $files = array();
        $files[] = $path . $record;
        File::delete($files);
    }
}
if(! function_exists('documentProcessUpload')) {
    function documentProcessUpload($request, $record, $file_name, $path)
    {
        if (env('DEMO_MODE')) {
            return;
        }
        if ($request->hasFile($file_name)) {
            $destinationPath = $path;
            $fileInfo = $request->$file_name->getClientOriginalName();
            $filename = pathinfo($fileInfo, PATHINFO_FILENAME);
            $fileName = $filename . '-' . time() .  '.' . $request->$file_name->guessClientExtension();
            $request->file($file_name)->move($destinationPath, $fileName);
            //Save Normal Image with 300x300    fit($examSettings->imageSize)->
//            $img = Image::make($destinationPath . $fileName);
//            $img->insert('/home/kamrul/php/laravel/lara_cms/public/uploads/post/kamrul.png');
//            $img->crop(100, 100, 25, 25);
//            $img->resize(100, 100);
//            $img->flip('h');
//            $img->save($destinationPath . 'll-' . $fileName);
            return $fileName;
        }
    }
}
if(! function_exists('processUpload')) {
    function processUpload($request, $record, $file_name = 'photo', $path)
    {
        if (env('DEMO_MODE')) {
            return;
        }
        if ($request->hasFile($file_name)) {
            $destinationPath = $path;

            if(!is_dir(public_path($destinationPath))){
                mkdir(public_path($destinationPath), 0777, true);
                chmod(public_path($destinationPath), 0777);
            }
//            $fileName = $record->id . '-' . $file_name . '.' . $request->$file_name->guessClientExtension();
//            $fileName = $request->$file_name->getClientOriginalName();// . $request->$file_name->guessClientExtension();
            $fileInfo = $request->$file_name->getClientOriginalName();
            $filename = pathinfo($fileInfo, PATHINFO_FILENAME);

            $fileName_new = $filename . '-' . time() . '.webp';
            $img = Image::make($request->file($file_name));
            $img->insert($request->file($file_name));
            $img->encode('webp', 90);
            $img->save($destinationPath . $fileName_new);
            return $fileName_new;
        }
    }
}
if(! function_exists('processUploadParameters')) {
    function processUploadParameters($request, $record, $file_name = 'photo', $path)
    {
        if (env('DEMO_MODE')) {
            return;
        }
        if ($request->hasFile($file_name)) {
            $destinationPath = $path;

            $fileInfo = $request->$file_name['value']->getClientOriginalName();
            $filename = pathinfo($fileInfo, PATHINFO_FILENAME);
            $fileName_new = $filename . '-' . time() . '.webp';
            $img = Image::make($request->file($file_name)['value']);
            $img->insert($request->file($file_name)['value']);
            $img->encode('webp', 90);
            $img->save($destinationPath . $fileName_new);
            return $fileName_new;
        }
    }
}
if(! function_exists('processUpload_update')) {
    function processUpload_update($request, $file_name = 'value', $path) {
        if (env('DEMO_MODE')) {
            return;
        }
        if ($request->hasFile($file_name)) {
            $destinationPath = $path;
            $patha = $_FILES[$file_name]['name'];
            $ext = pathinfo($patha['value'], PATHINFO_EXTENSION);
            $fileName = $file_name . '-' . Str::random(15) . '.' . $ext;
            move_uploaded_file($_FILES[$file_name]['tmp_name']['value'], $destinationPath . $fileName);
            return $fileName;
        }
    }
}
if(! function_exists('getArrayFromJson')) {
    function getArrayFromJson($jsonData)
    {
        $result = array();
        if ($jsonData) {
            foreach (json_decode($jsonData) as $key => $value)
                $result[$key] = $value;
        }
        return $result;
    }
}
/**
 * This method fetches the specified key in the type of setting
 * @param  [type] $key          [description]
 * @param  [type] $setting_type [description]
 * @return [type]               [description]
 */
if(! function_exists('getSetting')) {
    function getSetting($key, $setting_type, $default = ' ')
    {

        $name = Setting::getSetting($key, $setting_type);
        if(!empty($name)){
            return $name;
        }else{
            return $default;
        }
    }
}

if(! function_exists('hasRole')) {
    function hasRole($user_id)
    {
        $data = array();
        $user = \Modules\KamrulDashboard\Http\Models\User::find($user_id);
        foreach ($user->role->permission as $key=>$value){
            $data[$key] = $value->name;
        }
        return $data;
    }
}

if(! function_exists('kamrul_module_path')) {
    function kamrul_module_path($name, $path)
    {
        $DIRECTORY = __DIR__ . '/../';
        return $DIRECTORY . $path;
    }
}

if (! function_exists('updateEnv')) {
    function updateEnv($data = array())
    {
        if (!count($data)) {
            return;
        }

        $pattern = '/([^\=]*)\=[^\n]*/';

        $envFile = base_path() . '/.env';
        $lines = file($envFile);
        $newLines = [];
        foreach ($lines as $line) {
            preg_match($pattern, $line, $matches);

            if (!count($matches)) {
                $newLines[] = $line;
                continue;
            }

            if (!key_exists(trim($matches[1]), $data)) {
                $newLines[] = $line;
//                echo '<>'. $line . '<>';
                continue;
            }
//            else{
//                echo '<>'. $line . '<>';
//            }

            $line = trim($matches[1]) . "={$data[trim($matches[1])]}\n";
            $newLines[] = $line;
        }
        foreach ($data as $key=>$value) {
            $line2 = trim($key) . "=".trim($value)."\n";
            if(!array_search($line2,$newLines)){
                $newLines[] = $line2;
            }
        }

        $newContent = implode('', $newLines);
        file_put_contents($envFile, $newContent);
    }
}
//if (! function_exists('updateEnvironmentFile')) {
//    function updateEnvironmentFile($data = array())
//    {
//        if(count($data)>0) {
//            $env = file_get_contents(base_path() . '/.env');
//            $env = preg_split('/\s+/', $env);
//
//            foreach((array)$data as $key => $value){
//
//                // Loop through .env-data
//                foreach($env as $env_key => $env_value){
//
//                    // Turn the value into an array and stop after the first split
//                    // So it's not possible to split e.g. the App-Key by accident
//                    $entry = explode("=", $env_value, 2);
//
//                    // Check, if new key fits the actual .env-key
//                    if($entry[0] == $key){
//                        // If yes, overwrite it with the new one
//                        $env[$env_key] = $key . "=" . $value;
//                    } else {
//                        // If not, keep the old one
//                        $env[$env_key] = $env_value;
//                    }
//                }
//            }
//            $env = implode("\n", $env);
//            file_put_contents(base_path() . '/.env', $env);
//            return TRUE;
//        }
//        else
//        {
//            return FALSE;
//        }
//
//    }
//}

if (! function_exists('get_admin_email')) {
    function get_admin_email(): \Illuminate\Support\Collection
    {
        $email = setting('admin_email');

        if (! $email) {
            return collect();
        }

        $email = is_array($email) ? $email : (array)json_decode($email, true);

        return collect(array_filter($email));
    }
}
if (! function_exists('get_setting_email_status_key')) {
    function get_setting_email_status_key(string $type, string $module, string $templateKey): string
    {
        return $type . '_' . $module . '_' . $templateKey . '_' . 'status';
    }
}
if (! function_exists('get_setting_email_status')) {
    function get_setting_email_status(string $type, string $module, string $templateKey): string
    {
        $default = config($type . '.' . $module . '.email.templates.' . $templateKey . '.enabled', true);

        return setting(get_setting_email_status_key($type, $module, $templateKey), $default);
    }
}
if (! function_exists('get_setting_email_template_content')) {
    function get_setting_email_template_content(string $type, string $module, string $templateKey): string
    {
        $defaultPath = platform_path($type . '/' . $module . '/Resources/email-templates/' . $templateKey . '.tpl');
        $storagePath = get_setting_email_template_path($module, $templateKey);

        if ($storagePath != null && File::exists($storagePath)) {
            return DboardHelper::getFileData($storagePath, false);
        }
        return File::exists($defaultPath) ? DboardHelper::getFileData($defaultPath, false) : '';
    }
}
if (! function_exists('get_setting_email_template_path')) {
    function get_setting_email_template_path(string $module, string $templateKey): string
    {
        return storage_path('app/email-templates/' . $module . '/' . $templateKey . '.tpl');
    }
}
if (! function_exists('get_setting_email_subject_key')) {
    function get_setting_email_subject_key(string $type, string $module, string $templateKey): string
    {
        return $type . '_' . $module . '_' . $templateKey . '_subject';
    }
}

if (! function_exists('get_setting_email_subject')) {
    function get_setting_email_subject(string $type, string $module, string $templateKey): string
    {
        return setting(
            get_setting_email_subject_key($type, $module, $templateKey),
            trans(
                config(
                    $type . '.' . $module . '.email.templates.' . $templateKey . '.subject',
                    ''
                )
            )
        );
    }
}
