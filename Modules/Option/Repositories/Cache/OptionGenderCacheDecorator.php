<?php

namespace Modules\Option\Repositories\Cache;

use Modules\Option\Repositories\Interfaces\OptionGenderInterface;
use Modules\KamrulDashboard\Repositories\Caches\CacheAbstractDecorator;

class OptionGenderCacheDecorator extends CacheAbstractDecorator implements OptionGenderInterface
{

    /**
     * {@inheritDoc}
     */
    public function createSlug($name)
    {
        return $this->flushCacheAndUpdateData(__FUNCTION__, func_get_args());
    }
}
