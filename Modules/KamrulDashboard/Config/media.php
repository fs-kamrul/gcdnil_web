<?php

return [
    'sizes' => [
        'thumb' => '150x150',
    ],
    'permissions' => [
        'folders.create',
        'folders.edit',
        'folders.trash',
        'folders.destroy',
        'files.create',
        'files.edit',
        'files.trash',
        'files.destroy',
        'files.favorite',
        'folders.favorite',
    ],
    'libraries' => [
        'stylesheets' => [
            'vendor/Modules/KamrulDashboard/libraries/jquery-context-menu/jquery.contextMenu.min.css',
            'vendor/Modules/KamrulDashboard/css/media.css?v=' . time(),
        ],
        'javascript' => [
            'vendor/Modules/KamrulDashboard/libraries/lodash/lodash.min.js',
            'vendor/Modules/KamrulDashboard/libraries/clipboard/clipboard.min.js',
            'vendor/Modules/KamrulDashboard/libraries/dropzone/dropzone.js',
            'vendor/Modules/KamrulDashboard/libraries/jquery-context-menu/jquery.ui.position.min.js',
            'vendor/Modules/KamrulDashboard/libraries/jquery-context-menu/jquery.contextMenu.min.js',
            'vendor/Modules/KamrulDashboard/js/media.js?v=' . time(),
        ],
    ],
    'allowed_mime_types' => env(
        'DIGITAL_PRODUCT_ALLOWED_MIME_TYPES',
        'jpg,jpeg,png,gif,txt,docx,zip,mp3,bmp,csv,xls,xlsx,ppt,pptx,pdf,mp4,doc,mpga,wav,webp'
    ),
    'mime_types' => [
        'image' => [
            'image/png',
            'image/jpeg',
            'image/gif',
            'image/bmp',
            'image/svg+xml',
            'image/webp',
        ],
        'video' => [
            'video/mp4',
        ],
        'document' => [
            'application/pdf',
            'application/vnd.ms-excel',
            'application/excel',
            'application/x-excel',
            'application/x-msexcel',
            'text/plain',
            'application/msword',
            'text/csv',
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'application/vnd.ms-powerpoint',
            'application/vnd.openxmlformats-officedocument.presentationml.presentation',
        ],
    ],
    'default_image' => env('DBOARD_MEDIA_DEFAULT_IMAGE', '/vendor/Modules/KamrulDashboard/images/placeholder.png'),
    'sidebar_display' => env('DBOARD_MEDIA_SIDEBAR_DISPLAY', 'horizontal'), // Use "vertical" or "horizontal"
    'watermark' => [
        'enabled' => env('DBOARD_MEDIA_WATERMARK_ENABLED', 0),
        'source' => env('DBOARD_MEDIA_WATERMARK_SOURCE'),
        'size' => env('DBOARD_MEDIA_WATERMARK_SIZE', 10),
        'opacity' => env('DBOARD_MEDIA_WATERMARK_OPACITY', 70),
        'position' => env('DBOARD_MEDIA_WATERMARK_POSITION', 'bottom-right'),
        'x' => env('DBOARD_MEDIA_WATERMARK_X', 10),
        'y' => env('DBOARD_MEDIA_WATERMARK_Y', 10),
    ],

    'chunk' => [
        'enabled' => env('DBOARD_MEDIA_UPLOAD_CHUNK', false),
        'chunk_size' => 1024 * 1024, // Bytes
        'max_file_size' => 1024 * 1024, // MB

        /*
         * The storage config
         */
        'storage' => [
            /*
             * Returns the folder name of the chunks. The location is in storage/app/{folder_name}
             */
            'tmp' => 'tmp',
            'chunks' => 'chunks',
            'disk' => 'local',
        ],
        'clear' => [
            /*
             * How old chunks we should delete
             */
            'timestamp' => '-3 HOURS',
            'schedule' => [
                'enabled' => true,
                'cron' => '25 * * * *', // run every hour on the 25th minute
            ],
        ],
        'chunk' => [
            // setup for the chunk naming setup to ensure same name upload at same time
            'name' => [
                'use' => [
                    'session' => true, // should the chunk name use the session id? The uploader must send cookie!,
                    'browser' => false, // instead of session we can use the ip and browser?
                ],
            ],
        ],
    ],

    'preview' => [
        'document' => [
            'enabled' => env('DBOARD_MEDIA_DOCUMENT_PREVIEW_ENABLED', true),
            'default' => env('DBOARD_MEDIA_DOCUMENT_PREVIEW_PROVIDER', 'microsoft'),
            'type' => env('DBOARD_MEDIA_DOCUMENT_PREVIEW_TYPE', 'iframe'),          // use iframe or popup
            'mime_types' => [
                'application/pdf',
                'application/vnd.ms-excel',
                'application/excel',
                'application/x-excel',
                'application/x-msexcel',
                'application/msword',
                'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                'application/vnd.ms-powerpoint',
                'application/vnd.openxmlformats-officedocument.presentationml.presentation',
                'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            ],
        ],
    ],
    'default_upload_url' => env('DBOARD_MEDIA_DEFAULT_UPLOAD_URL', url('storage')),
    'generate_thumbnails_enabled' => env('DBOARD_MEDIA_GENERATE_THUMBNAILS_ENABLED', true),
];
