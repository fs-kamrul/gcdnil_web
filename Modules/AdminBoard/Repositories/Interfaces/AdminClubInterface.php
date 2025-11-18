<?php

namespace Modules\AdminBoard\Repositories\Interfaces;

use Modules\KamrulDashboard\Repositories\Interfaces\RepositoryInterface;

interface AdminClubInterface extends RepositoryInterface
{
    public function getAdminClubGroup(array $filters = [], array $params = []);
    public function getAdminClub(array $filters = [], array $params = []);
    public function getRelatedAdminClub(int $adminId, int $limit = 4, array $with = []);
    /**
     * @param string $name
     * @return mixed
     */
    public function createSlug($name);
}
