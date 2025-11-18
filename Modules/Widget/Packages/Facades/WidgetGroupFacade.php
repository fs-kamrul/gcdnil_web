<?php

namespace Modules\Widget\Packages\Facades;

use Illuminate\Support\Facades\Facade;

class WidgetGroupFacade extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'kamruldashboard.widget-group-collection';
    }
}
