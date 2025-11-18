<?php

namespace Modules\LanguageAdvanced\Listeners;

use Exception;
use Modules\LanguageAdvanced\Packages\Supports\Plugin;

class PriorityLanguageAdvancedPluginListener
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
