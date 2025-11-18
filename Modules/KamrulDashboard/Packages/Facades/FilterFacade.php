<?php
/**
 * Created by PhpStorm.
 * User: Kamrul Islam
 * Date: 10/11/2022
 * Time: 01:30 PM
 */
namespace Modules\KamrulDashboard\Packages\Facades;

use Illuminate\Support\Facades\Facade;


/**
 * @see \Modules\KamrulDashboard\Packages\Supports\Filter
 */
class FilterFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'kamruldashboard:filter';
    }
}
