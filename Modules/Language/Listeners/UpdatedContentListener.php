<?php

namespace Modules\Language\Listeners;

use Exception;
use Language;
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
            if ($event->request->input('language')) {
                Language::saveLanguage($event->screen, $event->request, $event->data);
            }
        } catch (Exception $exception) {
            info($exception->getMessage());
        }
    }
}
