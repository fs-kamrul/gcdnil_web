<?php

namespace Modules\KamrulDashboard\Forms\FieldOptions;

class ImageFieldOption extends TextFieldOption
{
    public static function make()
    {
        return parent::make()
            ->label(trans('kamruldashboard::forms.image'));
    }
}
