<?php
/**
 * Created by PhpStorm.
 * User: Kamrul Islam
 * Date: 05/11/2022
 * Time: 10:36 AM
 */
namespace Modules\KamrulDashboard\Packages\Facades;

use Illuminate\Support\Facades\Facade;
use Modules\KamrulDashboard\Packages\Supports\SlugHelper;

class SlugHelperFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return SlugHelper::class;
    }
}
