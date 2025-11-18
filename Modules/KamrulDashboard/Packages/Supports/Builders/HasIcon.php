<?php

namespace Modules\KamrulDashboard\Packages\Supports\Builders;

use Closure;
use Modules\KamrulDashboard\Http\Models\DboardModel;

trait HasIcon
{
    protected $icon;

    /**
     * @param DboardModel $model): string|string $icon
     */
    public function icon(Closure $icon): self
    {
        if (!$icon instanceof Closure && !is_string($icon)) {
            throw new \InvalidArgumentException('Icon must be a Closure or a string.');
        }
        $this->icon = $icon;

        return $this;
    }

    public function hasIcon(): bool
    {
        return isset($this->icon);
    }

    public function isRenderabeIcon(): bool
    {
        return $this->icon instanceof Closure;
    }

    public function getIcon(): ?string
    {
        if (! $this->hasIcon()) {
            return null;
        }

        return $this->isRenderabeIcon() ? call_user_func($this->icon, $this) : $this->icon;
    }
}
