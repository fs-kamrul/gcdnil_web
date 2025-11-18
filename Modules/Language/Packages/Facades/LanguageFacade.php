<?php

namespace Modules\Language\Packages\Facades;

use Illuminate\Support\Facades\Facade;
use Modules\Language\Packages\Supports\LanguageManager;

class LanguageFacade extends Facade
{

    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return LanguageManager::class;
    }
}
