<?php

namespace Modules\Theme\Events;

use Illuminate\Queue\SerializesModels;
use Modules\KamrulDashboard\Events\Event;

class ThemeRemoveEvent extends Event
{
    use SerializesModels;

    /**
     * @var string
     */
    public $theme;

    /**
     * ThemeRemoveEvent constructor.
     * @param string
     */
    public function __construct($theme)
    {
        $this->theme = $theme;
    }
}
