<?php

namespace Modules\KamrulDashboard\Forms\FieldOptions;



use Modules\KamrulDashboard\Forms\FormFieldOptions;

class ButtonFieldOption extends FormFieldOptions
{
    public function cssClass(string $class)
    {
        $cssClass = trim($this->getAttribute('class') . ' ' . $class);

        if ($cssClass) {
            $this->addAttribute('class', $cssClass);
        } else {
            $this->removeAttribute('class');
        }

        return $this;
    }
}
