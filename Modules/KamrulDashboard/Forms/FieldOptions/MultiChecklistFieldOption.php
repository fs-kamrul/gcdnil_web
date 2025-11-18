<?php

namespace Modules\KamrulDashboard\Forms\FieldOptions;

class MultiChecklistFieldOption extends SelectFieldOption
{
    public function placeholder(string $placeholder)
    {
        $this->addAttribute('placeholder', $placeholder);

        return $this;
    }

    public function toArray(): array
    {
        $data = parent::toArray();

        if (isset($this->emptyValue)) {
            $data['empty_value'] = $this->getEmptyValue();
        }

        return $data;
    }
}
