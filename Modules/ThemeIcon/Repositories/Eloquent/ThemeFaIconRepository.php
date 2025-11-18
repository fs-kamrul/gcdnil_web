<?php

namespace Modules\ThemeIcon\Repositories\Eloquent;

use Modules\ThemeIcon\Repositories\Interfaces\ThemeFaIconInterface;
use Modules\KamrulDashboard\Repositories\Eloquent\RepositoriesAbstract;
use Illuminate\Support\Str;

class ThemeFaIconRepository extends RepositoriesAbstract implements ThemeFaIconInterface
{
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
