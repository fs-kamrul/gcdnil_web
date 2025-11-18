<?php

namespace Modules\Admission\Repositories\Cache;

use Modules\Admission\Repositories\Interfaces\AdmissionSubjectInterface;
use Modules\KamrulDashboard\Repositories\Caches\CacheAbstractDecorator;

class AdmissionSubjectCacheDecorator extends CacheAbstractDecorator implements AdmissionSubjectInterface
{

    /**
     * {@inheritDoc}
     */
    public function createSlug($name)
    {
        return $this->flushCacheAndUpdateData(__FUNCTION__, func_get_args());
    }
}
