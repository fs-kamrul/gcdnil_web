<?php

namespace Modules\KamrulDashboard\Traits\FieldOptions;

trait HasAspectRatio
{
    protected $ratio = '';

    protected $withoutAspectRatio = false;

    public function aspectRatio(string $ratio): self
    {
        $this->ratio = $ratio;

        return $this;
    }

    public function withoutAspectRatio(): self
    {
        $this->withoutAspectRatio = true;

        return $this;
    }
}
