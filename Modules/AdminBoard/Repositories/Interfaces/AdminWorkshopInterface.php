<?php

namespace Modules\AdminBoard\Repositories\Interfaces;

use Modules\KamrulDashboard\Repositories\Interfaces\RepositoryInterface;

interface AdminWorkshopInterface extends RepositoryInterface
{

    public function getWorkshop(array $filters = [], array $params = []);
    public function getRelatedWorkshop(int $adminWorkshopId, int $limit = 4, array $with = []);
    /**
     * @param string $name
     * @return mixed
     */
    public function createSlug($name);
}
