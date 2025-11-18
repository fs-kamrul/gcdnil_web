<?php

namespace Modules\AdminBoard\Repositories\Interfaces;

use Modules\KamrulDashboard\Repositories\Interfaces\RepositoryInterface;

interface AdminGalleryBoardInterface extends RepositoryInterface
{
    public function getAdminGalleryBoard(array $filters = [], array $params = []);
    public function getRelatedAdminGalleryBoard(int $adminId, int $limit = 4, array $with = []);
    /**
     * @param string $name
     * @return mixed
     */
    public function createSlug($name);
}
