<?php

namespace Modules\AdminBoard\Repositories\Cache;

use Modules\AdminBoard\Repositories\Interfaces\AdminCategoryInterface;
use Modules\KamrulDashboard\Repositories\Caches\CacheAbstractDecorator;

class AdminCategoryCacheDecorator extends CacheAbstractDecorator implements AdminCategoryInterface
{
    /**
         * {@inheritDoc}
         */
        public function getAdminCategory(array $select, array $orderBy)
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
    public function getCategoriesByBoard($board)
    {
        return $this->flushCacheAndUpdateData(__FUNCTION__, func_get_args());
    }
}
