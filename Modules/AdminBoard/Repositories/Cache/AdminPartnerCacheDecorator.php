<?php

namespace Modules\AdminBoard\Repositories\Cache;

use Modules\AdminBoard\Repositories\Interfaces\AdminPartnerInterface;
use Modules\KamrulDashboard\Repositories\Caches\CacheAbstractDecorator;

class AdminPartnerCacheDecorator extends CacheAbstractDecorator implements AdminPartnerInterface
{
    /**
         * {@inheritDoc}
         */
        public function getAdminPartner(array $filters = [], array $params = [])
        {
            return $this->flushCacheAndUpdateData(__FUNCTION__, func_get_args());
        }
        /**
         * {@inheritDoc}
         */
        public function getRelatedAdminPartner(int $adminId, int $limit = 4, array $with = [])
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
