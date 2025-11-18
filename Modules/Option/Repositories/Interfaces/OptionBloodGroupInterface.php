<?php

namespace Modules\Option\Repositories\Interfaces;

use Modules\KamrulDashboard\Repositories\Interfaces\RepositoryInterface;

interface OptionBloodGroupInterface extends RepositoryInterface
{
    public function getOptionBloodGroup(array $filters = [], array $params = []);
    public function getRelatedOptionBloodGroup(int $adminId, int $limit = 4, array $with = []);
    /**
     * @param string $name
     * @return mixed
     */
    public function createSlug($name);
}
