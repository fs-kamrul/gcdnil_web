<?php

namespace Modules\Option\Packages\Facades;

use Illuminate\Support\Facades\Facade;
use Modules\Option\Packages\Support\Option;

/**
 * @see Location
 */
class OptionFacade extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return Option::class;
    }
}
