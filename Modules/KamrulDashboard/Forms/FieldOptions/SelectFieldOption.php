<?php

namespace Modules\KamrulDashboard\Forms\FieldOptions;

use Illuminate\Support\Collection;
use Modules\KamrulDashboard\Forms\FormFieldOptions;

class SelectFieldOption extends FormFieldOptions
{
    protected $choices = [];

    protected $selected;

    protected $searchable = false;

    protected $multiple = false;

    protected $emptyValue;

    protected $allowClear = false;

    public function choices(array $choices)
    {
        $this->choices = $choices;

        return $this;
    }

    public function getChoices(): array
    {
        return $this->choices;
    }

    public function selected($selected)
    {
        $this->selected = $selected;

        return $this;
    }

    public function getSelected()
    {
        return $this->selected;
    }

    public function searchable(bool $searchable = true)
    {
        $this->searchable = $searchable;

        if ($searchable) {
            if ($this->multiple) {
                $this->addAttribute('class', 'select-multiple');
            } else {
                $this->addAttribute('class', 'select-search-full');
            }
        }

        return $this;
    }

    public function ajaxSearch()
    {
        $this->addAttribute('class', 'select-search-ajax');

        return $this;
    }

    public function ajaxUrl(string $url)
    {
        $this->addAttribute('data-url', $url);

        return $this;
    }

    public function multiple(bool $multiple = true)
    {
        $this->multiple = $multiple;

        if ($multiple) {
            $this->addAttribute('multiple', true);

            if ($this->searchable) {
                $this->addAttribute('class', 'select-multiple');
            }
        }

        return $this;
    }

    public function emptyValue(string $value)
    {
        $this->emptyValue = $value;

        return $this;
    }

    public function getEmptyValue(): string
    {
        return $this->emptyValue;
    }

    public function allowClear(bool $allowClear = true)
    {
        $this->allowClear = $allowClear;

        return $this;
    }

    public function toArray(): array
    {
        $data = parent::toArray();

        $data['choices'] = $this->getChoices();

        if (isset($this->selected)) {
            $data['selected'] = $this->getSelected();

            if (is_array($this->selected) && ! empty(array_filter($this->selected))) {
                $data['attr']['data-selected'] = json_encode($this->getSelected());
            }
        } elseif (isset($this->defaultValue)) {
            $data['selected'] = $this->getDefaultValue();
        }

        if (isset($this->emptyValue) && $placeholder = $this->getEmptyValue()) {
            $data['attr']['placeholder'] = $placeholder;
            $data['attr']['data-placeholder'] = $placeholder;

        }

        if ($this->searchable) {
            $data['attr']['data-allow-clear'] = $this->allowClear ? 'true' : 'false';
        }

        return $data;
    }
}
