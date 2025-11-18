<?php

namespace Modules\AdminBoard\Repositories\Cache;

use Modules\AdminBoard\Repositories\Interfaces\AdminEducationInterface;
use Modules\KamrulDashboard\Repositories\Caches\CacheAbstractDecorator;

class AdminEducationCacheDecorator extends CacheAbstractDecorator implements AdminEducationInterface
{
    /**
         * {@inheritDoc}
         */
        public function getAdminEducation(array $filters = [], array $params = [])
        {
            return $this->flushCacheAndUpdateData(__FUNCTION__, func_get_args());
        }
        /**
         * {@inheritDoc}
         */
        public function getRelatedAdminEducation(int $adminId, int $limit = 4, array $with = [])
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
