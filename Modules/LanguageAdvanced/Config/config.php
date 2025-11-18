<?php

return [
    'name' => 'LanguageAdvanced',
    'module_version' => "1.0",
    'module_type' => "plugin",
    'pid' => 46,
    'supported'               => [],
    'translatable_meta_boxes' => ['language_advanced_wrap', 'seo_wrap'],
    'page_use_language_v2'    => env('PAGE_USE_LANGUAGE_VERSION_2', false),
    'post_use_language_v2'    => env('POST_USE_LANGUAGE_VERSION_2', false),
    'category_use_language_v2'=> env('CATEGORY_USE_LANGUAGE_VERSION_2', false),
];

