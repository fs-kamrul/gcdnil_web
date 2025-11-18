<?php

namespace Modules\KamrulDashboard\Forms\FieldOptions;

class EmailFieldOption extends TextFieldOption
{
    public static function make()
    {
        return parent::make()
            ->label(trans('kamruldashboard::forms.email'))
            ->placeholder(trans('kamruldashboard::forms.email_placeholder'))
            ->maxLength(60);
    }
}
