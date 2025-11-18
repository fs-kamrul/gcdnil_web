<?php

namespace Modules\Theme\Events;

use Illuminate\Queue\SerializesModels;
use Modules\KamrulDashboard\Events\Event;

class RenderingHomePageEvent extends Event
{
    use SerializesModels;
}
