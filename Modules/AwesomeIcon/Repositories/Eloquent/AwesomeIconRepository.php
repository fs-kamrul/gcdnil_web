<?php

namespace Modules\AwesomeIcon\Repositories\Eloquent;

use Modules\AwesomeIcon\Repositories\Interfaces\AwesomeIconInterface;
use Modules\KamrulDashboard\Repositories\Eloquent\RepositoriesAbstract;
use Illuminate\Support\Str;

class AwesomeIconRepository extends RepositoriesAbstract implements AwesomeIconInterface
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
