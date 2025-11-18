<?php

namespace Modules\AdminBoard\Repositories\Interfaces;

use Modules\KamrulDashboard\Repositories\Interfaces\RepositoryInterface;

interface AdminEducationInterface extends RepositoryInterface
{
    public function getAdminEducation(array $filters = [], array $params = []);
    public function getRelatedAdminEducation(int $adminId, int $limit = 4, array $with = []);
    /**
     * @param string $name
     * @return mixed
     */
    public function createSlug($name);
}
