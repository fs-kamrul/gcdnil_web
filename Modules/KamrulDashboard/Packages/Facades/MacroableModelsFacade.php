<?php

/**
 * Created by PhpStorm.
 * User: Kamrul Islam
 * Date: 27/11/2022
 * Time: 11:20 AM
 */
namespace Modules\KamrulDashboard\Packages\Facades;

use Illuminate\Support\Facades\Facade;
use Modules\KamrulDashboard\Packages\Supports\MacroableModels;

class MacroableModelsFacade extends Facade
{

    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return MacroableModels::class;
    }
}
