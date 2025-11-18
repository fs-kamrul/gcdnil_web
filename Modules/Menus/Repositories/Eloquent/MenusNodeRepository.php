<?php

namespace Modules\Menus\Repositories\Eloquent;


use Modules\KamrulDashboard\Repositories\Eloquent\RepositoriesAbstract;
use Modules\Menus\Repositories\Interfaces\MenusNodeInterface;

class MenusNodeRepository extends RepositoriesAbstract implements MenusNodeInterface
{
    /**
     * {@inheritDoc}
     */
    public function getByMenuId($menuId, $parentId, $select = ['*'], array $with = ['child'])
    {
        $data = $this->model
            ->with($with)
            ->where([
                'menus_id'   => $menuId,
                'parent_id' => $parentId,
            ]);

        if (!empty($select)) {
            $data = $data->select($select);
        }

        $data = $data->orderBy('position', 'asc')
            ->get();

        $this->resetModel();

        return $data;
    }
}
