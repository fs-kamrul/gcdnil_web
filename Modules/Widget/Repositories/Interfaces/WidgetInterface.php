<?php

namespace Modules\Widget\Repositories\Interfaces;

use Modules\KamrulDashboard\Repositories\Interfaces\RepositoryInterface;

interface WidgetInterface extends RepositoryInterface
{
    /**
     * Get all theme widgets
     * @param string $theme
     * @return mixed
     */
    public function getByTheme($theme);
    /**
     * @param string $name
     * @return mixed
     */
    public function createSlug($name);
}
