<?php

namespace Modules\Option\Repositories\Cache;

use Modules\Option\Repositories\Interfaces\OptionSectionInterface;
use Modules\KamrulDashboard\Repositories\Caches\CacheAbstractDecorator;

class OptionSectionCacheDecorator extends CacheAbstractDecorator implements OptionSectionInterface
{

    /**
     * {@inheritDoc}
     */
    public function createSlug($name)
    {
        return $this->flushCacheAndUpdateData(__FUNCTION__, func_get_args());
    }
}
