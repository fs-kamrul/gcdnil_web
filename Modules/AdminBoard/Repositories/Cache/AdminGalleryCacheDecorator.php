<?php

namespace Modules\AdminBoard\Repositories\Cache;

use Modules\AdminBoard\Repositories\Interfaces\AdminGalleryInterface;
use Modules\KamrulDashboard\Repositories\Caches\CacheAbstractDecorator;

class AdminGalleryCacheDecorator extends CacheAbstractDecorator implements AdminGalleryInterface
{
    /**
         * {@inheritDoc}
         */
        public function getAdminGallery(array $filters = [], array $params = [])
        {
            return $this->flushCacheAndUpdateData(__FUNCTION__, func_get_args());
        }
        /**
         * {@inheritDoc}
         */
        public function getRelatedAdminGallery(int $adminId, int $limit = 4, array $with = [])
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
