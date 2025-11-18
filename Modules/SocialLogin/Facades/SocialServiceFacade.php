<?php

namespace Modules\SocialLogin\Facades;

use Modules\SocialLogin\Supports\SocialService;
use Illuminate\Support\Facades\Facade;

/**
 * @see \Modules\SocialLogin\Supports\SocialService
 */
class SocialServiceFacade extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return SocialService::class;
    }
}
