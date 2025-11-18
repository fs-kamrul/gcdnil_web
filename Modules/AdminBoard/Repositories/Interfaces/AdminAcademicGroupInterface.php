<?php

namespace Modules\AdminBoard\Repositories\Interfaces;

use Modules\KamrulDashboard\Repositories\Interfaces\RepositoryInterface;

interface AdminAcademicGroupInterface extends RepositoryInterface
{
    public function getAdminAcademicGroup(array $filters = [], array $params = []);
    public function getRelatedAdminAcademicGroup(int $adminId, int $limit = 4, array $with = []);
    /**
     * @param string $name
     * @return mixed
     */
    public function createSlug($name);
}
