<?php

if (!defined('LANGUAGE_ADVANCED_ACTION_SAVED')) {
    define('LANGUAGE_ADVANCED_ACTION_SAVED', 'language-advanced-saved');
}

if (!defined('LANGUAGE_ADVANCED_MODULE_SCREEN_NAME')) {
    define('LANGUAGE_ADVANCED_MODULE_SCREEN_NAME', 'language-advanced');
}

if (!function_exists('getLanguageUrlPost')) {
    /**
     * @param string|null $path
     * @return string
     */
    function getLanguageUrlPost($id, $url)
    {
        $active_lang = Language::getCurrentLocaleCode();
        $ref_lang = Language::getCurrentAdminLocaleCode();
        if($active_lang == $ref_lang){
            $add_url['url'] = route($url . '.edit' . $url . '.update', $id);
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
