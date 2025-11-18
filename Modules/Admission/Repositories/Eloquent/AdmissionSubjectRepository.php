<?php

namespace Modules\Admission\Repositories\Eloquent;

use Modules\Admission\Repositories\Interfaces\AdmissionSubjectInterface;
use Modules\KamrulDashboard\Repositories\Eloquent\RepositoriesAbstract;
use Illuminate\Support\Str;

class AdmissionSubjectRepository extends RepositoriesAbstract implements AdmissionSubjectInterface
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
