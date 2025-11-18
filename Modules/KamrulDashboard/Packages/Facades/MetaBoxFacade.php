<?php

/**
 * Created by PhpStorm.
 * User: Kamrul Islam
 * Date: 27/11/2022
 * Time: 11:28 AM
 */
namespace Modules\KamrulDashboard\Packages\Facades;

use Illuminate\Support\Facades\Facade;
use Modules\KamrulDashboard\Packages\Supports\MetaBox;

class MetaBoxFacade extends Facade
{

    /**
     * @return string
     * @since 2.2
     */
    protected static function getFacadeAccessor()
    {
        return MetaBox::class;
    }
}
