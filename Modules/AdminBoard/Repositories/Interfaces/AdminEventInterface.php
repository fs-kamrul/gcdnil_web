<?php

namespace Modules\AdminBoard\Repositories\Interfaces;

use Modules\KamrulDashboard\Repositories\Interfaces\RepositoryInterface;

interface AdminEventInterface extends RepositoryInterface
{
    public function getEvent(array $filters = [], array $params = []);
    public function getRelatedEvent(int $adminWorkshopId, int $limit = 4, array $with = []);
    /**
     * @param string $name
     * @return mixed
     */
    public function createSlug($name);
}
