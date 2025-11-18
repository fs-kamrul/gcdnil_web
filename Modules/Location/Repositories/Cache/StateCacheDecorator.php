<?php

namespace Modules\Location\Repositories\Cache;

use Modules\Location\Repositories\Interfaces\StateInterface;
use Modules\KamrulDashboard\Repositories\Caches\CacheAbstractDecorator;

class StateCacheDecorator extends CacheAbstractDecorator implements StateInterface
{
}
