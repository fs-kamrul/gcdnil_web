<?php

namespace Modules\KamrulDashboard\Widgets;

use Modules\KamrulDashboard\Widgets\Widget;

abstract class Html extends Widget
{
    protected $view = 'html';

    public function getContent(): string
    {
        return '';
    }

    public function getViewData(): array
    {
        return array_merge(parent::getViewData(), [
            'content' => $this->getContent(),
        ]);
    }
}
