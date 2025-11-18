<?php

namespace Modules\KamrulDashboard\Packages\Supports\Builders;

use Illuminate\Support\Arr;

trait HasAttributes
{
    protected  $attributes = [];

    public function attributes(array $attributes)
    {
        $this->attributes = $attributes;

        return $this;
    }

    public function addAttribute(string $attribute, $value)
    {
        $this->attributes[$attribute] = $value;

        return $this;
    }

    public function removeAttribute(string $attribute)
    {
        Arr::forget($this->attributes, $attribute);

        return $this;
    }

    public function getAttributes(): array
    {
        return $this->attributes;
    }

    public function getAttribute(string $attribute, $default = null)
    {
        return Arr::get($this->attributes, $attribute, $default);
    }
}
