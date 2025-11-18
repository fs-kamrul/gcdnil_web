<?php

namespace Modules\KamrulDashboard\Forms\FieldOptions;

class ContentFieldOption extends EditorFieldOption
{
    public static function make()
    {
        return parent::make()
            ->label(trans('kamruldashboard::forms.content'))
            ->placeholder(trans('kamruldashboard::forms.content_placeholder'));
    }
}
