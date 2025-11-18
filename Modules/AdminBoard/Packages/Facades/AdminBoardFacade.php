<?php

namespace Modules\AdminBoard\Packages\Facades;

use Illuminate\Support\Facades\Facade;
use Modules\AdminBoard\Packages\Supports\AdminBoardHelper;

class AdminBoardFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return AdminBoardHelper::class;
    }
}
