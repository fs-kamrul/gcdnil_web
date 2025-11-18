<?php

namespace Modules\Admission\Repositories\Cache;

use Modules\Admission\Repositories\Interfaces\AdmissionInterface;
use Modules\KamrulDashboard\Repositories\Caches\CacheAbstractDecorator;

class AdmissionCacheDecorator extends CacheAbstractDecorator implements AdmissionInterface
{

    /**
     * {@inheritDoc}
     */
    public function createSlug($name)
    {
        return $this->flushCacheAndUpdateData(__FUNCTION__, func_get_args());
    }
}
