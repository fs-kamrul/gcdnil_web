<?php

namespace Modules\AdminBoard\Repositories\Eloquent;

use Modules\AdminBoard\Repositories\Interfaces\AdminCategoryInterface;
use Modules\KamrulDashboard\Repositories\Eloquent\RepositoriesAbstract;
use Illuminate\Support\Str;

class AdminCategoryRepository extends RepositoriesAbstract implements AdminCategoryInterface
{
     public function getAdminCategory(array $select, array $orderBy, array $conditions = [])
     {

         $data = $this->model->where($conditions);
         if ($conditions) {
             $data = $data->where($conditions);
         }
//         dd($select);
//         foreach ($orderBy as $by => $direction) {
//             $data = $data->orderBy($by, $direction);
//         }

         return $this->applyBeforeExecuteQuery($data)->get();
     }

    /**
     * {@inheritDoc}
     */
    public function createSlug($name)
    {
        $slug = Str::slug($name);
        $index = 1;
        $baseSlug = $slug;
        while ($this->model->where('slug', $slug)->count() > 0) {
            $slug = $baseSlug . '-' . $index++;
        }

        if (empty($slug)) {
            $slug = time();
        }

        $this->resetModel();

        return $slug;
    }
    public function getCategoriesByBoard($board)
    {
        return $this->model->where('adminboard', $board)->pluck('name', 'id')->toArray();
    }
}
