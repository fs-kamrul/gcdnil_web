<?php

namespace Modules\KamrulDashboard\Packages\Facades;

use Illuminate\Support\Facades\Facade;
use Modules\KamrulDashboard\Packages\Supports\Assets;

class AssetsFacade extends Facade
{

    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return Assets::class;
    }
}
