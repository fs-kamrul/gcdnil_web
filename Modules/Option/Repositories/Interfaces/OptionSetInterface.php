<?php

namespace Modules\Option\Repositories\Interfaces;

use Modules\KamrulDashboard\Repositories\Interfaces\RepositoryInterface;

interface OptionSetInterface extends RepositoryInterface
{
    public function getOptionSet(array $filters = [], array $params = []);
    public function getRelatedOptionSet(int $adminId, int $limit = 4, array $with = []);
    /**
     * @param string $name
     * @return mixed
     */
    public function createSlug($name);
}
