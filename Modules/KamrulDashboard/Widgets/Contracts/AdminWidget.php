<?php

namespace Modules\KamrulDashboard\Widgets\Contracts;

use Illuminate\Contracts\View\View;

interface AdminWidget
{
    public function register(array $widgets, $namespace);

    public function remove(string $id, $namespace);

    public function getColumns($namespace): int;

    public function render(string $namespace): View;
}
