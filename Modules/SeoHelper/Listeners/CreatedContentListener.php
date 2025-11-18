<?php

namespace Modules\SeoHelper\Listeners;

use Exception;
use Modules\KamrulDashboard\Events\CreatedContentEvent;
use SeoHelper;

class CreatedContentListener
{
    public function handle(CreatedContentEvent $event): void
    {
        try {
            SeoHelper::saveMetaData($event->screen, $event->request, $event->data);
        } catch (Exception $exception) {
            info($exception->getMessage());
        }
    }
}
