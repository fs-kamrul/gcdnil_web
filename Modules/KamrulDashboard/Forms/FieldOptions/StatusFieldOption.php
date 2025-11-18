<?php

namespace Modules\KamrulDashboard\Forms\FieldOptions;


use Modules\KamrulDashboard\Packages\Supports\DboardStatus;

class StatusFieldOption extends SelectFieldOption
{
    public static function make()
    {
        return parent::make()
            ->label(trans('kamruldashboard::forms.status'))
            ->required()
            ->choices(DboardStatus::labels());
    }
}
