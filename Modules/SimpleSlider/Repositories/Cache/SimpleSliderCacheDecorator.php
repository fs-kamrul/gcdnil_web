<?php

namespace Modules\SimpleSlider\Repositories\Cache;

use Modules\SimpleSlider\Repositories\Interfaces\SimpleSliderInterface;
use Modules\KamrulDashboard\Repositories\Caches\CacheAbstractDecorator;

class SimpleSliderCacheDecorator extends CacheAbstractDecorator implements SimpleSliderInterface
{

    /**
     * {@inheritDoc}
     */
    public function createSlug($name)
    {
        return $this->flushCacheAndUpdateData(__FUNCTION__, func_get_args());
    }
}
