<?php

namespace Modules\SeoHelper\Listeners;

use Exception;
use Modules\KamrulDashboard\Events\DeletedContentEvent;
use SeoHelper;

class DeletedContentListener
{
    public function handle(DeletedContentEvent $event): void
    {
        try {
            SeoHelper::deleteMetaData($event->screen, $event->data);
        } catch (Exception $exception) {
            info($exception->getMessage());
        }
    }
}
