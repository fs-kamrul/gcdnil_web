<?php

namespace Modules\KamrulDashboard\Events;

use Illuminate\Queue\SerializesModels;
use Modules\KamrulDashboard\Packages\Supports\AdminNotificationItem;

class AdminNotificationEvent extends Event
{
    use SerializesModels;

    public function __construct(AdminNotificationItem $item)
    {
    }
}
