<?php

namespace Modules\Admission\Repositories\Cache;

use Modules\Admission\Repositories\Interfaces\AdmissionMeritInterface;
use Modules\KamrulDashboard\Repositories\Caches\CacheAbstractDecorator;

class AdmissionMeritCacheDecorator extends CacheAbstractDecorator implements AdmissionMeritInterface
{

    /**
     * {@inheritDoc}
     */
    public function createSlug($name)
    {
        return $this->flushCacheAndUpdateData(__FUNCTION__, func_get_args());
    }
}
