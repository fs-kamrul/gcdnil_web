<?php

use Modules\SimpleSlider\Repositories\Interfaces\SimpleSliderInterface;
use Illuminate\Database\Eloquent\Collection;

if (! defined('SIMPLESLIDER_MODULE_SCREEN_NAME')) {
    define('SIMPLESLIDER_MODULE_SCREEN_NAME', 'simpleslider');
}
if (! defined('SIMPLE_SLIDER_MODULE_SCREEN_NAME')) {
    define('SIMPLE_SLIDER_MODULE_SCREEN_NAME', 'simple-slider');
}

if (! defined('SIMPLE_SLIDER_ITEM_MODULE_SCREEN_NAME')) {
    define('SIMPLE_SLIDER_ITEM_MODULE_SCREEN_NAME', 'simple-slider-item');
}

if (! defined('SIMPLE_SLIDER_VIEW_TEMPLATE')) {
    define('SIMPLE_SLIDER_VIEW_TEMPLATE', 'simple-slider-view-template');
}
//add_next_line

if (! function_exists('get_all_simple_sliders')) {
    function get_all_simple_sliders(array $condition = []): Collection
    {
        return app(SimpleSliderInterface::class)->allBy($condition);
    }
}

if (!function_exists('getLanguageUrlSlider')) {
    /**
     * @param string|null $path
     * @return string
     */
    function getLanguageUrlSlider($id, $url)
    {
        $active_lang = Language::getCurrentLocaleCode();
        $ref_lang = Language::getCurrentAdminLocaleCode();
        if($active_lang == $ref_lang){
            $add_url['url'] = route($url . '.edit' . '.update', $id);
            $add_url['code_edit'] = 1;
            $add_url['code'] = $ref_lang;
        }else{
            $add_url['url'] = route('language-advanced.save', $id) . '?ref_lang=' . $ref_lang;
            $add_url['code_edit'] = 0;
            $add_url['code'] = $ref_lang;
        }
        return $add_url;
    }
}
