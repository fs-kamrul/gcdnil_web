<?php
/**
 * Created by PhpStorm.
 * User: Kamrul Islam
 * Date: 04/11/2022
 * Time: 04:25 PM
 */
namespace Modules\Theme\Packages\Facades;

use Illuminate\Support\Facades\Facade;
use Modules\Theme\Packages\Supports\Theme;

class ThemeFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return Theme::class;
    }
}
