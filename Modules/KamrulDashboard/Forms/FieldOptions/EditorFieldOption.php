<?php

namespace Modules\KamrulDashboard\Forms\FieldOptions;

class EditorFieldOption extends TextareaFieldOption
{
    public static function make()
    {
        return parent::make()
            ->maxLength(100000)
            ->rows(4);
    }

    public function allowedShortcodes(bool $allowedShortcodes = true)
    {
        $this->addAttribute('with-short-code', $allowedShortcodes);

        return $this;
    }
}
