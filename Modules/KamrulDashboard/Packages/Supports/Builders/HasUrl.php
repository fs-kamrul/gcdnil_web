<?php

namespace Modules\KamrulDashboard\Packages\Supports\Builders;

use Closure;

trait HasUrl
{
    protected $url; // Remove union type to make it compatible with PHP 7.4

    protected $openUrlInNewTab = false;

    /**
     * @param \Closure|string $url
     * @return self
     */
    public function url($url): self
    {
        if (!$url instanceof Closure && !is_string($url)) {
            throw new \InvalidArgumentException('The $url parameter must be a Closure or a string.');
        }

        $this->url = $url;

        return $this;
    }

    public function hasUrl(): bool
    {
        return isset($this->url);
    }

    public function getUrl(): ?string
    {
        if (!$this->hasUrl()) {
            return null;
        }

        return $this->url instanceof Closure ? call_user_func($this->url, $this) : $this->url;
    }

    public function openUrlInNewTab(bool $openUrlInNewTab = true): self
    {
        $this->openUrlInNewTab = $openUrlInNewTab;

        return $this;
    }

    public function shouldOpenUrlInNewTab(): bool
    {
        return $this->openUrlInNewTab;
    }

    public function route(string $route, array $parameters = [], bool $absolute = true): self
    {
        $this
            ->url(function ($action) use ($route, $parameters, $absolute) {
                return route($route, array_merge($parameters, [$action->getItem()->getKey()]), $absolute);
            })
            ->permission($route);

        return $this;
    }
}
