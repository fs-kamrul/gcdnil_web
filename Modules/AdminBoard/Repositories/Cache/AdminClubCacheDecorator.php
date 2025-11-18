<?php

namespace Modules\AdminBoard\Repositories\Cache;

use Modules\AdminBoard\Repositories\Interfaces\AdminClubInterface;
use Modules\KamrulDashboard\Repositories\Caches\CacheAbstractDecorator;

class AdminClubCacheDecorator extends CacheAbstractDecorator implements AdminClubInterface
{
    /**
     * {@inheritDoc}
     */
    public function getAdminClubGroup(array $filters = [], array $params = [])
    {
        return $this->flushCacheAndUpdateData(__FUNCTION__, func_get_args());
    }
    /**
         * {@inheritDoc}
         */
        public function getAdminClub(array $filters = [], array $params = [])
        {
            return $this->flushCacheAndUpdateData(__FUNCTION__, func_get_args());
        }
        /**
         * {@inheritDoc}
         */
        public function getRelatedAdminClub(int $adminId, int $limit = 4, array $with = [])
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
