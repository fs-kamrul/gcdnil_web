<?php

namespace Modules\KamrulDashboard\Listeners;

use Exception;
use Modules\KamrulDashboard\Events\UpdatedContentEvent;

class UpdatedContentListener
{

    /**
     * Handle the event.
     *
     * @param UpdatedContentEvent $event
     * @return void
     */
    public function handle(UpdatedContentEvent $event)
    {
        try {
            do_action(BASE_ACTION_AFTER_UPDATE_CONTENT, $event->screen, $event->request, $event->data);
        } catch (Exception $exception) {
            info($exception->getMessage());
        }
    }
}
