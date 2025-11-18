<?php

namespace Modules\KamrulDashboard\Forms\Fields;


use Modules\KamrulDashboard\Forms\FormField;

class TextField extends FormField
{
    protected function getTemplate(): string
    {
        return 'kamruldashboard::forms.fields.text';
    }
}
