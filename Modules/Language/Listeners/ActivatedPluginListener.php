<?php

namespace Modules\Language\Listeners;

use Exception;
use Modules\Language\Packages\Supports\Plugin;

class ActivatedPluginListener
{

    /**
     * Handle the event.
     *
     * @return void
     */
    public function handle()
    {
        try {
            Plugin::activated();
        } catch (Exception $exception) {
            info($exception->getMessage());
        }
    }
}
