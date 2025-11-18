<?php

namespace Modules\Option\Repositories\Cache;

use Modules\Option\Repositories\Interfaces\OptionClassInterface;
use Modules\KamrulDashboard\Repositories\Caches\CacheAbstractDecorator;

class OptionClassCacheDecorator extends CacheAbstractDecorator implements OptionClassInterface
{

    /**
     * {@inheritDoc}
     */
    public function createSlug($name)
    {
        return $this->flushCacheAndUpdateData(__FUNCTION__, func_get_args());
    }
}
