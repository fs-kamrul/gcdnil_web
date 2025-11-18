<?php

namespace Modules\KamrulDashboard\Forms;

use Closure;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Traits\Conditionable;
use Illuminate\Support\Traits\Tappable;
use Modules\KamrulDashboard\Packages\Supports\Builders\HasAttributes;
use Modules\KamrulDashboard\Packages\Supports\Builders\HasLabel;
use Modules\KamrulDashboard\Traits\Forms\CanSpanColumns;
use Modules\KamrulDashboard\Traits\Forms\HasCollapsibleField;

class FormFieldOptions implements Arrayable
{
    use CanSpanColumns;
    use Conditionable;
    use HasAttributes;
    use HasCollapsibleField;
    use HasLabel;
    use Tappable;

    protected $required = false;

    protected $helperText = [];

    protected $labelAttributes = [];

    protected $wrapperAttributes = [];

    protected $metadata = false;

    protected $disabled = false;

    protected $defaultValue;

    public static function make()
    {
        return app(static::class);
    }

    public function required(bool $required = true)
    {
        $this->required = $required;

        return $this;
    }

    public function isRequired(): bool
    {
        return $this->required;
    }

    public function labelAttributes(array $attributes)
    {
        $this->labelAttributes = $attributes;

        return $this;
    }

    public function getLabelAttributes(): array
    {
        return $this->labelAttributes;
    }

    public function wrapperAttributes(array $attributes)
    {
        $this->wrapperAttributes = $attributes;

        return $this;
    }

    public function getWrapperAttributes()
    {
        return $this->wrapperAttributes;
    }

    public function helperText(?string $helperText, array $attributes = [])
    {
        if (! $helperText) {
            return $this;
        }

        $attributes['class'] = (isset($attributes['class']) ? ' ' : '') . 'form-hint';

        $this->helperText = [
            'text' => $helperText,
            'tag' => 'small',
            'attr' => $attributes,
        ];

        return $this;
    }

    public function getHelperText(): array
    {
        return $this->helperText;
    }

    public function isMetadata(): bool
    {
        return $this->metadata;
    }

    public function metadata(bool $metadata = true)
    {
        $this->metadata = $metadata;

        return $this;
    }

    public function disabled(bool $disabled = true)
    {
        $this->disabled = $disabled;

        return $this;
    }

    public function isDisabled(): bool
    {
        return is_callable($this->disabled) ? call_user_func($this->disabled) : $this->disabled;
    }

    public function getDefaultValue()
    {
        return $this->defaultValue;
    }

    public function defaultValue($defaultValue)
    {
        $this->defaultValue = $defaultValue;

        return $this;
    }

    public function toArray(): array
    {
        $data = [
            'label' => $this->getLabel(),
            'required' => $this->isRequired(),
            'attr' => $this->getAttributes(),
        ];

        if ($this->colspan) {
            $data['colspan'] = $this->getColspan();
        }

        if ($this->helperText) {
            $data['help_block'] = $this->getHelperText();
        }

        if ($this->labelAttributes) {
            $data['label_attr'] = $this->getLabelAttributes();
        }

        if ($this->wrapperAttributes || $this->wrapperAttributes === false) {
            $data['wrapper'] = $this->getWrapperAttributes();
        }

        if ($this->isMetadata()) {
            $data['metadata'] = true;
        }

        if ($this->isDisabled()) {
            $data['attr']['disabled'] = true;
        }

        if (isset($this->defaultValue)) {
            $data['default_value'] = $this->getDefaultValue();
        }

        return $data;
    }
}
