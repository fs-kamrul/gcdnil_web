<?php

namespace Modules\KamrulDashboard\Console;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Artisan;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class CreateInstallCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'kamrul:create {composer}';

    protected $files;

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate new Install Controller.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(Filesystem $files)
    {
        $this->files=$files;
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $viewComposer=$this->argument('composer');
//        $location=$this->argument('location');

        if ($viewComposer === '' || is_null($viewComposer) || empty($viewComposer)) {
            return $this->error('Composer Name Invalid..!');
        }
        $fileName = 'InstallController';
        $contents=
            '<?php

namespace Modules\\'.$viewComposer.'\Http\Controllers;

use Composer\Semver\Comparator;
use Illuminate\Http\Response;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Artisan;
use Modules\KamrulDashboard\Http\Models\Systems;

use Illuminate\Support\Facades\DB;

class '.$fileName.'  extends Controller
{

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function __construct()
    {
        $this->module_name = \''.$viewComposer.'\';
        $this->appVersion = config(\''.strtolower($viewComposer).'.module_version\');
        $this->appType = config(\''.strtolower($viewComposer).'.module_type\');
        // Dependencies automatically resolved by service container...

    }

    /**
     * Install
     * @return Response
     */
    public function index()
    {

        ini_set(\'max_execution_time\', 0);
        ini_set(\'memory_limit\', \'512M\');

        $this->installSettings();

        //Check if installed or not.
        $is_installed = Systems::getProperty($this->module_name . \'_version\');
        if (empty($is_installed)) {
            DB::statement(\'SET default_storage_engine=INNODB;\');
            Artisan::call(\'module:migrate\', [\'module\' => "'.$viewComposer.'"]);
            Artisan::call(\'module:seed\', [\'module\' => "'.$viewComposer.'"]);
            Artisan::call(\'module:enable\', [\'module\' => "'.$viewComposer.'"]);
            Artisan::call(\'optimize\');
            Systems::addProperty($this->module_name . \'_version\', $this->appVersion);
            Systems::addProperty($this->module_name . \'_type\', $this->appType);
        }

        $output = [\'status\' => 1,
                    \'message\' => \''.$viewComposer.' module installed successfully\'
                ];

        return redirect()->back()->with([\'response_data\' => $output]);
//        return redirect()
//            ->action(\'\Modules\KamrulDashboard\Http\Controllers\PluginsController@index\')
//            ->with(\'response_data\', $output);
    }

    /**
     * Initialize all install functions
     *
     */
    private function installSettings()
    {
        config([\'app.debug\' => true]);
        Artisan::call(\'config:clear\');
    }

    //Updating
    public function update()
    {
        //Check if superadmin_version is same as appVersion then 404
        //If appVersion > superadmin_version - run update script.
        //Else there is some problem.


        try {
            //DB::beginTransaction();

            ini_set(\'max_execution_time\', 0);
            ini_set(\'memory_limit\', \'512M\');

            $superadmin_version = Systems::getProperty($this->module_name . \'_version\');

            if (Comparator::greaterThan($this->appVersion, $superadmin_version)) {
                ini_set(\'max_execution_time\', 0);
                ini_set(\'memory_limit\', \'512M\');
                $this->installSettings();

                DB::statement(\'SET default_storage_engine=INNODB;\');
                Artisan::call(\'module:migrate\', [\'module\' => "'.$viewComposer.'"]);
                Artisan::call(\'module:seed\', [\'module\' => "'.$viewComposer.'"]);
                Artisan::call(\'module:enable\', [\'module\' => "'.$viewComposer.'"]);
                Artisan::call(\'optimize\');

                Systems::setProperty($this->module_name . \'_version\', $this->appVersion);
                Systems::setProperty($this->module_name . \'_type\', $this->appType);
            } else {
                abort(404);
            }

            //DB::commit();

            $output = [\'status\' => 1,
                        \'message\' => \''.$viewComposer.' module updated Succesfully to version \' . $this->appVersion . \' !!\'
                    ];

        return redirect()->back()->with([\'response_data\' => $output]);
//            return redirect()
//            ->action(\'\Modules\KamrulDashboard\Http\Controllers\PluginsController@index\')
//            ->with(\'response_data\', $output);
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
            Artisan::call(\'module:disable\', [\'module\' => "'.$viewComposer.'"]);
            Artisan::call(\'optimize\');
            Systems::removeProperty($this->module_name . \'_version\');
            Systems::removeProperty($this->module_name . \'_type\');

            $output = [\'status\' => 1,
                \'message\' => $this->module_name . \' module Uninstalled successfully\'
                        ];
        } catch (\Exception $e) {
            $output = [\'status\' => 0,
                        \'message\' => $e->getMessage()
                    ];
        }

        return redirect()->back()->with([\'response_data\' => $output]);
    }
}';
        if ($this->confirm('Do you wish to create '. $fileName . ' form ' .$viewComposer.' Controller file?')) {
            $file = "${fileName}.php";
            $path=app_path();

            $file=$path."/../Modules/$viewComposer/Http/Controllers/$file";
            $composerDir=$path."/../Modules/$viewComposer";

            if($this->files->isDirectory($composerDir)){
//                if($this->files->isFile($file))
//                    return $this->error($viewComposer . ' Module ' . $fileName . ' File Already exists!');

//                Artisan::call('kamrul:create-route', ['composer' => "$viewComposer"]);
                if(!$this->files->put($file, $contents))
                    return $this->error('Something went wrong!');
                $this->info("$viewComposer Module $fileName generated!");
            }
            else{
//                $this->files->makeDirectory($composerDir, 0777, true, true);
//                Artisan::call('module:make ' . $viewComposer);

//                if(!$this->files->put($file, $contents))
//                    return $this->error('Something went wrong!');
                $this->error("Something went wrong! Please at fist Create this module ");
//                $this->info("$viewComposer Module $fileName generated!");
            }

        }
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['example', InputArgument::REQUIRED, 'An example argument.'],
        ];
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['example', null, InputOption::VALUE_OPTIONAL, 'An example option.', null],
        ];
    }
}
