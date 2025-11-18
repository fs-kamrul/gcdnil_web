<?php

namespace Modules\KamrulDashboard\Hooks;

use EmailHandler;

class EmailSettingHooks
{
    public static function addEmailTemplateSettings(?string $html): string
    {
        $templates = '';

        foreach (EmailHandler::getTemplates() as $type => $item) {
            foreach ($item as $module => $data) {
                $templates .= view('kamruldashboard::setting_data.template-line', compact('type', 'module', 'data'))->render();
            }
        }

        return $html . $templates;
    }
}
