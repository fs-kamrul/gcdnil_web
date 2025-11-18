<?php

namespace Modules\AwesomeIcon\Repositories\Cache;

use Modules\AwesomeIcon\Repositories\Interfaces\AwesomeIconInterface;
use Modules\KamrulDashboard\Repositories\Caches\CacheAbstractDecorator;

class AwesomeIconCacheDecorator extends CacheAbstractDecorator implements AwesomeIconInterface
{

    /**
     * {@inheritDoc}
     */
    public function createSlug($name)
    {
        return $this->flushCacheAndUpdateData(__FUNCTION__, func_get_args());
    }
}
