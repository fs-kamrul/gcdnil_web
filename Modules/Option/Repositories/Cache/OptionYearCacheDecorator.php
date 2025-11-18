<?php

namespace Modules\Option\Repositories\Cache;

use Modules\Option\Repositories\Interfaces\OptionYearInterface;
use Modules\KamrulDashboard\Repositories\Caches\CacheAbstractDecorator;

class OptionYearCacheDecorator extends CacheAbstractDecorator implements OptionYearInterface
{

    /**
     * {@inheritDoc}
     */
    public function createSlug($name)
    {
        return $this->flushCacheAndUpdateData(__FUNCTION__, func_get_args());
    }
}
