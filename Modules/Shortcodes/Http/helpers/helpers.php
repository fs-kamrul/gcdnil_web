<?php

if (!defined('SHORTCODE_REGISTER_CONTENT_IN_ADMIN')) {
    define('SHORTCODE_REGISTER_CONTENT_IN_ADMIN', 'sc-content-admin');
}
if (!function_exists('shortcode')) {
    /**
     * @return \Modules\Shortcodes\Shortcode
     */
    function shortcode()
    {
        return app('shortcode');
    }
}

if (!function_exists('add_shortcode')) {
    /**
     * @param string $key
     * @param string $name
     * @param null|string $description
     * @param Callable|string $callback
     * @return \Modules\Shortcodes\Shortcode
     */
    function add_shortcode($key, $name, $description = null, $callback = null)
    {
        return shortcode()->register($key, $name, $description, $callback);
    }
}

if (!function_exists('do_shortcode')) {
    /**
     * @param string $content
     * @return string
     */
    function do_shortcode($content)
    {
        return shortcode()->compile($content);
    }
}

if (!function_exists('generate_shortcode')) {
    /**
     * @param string $name
     * @param array $attributes
     * @return string
     */
    function generate_shortcode($name, array $attributes = [])
    {
        return shortcode()->generateShortcode($name, $attributes);
    }
}
