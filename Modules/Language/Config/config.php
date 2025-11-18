<?php

return [
    'name' => 'Language',
    'module_version' => "1.0",
    'module_type' => "plugin",
    'pid' => 60,
    // List supported modules or plugins
    'supported'              => [
        'Modules\Post\Http\Models\Page',
        'Modules\Menus\Http\Models\Menus',
        'Modules\Menus\Http\Models\MenusLocation',
    ],
    'hideDefaultLocaleInURL' => env('LANGUAGE_HIDE_DEFAULT_LOCALE_IN_URL', true),

    'localesMapping' => [],
];

