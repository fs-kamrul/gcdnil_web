<?php
/**
 * Created by PhpStorm.
 * User: Kamrul Islam
 * Date: 19/10/2022
 * Time: 04:09 PM
 */
namespace Modules\Theme\Packages\Facades;

use Illuminate\Support\Facades\Facade;
use Modules\Theme\Packages\Supports\Vimeo;

class VimeoFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return Vimeo::class;
    }
}
