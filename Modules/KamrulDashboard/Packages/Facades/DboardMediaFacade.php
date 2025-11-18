<?php
/**
 * Created by PhpStorm.
 * User: Kamrul Islam
 * Date: 02/05/2023
 * Time: 03:09 PM
 */
namespace Modules\KamrulDashboard\Packages\Facades;
use Illuminate\Support\Facades\Facade;
use Modules\KamrulDashboard\Services\DboardMedia;

class DboardMediaFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return DboardMedia::class;
    }
}
