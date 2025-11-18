<?php

namespace Modules\Language\Listeners;

use Exception;
use Language;
use Modules\KamrulDashboard\Repositories\Interfaces\SettingInterface;
use Modules\Theme\Events\ThemeRemoveEvent;
use Modules\Widget\Repositories\Interfaces\WidgetInterface;

class ThemeRemoveListener
{

    /**
     * Handle the event.
     *
     * @param ThemeRemoveEvent $event
     * @return void
     */
    public function handle(ThemeRemoveEvent $event)
    {
        try {
            $languages = Language::getActiveLanguage(['lang_code']);

            foreach ($languages as $language) {
                app(WidgetInterface::class)->deleteBy(['theme' => $event->theme . '-' . $language->lang_code]);

                app(SettingInterface::class)
                    ->deleteBy(['key', 'like', 'theme-' . $event->theme . '-' . $language->lang_code . '-%']);
            }

        } catch (Exception $exception) {
            info($exception->getMessage());
        }
    }
}
