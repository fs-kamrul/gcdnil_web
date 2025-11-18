<?php

namespace Modules\KamrulDashboard\Forms\FieldOptions;


use Modules\KamrulDashboard\Forms\FormFieldOptions;

class CheckboxFieldOption extends FormFieldOptions
{
    protected $value;

    protected $checked;

    public function value($value)
    {
        $this->value = $value;

        return $this;
    }

    public function getValue()
    {
        return $this->value;
    }

    public function checked(bool $checked)
    {
        $this->checked = $checked;

        return $this;
    }

    public function toArray(): array
    {
        $data = parent::toArray();

        if (isset($this->value)) {
            $data['value'] = $this->getValue();
        }

        if (isset($this->checked)) {
            $data['checked'] = $this->checked;
        }

        return $data;
    }
}
