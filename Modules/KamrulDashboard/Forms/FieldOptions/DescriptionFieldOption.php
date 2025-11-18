<?php

namespace Modules\KamrulDashboard\Forms\FieldOptions;

class DescriptionFieldOption extends TextareaFieldOption
{
    public static function make()
    {
        return parent::make()
            ->label(trans('kamruldashboard::forms.short_description'))
            ->placeholder(trans('kamruldashboard::forms.description_placeholder'))
            ->maxLength(400)
            ->rows(4);
    }
}
