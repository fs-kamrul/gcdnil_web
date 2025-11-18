<?php

namespace Modules\KamrulDashboard\Forms\Fields;


use Modules\KamrulDashboard\Forms\FieldTypes\SelectType;

class SelectField extends SelectType
{
    protected function getTemplate(): string
    {
        return 'kamruldashboard::forms.fields.custom-select';
    }

    public function getDefaults(): array
    {
        return [
            'choices' => [],
            'option_attributes' => [],
            'empty_value' => null,
            'selected' => null,
        ];
    }
}
