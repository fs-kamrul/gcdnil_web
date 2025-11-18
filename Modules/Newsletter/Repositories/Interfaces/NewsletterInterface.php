<?php

namespace Modules\Newsletter\Repositories\Interfaces;

use Modules\KamrulDashboard\Repositories\Interfaces\RepositoryInterface;

interface NewsletterInterface extends RepositoryInterface
{
    /**
     * @param string $name
     * @return mixed
     */
    public function createSlug($name);
}
