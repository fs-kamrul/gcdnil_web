<?php

namespace Modules\AdminBoard\Repositories\Interfaces;

use Modules\KamrulDashboard\Repositories\Interfaces\RepositoryInterface;

interface AdminGalleryInterface extends RepositoryInterface
{
    public function getAdminGallery(array $filters = [], array $params = []);
    public function getRelatedAdminGallery(int $adminId, int $limit = 4, array $with = []);
    /**
     * @param string $name
     * @return mixed
     */
    public function createSlug($name);
}
