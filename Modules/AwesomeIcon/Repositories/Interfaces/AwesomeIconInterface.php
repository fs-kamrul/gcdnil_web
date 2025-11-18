<?php

namespace Modules\AwesomeIcon\Repositories\Interfaces;

use Modules\KamrulDashboard\Repositories\Interfaces\RepositoryInterface;

interface AwesomeIconInterface extends RepositoryInterface
{
    /**
     * @param string $name
     * @return mixed
     */
    public function createSlug($name);
}
