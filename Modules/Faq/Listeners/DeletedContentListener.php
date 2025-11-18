<?php

namespace Modules\Faq\Listeners;

use Exception;
use MetaBox;
use Modules\KamrulDashboard\Events\DeletedContentEvent;

class DeletedContentListener
{
    public function handle(DeletedContentEvent $event): void
    {
        try {
            MetaBox::deleteMetaData($event->data, 'faq_schema_config');
            MetaBox::deleteMetaData($event->data, 'curriculum_schema_config');
        } catch (Exception $exception) {
            info($exception->getMessage());
        }
    }
}
