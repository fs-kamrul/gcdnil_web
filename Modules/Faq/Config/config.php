<?php

return [
    'name' => 'Faq',
    'module_version' => "1.0",
    'module_type' => "plugin",
    'pid' => 22,
    'schema_supported' => [
        'Modules\Post\Http\Models\Page',
        'Modules\Post\Http\Models\Post',
    ],
    'use_language_v2' => env('FAQ_USE_LANGUAGE_VERSION_2', false),
];


