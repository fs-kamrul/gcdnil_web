<?php

namespace Modules\Menus\Repositories\Interfaces;

use Illuminate\Database\Eloquent\Collection;
use Modules\KamrulDashboard\Repositories\Interfaces\RepositoryInterface;

interface MenusNodeInterface extends RepositoryInterface
{
    /**
     * @param int $menuId
     * @param int $parentId
     * @param array $select
     * @param array $with
     * @return array|Collection|static[]
     */
    public function getByMenuId($menuId, $parentId, $select = ['*'], array $with = ['child']);
}
