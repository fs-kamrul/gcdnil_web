<?php
/**
 * Created by PhpStorm.
 * User: Kamrul Islam
 * Date: 28/12/2022
 * Time: 06:00 PM
 */
namespace Modules\Theme\Packages\Facades;

use Illuminate\Support\Facades\Facade;
use Modules\Theme\Packages\Supports\Manager;


class ManagerFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return Manager::class;
    }
}
