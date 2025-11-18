<?php

namespace Modules\KamrulDashboard\Forms\FieldOptions;


use Modules\KamrulDashboard\Forms\FormFieldOptions;

class MediaImagesFieldOption extends FormFieldOptions
{
    protected $selected;

    public static function make()
    {
        return parent::make()
            ->label(trans('kamruldashboard::forms.images'));
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

    public function toArray(): array
    {
        $data = parent::toArray();

        if (isset($this->selected)) {
            $data['selected'] = $this->getSelected();
        }

        return $data;
    }
}
