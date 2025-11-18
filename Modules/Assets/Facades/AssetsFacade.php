<?php

namespace Modules\Assets\Facades;

use Modules\Assets\Assets;
use Illuminate\Support\Facades\Facade;

/**
 * Class AssetsFacade.
 *
 * @since 07/03/2023 10:25 AM
 */
class AssetsFacade extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return Assets::class;
    }
}
