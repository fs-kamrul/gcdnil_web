<?php

namespace Modules\KamrulDashboard\Traits\FieldOptions;

trait HasNumberItemsPerRow
{
    protected $numberItemsPerRow = 3;

    public function numberItemsPerRow(int $number): self
    {
        $this->numberItemsPerRow = $number;

        return $this;
    }
}
