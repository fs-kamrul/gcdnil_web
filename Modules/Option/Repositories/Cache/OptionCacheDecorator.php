<?php

namespace Modules\Option\Repositories\Cache;

use Modules\Option\Repositories\Interfaces\OptionInterface;
use Modules\KamrulDashboard\Repositories\Caches\CacheAbstractDecorator;

class OptionCacheDecorator extends CacheAbstractDecorator implements OptionInterface
{

    /**
     * {@inheritDoc}
     */
    public function createSlug($name)
    {
        return $this->flushCacheAndUpdateData(__FUNCTION__, func_get_args());
    }
}
