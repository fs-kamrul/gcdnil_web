<?php

namespace Modules\Widget\Packages\Facades;

use Illuminate\Support\Facades\Facade;
use Modules\Widget\Packages\Supports\WidgetGroup;

class WidgetFacade extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'kamruldashboard.widget';
    }

    /**
     * Get the widget group object.
     *
     * @param string $name
     *
     * @return WidgetGroup
     */
    public static function group($name)
    {
        return app('kamruldashboard.widget-group-collection')->group($name);
    }
}
