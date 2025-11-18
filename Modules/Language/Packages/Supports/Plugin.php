<?php

namespace Modules\Language\Packages\Supports;

use Illuminate\Support\Facades\Schema;
use Modules\KamrulDashboard\Packages\Supports\PluginOperationAbstract;
use SettingDataF;

class Plugin extends PluginOperationAbstract
{
    public static function activated()
    {
        $plugins = get_active_plugins();

        if (($key = array_search('language', $plugins)) !== false) {
            unset($plugins[$key]);
        }

        array_unshift($plugins, 'language');

        SettingDataF::set('activated_plugins', json_encode($plugins))->save();
    }

    public static function remove()
    {
        Schema::dropIfExists('languages');
        Schema::dropIfExists('language_meta');
    }
}
