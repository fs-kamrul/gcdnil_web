<?php

namespace Modules\KamrulDashboard\Forms\FieldOptions;

class RadioFieldOption extends SelectFieldOption
{
    public function toArray(): array
    {
        $data = parent::toArray();

        $data['values'] = $this->getChoices();

        return $data;
    }
}
