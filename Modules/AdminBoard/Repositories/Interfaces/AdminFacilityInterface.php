<?php

namespace Modules\AdminBoard\Repositories\Interfaces;

use Modules\KamrulDashboard\Repositories\Interfaces\RepositoryInterface;

interface AdminFacilityInterface extends RepositoryInterface
{
    public function getAdminFacility(array $filters = [], array $params = []);
    public function getRelatedAdminFacility(int $adminId, int $limit = 4, array $with = []);
    /**
     * @param string $name
     * @return mixed
     */
    public function createSlug($name);
}
