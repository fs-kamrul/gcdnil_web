<?php

namespace Modules\Language\Listeners;

use Exception;
use Language;
use Modules\KamrulDashboard\Events\CreatedContentEvent;

class CreatedContentListener
{

    /**
     * Handle the event.
     *
     * @param CreatedContentEvent $event
     * @return void
     */
    public function handle(CreatedContentEvent $event)
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
