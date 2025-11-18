<?php

namespace Modules\KamrulDashboard\Forms\FieldOptions;

class SortOrderFieldOption extends TextFieldOption
{
    public static function make()
    {
        return parent::make()
            ->label(trans('kamruldashboard::forms.sort_order'))
            ->placeholder(trans('kamruldashboard::forms.order_by_placeholder'))
            ->defaultValue(0);
    }
}
