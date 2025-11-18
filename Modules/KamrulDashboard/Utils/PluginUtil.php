<?php

namespace Modules\KamrulDashboard\Utils;

use Composer\Semver\Comparator;
use Module;
use Modules\KamrulDashboard\Http\Models\Systems;

class PluginUtil extends Util
{
    /**
     * This function check if a module is installed or not.
     *
     * @param string $module_name (Exact module name, with first letter capital)
     * @return boolean
     */
    public function isModuleInstalled($module_name)
    {
        $is_available = Module::has($module_name);

        if ($is_available) {
            //Check if installed by checking the system table {module_name}_version
            $module_version = Systems::getProperty(strtolower($module_name) . '_version');
            if (empty($module_version)) {
                return false;
            } else {
                return true;
            }
        }

        return false;
    }

    /**
     * This function returns the installed version, available version
     * and uses comparator to check if update is available or not.
     *
     * @param string $module_name (Exact module name, with first letter capital)
     * @return array
     */
    public function getModuleVersionInfo($module_name)
    {
        $output = ['installed_version' => null,
            'available_version' => null,
            'is_update_available' => null
        ];

        $is_available = Module::has($module_name);

        if ($is_available) {
            //Check if installed by checking the system table {module_name}_version
            $module_version = Systems::getProperty(strtolower($module_name) . '_version');

            $output['installed_version'] = $module_version;
            $output['available_version'] = config(strtolower($module_name) . '.module_version');

            $output['is_update_available'] = Comparator::greaterThan($output['available_version'], $output['installed_version']);
        }

        return $output;
    }
    /**
     * This function check if superadmin module is installed or not.
     * @return boolean
     */
    public function isSuperadminInstalled()
    {
        return $this->isModuleInstalled('Superadmin');
    }

    /**
     * This function check if a function provided exist in all modules
     * DataController, merges the data and returned it.
     *
     * @param string $function_name
     *
     * @return array
     */
    public function getModuleData($function_name, $arguments = null)
    {
        $modules = Module::toCollection()->toArray();

        $installed_modules = [];
        foreach ($modules as $module => $details) {
            if ($this->isModuleInstalled($details['name'])) {
                $installed_modules[] = $details;
            }
        }

        $data = [];
        if (!empty($installed_modules)) {
            foreach ($installed_modules as $module) {
                $class = 'Modules\\' . $module['name'] . '\Http\Controllers\DataController';

                if (class_exists($class)) {
                    $class_object = new $class();
                    if (method_exists($class_object, $function_name)) {
                        if (!empty($arguments)) {
                            $data[$module['name']] = call_user_func([$class_object, $function_name], $arguments);
                        } else {
                            $data[$module['name']] = call_user_func([$class_object, $function_name]);
                        }
                    }
                }
            }
        }

        return $data;
    }

    /**
     * Checks if a module is defined
     *
     * @param string $module_name
     * @return bool
     */
    public function isModuleDefined($module_name)
    {
        $is_installed = $this->isModuleInstalled($module_name);

        $check_for_enable = [];

        $output = !empty($is_installed) ? true : false;

        if (in_array($module_name, $check_for_enable) &&
            !$this->isModuleEnabled(strtolower($module_name))) {
            $output = false;
        }

        return $output;
    }

    /**
     * Returns the name of view used to display for subscription expired.
     *
     * @return string
     */
    public static function expiredResponse($redirect_url = null)
    {
        $response_array = ['success' => 0,
                        'msg' => __(
                            "superadmin::lang.subscription_expired_toastr",
                            ['app_name' => config('app.name'),
                                'subscribe_url' => action('\Modules\Superadmin\Http\Controllers\SubscriptionController@index')
                            ]
                        )
                    ];

        if (request()->ajax()) {
            if (request()->wantsJson()) {
                return $response_array;
            } else {
                return view('superadmin::subscription.subscription_expired_modal');
            }
        } else {
            if (is_null($redirect_url)) {
                return back()
                    ->with('status', $response_array);
            } else {
                return redirect($redirect_url)
                    ->with('status', $response_array);
            }
        }
    }


}
