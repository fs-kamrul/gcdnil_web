<?php

namespace Modules\AdminBoard\Repositories\Interfaces;

use Modules\KamrulDashboard\Repositories\Interfaces\RepositoryInterface;

interface AdminCareerNavigatorInterface extends RepositoryInterface
{
    public function getAdminCareerNavigator(array $filters = [], array $params = []);
    public function getRelatedAdminCareerNavigator(int $adminId, int $limit = 4, array $with = []);
    /**
     * @param string $name
     * @return mixed
     */
    public function createSlug($name);
}
