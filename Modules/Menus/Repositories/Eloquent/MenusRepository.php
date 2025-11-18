<?php

namespace Modules\Menus\Repositories\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Eloquent;
use Modules\KamrulDashboard\Packages\Supports\DboardStatus;
use Modules\KamrulDashboard\Repositories\Eloquent\RepositoriesAbstract;
use Modules\Menus\Repositories\Interfaces\MenusInterface;

class MenusRepository extends RepositoriesAbstract  implements MenusInterface
{
    /**
     * {@inheritDoc}
     */
    public function findBySlug($slug, $active = 1, array $select = [], array $with = [])
    {
        $data = $this->model->where('slug', $slug);

        if ($active) {
            $data = $data->where('status', DboardStatus::PUBLISHED);
        }

        if (!empty($select)) {
            $data = $data->select($select);
        }

        if (!empty($with)) {
            $data = $data->with($with);
        }

        $data = $this->applyBeforeExecuteQuery($data, true)->first();

        $this->resetModel();

        return $data;
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

    /**
     * {@inheritDoc}
     */
    public function resetModel()
    {
        $this->model = new $this->originalModel;

        return $this;
    }
}
