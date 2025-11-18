<?php

namespace Modules\AdminBoard\Repositories\Cache;

use Modules\AdminBoard\Repositories\Interfaces\AdminFacilityInterface;
use Modules\KamrulDashboard\Repositories\Caches\CacheAbstractDecorator;

class AdminFacilityCacheDecorator extends CacheAbstractDecorator implements AdminFacilityInterface
{
    /**
         * {@inheritDoc}
         */
        public function getAdminFacility(array $filters = [], array $params = [])
        {
            return $this->flushCacheAndUpdateData(__FUNCTION__, func_get_args());
        }
        /**
         * {@inheritDoc}
         */
        public function getRelatedAdminFacility(int $adminId, int $limit = 4, array $with = [])
        {
            return $this->flushCacheAndUpdateData(__FUNCTION__, func_get_args());
        }
    /**
     * {@inheritDoc}
     */
    public function createSlug($name)
    {
        return $this->flushCacheAndUpdateData(__FUNCTION__, func_get_args());
    }
}
