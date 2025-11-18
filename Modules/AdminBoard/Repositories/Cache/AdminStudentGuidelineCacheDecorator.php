<?php

namespace Modules\AdminBoard\Repositories\Cache;

use Modules\AdminBoard\Repositories\Interfaces\AdminStudentGuidelineInterface;
use Modules\KamrulDashboard\Repositories\Caches\CacheAbstractDecorator;

class AdminStudentGuidelineCacheDecorator extends CacheAbstractDecorator implements AdminStudentGuidelineInterface
{
    /**
         * {@inheritDoc}
         */
        public function getAdminStudentGuideline(array $filters = [], array $params = [])
        {
            return $this->flushCacheAndUpdateData(__FUNCTION__, func_get_args());
        }
        /**
         * {@inheritDoc}
         */
        public function getRelatedAdminStudentGuideline(int $adminId, int $limit = 4, array $with = [])
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
