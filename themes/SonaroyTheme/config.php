<?php

use Modules\Theme\Packages\Supports\Theme;

return [

    /*
    |--------------------------------------------------------------------------
    | Inherit from another theme
    |--------------------------------------------------------------------------
    |
    | Set up inherit from another if the file is not exists,
    | this is work with "layouts", "partials" and "views"
    |
    | [Notice] assets cannot inherit.
    |
    */

    'inherit' => null, //default

    /*
    |--------------------------------------------------------------------------
    | Listener from events
    |--------------------------------------------------------------------------
    |
    | You can hook a theme when event fired on activities
    | this is cool feature to set up a title, meta, default styles and scripts.
    |
    | [Notice] these event can be override by package config.
    |
    */

    'events' => [

        // Before event inherit from package config and the theme that call before,
        // you can use this event to set meta, breadcrumb template or anything
        // you want inheriting.
        'before' => function($theme)
        {
            // You can remove this line anytime.
        },

        // Listen on event before render a theme,
        // this event should call to assign some assets,
        // breadcrumb template.
        'beforeRenderTheme' => function (Theme $theme)
        {
            // Partial composer.
            // $theme->partialComposer('header', function($view) {
            //     $view->with('auth', \Auth::user());
            // });
            if (is_module_active('Ecommerce')) {
                $categories = ProductCategoryHelper::getActiveTreeCategories();

                $theme->partialComposer('header', function ($view) use ($categories) {
                    $view->with('categories', $categories);
                });
            }
            $version = get_cms_version();
//            $version = '1.0.1';

            // You may use this event to set up your assets.
//            $theme->asset()->usePath()->add('style', 'style.css', [], [], $version);
//            $theme->asset()->usePath()->add('bootstrap', 'css/bootstrap.min.css', [], [], $version);
            $theme->asset()->add('bootstrap', 'vendor/Modules/KamrulDashboard/vendor/bootstrap/dist/css/bootstrap.min.css', [], [], $version);
            $theme->asset()->usePath()->add('base', 'css/base.css', [], [], $version);
            $theme->asset()->usePath()->add('skeleton', 'css/skeleton.css', [], [], $version);
            $theme->asset()->usePath()->add('style', 'css/style.css', [], [], $version);
            $theme->asset()->usePath()->add('meganizr', 'css/meganizr.css', [], [], $version);
            $theme->asset()->usePath()->add('flaticon', 'css/flaticon.css', [], [], $version);
            $theme->asset()->usePath()->add('style2', 'css/style2.css', [], [], $version);
            $theme->asset()->usePath()->add('responsiveslides', 'css/responsiveslides.css', [], [], $version);
            $theme->asset()->usePath()->add('responsive', 'css/responsive.css', [], [], $version);
            $theme->asset()->usePath()->add('accessibility', 'css/accessibility.css', [], [], $version);

            $theme->asset()->usePath()->add('remixicon', 'css/remixicon/remixicon.css', [], [], $version);
            $theme->asset()->usePath()->add('toastr_css', 'toastr/css/toastr.min.css', [], [], $version);
            $theme->asset()->usePath()->add('custom_style', 'css/custom_style.css', [], [], $version);


//            $theme->asset()->container('footer')->usePath()->add('jquery_12', 'js/jquery-1.12.4.min.js');

            $theme->asset()->container('footer')->usePath()->add('jquery', 'js/jquery-1.12.4.min.js');
//            $theme->asset()->container('footer')->add('bootstrap-js', 'vendor/Modules/KamrulDashboard/vendor/bootstrap/dist/js/bootstrap.bundle.min.js');
            $theme->asset()->container('footer')->usePath()->add('bootstrap-slim', 'js/jquery-3.3.1.slim.min.js');
            $theme->asset()->container('footer')->usePath()->add('bootstrap-popper', 'js/popper.min.js');
            $theme->asset()->container('footer')->usePath()->add('bootstrap-js', 'js/bootstrap.min.js');
            $theme->asset()->container('footer')->usePath()->add('slick', 'js/jquery-accessibleMegaMenu.js');
            $theme->asset()->container('footer')->usePath()->add('responsiveslides', 'js/responsiveslides.min.js');
            $theme->asset()->container('footer')->usePath()->add('vticker', 'js/jquery.vticker.js');
            $theme->asset()->container('footer')->usePath()->add('domain_selector', 'js/domain_selector.js');
            $theme->asset()->container('footer')->usePath()->add('utils', 'js/utils.js');
            $theme->asset()->container('footer')->usePath()->add('yoxview', 'js/yoxview/yoxview-init.js');
//            $theme->asset()->container('footer')->usePath()->add('slick', 'js/slick');
//            $theme->asset()->container('footer')->usePath()->add('script', 'js/script.js');

            $theme->asset()->container('footer')->usePath()->add('toastr_js', 'toastr/js/toastr.min.js');
            $theme->asset()->container('footer')->usePath()->add('toastr_script_js', 'toastr/js/toastr_script.js');
            $theme->asset()->container('footer')->usePath()->add('newsletter', 'js/newsletter.js');
//            $theme->asset()->container('footer')->usePath()->add('backend', 'js/backend.js');

//            $theme->asset()->usePath()->add('widgets', 'css/widgets.css', [], [], $version);
//            $theme->asset()->usePath()->add('responsive', 'css/responsive.css', [], [], $version);
//            $theme->asset()->usePath()->add('custom', 'css/custom.css', [], [], $version);

            if (function_exists('shortcode')) {
                $theme->composer(['page', 'post', 'ecommerce.product'], function (\Modules\Shortcodes\Resources\views\View $view) {
                    $view->withShortcodes();
                });
            }
        },

        // Listen on event before render a layout,
        // this should call to assign style, script for a layout.
        'beforeRenderLayout' => [

            'default' => function ($theme)
            {
                // $theme->asset()->usePath()->add('ipad', 'css/layouts/ipad.css');
            }
        ]
    ]
];
