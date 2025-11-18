<?php

return [
    'name' => 'Theme',
    'module_version' => "1.0",
    'module_type' => "plugin",
    'pid' => 84,
    'public_theme_name' => env('THEME_PUBLIC_NAME'),
    'events' => [],
    'containerDir' => [
        'layout'  => 'layouts',
        'asset'   => '',
        'partial' => 'partials',
        'view'    => 'views',
    ],
    'themeDefault' => 'default',
    'themeDir' => 'themes',
    'display_theme_manager_in_admin_panel' => env('CMS_THEME_DISPLAY_THEME_MANAGER_IN_ADMIN_PANEL', true),
];

