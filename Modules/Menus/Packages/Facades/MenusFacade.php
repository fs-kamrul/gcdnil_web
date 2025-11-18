<?php
/**
 * Created by PhpStorm.
 * User: Kamrul Islam
 * Date: 07/11/2022
 * Time: 01:13 PM
 */
namespace Modules\Menus\Packages\Facades;

use Illuminate\Support\Facades\Facade;
use Modules\Menus\Packages\Supports\Menu;

class MenusFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return Menu::class;
    }
}
