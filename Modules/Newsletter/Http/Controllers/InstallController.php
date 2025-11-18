<?php

namespace Modules\Newsletter\Http\Controllers;

use Composer\Semver\Comparator;
use Illuminate\Http\Response;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Artisan;
use Modules\KamrulDashboard\Http\Models\Systems;

use Illuminate\Support\Facades\DB;

class InstallController  extends Controller
{

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function __construct()
    {
        $this->module_name = 'Newsletter';
        $this->appVersion = config('newsletter.module_version');
        $this->appType = config('newsletter.module_type');
        // Dependencies automatically resolved by service container...

    }

    /**
     * Install
     * @return Response
     */
    public function index()
    {

        ini_set('max_execution_time', 0);
        ini_set('memory_limit', '512M');

        $this->installSettings();

        //Check if installed or not.
        $is_installed = Systems::getProperty($this->module_name . '_version');
        if (empty($is_installed)) {
            DB::statement('SET default_storage_engine=INNODB;');
            Artisan::call('module:migrate', ['module' => "Newsletter"]);
            Artisan::call('module:seed', ['module' => "Newsletter"]);
            Artisan::call('module:enable', ['module' => "Newsletter"]);
            Artisan::call('optimize');
            Systems::addProperty($this->module_name . '_version', $this->appVersion);
            Systems::addProperty($this->module_name . '_type', $this->appType);
        }

        $output = ['status' => 1,
                    'message' => 'Newsletter module installed successfully'
                ];

        return redirect()->back()->with(['response_data' => $output]);
//        return redirect()
//            ->action('\Modules\KamrulDashboard\Http\Controllers\PluginsController@index')
//            ->with('response_data', $output);
    }

    /**
     * Initialize all install functions
     *
     */
    private function installSettings()
    {
        config(['app.debug' => true]);
        Artisan::call('config:clear');
    }

    //Updating
    public function update()
    {
        //Check if superadmin_version is same as appVersion then 404
        //If appVersion > superadmin_version - run update script.
        //Else there is some problem.


        try {
            //DB::beginTransaction();

            ini_set('max_execution_time', 0);
            ini_set('memory_limit', '512M');

            $superadmin_version = Systems::getProperty($this->module_name . '_version');

            if (Comparator::greaterThan($this->appVersion, $superadmin_version)) {
                ini_set('max_execution_time', 0);
                ini_set('memory_limit', '512M');
                $this->installSettings();

                DB::statement('SET default_storage_engine=INNODB;');
                Artisan::call('module:migrate', ['module' => "Newsletter"]);
                Artisan::call('module:seed', ['module' => "Newsletter"]);
                Artisan::call('module:enable', ['module' => "Newsletter"]);
                Artisan::call('optimize');

                Systems::setProperty($this->module_name . '_version', $this->appVersion);
                Systems::setProperty($this->module_name . '_type', $this->appType);
            } else {
                abort(404);
            }

            //DB::commit();

            $output = ['status' => 1,
                        'message' => 'Newsletter module updated Succesfully to version ' . $this->appVersion . ' !!'
                    ];

            return redirect()->back()->with(['response_data' => $output]);
//            return redirect()
//            ->action('\Modules\KamrulDashboard\Http\Controllers\PluginsController@index')
//            ->with('response_data', $output);
        } catch (Exception $e) {
            //DB::rollBack();
            die($e->getMessage());
        }
    }

    /**
     * Uninstall
     * @return Response
     */
    public function uninstall()
    {
        try {
            Artisan::call('module:disable', ['module' => "Newsletter"]);
            Artisan::call('optimize');
            Systems::removeProperty($this->module_name . '_version');
            Systems::removeProperty($this->module_name . '_type');

            $output = ['status' => 1,
                'message' => $this->module_name . ' module Uninstalled successfully'
                        ];
        } catch (\Exception $e) {
            $output = ['status' => 0,
                        'message' => $e->getMessage()
                    ];
        }

        return redirect()->back()->with(['response_data' => $output]);
    }
}
