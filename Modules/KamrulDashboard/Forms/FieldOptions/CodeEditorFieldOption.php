<?php

namespace Modules\KamrulDashboard\Forms\FieldOptions;

class CodeEditorFieldOption extends TextareaFieldOption
{
    public function mode(string $mode)
    {
        $this->addAttribute('mode', $mode);

        return $this;
    }
}
