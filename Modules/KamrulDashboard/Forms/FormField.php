<?php

namespace Modules\KamrulDashboard\Forms;

use Kris\LaravelFormBuilder\Fields\FormField as DboardFormField;
use Modules\KamrulDashboard\Traits\Forms\CanSpanColumns;

abstract class FormField extends DboardFormField
{
    use CanSpanColumns;

    protected $useDefaultFieldClass = true;

    protected $defaultFieldAttributes = [];

    protected function getDefaults(): array
    {
        $attributes = parent::getDefaults();

        if ($this->defaultFieldAttributes) {
            $attributes['attr'] = array_merge(
                isset($attributes['attr']) ? $attributes['attr'] : [],
                $this->defaultFieldAttributes
            );
        }

        if (! $this->useDefaultFieldClass) {
            $attributes['attr']['class'] = null;
        }

        return $attributes;
    }
}
