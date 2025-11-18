<?php


if (!defined('THEME_OPTIONS_MODULE_SCREEN_NAME')) {
    define('THEME_OPTIONS_MODULE_SCREEN_NAME', 'theme-options');
}
if (!defined('THEME_MODULE_SCREEN_NAME')) {
    define('THEME_MODULE_SCREEN_NAME', 'theme');
}
if (!defined('RENDERING_THEME_OPTIONS_PAGE')) {
    define('RENDERING_THEME_OPTIONS_PAGE', 'rendering-theme-options-page');
}
if (! defined('THEME_FRONT_HEADER')) {
    define('THEME_FRONT_HEADER', 'theme-front-header');
}

if (! defined('THEME_FRONT_FOOTER')) {
    define('THEME_FRONT_FOOTER', 'theme-front-footer');
}

if (!function_exists('sanitize_html_class')) {
    /**
     * @param string $class
     * @param string $fallback
     * @return string
     */
    function sanitize_html_class($class, $fallback = '')
    {
        //Strip out any % encoded octets
        $sanitized = preg_replace('|%[a-fA-F0-9][a-fA-F0-9]|', '', $class);

        //Limit to A-Z,a-z,0-9,_,-
        $sanitized = preg_replace('/[^A-Za-z0-9_-]/', '', $sanitized);

        if ('' == $sanitized && $fallback) {
            return sanitize_html_class($fallback);
        }

        /**
         * Filters a sanitized HTML class string.
         *
         * @param string $sanitized The sanitized HTML class.
         * @param string $class HTML class before sanitization.
         * @param string $fallback The fallback string.
         * @since 2.8.0
         */
//        return $sanitized;
        return apply_filters('sanitize_html_class', $sanitized, $class, $fallback);
    }
}

if (!function_exists('parse_args')) {
    /**
     * @param array|object $args
     * @param string $defaults
     * @return array
     */
    function parse_args($args, $defaults = '')
    {
        if (is_object($args)) {
            $result = get_object_vars($args);
        } else {
            $result =& $args;
        }

        if (is_array($defaults)) {
            return array_merge($defaults, $result);
        }

        return $result;
    }
}

if (!function_exists('theme')) {
    /**
     * Get the theme instance.
     *
     * @param string $themeName
     * @param string $layoutName
     * @return \Illuminate\Contracts\Foundation\Application|mixed
     */
    function theme($themeName = null, $layoutName = null)
    {
        $theme = app('theme');

        if ($themeName) {
            $theme->theme($themeName);
        }

        if ($layoutName) {
            $theme->layout($layoutName);
        }

        return $theme;
    }
}

if (!function_exists('theme_option')) {
    /**
     * @return \Modules\Theme\Packages\Supports\ThemeOption|string
     */
    function theme_option($key = null, $default = '')
    {
        if (!empty($key)) {
            try {
                return ThemeOption::getOption($key, $default);
            } catch (Exception $exception) {
                info($exception->getMessage());
            }
        }

        return \Modules\Theme\Packages\Facades\ThemeOptionFacade::getFacadeRoot();
    }
}
if (!function_exists('random_color')) {
    /**
     * @return string
     */
    function random_color()
    {
        $colors = ['warning', 'primary', 'info', 'success'];

        return 'text-' . $colors[array_rand($colors)];
    }
}
if (!function_exists('theme_path')) {
    /**
     * @return string
     */
    function theme_path($path = null)
    {
        return platform_path(config('theme.themeDir') . DIRECTORY_SEPARATOR . $path);
//        return platform_path($path);
    }
}

if (!function_exists('scan_folder')) {
    /**
     * @param string $path
     * @param array $ignoreFiles
     * @return array
     */
    function scan_folder($path, $ignoreFiles = [])
    {
        return DboardHelper::scanFolder($path, $ignoreFiles);
    }
}
if (!function_exists('admin_bar')) {
    /**
     * @return \Modules\Theme\Packages\Supports\AdminBar
     */
    function admin_bar()
    {
        return \Modules\Theme\Packages\Facades\AdminBarFacade::getFacadeRoot();
    }
}
if (!function_exists('get_branch_by_slug')) {
    function get_branch_by_slug($branch)
    {
        if (is_module_active('Branch')) {
            $branch_name =  app(\Modules\Branch\Repositories\Interfaces\BranchInterface::class)->advancedGet(['condition' => ['slug'=>$branch], 'take' => 1]);
        }else{
            $branch_name = null;
        }
        return $branch_name;
    }
}
