<?php

namespace Modules\Menus\Repositories\Interfaces;


use Modules\KamrulDashboard\Repositories\Interfaces\RepositoryInterface;

interface MenusInterface extends RepositoryInterface
{

    /**
     * @param string $slug
     * @param bool $active
     * @param array $select
     * @param array $with
     * @return mixed
     */
    public function findBySlug($slug, $active, array $select = [], array $with = []);

    /**
     * @param string $name
     * @return mixed
     */
    public function createSlug($name);
}
