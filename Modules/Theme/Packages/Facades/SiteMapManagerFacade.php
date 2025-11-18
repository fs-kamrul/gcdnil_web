<?php
/**
 * Created by PhpStorm.
 * User: Kamrul Islam
 * Date: 14/12/2022
 * Time: 02:09 PM
 */
namespace Modules\Theme\Packages\Facades;

use Illuminate\Support\Facades\Facade;
use Modules\Theme\Packages\Supports\SiteMapManager;

class SiteMapManagerFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return SiteMapManager::class;
    }
}
