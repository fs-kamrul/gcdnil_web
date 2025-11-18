<?php

namespace Modules\Location\Packages\Facades;

use Illuminate\Support\Facades\Facade;
use Modules\Location\Packages\Support\Location;

/**
 * @see Location
 */
class LocationFacade extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return Location::class;
    }
}
