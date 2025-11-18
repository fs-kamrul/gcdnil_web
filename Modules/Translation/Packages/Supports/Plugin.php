<?php

namespace Modules\Translation\Packages\Supports;

use Illuminate\Support\Facades\Schema;
use Modules\KamrulDashboard\Packages\Supports\PluginOperationAbstract;

class Plugin extends PluginOperationAbstract
{
    public static function remove()
    {
        Schema::dropIfExists('translations');
    }
}
