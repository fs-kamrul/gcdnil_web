<?php

namespace Modules\KamrulDashboard\Packages\Savefunction;

use Countable;
use Modules\KamrulDashboard\Utils\PluginUtil;

class Savefunction
{
    /**
     * The menus collections.
     *
     * @var array
     */
    protected $menus = array();

    public function __construct()
    {

    }

    public function request_to_redirect_function($func, $data = null)
    {

        $moduleUtil = new PluginUtil;
        $moduleUtil->getModuleData($func, $data);

    }
    public function request_module_defined($module_name)
    {
        $moduleUtil = new PluginUtil;
        $module = $moduleUtil->isModuleDefined($module_name);
        return $module;
    }
}
