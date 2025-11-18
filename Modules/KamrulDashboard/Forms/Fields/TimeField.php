<?php

namespace Modules\KamrulDashboard\Forms\Fields;

use Assets;
use Kris\LaravelFormBuilder\Fields\FormField;

class TimeField extends FormField
{

    /**
     * {@inheritDoc}
     */
    protected function getTemplate()
    {
        Assets::addScripts(['timepicker'])
            ->addStyles(['timepicker']);

        return 'kamruldashboard::forms.fields.time';
    }
}
