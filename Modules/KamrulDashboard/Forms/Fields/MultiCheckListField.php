<?php

namespace Modules\KamrulDashboard\Forms\Fields;

use Kris\LaravelFormBuilder\Fields\FormField;

class MultiCheckListField extends FormField
{

    /**
     * {@inheritDoc}
     */
    protected function getTemplate()
    {
        return 'kamruldashboard::forms.fields.multi-check-list';
    }
}
