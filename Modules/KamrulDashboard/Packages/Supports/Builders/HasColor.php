<?php

namespace Modules\KamrulDashboard\Packages\Supports\Builders;

trait HasColor
{
    protected $color = '';

    public function color(string $color): self
    {
        $this->color = $color;

        return $this;
    }

    public function getColor(): string
    {
        $colors = [
            'primary' => 'btn-primary',
            'success' => 'btn-success',
            'info' => 'btn-info',
            'warning' => 'btn-warning',
            'danger' => 'btn-danger',
            'secondary' => 'btn-secondary',
        ];

        return $colors[$this->color] ?? '';
    }
}
