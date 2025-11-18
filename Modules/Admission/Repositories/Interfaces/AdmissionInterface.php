<?php

namespace Modules\Admission\Repositories\Interfaces;

use Modules\KamrulDashboard\Repositories\Interfaces\RepositoryInterface;

interface AdmissionInterface extends RepositoryInterface
{
    /**
     * @param string $name
     * @return mixed
     */
    public function createSlug($name);
}
