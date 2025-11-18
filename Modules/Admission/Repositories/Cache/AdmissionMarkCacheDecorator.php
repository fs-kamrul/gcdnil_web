<?php

namespace Modules\Admission\Repositories\Cache;

use Modules\Admission\Repositories\Interfaces\AdmissionMarkInterface;
use Modules\KamrulDashboard\Repositories\Caches\CacheAbstractDecorator;

class AdmissionMarkCacheDecorator extends CacheAbstractDecorator implements AdmissionMarkInterface
{

    /**
     * {@inheritDoc}
     */
    public function createSlug($name)
    {
        return $this->flushCacheAndUpdateData(__FUNCTION__, func_get_args());
    }
}
