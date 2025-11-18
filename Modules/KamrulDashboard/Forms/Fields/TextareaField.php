<?php

namespace Modules\KamrulDashboard\Forms\Fields;


use Modules\KamrulDashboard\Forms\FormField;

class TextareaField extends FormField
{
    protected function getTemplate(): string
    {
        return 'kamruldashboard::forms.fields.textarea';
    }
}
