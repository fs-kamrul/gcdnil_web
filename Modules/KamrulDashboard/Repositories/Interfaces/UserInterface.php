<?php

namespace Modules\KamrulDashboard\Repositories\Interfaces;

interface UserInterface extends RepositoryInterface
{

    /**
     * Get unique username from email
     *
     * @param $email
     * @return string
     *
     */
    public function getUniqueUsernameFromEmail($email);
}
