<?php
if (!defined('FILTER_PRE_DEFINED_WIDGETS')) {
    define('FILTER_PRE_DEFINED_WIDGETS', 'pre_defined_widgets');
}

if (!defined('WIDGET_MANAGER_MODULE_SCREEN_NAME')) {
    define('WIDGET_MANAGER_MODULE_SCREEN_NAME', 'widget-manager');
}

if (!defined('WIDGET_TOP_META_BOXES')) {
    define('WIDGET_TOP_META_BOXES', 'widget-top-meta-boxes');
}

if (!function_exists('register_widget')) {
    /**
     * @param string $widgetId
     * @return \Modules\Widget\Packages\Factories\WidgetFactory
     */
    function register_widget($widgetId)
    {
        return Widget::registerWidget($widgetId);
    }
}

if (!function_exists('register_sidebar')) {
    /**
     * @param array $args
     * @return \Modules\Widget\Packages\Supports\WidgetGroup
     */
    function register_sidebar($args)
    {
        return WidgetGroup::setGroup($args);
    }
}

if (!function_exists('remove_sidebar')) {
    /**
     * @param string $sidebarId
     * @return \Modules\Widget\Packages\Supports\WidgetGroupCollection
     */
    function remove_sidebar(string $sidebarId)
    {
        return WidgetGroup::removeGroup($sidebarId);
    }
}

if (!function_exists('dynamic_sidebar')) {
    /**
     * @param string $sidebarId
     * @return string
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    function dynamic_sidebar(string $sidebarId)
    {
        return WidgetGroup::render($sidebarId);
    }
}
