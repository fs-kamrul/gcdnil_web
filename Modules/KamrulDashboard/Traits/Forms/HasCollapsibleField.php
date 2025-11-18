<?php

namespace Modules\KamrulDashboard\Traits\Forms;

use Illuminate\Support\Arr;

trait HasCollapsibleField
{
    public function collapsible(string $target)
    {
        $this->attributes([
            'data-bb-toggle' => 'collapse',
            'data-bb-target' => sprintf('[data-bb-trigger=%s]', $target),
        ]);

        return $this;
    }

    public function collapseTrigger(string $trigger, $value, bool $isShow = true)
    {
        $this->wrapperAttributes([
            'data-bb-trigger' => $trigger,
            'data-bb-value' => $value,
            'style' => trim(sprintf(
                '%s; %s',
                Arr::get($this->getWrapperAttributes(), 'style'),
                $isShow ? '' : 'display: none;'
            )),
        ]);

        return $this;
    }
}
