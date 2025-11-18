<?php

namespace Modules\ThemeIcon\Repositories\Cache;

use Modules\ThemeIcon\Repositories\Interfaces\ThemeFaIconInterface;
use Modules\KamrulDashboard\Repositories\Caches\CacheAbstractDecorator;

class ThemeFaIconCacheDecorator extends CacheAbstractDecorator implements ThemeFaIconInterface
{

    /**
     * {@inheritDoc}
     */
    public function createSlug($name)
    {
        return $this->flushCacheAndUpdateData(__FUNCTION__, func_get_args());
    }
}
