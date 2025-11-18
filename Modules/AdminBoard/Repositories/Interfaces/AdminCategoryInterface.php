<?php

namespace Modules\AdminBoard\Repositories\Interfaces;

use Modules\KamrulDashboard\Repositories\Interfaces\RepositoryInterface;

interface AdminCategoryInterface extends RepositoryInterface
{
    public function getAdminCategory(array $select, array $orderBy);
    /**
     * @param string $name
     * @return mixed
     */
    public function createSlug($name);
    public function getCategoriesByBoard($board);
}
