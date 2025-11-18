<?php

namespace Modules\KamrulDashboard\Forms\Fields;

use Kris\LaravelFormBuilder\Fields\FormField;

class CustomRadioField extends FormField
{

    /**
     * {@inheritDoc}
     */
    protected function getTemplate()
    {
        return 'kamruldashboard::forms.fields.custom-radio';
    }
}
