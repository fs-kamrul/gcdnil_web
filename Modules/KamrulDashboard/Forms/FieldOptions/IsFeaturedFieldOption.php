<?php

namespace Modules\KamrulDashboard\Forms\FieldOptions;

class IsFeaturedFieldOption extends CheckboxFieldOption
{
    public static function make()
    {
        return parent::make()
            ->label(trans('kamruldashboard::forms.is_featured'))
            ->defaultValue(0);
    }
}
