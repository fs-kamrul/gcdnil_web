<?php

namespace Modules\KamrulDashboard\Forms\FieldOptions;


use Modules\KamrulDashboard\Forms\FormFieldOptions;

class InputFieldOption extends FormFieldOptions
{
    protected $value;

    public function value($value)
    {
        $this->value = $value;

        return $this;
    }

    public function getValue()
    {
        return $this->value;
    }

    public function placeholder(string $placeholder)
    {
        $this->addAttribute('placeholder', $placeholder);

        return $this;
    }

    public function toArray(): array
    {
        $data = parent::toArray();

        if (isset($this->value)) {
            $data['value'] = $this->getValue();
        }

        return $data;
    }
}
