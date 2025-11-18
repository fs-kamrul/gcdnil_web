<?php

namespace Modules\KamrulDashboard\Traits\Forms;

use Modules\KamrulDashboard\Forms\FormAbstract;

trait CanSpanColumns
{
    protected $colspan = 0;

    public function colspan(int $colspan): self
    {
        $this->colspan = $colspan;

        return $this;
    }

    public function getColspan(): int
    {
        return $this->colspan;
    }

    public function getColumnSpan($breakpoint = null)
    {
        $columnSpan = [];
        $span = $this->getOption('colspan');

        /**
         * @var FormAbstract $parent
         */
        $parent = $this->getParent();

        if ($span === 'full') {
            $parentSpan = $parent->getColumns();

            if ($breakpoint !== null) {
                $span = $parentSpan[$breakpoint] ?? null;
            }
        }

        if (!is_array($span)) {
            $span = [
                'lg' => ceil(12 / ((int) $parent->getColumns('lg')) * $span),
            ];
        }

        // Merge arrays without the spread operator
        foreach ($span as $key => $value) {
            $columnSpan[$key] = $value;
        }

        if ($breakpoint !== null) {
            return $columnSpan[$breakpoint] ?? null;
        }

        return array_map(function ($value) use ($span) {
            return $value * $span;
        }, $parent->getColumns());
    }

    public function render(array $options = [], $showLabel = true, $showField = true, $showError = true)
    {
        return view('kamruldashboard::forms.columns.column-span', [
            'field' => $this,
            'html' => parent::render($options, $showLabel, $showField, $showError),
        ]);
    }
}
