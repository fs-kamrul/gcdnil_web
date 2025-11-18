<?php
/**
 * Created by PhpStorm.
 * User: Kamrul Islam
 * Date: 10/11/2022
 * Time: 01:32 PM
 */
namespace Modules\KamrulDashboard\Packages\Facades;

use Illuminate\Support\Facades\Facade;


/**
 * @see \Modules\KamrulDashboard\Packages\Supports\Action
 */
class ActionFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'kamruldashboard:action';
    }
}
