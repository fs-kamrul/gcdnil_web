<?php

namespace Modules\KamrulDashboard\Widgets;

use Modules\KamrulDashboard\Events\RenderingAdminWidgetEvent;
use Modules\KamrulDashboard\Widgets\Contracts\AdminWidget as AdminWidgetContract;
use Illuminate\Contracts\View\View;

class AdminWidget implements AdminWidgetContract
{
    protected $widgets = [];

    protected $namespace = 'global';

    public function register(array $widgets, $namespace)
    {
        foreach ($widgets as $key => $widget) {
            $this->widgets[$namespace][is_string($key) ? $key : $widget] = $widget;
        }

        return $this;
    }

    public function remove(string $id, $namespace)
    {
        unset($this->widgets[$namespace][$id]);

        return $this;
    }

    public function getColumns($namespace): int
    {
        $count = count($this->widgets[$namespace]);
//        dd($count);
        switch ($count) {
            case 5:
            case 6:
            case 9:
            case 11:
                return 3;
            case 7:
//                return 12;
            case 8:
            case 10:
            case 12:
                return 4;
            default:
                return $count;
        }
    }

    public function render(string $namespace): View
    {
        event(new RenderingAdminWidgetEvent($this));

        $widgets = collect();

//        dd($this->widgets[$namespace]);
        foreach ($this->widgets[$namespace] as $widget) {
            $widgets->add(resolve($widget));
        }

//        dd($this->getColumns($namespace));
        $widgets = $widgets->sortBy(function (Widget $widget) {
            return $widget->getPriority();
        })->toArray();

//        dd($widgets);
        return view('kamruldashboard::widgets.render', [
            'widgets' => $widgets,
            'columns' => $this->getColumns($namespace),
        ]);
    }
}
