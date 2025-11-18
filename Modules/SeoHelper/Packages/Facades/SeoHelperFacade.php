<?php

namespace Modules\SeoHelper\Packages\Facades;

use Illuminate\Support\Facades\Facade;
use Modules\SeoHelper\Packages\Supports\SeoHelper;

/**
 * @since 02/12/2015 14:08 PM
 */
class SeoHelperFacade extends Facade
{

    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return SeoHelper::class;
    }
}
