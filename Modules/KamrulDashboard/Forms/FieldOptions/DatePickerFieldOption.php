<?php

namespace Modules\KamrulDashboard\Forms\FieldOptions;

use Carbon\Carbon;

class DatePickerFieldOption extends InputFieldOption
{
    public static function make()
    {
        return parent::make()
            ->defaultValue(Carbon::now()->toDateString());
    }

    public function withTimePicker(bool $withTimePicker = true)
    {
        $options = $this->getAttribute('data-options', []);

        if ($withTimePicker) {
            $options['enableTime'] = true;
            $options['dateFormat'] = 'Y-m-d H:i:s';
        } else {
            $options['enableTime'] = false;
            $options['dateFormat'] = 'Y-m-d';
        }

        $this->addAttribute('data-options', $options);

        return $this;
    }
}
