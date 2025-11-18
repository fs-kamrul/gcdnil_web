<?php

namespace Modules\LanguageAdvanced\Listeners;

use Illuminate\Support\Facades\DB;
use Modules\KamrulDashboard\Events\DeletedContentEvent;
use Modules\LanguageAdvanced\Packages\Supports\LanguageAdvancedManager;

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
        if (LanguageAdvancedManager::isSupported($event->data)) {

            $table = $event->data->getTable() . '_translations';

            DB::table($table)->where([$event->data->getTable() . '_id' => $event->data->id])->delete();
        }
    }
}
