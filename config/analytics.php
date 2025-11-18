<?php

return [
    'name'                      => 'Analytics',
    'module_version'            => "1.0",
    'module_type'               => "plugin",
    'pid'                       => 98,
    'view_id'                   => env('ANALYTICS_VIEW_ID'),
    'cache_lifetime_in_minutes' => env('ANALYTICS_CACHE_TIME', 60 * 24),
    'cache'                     => [
        'store' => 'file',
    ],
    'enabled_dashboard_widgets' => env('ANALYTICS_ENABLE_DASHBOARD_WIDGETS', true),
];

