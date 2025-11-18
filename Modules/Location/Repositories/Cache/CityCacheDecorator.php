<?php

namespace Modules\Location\Repositories\Cache;

use Illuminate\Database\Eloquent\Collection;
use Modules\Location\Repositories\Interfaces\CityInterface;
use Modules\KamrulDashboard\Repositories\Caches\CacheAbstractDecorator;

class CityCacheDecorator extends CacheAbstractDecorator implements CityInterface
{

    /**
     * {@inheritDoc}
     */
    public function filters(?string $keyword, ?int $limit = 10, array $with = [], array $select = ['cities.*']): Collection
    {
        return $this->getDataIfExistCache(__FUNCTION__, func_get_args());
    }
}
