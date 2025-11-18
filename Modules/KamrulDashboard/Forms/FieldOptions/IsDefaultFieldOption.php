<?php

namespace Modules\KamrulDashboard\Forms\FieldOptions;

class IsDefaultFieldOption extends CheckboxFieldOption
{
    public static function make()
    {
        return parent::make()
            ->label(trans('kamruldashboard::forms.is_default'))
            ->defaultValue(0);
    }
}
