<?php

namespace Modules\KamrulDashboard\Forms\FieldOptions;


use Modules\KamrulDashboard\Forms\FormFieldOptions;

class RepeaterFieldOption extends FormFieldOptions
{
    protected $fields = [];

    protected $value = null;

    public function fields(array $fields)
    {
        $this->fields = $fields;

        return $this;
    }

    public function value($value)
    {
        $this->value = $value;

        return $this;
    }

    protected function parseValueJsonToArray(?string $data): array
    {
        if (! $data) {
            return [];
        }

        $items = json_decode($data);

        if (! is_array($items)) {
            return [];
        }

        foreach ($items as $i => $item) {
            foreach ($item as $j => $childItem) {
                $items[$i][$j] = collect($childItem)->toArray();
            }
        }

        return $items;
    }

    public function toArray(): array
    {
        $data = parent::toArray();

        if ($fields = $this->fields) {
            $data['fields'] = $fields;
        }

        if ($value = $this->value) {
            if (! is_array($value)) {
                $value = $this->parseValueJsonToArray($value);
            }

            $data['value'] = $value;
        }

        return $data;
    }
}
