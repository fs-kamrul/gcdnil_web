<?php

namespace Modules\AdminBoard\Repositories\Interfaces;

use Modules\KamrulDashboard\Repositories\Interfaces\RepositoryInterface;

interface AdminNoticeBoardInterface extends RepositoryInterface
{
    public function getAdminNoticeBoard(array $filters = [], array $params = []);
    public function getRelatedAdminNoticeBoard(int $adminId, int $limit = 4, array $with = []);
    /**
     * @param string $name
     * @return mixed
     */
    public function createSlug($name);
}
