<?php

namespace Modules\VenueFacility\Repositories\Cache;

use Modules\VenueFacility\Repositories\Interfaces\KeyFacilityInterface;
use Modules\KamrulDashboard\Repositories\Caches\CacheAbstractDecorator;

class KeyFacilityCacheDecorator extends CacheAbstractDecorator implements KeyFacilityInterface
{

    /**
     * {@inheritDoc}
     */
    public function createSlug($name)
    {
        return $this->flushCacheAndUpdateData(__FUNCTION__, func_get_args());
    }
}
