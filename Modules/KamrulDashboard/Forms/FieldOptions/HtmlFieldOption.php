<?php

namespace Modules\KamrulDashboard\Forms\FieldOptions;

use Closure;
use Modules\KamrulDashboard\Forms\FormFieldOptions;

class HtmlFieldOption extends FormFieldOptions
{
    protected $html = '';

    public function view(string $view, array $data = [], array $mergeData = [])
    {
        return $this->content(
            view($view, $data, $mergeData)->render()
        );
    }

    public function content(string $content)
    {
        $this->html = value($content);

        return $this;
    }

    public function toArray(): array
    {
        return [
            parent::toArray(),
            'html' => $this->html,
        ];
    }
}
