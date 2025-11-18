<?php

namespace Modules\KamrulDashboard\Forms\FieldOptions;


class TextFieldOption extends InputFieldOption
{
    protected $append;

    protected $prepend;

    public static function make()
    {
        return parent::make()
            ->maxLength(250);
    }

    public function maxLength(int $maxLength)
    {
        if ($maxLength > 0) {
            $this->addAttribute('data-counter', $maxLength);
        } else {
            $this->removeAttribute('data-counter');
        }

        return $this;
    }

    public function allowOverLimit(bool $allowOverLimit = true)
    {
        $this->addAttribute('data-allow-over-limit', $allowOverLimit);

        return $this;
    }

    public function append(string $append)
    {
        $this->append = $append;

        return $this;
    }

    public function prepend(string $prepend)
    {
        $this->prepend = $prepend;

        return $this;
    }

    public function cssClass(string $class)
    {
        $cssClass = trim($this->getAttribute('class') . ' ' . $class);

        if ($cssClass) {
            $this->addAttribute('class', $cssClass);
        } else {
            $this->removeAttribute('class');
        }

        return $this;
    }

    public function toArray(): array
    {
        $data = parent::toArray();

        if (isset($this->append)) {
            $data['append'] = $this->append;
        }

        if (isset($this->prepend)) {
            $data['prepend'] = $this->prepend;
        }

        return $data;
    }
}
