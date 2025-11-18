<?php
/**
 * Created by PhpStorm.
 * User: Kamrul Islam
 * Date: 31/10/2022
 * Time: 04:09 PM
 */
namespace Modules\Theme\Packages\Facades;

use Illuminate\Support\Facades\Facade;
use Modules\Theme\Packages\Supports\ThemeOption;

class ThemeOptionFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return ThemeOption::class;
    }
}
