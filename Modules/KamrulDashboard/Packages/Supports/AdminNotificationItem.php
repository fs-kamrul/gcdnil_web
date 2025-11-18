<?php

namespace Modules\KamrulDashboard\Packages\Supports;

use Closure;

class AdminNotificationItem
{
    protected $title = '';

    protected $description = '';

    protected $label = '';

    protected $route = null;

    protected $action = [];

    public static function make()
    {
        return new static();
    }

    public function title(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function description(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function action(string $label, $route): self
    {
        $this->route = $route;
        $this->label = $label;

        return $this;
    }

    public function getLabel(): string
    {
        return $this->label;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getRoute()
    {
        return $this->route;
    }
}
