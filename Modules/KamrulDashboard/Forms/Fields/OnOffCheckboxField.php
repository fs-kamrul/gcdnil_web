<?php

namespace Modules\KamrulDashboard\Forms\Fields;

use Modules\KamrulDashboard\Forms\FieldTypes\FormField;

class OnOffCheckboxField extends FormField
{
    protected $useDefaultFieldClass = false;

    protected function getTemplate(): string
    {
        return 'kamruldashboard::forms.fields.on-off-checkbox';
    }
}
