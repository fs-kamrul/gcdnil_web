<?php

return [
    'name' => 'Sitemap',
    'module_version' => "1.0",
    'module_type' => "plugin",
    'pid' => 50,
    'use_cache'       => false,
    'cache_key'       => 'cms-sitemap.' . config('app.url'),
    'cache_duration'  => 3600,
    'escaping'        => true,
    'use_limit_size'  => false,
    'max_size'        => null,
    'use_styles'      => true,
    'styles_location' => '/vendor/sitemap/styles/',
    'use_gzip'        => false,
];

