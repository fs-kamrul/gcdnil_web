<?php

namespace Modules\Newsletter\Repositories\Eloquent;

use Modules\Newsletter\Repositories\Interfaces\NewsletterInterface;
use Modules\KamrulDashboard\Repositories\Eloquent\RepositoriesAbstract;
use Illuminate\Support\Str;

class NewsletterRepository extends RepositoriesAbstract implements NewsletterInterface
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
