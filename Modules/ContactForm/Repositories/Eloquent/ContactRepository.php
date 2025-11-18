<?php

namespace Modules\ContactForm\Repositories\Eloquent;

use Modules\ContactForm\Enums\ContactStatus;
use Modules\ContactForm\Repositories\Interfaces\ContactInterface;
use Modules\KamrulDashboard\Repositories\Eloquent\RepositoriesAbstract;

class ContactRepository extends RepositoriesAbstract implements ContactInterface
{
    /**
     * {@inheritDoc}
     */
    public function getUnread($select = ['*'])
    {
        $data = $this->model
            ->where('status', ContactStatus::UNREAD)
            ->select($select)
            ->orderBy('created_at', 'DESC')
            ->get();

        $this->resetModel();

        return $data;
    }

    /**
     * {@inheritDoc}
     */
    public function countUnread()
    {
        $data = $this->model->where('status', ContactStatus::UNREAD)->count();
        $this->resetModel();

        return $data;
    }
}
