<?php

namespace Modules\KamrulDashboard\Packages\Facades;

use Illuminate\Support\Facades\Facade;
use Modules\KamrulDashboard\Packages\Supports\EmailHandler;

/**
 * @see EmailHandler
 */
class EmailHandlerFacade extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return EmailHandler::class;
    }
}
