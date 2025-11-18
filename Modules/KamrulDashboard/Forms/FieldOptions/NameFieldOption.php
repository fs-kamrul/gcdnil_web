<?php

namespace Modules\KamrulDashboard\Forms\FieldOptions;

class NameFieldOption extends TextFieldOption
{
    public static function make()
    {
        return parent::make()
            ->label(trans('kamruldashboard::forms.name'))
            ->placeholder(trans('kamruldashboard::forms.name_placeholder'))
            ->maxLength(250);
    }
}
