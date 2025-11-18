<?php

namespace Modules\KamrulDashboard\Traits\Forms;

use Illuminate\Support\HtmlString;

trait HasColumns
{
    public function columns($columns = 2)
    {
        if (!is_array($columns)) {
            $columns = [
                'lg' => $columns,
            ];
        }

        $this->setFormOption('columns', array_merge(
            $this->columns ?? [],
            $columns
        ));

        return $this;
    }

    public function getColumns(?string $breakpoint = null)
    {
        $columns = $this->getFormOption('columns', [
            'default' => 1,
            'sm' => null,
            'md' => null,
            'lg' => null,
            'xl' => null,
            'xxl' => null,
        ]);

        if ($breakpoint !== null) {
            return isset($columns[$breakpoint]) ? $columns[$breakpoint] : null;
        }


        return $columns;
    }

    public function getOpenWrapperFormColumns(): ?HtmlString
    {
        $columns = $this->getFormOption('columns');

        if (! $columns) {
            return null;
        }

        return new HtmlString(view('kamruldashboard::forms.columns.form-open-wrapper', [
            'form' => $this,
        ]));
    }

    public function getCloseWrapperFormColumns(): ?HtmlString
    {
        $columns = $this->getFormOption('columns');

        if (! $columns) {
            return null;
        }

        return new HtmlString('</div>');
    }
}
