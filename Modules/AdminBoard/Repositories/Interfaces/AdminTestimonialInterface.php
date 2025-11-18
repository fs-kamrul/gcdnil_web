<?php

namespace Modules\AdminBoard\Repositories\Interfaces;

use Modules\KamrulDashboard\Repositories\Interfaces\RepositoryInterface;

interface AdminTestimonialInterface extends RepositoryInterface
{
    public function getAdminTestimonial(array $filters = [], array $params = []);
    public function getRelatedAdminTestimonial(int $adminId, int $limit = 4, array $with = []);
    /**
     * @param string $name
     * @return mixed
     */
    public function createSlug($name);
}
