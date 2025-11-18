<?php

namespace Modules\AdminBoard\Repositories\Cache;

use Modules\AdminBoard\Repositories\Interfaces\AdminEventInterface;
use Modules\KamrulDashboard\Repositories\Caches\CacheAbstractDecorator;

class AdminEventCacheDecorator extends CacheAbstractDecorator implements AdminEventInterface
{
    /**
     * {@inheritDoc}
     */
    public function getEvent(array $filters = [], array $params = [])
    {
        return $this->flushCacheAndUpdateData(__FUNCTION__, func_get_args());
//        return $this->getDataIfExistCache(__FUNCTION__, compact('filters', 'params'));
    }
    /**
     * {@inheritDoc}
     */
    public function getRelatedEvent(int $adminWorkshopId, int $limit = 4, array $with = [])
    {
        return $this->flushCacheAndUpdateData(__FUNCTION__, func_get_args());
//        return $this->getDataIfExistCache(__FUNCTION__, compact('adminWorkshopId', 'limit', 'with'));
    }

    /**
     * {@inheritDoc}
     */
    public function createSlug($name)
    {
        return $this->flushCacheAndUpdateData(__FUNCTION__, func_get_args());
    }
}
