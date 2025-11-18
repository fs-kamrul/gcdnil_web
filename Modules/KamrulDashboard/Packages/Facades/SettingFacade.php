<?php
/**
 * Created by PhpStorm.
 * User: Kamrul Islam
 * Date: 22/02/2022
 * Time: 03:20 PM
 */
namespace Modules\KamrulDashboard\Packages\Facades;

use Illuminate\Support\Facades\Facade;
use Modules\KamrulDashboard\Packages\Supports\DatabaseSettingStore;
use Modules\KamrulDashboard\Packages\Supports\SettingStore;

class SettingFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return DatabaseSettingStore::class;
    }
}
