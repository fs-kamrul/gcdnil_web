<?php
/**
 * Date: 22/07/2015
 * Time: 8:11 PM
 */

return [
    'offline'        => env('ASSETS_OFFLINE', true),
    'enable_version' => env('ASSETS_ENABLE_VERSION', true),
    'version'        => env('ASSETS_VERSION', get_cms_version()),
    'scripts'        => [
        'global',
        'quixnav-init',
        'custom',
        'select2',
        'datepicker',
        'app',
        'toastr',
        'toastr_script',
        'language-global',
    ],
    'styles'         => [
        'color_picker',
        'style',
        'font-icons',
        'toastr_css',
        'select2',
        'datepicker',
        'waypoints',
        'style_custom',
        'language',
    ],
    'resources'      => [
        'scripts' => [
            'toastr'       => [
                'use_cdn'  => false,
                'location' => 'footer',
                'src'      => [
                    'local' => '/vendor/Modules/KamrulDashboard/vendor/toastr/js/toastr.min.js',
                ],
            ],
            'toastr_script' => [
                'use_cdn'  => false,
                'location' => 'footer',
                'src'      => [
                    'local' => '/vendor/Modules/KamrulDashboard/js/toastr_script.js',
                ],
            ],
            'global'               => [
                'use_cdn'  => false,
                'location' => 'footer',
                'src'      => [
                    'local' => '/vendor/Modules/KamrulDashboard/vendor/global/global.min.js',
                ],
            ],
            'quixnav-init'               => [
                'use_cdn'  => false,
                'location' => 'footer',
                'src'      => [
                    'local' => '/vendor/Modules/KamrulDashboard/js/quixnav-init.js',
                ],
            ],
            'custom'               => [
                'use_cdn'  => false,
                'location' => 'footer',
                'src'      => [
                    'local' => '/vendor/Modules/KamrulDashboard/js/custom.min.js',
                ],
            ],
            'custom-scrollbar'   => [
                'use_cdn'  => false,
                'location' => 'footer',
                'src'      => [
                    'local' => '/vendor/Modules/KamrulDashboard/vendor2/mCustomScrollbar/jquery.mCustomScrollbar.js',
                ],
            ],
            'excanvas'   => [
                'use_cdn'  => false,
                'location' => 'footer',
                'src'      => [
                    'local' => '/vendor/Modules/KamrulDashboard/vendor2/excanvas/excanvas.min.js',
                ],
            ],
            'fancybox'   => [
                'use_cdn'  => false,
                'location' => 'footer',
                'src'      => [
                    'local' => '/vendor/Modules/KamrulDashboard/vendor2/fancybox/jquery.fancybox.min.js',
                ],
            ],
            'are-you-sure'   => [
                'use_cdn'  => false,
                'location' => 'footer',
                'src'      => [
                    'local' => '/vendor/Modules/KamrulDashboard/vendor2/are-you-sure/jquery.are-you-sure.js',
                ],
            ],
            'waypoints'   => [
                'use_cdn'  => false,
                'location' => 'footer',
                'src'      => [
                    'local' => '/vendor/Modules/KamrulDashboard/vendor2/waypoints/jquery.waypoints.min.js',
                ],
            ],
            'slug'   => [
                'use_cdn'  => false,
                'location' => 'footer',
                'src'      => [
                    'local' => '/vendor/Modules/KamrulDashboard/slug/slug.js',
                ],
            ],
            'spectrum'   => [
                'use_cdn'  => false,
                'location' => 'footer',
                'src'      => [
                    'local' => '/vendor/Modules/KamrulDashboard/vendor2/spectrum/spectrum.js',
                ],
            ],
            'jquery-ui' => [
                'use_cdn' => false,
                'location' => 'footer',
                'src' => [
                    'local' => '/vendor/Modules/KamrulDashboard/vendor2/jquery-ui/jquery-ui.min.js',
                ],
            ],
            'language-global'   => [
                'use_cdn'  => false,
                'location' => 'footer',
                'src'      => [
                    'local' => '/vendor/Modules/Language/js/language-global.js',
                ],
            ],
            'stickyTableHeaders'   => [
                'use_cdn'  => false,
                'location' => 'footer',
                'src'      => [
                    'local' => '/vendor/Modules/KamrulDashboard/vendor2/StickyTableHeaders/jquery.stickytableheaders.min.js',
                ],
            ],
            'select2'            => [
                'use_cdn'  => false,
                'location' => 'footer',
                'src'      => [
                    'local' => '/vendor/Modules/KamrulDashboard/vendor2/select2/js/select2.min.js',
                ],
            ],
            'datepicker'               => [
                'use_cdn'  => false,
                'location' => 'footer',
                'src'      => [
//                    'local' => '/vendor/Modules/KamrulDashboard/vendor2/bootstrap-datepicker/js/bootstrap-datepicker.min.js',
                    'local' => '/vendor/Modules/KamrulDashboard/vendor2/flatpickr/flatpickr.min.js',
                ],
            ],
            'datetimepicker' => [
                'use_cdn' => false,
                'location' => 'footer',
                'src' => [
                    'local' => '/vendor/Modules/KamrulDashboard/vendor2/bootstrap-datetimepicker/bootstrap-datetimepicker.min.js',
                ],
            ],
            'clockpicker' => [
                'use_cdn' => false,
                'location' => 'footer',
                'src' => [
                    'local' => [
                        '/vendor/Modules/KamrulDashboard/vendor/clockpicker/js/bootstrap-clockpicker.min.js',
                        '/vendor/Modules/KamrulDashboard/js/plugins-init/clock-picker-init.js',
                    ]
                ],
            ],
            'timepicker' => [
                'use_cdn' => false,
                'location' => 'footer',
                'src' => [
                    'local' => '/vendor/Modules/KamrulDashboard/vendor2/bootstrap-timepicker/js/bootstrap-timepicker.min.js',
                ],
            ],
            'input-mask' => [
                'use_cdn' => false,
                'location' => 'footer',
                'src' => [
                    'local' => '/vendor/Modules/KamrulDashboard/vendor2/jquery-inputmask/jquery.inputmask.bundle.min.js',
                ],
            ],
            'app' => [
                'use_cdn' => false,
                'location' => 'header',
                'src' => [
                    'local' => '/vendor/Modules/KamrulDashboard/js/app.js',
                ],
            ],
            'vue-app' => [
                'use_cdn' => false,
                'location' => 'header',
                'src' => [
                    'local' => '/vendor/Modules/KamrulDashboard/js/vue-app.js',
                ],
            ],
            'blockui' => [
                'use_cdn' => false,
                'location' => 'footer',
                'src' => [
                    'local' => '/vendor/Modules/KamrulDashboard/vendor2/jquery.blockUI.js',
                ],
            ],
            'dropzone' => [
                'use_cdn' => false,
                'location' => 'footer',
                'src' => [
                    'local' => '/vendor/Modules/KamrulDashboard/dropzone/dist/min/dropzone.min.js',
                ],
            ],
            'color_picker'               => [
                'use_cdn'  => false,
                'location' => 'footer',
                'src'      => [
                    'local' => [
                        '/vendor/Modules/KamrulDashboard/vendor/jquery-asColor/jquery-asColor.min.js',
                        '/vendor/Modules/KamrulDashboard/vendor/jquery-asGradient/jquery-asGradient.min.js',
                        '/vendor/Modules/KamrulDashboard/vendor/jquery-asColorPicker/js/jquery-asColorPicker.min.js',
                        '/vendor/Modules/KamrulDashboard/js/plugins-init/jquery-asColorPicker.init.js'
                    ],
                ],
            ],
            'datatables'         => [
                'use_cdn'  => false,
                'location' => 'footer',
                'src'      => [
                    'local' => [
                        '/vendor/Modules/KamrulDashboard/vendor2/DataTables/DataTables/js/jquery.dataTables.min.js',
                        '/vendor/Modules/KamrulDashboard/vendor2/DataTables/DataTables/js/dataTables.bootstrap.min.js',
                        '/vendor/Modules/KamrulDashboard/vendor2/DataTables/Buttons/js/dataTables.buttons.min.js',
                        '/vendor/Modules/KamrulDashboard/vendor2/DataTables/Buttons/js/buttons.bootstrap.min.js',
                        '/vendor/Modules/KamrulDashboard/vendor2/DataTables/Responsive/js/dataTables.responsive.min.js',
                    ],
                ],
            ],
            'form-validation'    => [
                'use_cdn'  => false,
                'location' => 'footer',
                'src'      => [
                    'local' => '/vendor/Modules/KamrulDashboard/js-validation/js/js-validation.js',
                ],
            ],
            'moment'               => [
                'use_cdn'  => false,
                'location' => 'footer',
                'src'      => [
                    'local' => '/vendor/Modules/KamrulDashboard/vendor2/moment-with-locales.min.js',
                ],
            ],
            'bootstrap3-editable'               => [
                'use_cdn'  => false,
                'location' => 'footer',
                'src'      => [
                    'local' => '/vendor/Modules/KamrulDashboard/vendor/bootstrap3-editable/js/bootstrap-editable.js',
                ],
            ],
            'tagify'               => [
                'use_cdn'  => false,
                'location' => 'footer',
                'src'      => [
                    'local' => '/vendor/Modules/KamrulDashboard/vendor2/tagify/tagify.js',
                ],
            ],
            'ckeditor'               => [
                'use_cdn'  => false,
                'location' => 'footer',
                'attributes'      =>  [ 'type' => 'module'],
                'src'      => [
                    'local' => [
                        '/vendor/Modules/KamrulDashboard/js/ckeditor/script.js',
                        '/vendor/Modules/KamrulDashboard/js/ckeditor/ckeditor.js',
                        '/vendor/Modules/KamrulDashboard/js/ckeditor/editor.js'
                    ]
                ],
            ],
            'apexchart' => [
                'use_cdn' => false,
                'location' => 'footer',
                'src' => [
                    'local' => '/vendor/Modules/KamrulDashboard/apexchart/apexcharts.min.js',
                ],
            ],
            'jquery-nestable' => [
                'use_cdn' => false,
                'location' => 'footer',
                'src' => [
                    'local' => '/vendor/Modules/KamrulDashboard/vendor2/jquery-nestable/jquery.nestable.min.js',
                ],
            ],
            // End JS
        ],
        /* -- STYLESHEET ASSETS -- */
        'styles'  => [
            'toastr_css'   => [
                'use_cdn'  => false,
                'location' => 'header',
                'src'      => [
                    'local' => '/vendor/Modules/KamrulDashboard/vendor/toastr/css/toastr.min.css',
                ],
            ],
            'style'        => [
                'use_cdn'  => false,
                'location' => 'header',
                'src'      => [
                    'local' => '/vendor/Modules/KamrulDashboard/css/style.css',
                ],
            ],
            'style_custom'        => [
                'use_cdn'  => false,
                'location' => 'header',
                'src'      => [
                    'local' => '/vendor/Modules/KamrulDashboard/css/style_custom.css',
                ],
            ],
            'bootstrap3-editable'        => [
                'use_cdn'  => false,
                'location' => 'header',
                'src'      => [
                    'local' => '/vendor/Modules/KamrulDashboard/vendor/bootstrap3-editable/css/bootstrap-editable.css',
                ],
            ],
            'spectrum'   => [
                'use_cdn'  => false,
                'location' => 'header',
                'src'      => [
                    'local' => '/vendor/Modules/KamrulDashboard/vendor2/spectrum/spectrum.css',
                ],
            ],
            'fancybox'   => [
                'use_cdn'  => false,
                'location' => 'header',
                'src'      => [
                    'local' => '/vendor/Modules/KamrulDashboard/vendor2/fancybox/jquery.fancybox.min.css',
                ],
            ],
            'menu_custom'        => [
                'use_cdn'  => false,
                'location' => 'header',
                'src'      => [
                    'local' => '/vendor/Modules/Menus/css/menu_custom.css',
                ],
            ],
            'color_picker'               => [
                'use_cdn'  => false,
                'location' => 'header',
                'src'      => [
                    'local' => '/vendor/Modules/KamrulDashboard/vendor/jquery-asColorPicker/css/asColorPicker.min.css',
                ],
            ],
            'jquery-ui' => [
                'use_cdn' => false,
                'location' => 'header',
                'src' => [
                    'local' => '/vendor/Modules/KamrulDashboard/vendor2/jquery-ui/jquery-ui.min.css',
                ],
            ],
            'tagify'               => [
                'use_cdn'  => false,
                'location' => 'header',
                'src'      => [
                    'local' => '/vendor/Modules/KamrulDashboard/vendor2/tagify/tagify.css',
                ],
            ],
            'font-icons'   => [
                'use_cdn'  => false,
                'location' => 'header',
                'src'      => [
                    'local' => '/vendor/Modules/KamrulDashboard/icons/font-icons.css',
                ],
            ],
            'custom-scrollbar'   => [
                'use_cdn'  => false,
                'location' => 'header',
                'src'      => [
                    'local' => '/vendor/Modules/KamrulDashboard/vendor2/mCustomScrollbar/jquery.mCustomScrollbar.css',
                ],
            ],
            'select2'            => [
                'use_cdn'  => false,
                'location' => 'header',
                'src'      => [
                    'local' => [
                        '/vendor/Modules/KamrulDashboard/vendor2/select2/css/select2.min.css',
                        '/vendor/Modules/KamrulDashboard/vendor2/select2/css/select2-bootstrap.min.css',
                    ],
                ],
            ],
            'slug'   => [
                'use_cdn'  => false,
                'location' => 'header',
                'src'      => [
                    'local' => '/vendor/Modules/KamrulDashboard/slug/slug.css',
                ],
            ],
            'datepicker'               => [
                'use_cdn'  => false,
                'location' => 'header',
                'src'      => [
//                    'local' => '/vendor/Modules/KamrulDashboard/vendor2/bootstrap-datepicker/css/bootstrap-datepicker3.min.css',
                    'local' => '/vendor/Modules/KamrulDashboard/vendor2/flatpickr/flatpickr.min.css',
                ],
            ],
            'datetimepicker' => [
                'use_cdn' => false,
                'location' => 'header',
                'src' => [
                    'local' => '/vendor/Modules/KamrulDashboard/vendor2/bootstrap-datetimepicker/bootstrap-datetimepicker.min.css',
                ],
            ],
            'clockpicker' => [
                'use_cdn' => false,
                'location' => 'header',
                'src' => [
                    'local' => '/vendor/Modules/KamrulDashboard/vendor/clockpicker/css/bootstrap-clockpicker.min.css',
                ],
            ],
            'timepicker' => [
                'use_cdn' => false,
                'location' => 'header',
                'src' => [
                    'local' => '/vendor/Modules/KamrulDashboard/vendor2/bootstrap-timepicker/css/bootstrap-timepicker.min.css',
                ],
            ],
            'dropzone' => [
                'use_cdn' => false,
                'location' => 'header',
                'src' => [
                    'local' => '/vendor/Modules/KamrulDashboard/dropzone/dist/min/dropzone.min.css',
                ],
            ],
            'language' => [
                'use_cdn'  => false,
                'location' => 'header',
                'src'      => [
                    'local' => '/vendor/Modules/KamrulDashboard/language/css/language.css',
                ],
            ],
            'datatables'         => [
                'use_cdn'  => false,
                'location' => 'header',
                'src'      => [
                    'local' => [
                        '/vendor/Modules/KamrulDashboard/vendor2/DataTables/DataTables/css/dataTables.bootstrap.min.css',
                        '/vendor/Modules/KamrulDashboard/vendor2/DataTables/Buttons/css/buttons.bootstrap.min.css',
                        '/vendor/Modules/KamrulDashboard/vendor2/DataTables/Responsive/css/responsive.bootstrap.min.css',
                    ],
                ],
            ],
            'apexchart' => [
                'use_cdn' => false,
                'location' => 'header',
                'src' => [
                    'local' => '/vendor/Modules/KamrulDashboard/apexchart/apexcharts.css',
                ],
            ],
            'jquery-nestable' => [
                'use_cdn' => false,
                'location' => 'header',
                'src' => [
                    'local' => '/vendor/Modules/KamrulDashboard/vendor2/jquery-nestable/jquery.nestable.min.css',
                ],
            ],
        ],
    ],
];
