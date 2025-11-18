<?php

namespace Modules\KamrulDashboard\Forms\FieldOptions;

class TextareaFieldOption extends TextFieldOption
{
    public static function make()
    {
        return parent::make()
            ->maxLength(1000)
            ->rows(3);
    }

    public function rows(int $rows)
    {
        $this->addAttribute('rows', $rows);

        return $this;
    }
}
