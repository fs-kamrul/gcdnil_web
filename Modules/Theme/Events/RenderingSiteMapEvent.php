<?php

namespace Modules\Theme\Events;

use Modules\KamrulDashboard\Events\Event;
use Illuminate\Queue\SerializesModels;

class RenderingSiteMapEvent extends Event
{
    use SerializesModels;
}
