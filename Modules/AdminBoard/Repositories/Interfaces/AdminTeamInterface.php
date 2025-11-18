<?php

namespace Modules\AdminBoard\Repositories\Interfaces;

use Modules\KamrulDashboard\Repositories\Interfaces\RepositoryInterface;

interface AdminTeamInterface extends RepositoryInterface
{
    public function getAdminTeam(array $filters = [], array $params = []);
    public function getRelatedAdminTeam(int $adminId, int $limit = 4, array $with = []);
    /**
     * @param string $name
     * @return mixed
     */
    public function createSlug($name);
}
