<?php

namespace Modules\Location\Repositories\Interfaces;

use Illuminate\Database\Eloquent\Collection;
use Modules\KamrulDashboard\Repositories\Interfaces\RepositoryInterface;

interface CityInterface extends RepositoryInterface
{
    public function filters(?string $keyword, ?int $limit = 10, array $with = [], array $select = ['cities.*']): Collection;
}
