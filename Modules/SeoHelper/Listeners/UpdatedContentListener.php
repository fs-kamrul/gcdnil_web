<?php

namespace Modules\SeoHelper\Listeners;

use Exception;
use Modules\KamrulDashboard\Events\UpdatedContentEvent;
use SeoHelper;

class UpdatedContentListener
{
    public function handle(UpdatedContentEvent $event): void
    {
        try {
            SeoHelper::saveMetaData($event->screen, $event->request, $event->data);
        } catch (Exception $exception) {
            info($exception->getMessage());
        }
    }
}
