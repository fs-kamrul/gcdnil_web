<?php

namespace Modules\KamrulDashboard\Events;

use Illuminate\Queue\SerializesModels;

class ActivatedPluginEvent extends Event
{
    use SerializesModels;

    /**
     * @var string
     */
    public $plugin;

    /**
     * ActivatedPluginEvent constructor.
     * @param string $plugin
     */
    public function __construct(string $plugin)
    {
        $this->plugin = $plugin;
    }
}
