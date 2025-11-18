<?php

namespace Modules\ThemeIcon\Repositories\Interfaces;

use Modules\KamrulDashboard\Repositories\Interfaces\RepositoryInterface;

interface ThemeFaIconInterface extends RepositoryInterface
{
    /**
     * @param string $name
     * @return mixed
     */
    public function createSlug($name);
}
