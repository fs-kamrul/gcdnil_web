<?php

namespace Modules\KamrulDashboard\Forms\FieldOptions;

class TagFieldOption extends SelectFieldOption
{
    protected $value = null;

    public function ajaxUrl(string $url)
    {
        $this->addAttribute('data-url', $url);

        return $this;
    }

    public function placeholder(string $placeholder)
    {
        $this->addAttribute('placeholder', $placeholder);

        return $this;
    }

    public function value($value)
    {
        $this->value = $value;

        return $this;
    }

    public function toArray(): array
    {
        $data = parent::toArray();

        if ($this->value) {
            $data['value'] = $this->value;
        }

        return $data;
    }
}
