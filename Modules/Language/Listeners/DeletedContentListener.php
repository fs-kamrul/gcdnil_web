<?php

namespace Modules\Language\Listeners;

use Exception;
use Language;
use Modules\KamrulDashboard\Events\DeletedContentEvent;

class DeletedContentListener
{

    /**
     * Handle the event.
     *
     * @param DeletedContentEvent $event
     * @return void
     */
    public function handle(DeletedContentEvent $event)
    {
        try {
            Language::deleteLanguage($event->screen, $event->data);
        } catch (Exception $exception) {
            info($exception->getMessage());
        }
    }
}
