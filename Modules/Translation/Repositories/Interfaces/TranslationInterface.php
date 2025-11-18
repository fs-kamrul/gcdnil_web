<?php

namespace Modules\Translation\Repositories\Interfaces;

use Modules\KamrulDashboard\Repositories\Interfaces\RepositoryInterface;

interface TranslationInterface extends RepositoryInterface
{
    /**
     * @param string $name
     * @return mixed
     */
    public function createSlug($name);
}
