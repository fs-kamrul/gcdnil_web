<?php
/**
 * Created by PhpStorm.
 * User: Kamrul Islam
 * Date: 22/02/2022
 * Time: 03:20 PM
 */
namespace Modules\KamrulDashboard\Packages\Facades;

use Modules\KamrulDashboard\Packages\dboard\Dboard;
use Illuminate\Support\Facades\Facade;
class DboardFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return Dboard::class;
    }
}
