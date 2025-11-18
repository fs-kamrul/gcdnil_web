<?php

namespace Modules\Widget\Repositories\Eloquent;

use Modules\Widget\Repositories\Interfaces\WidgetInterface;
use Modules\KamrulDashboard\Repositories\Eloquent\RepositoriesAbstract;
use Illuminate\Support\Str;

class WidgetRepository extends RepositoriesAbstract implements WidgetInterface
{

    /**
     * {@inheritDoc}
     */
    public function getByTheme($theme)
    {
        $data = $this->model->where('theme', $theme)->get();
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
}
