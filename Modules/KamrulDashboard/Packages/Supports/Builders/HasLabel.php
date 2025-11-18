<?php

namespace Modules\KamrulDashboard\Packages\Supports\Builders;

trait HasLabel
{
    /**
     * The label property can be either a string or a boolean.
     * We'll remove the type hint and handle type validation manually.
     */
    protected $label = '';

    /**
     * Set the label, which can be a string or a boolean.
     *
     * @param mixed $label
     * @return self
     */
    public function label($label): self
    {
        if (!is_string($label) && !is_bool($label)) {
            throw new \InvalidArgumentException('Label must be a string or a boolean.');
        }

        $this->label = $label;

        return $this;
    }

    /**
     * Get the label, which can be either a string or a boolean.
     *
     * @return mixed
     */
    public function getLabel()
    {
        return $this->label;
    }
}
