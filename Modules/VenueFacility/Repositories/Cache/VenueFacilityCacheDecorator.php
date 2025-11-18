<?php

namespace Modules\VenueFacility\Repositories\Cache;

use Modules\VenueFacility\Repositories\Interfaces\VenueFacilityInterface;
use Modules\KamrulDashboard\Repositories\Caches\CacheAbstractDecorator;

class VenueFacilityCacheDecorator extends CacheAbstractDecorator implements VenueFacilityInterface
{

    /**
     * {@inheritDoc}
     */
    public function createSlug($name)
    {
        return $this->flushCacheAndUpdateData(__FUNCTION__, func_get_args());
    }
}
