<?php

namespace Modules\KamrulDashboard\Console;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class CreateDataCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'kamrul:create-data {composer}';

    protected $files;

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate new All file and replace file.';

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
        $viewComposer = ucfirst($viewComposer);
//        $location=$this->argument('location');

        if ($viewComposer === '' || is_null($viewComposer) || empty($viewComposer)) {
            return $this->error('Composer Name Invalid..!');
        }


        if ($this->confirm('Do you wish to create form ' .$viewComposer.' Module file?')) {
            $this->MainHookProviderFileCreate($viewComposer);
            $this->MainBackupFileCreate($viewComposer);
            $this->langFileCreate($viewComposer);
            $this->ControllerFileCreate($viewComposer);
            $this->ConfigFileCreate($viewComposer);
            $this->RouteFileCreate($viewComposer);
            $this->MainControllerFileCreate($viewComposer);
            $this->MainViewFileCreate($viewComposer);
            $this->MainModelFileCreate($viewComposer);
            $this->MainMigrationFileCreate($viewComposer);
            $this->MainImportFileCreate($viewComposer);
            $this->TableFileCreate($viewComposer);
            $this->helpersFileCreate($viewComposer);
            $this->MainRepositoriesFileCreate($viewComposer);
            $this->MainPermissionFileCreate($viewComposer);
        }
    }

    protected function MainMigrationFileCreate($viewComposer){

        $SixDigitRandomNumber = rand(100000,999999);
        $path=base_path();
        $fileName = date('Y_m_d') . '_' . $SixDigitRandomNumber . '_create_' . strtolower($viewComposer) . '_table';
        $filereplace=$path."/Modules/KamrulDashboard/Console/filereplace/PluginMigration.stub";
        $mainContent = File::get($filereplace);
        $new_item = Str::replace('__PlaginName__', $viewComposer, $mainContent);
        $new_item = Str::replace('__ShortPlaginName__', strtolower($viewComposer), $new_item);
        $model_name = lara_models($viewComposer);
        $new_item = Str::replace('__PluralizePlaginName__', pluralize(strtolower($model_name)), $new_item);

        $file = "${fileName}.php";
        $file=$path."/Modules/$viewComposer/Database/Migrations/$file";
        $composerDir=$path."/Modules/$viewComposer/Database/Migrations";

        if($this->files->isDirectory($composerDir)){
            if(!$this->files->put($file, $new_item))
                return $this->error('Something went wrong!');
//            $this->info("$viewComposer Module $fileName File generated!");
            $this->info("Created :  " . $composerDir . '/' . $fileName . '.php');
        }
        else{
            $this->files->makeDirectory($composerDir, 0777, true, true);
//                Artisan::call('module:make ' . $viewComposer);

            if(!$this->files->put($file, $new_item))
                return $this->error('Something went wrong!');
//            $this->error("Something went wrong! Please at fist Create this module ");
//            $this->info("$viewComposer Module $fileName File generated!");
            $this->info("Created :  " . $composerDir . '/' . $fileName . '.php');
        }
    }
    protected function MainModelFileCreate($viewComposer){

        $path=base_path();
        $fileName = $viewComposer;
        $filereplace=$path."/Modules/KamrulDashboard/Console/filereplace/PluginModel.stub";
        $mainContent = File::get($filereplace);
        $new_item = Str::replace('__PlaginName__', $viewComposer, $mainContent);
        $new_item = Str::replace('__ShortPlaginName__', strtolower($viewComposer), $new_item);

        $file = "${fileName}.php";
        $file=$path."/Modules/$viewComposer/Http/Models/$file";
        $composerDir=$path."/Modules/$viewComposer/Http/Models";

        if($this->files->isDirectory($composerDir)){
            if(!$this->files->put($file, $new_item))
                return $this->error('Something went wrong!');
//            $this->info("$viewComposer Module $fileName Model File generated!");
            $this->info("Created :  " . $composerDir . '/' . $fileName . '.php');
        }
        else{
            $this->files->makeDirectory($composerDir, 0777, true, true);
            if(!$this->files->put($file, $new_item))
                return $this->error('Something went wrong!');
//            $this->error("Something went wrong! Please at fist Create this module ");
//            $this->info("$viewComposer Module $fileName Model File generated!");
            $this->info("Created :  " . $composerDir . '/' . $fileName . '.php');
        }
    }
    protected function MainControllerFileCreate($viewComposer){

        //Main Controller Create blade
        $path=base_path();
        $fileName = $viewComposer . 'Controller';
        $filereplace=$path."/Modules/KamrulDashboard/Console/filereplace/PluginController.stub";
        $mainContent = File::get($filereplace);
        $new_item = Str::replace('__PlaginName__', $viewComposer, $mainContent);
        $new_item = Str::replace('__AllPlaginName__', strtoupper($viewComposer), $new_item);
        $new_item = Str::replace('__ShortPlaginName__', strtolower($viewComposer), $new_item);
        $new_item = Str::replace('__SingularPlaginName__', singularize(strtolower($viewComposer)), $new_item);
        $file = "${fileName}.php";
        $file=$path."/Modules/$viewComposer/Http/Controllers/$file";
        $composerDir=$path."/Modules/$viewComposer";
        $this->CreateSaveFileDir($file, $fileName, $new_item, $viewComposer, $composerDir);

        //Install Controller Create blade
//        $path_create=base_path();
//        $fileName_create = 'InstallController';
//        $filereplace_create=$path_create."/Modules/KamrulDashboard/Console/filereplace/PluginInstallController.stub";
//        $mainContent_create = File::get($filereplace_create);
//        $new_item_create = Str::replace('__PlaginName__', $viewComposer, $mainContent_create);
//        $new_item_create = Str::replace('__ShortPlaginName__', strtolower($viewComposer), $new_item_create);
//        $file_create = "${fileName_create}.php";
//        $file_create =$path_create."/Modules/$viewComposer/Http/Controllers/$file_create ";
//        $this->CreateSaveFileDir($file_create, $fileName_create, $new_item_create, $viewComposer, $composerDir);
    }
    protected function MainPermissionFileCreate($viewComposer)
    {

        //Main Permission Create blade
        $path = base_path();
        $fileName = $viewComposer . 'PermissionSeeder';
        $filereplace = $path . "/Modules/KamrulDashboard/Console/filereplace/PluginPermission.stub";
        $mainContent = File::get($filereplace);
        $new_item = Str::replace('__PlaginName__', $viewComposer, $mainContent);
        $new_item = Str::replace('__ShortPlaginName__', strtolower($viewComposer), $new_item);
        $new_item = Str::replace('__SingularPlaginName__', singularize(strtolower($viewComposer)), $new_item);
        $file = "${fileName}.php";
        $file = $path . "/Modules/$viewComposer/Database/Seeders/$file";
        $composerDir = $path . "/Modules/$viewComposer/Database/Seeders/";
        $this->CreateSaveFile($file, $fileName, $new_item, $viewComposer, $composerDir);

        //Install Permission Database Create blade
        $path_create=base_path();
        $fileName_create = $viewComposer . 'DatabaseSeeder';
        $filereplace_create=$path_create."/Modules/KamrulDashboard/Console/filereplace/PluginPermissionDatabase.stub";
        $mainContent_create = File::get($filereplace_create);
        $new_item_create = Str::replace('__PlaginName__', $viewComposer, $mainContent_create);
        $new_item_create = Str::replace('__ShortPlaginName__', strtolower($viewComposer), $new_item_create);
        $file_create = "${fileName_create}.php";
        $file_create = $path_create."/Modules/$viewComposer/Database/Seeders/$file_create";
        $this->CreateSaveFile($file_create, $fileName_create, $new_item_create, $viewComposer, $composerDir);
    }
    protected function MainBackupFileCreate($viewComposer)
    {

        $data = [
            'ARCANEDEV_LOGVIEWER_MIDDLEWARE' => 'web,auth'
        ];
        updateEnv($data);

        //Main Permission Create blade
        $path = base_path();
        $fileName = 'backup';
        $filereplace = $path . "/Modules/KamrulDashboard/Console/filereplace/backup.stub";
        $mainContent = File::get($filereplace);
        $new_item = $mainContent;//Str::replace('__PlaginName__', $viewComposer, $mainContent);
//        $new_item = Str::replace('__ShortPlaginName__', strtolower($viewComposer), $new_item);
//        $new_item = Str::replace('__SingularPlaginName__', singularize(strtolower($viewComposer)), $new_item);
        $file = "${fileName}.php";
        $file = $path . "/config/$file";
        $composerDir = $path . "/config/";
        $this->CreateSaveFile($file, $fileName, $new_item, $viewComposer, $composerDir);

    }
    protected function MainImportFileCreate($viewComposer){

        //Main Import Create blade
        $path=base_path();


        //Install Controller Create blade
        $path_create=base_path();
        $fileName_create = 'create_import.blade';
        $filereplace_create=$path_create."/Modules/KamrulDashboard/Console/filereplace/PluginImportBlade.stub";
        $mainContent_create = File::get($filereplace_create);
        $new_item_create = Str::replace('__PlaginName__', $viewComposer, $mainContent_create);
        $new_item_create = Str::replace('__ShortPlaginName__', strtolower($viewComposer), $new_item_create);
        $file_create = "${fileName_create}.php";
        $file_create = $path_create."/Modules/$viewComposer/Resources/views/" . strtolower($viewComposer) . "/$file_create";
        $composerDir=$path."/Modules/$viewComposer/Resources/views/" . strtolower($viewComposer);
        $this->CreateSaveFile($file_create, $fileName_create, $new_item_create, $viewComposer, $composerDir);

        //Install Controller Imports blade
        $path_imports=base_path();
        $fileName_imports = $viewComposer . 'Import';
        $filereplace_imports=$path_imports."/Modules/KamrulDashboard/Console/filereplace/PluginImport.stub";
        $mainContent_imports = File::get($filereplace_imports);
        $new_item_imports = Str::replace('__PlaginName__', $viewComposer, $mainContent_imports);
        $new_item_imports = Str::replace('__ShortPlaginName__', strtolower($viewComposer), $new_item_imports);
        $file_imports = "${fileName_imports}.php";
        $file_imports = $path_imports."/Modules/$viewComposer/Http/Imports/$file_imports";
        $composerDir_imports=$path."/Modules/$viewComposer/Http/Imports/";
        $this->CreateSaveFile($file_imports, $fileName_imports, $new_item_imports, $viewComposer, $composerDir_imports);

        //Install Controller Composer blade
        $path_composer=base_path();
        $fileName_composer = 'composer';
        $filereplace_composer=$path_composer."/Modules/KamrulDashboard/Console/filereplace/PluginComposer.stub";
        $mainContent_composer = File::get($filereplace_composer);
        $new_item_composer = Str::replace('__PlaginName__', $viewComposer, $mainContent_composer);
        $new_item_composer = Str::replace('__ShortPlaginName__', strtolower($viewComposer), $new_item_composer);
        $file_composer = "${fileName_composer}.json";
        $file_composer = $path_composer."/Modules/$viewComposer/$file_composer";
        $composerDir_composer=$path."/Modules/$viewComposer/";
        $this->CreateSaveFile($file_composer, $fileName_composer, $new_item_composer, $viewComposer, $composerDir_composer);

        //Install Controller Composer blade
        $path_module=base_path();
        $fileName_composer = 'module';
        $filereplace_composer=$path_module."/Modules/KamrulDashboard/Console/filereplace/PluginModule.stub";
        $mainContent_composer = File::get($filereplace_composer);
        $new_item_module = Str::replace('__PlaginName__', $viewComposer, $mainContent_composer);
        $new_item_module = Str::replace('__ShortPlaginName__', strtolower($viewComposer), $new_item_module);
        $file_module = "${fileName_composer}.json";
        $file_module = $path_module."/Modules/$viewComposer/$file_module";
        $composerDir_module=$path."/Modules/$viewComposer/";
        $this->CreateSaveFile($file_module, $fileName_composer, $new_item_module, $viewComposer, $composerDir_module);

    }
    protected function TableFileCreate($viewComposer){

        //Main Import Create blade
        $path=base_path();


        //Install Controller Create blade
        $path_create=base_path();
        $fileName_create = $viewComposer.'Table';
        $filereplace_create=$path_create."/Modules/KamrulDashboard/Console/filereplace/PluginTable.stub";
        $mainContent_create = File::get($filereplace_create);
        $new_item_create = Str::replace('__PlaginName__', $viewComposer, $mainContent_create);
        $new_item_create = Str::replace('__ShortPlaginName__', strtolower($viewComposer), $new_item_create);
        $file_create = "${fileName_create}.php";
        $file_create = $path_create."/Modules/$viewComposer/Tables/$file_create";
        $composerDir=$path."/Modules/$viewComposer/Tables/";
        $this->CreateSaveFile($file_create, $fileName_create, $new_item_create, $viewComposer, $composerDir);

    }
    protected function helpersFileCreate($viewComposer){

        //Main Import Create blade
        $path=base_path();


        //Install Controller Create blade
        $path_create=base_path();
        $fileName_create = 'helpers';
        $filereplace_create=$path_create."/Modules/KamrulDashboard/Console/filereplace/PluginHelpers.stub";
        $mainContent_create = File::get($filereplace_create);
        $new_item_create = Str::replace('__AllPlaginName__', strtoupper($viewComposer), $mainContent_create);
        $new_item_create = Str::replace('__ShortPlaginName__', strtolower($viewComposer), $new_item_create);
        $file_create = "${fileName_create}.php";
        $file_create = $path_create."/Modules/$viewComposer/Http/helpers/$file_create";
        $composerDir=$path."/Modules/$viewComposer/Http/helpers";
        $this->CreateSaveFile($file_create, $fileName_create, $new_item_create, $viewComposer, $composerDir);

    }
    protected function MainRepositoriesFileCreate($viewComposer){

        //Main Import Create blade
        $path=base_path();


        //Install Controller Create blade
        $path_create=base_path();
        $fileName_create = $viewComposer.'Repository';
        $filereplace_create=$path_create."/Modules/KamrulDashboard/Console/filereplace/PluginEloquentRepository.stub";
        $mainContent_create = File::get($filereplace_create);
        $new_item_create = Str::replace('__PlaginName__', $viewComposer, $mainContent_create);
        $new_item_create = Str::replace('__ShortPlaginName__', strtolower($viewComposer), $new_item_create);
        $file_create = "${fileName_create}.php";
        $file_create = $path_create."/Modules/$viewComposer/Repositories/Eloquent/$file_create";
        $composerDir=$path."/Modules/$viewComposer/Repositories/Eloquent/";
        $this->CreateSaveFile($file_create, $fileName_create, $new_item_create, $viewComposer, $composerDir);

        //Install Controller Imports blade
        $path_imports=base_path();
        $fileName_imports = $viewComposer.'Interface';
        $filereplace_imports=$path_imports."/Modules/KamrulDashboard/Console/filereplace/PluginInterfaceRepository.stub";
        $mainContent_imports = File::get($filereplace_imports);
        $new_item_imports = Str::replace('__PlaginName__', $viewComposer, $mainContent_imports);
        $new_item_imports = Str::replace('__ShortPlaginName__', strtolower($viewComposer), $new_item_imports);
        $file_imports = "${fileName_imports}.php";
        $file_imports = $path_imports."/Modules/$viewComposer/Repositories/Interfaces/$file_imports";
        $composerDir_imports=$path."/Modules/$viewComposer/Repositories/Interfaces/";
        $this->CreateSaveFile($file_imports, $fileName_imports, $new_item_imports, $viewComposer, $composerDir_imports);

        //Install Cache blade
        $path_cache=base_path();
        $fileName_cache = $viewComposer.'CacheDecorator';
        $filereplace_cache=$path_cache."/Modules/KamrulDashboard/Console/filereplace/PluginCacheDecorator.stub";
        $mainContent_cache = File::get($filereplace_cache);
        $new_item_cache = Str::replace('__PlaginName__', $viewComposer, $mainContent_cache);
        $new_item_cache = Str::replace('__ShortPlaginName__', strtolower($viewComposer), $new_item_cache);
        $file_cache = "${fileName_cache}.php";
        $file_cache = $path_cache."/Modules/$viewComposer/Repositories/Cache/$file_cache";
        $composerDir_cache=$path."/Modules/$viewComposer/Repositories/Cache";
        $this->CreateSaveFile($file_cache, $fileName_cache, $new_item_cache, $viewComposer, $composerDir_cache);
    }
    protected function MainHookProviderFileCreate($viewComposer){

        //Main Import Create blade
        $path=base_path();


        //Install Controller Create blade
        $path_create=base_path();
        $fileName_create = 'HookServiceProvider';
        $filereplace_create=$path_create."/Modules/KamrulDashboard/Console/filereplace/PluginHookServiceProvider.stub";
        $mainContent_create = File::get($filereplace_create);
        $new_item_create = Str::replace('__PlaginName__', $viewComposer, $mainContent_create);
        $new_item_create = Str::replace('__ShortPlaginName__', strtolower($viewComposer), $new_item_create);
        $file_create = "${fileName_create}.php";
        $file_create = $path_create."/Modules/$viewComposer/Providers/$file_create";
        $composerDir=$path."/Modules/$viewComposer/Providers/";
        $this->CreateSaveFile($file_create, $fileName_create, $new_item_create, $viewComposer, $composerDir);
    }

    protected function MainViewFileCreate($viewComposer){

        $path=base_path();
        //Index blade
        $fileName = 'index.blade';
        $filereplace=$path."/Modules/KamrulDashboard/Console/filereplace/PluginIndex.blade.stub";
        $mainContent = File::get($filereplace);
        $new_item = Str::replace('__PlaginName__', $viewComposer, $mainContent);
        $new_item = Str::replace('__ShortPlaginName__', strtolower($viewComposer), $new_item);
        $file = "${fileName}.php";
        $file=$path."/Modules/$viewComposer/Resources/views/" . strtolower($viewComposer) . "/$file";
        $composerDir=$path."/Modules/$viewComposer/Resources/views/" . strtolower($viewComposer);
        $this->CreateSaveFile($file, $fileName, $new_item, $viewComposer, $composerDir);

        //Create blade
        $fileName_create = 'create.blade';
        $filereplace_create=$path."/Modules/KamrulDashboard/Console/filereplace/PluginCreate.blade.stub";
        $mainContent_create = File::get($filereplace_create);
        $new_item_create = Str::replace('__PlaginName__', $viewComposer, $mainContent_create);
        $new_item_create = Str::replace('__ShortPlaginName__', strtolower($viewComposer), $new_item_create);
        $file_create = "${fileName_create}.php";
        $file_create=$path."/Modules/$viewComposer/Resources/views/" . strtolower($viewComposer) . "/$file_create";

        $this->CreateSaveFile($file_create, $fileName_create, $new_item_create, $viewComposer, $composerDir);

        // Show Blade blade
        $fileName_show = 'show.blade';
        $filereplace_show=$path."/Modules/KamrulDashboard/Console/filereplace/PluginShowBlade.stub";
        $mainContent_show = File::get($filereplace_show);
        $new_item_show = Str::replace('__PlaginName__', $viewComposer, $mainContent_show);
        $new_item_show = Str::replace('__ShortPlaginName__', strtolower($viewComposer), $new_item_show);
        $file_show = "${fileName_show}.php";
        $file_show=$path."/Modules/$viewComposer/Resources/views/" . strtolower($viewComposer) . "/$file_show";

        $this->CreateSaveFile($file_show, $fileName_show, $new_item_show, $viewComposer, $composerDir);

        // pdf Blade blade
        $fileName_pdf = 'pdf.blade';
        $filereplace_pdf=$path."/Modules/KamrulDashboard/Console/filereplace/PluginPdfBlade.stub";
        $mainContent_pdf = File::get($filereplace_pdf);
        $new_item_pdf = Str::replace('__PlaginName__', $viewComposer, $mainContent_pdf);
        $new_item_pdf = Str::replace('__ShortPlaginName__', strtolower($viewComposer), $new_item_pdf);
        $file_pdf = "${fileName_pdf}.php";
        $file_pdf=$path."/Modules/$viewComposer/Resources/views/" . strtolower($viewComposer) . "/$file_pdf";

        $this->CreateSaveFile($file_pdf, $fileName_pdf, $new_item_pdf, $viewComposer, $composerDir);

    }
    protected function CreateSaveFile($file, $fileName, $new_item, $viewComposer, $composerDir){
        if($this->files->isDirectory($composerDir)){
            if(!$this->files->put($file, $new_item))
                return $this->error('Something went wrong!');
//            $this->info("$viewComposer Module $fileName File generated!");
            $this->info("Created :  " . $composerDir . '/' . $fileName . '.php');
        }
        else{
            $this->files->makeDirectory($composerDir, 0777, true, true);
            if(!$this->files->put($file, $new_item))
                return $this->error('Something went wrong!');
//            $this->error("Something went wrong! Please at fist Create this module ");
//            $this->info("$viewComposer Module $fileName File generated!");
            $this->info("Created :  " . $composerDir . '/' . $fileName . '.php');
        }
    }
    protected function CreateSaveFileDir($file, $fileName, $new_item, $viewComposer, $composerDir){
        if($this->files->isDirectory($composerDir)){
            if(!$this->files->put($file, $new_item))
                return $this->error('Something went wrong!');
//            $this->info("$viewComposer Module $fileName File generated!");
            $this->info("Created :  " . $composerDir . '/' . $fileName . '.php');
        }
        else{
//            $this->files->makeDirectory($composerDir, 0777, true, true);
//            if(!$this->files->put($file, $new_item))
//                return $this->error('Something went wrong!');
            $this->error("Something went wrong! Please at fist Create this module ");
//            $this->info("$viewComposer Module $fileName File generated!");
        }
    }
    protected function ConfigFileCreate($viewComposer){
        $fileName = 'config';
        $contents=
            '<?php

return [
    \'name\' => \''.$viewComposer.'\',
    \'module_version\' => "1.0",
    \'module_type\' => "plugin",
    \'pid\' => '.rand(10,100).'
];

';
        $file = "${fileName}.php";
        $path=base_path();

        $file=$path."/Modules/$viewComposer/Config/$file";
        $composerDir=$path."/Modules/$viewComposer";

        if($this->files->isDirectory($composerDir)){
//                if($this->files->isFile($file))
//                    return $this->error($viewComposer . ' Module ' . $fileName . ' File Already exists!');

            if(!$this->files->put($file, $contents))
                return $this->error('Something went wrong!');
//            $this->info("$viewComposer Module $fileName File generated!");
            $this->info("Created :  " . $composerDir . '/' . $fileName . '.php');
        }
        else{
//                $this->files->makeDirectory($composerDir, 0777, true, true);
//                Artisan::call('module:make ' . $viewComposer);
//                if(!$this->files->put($file, $contents))
//                    return $this->error('Something went wrong!');
            $this->error("Something went wrong! Please at fist Create this module ");
//                $this->info("$viewComposer Module $fileName Route generated!");
        }
    }
    protected function RouteFileCreate($viewComposer){
        $fileName = 'web';
        $contents=
            '<?php



Route::group([\'middleware\' => [\'auth\', \'\Modules\KamrulDashboard\Http\Middleware\IsInstalled\', \'\Modules\KamrulDashboard\Http\Middleware\AdminSidebarMenu\']], function () {
    Route::prefix(\''.strtolower($viewComposer).'\')->group(function() {
        Route::get(\'/install\', \'InstallController@index\');
        Route::get(\'/install/update\', \'InstallController@update\');
        Route::get(\'/install/uninstall\', \'InstallController@uninstall\');
    //    Route::get(\'/import\', \''.$viewComposer.'Controller@import\')->name(\''.strtolower($viewComposer).'.import\');
    //    Route::post(\'/store_import\', \''.$viewComposer.'Controller@store_import\')->name(\''.strtolower($viewComposer).'.store_import\');
    //    Route::get(\'/pdf_show/{'.singularize(strtolower($viewComposer)).'}\', \''.$viewComposer.'Controller@pdf\')->name(\''.strtolower($viewComposer).'.pdf_show\');

    });
  //  Route::get(\'api/'.strtolower($viewComposer).'\',\''.$viewComposer.'Controller@data\');
    Route::group([\'prefix\' => DboardHelper::getAdminPrefix()], function () {
        Route::resource(\''.strtolower($viewComposer).'\', \''.$viewComposer.'Controller\');
        Route::delete(\''.strtolower($viewComposer).'/items/destroy\', [
            \'as\'         => \''.strtolower($viewComposer).'.deletes\',
            \'uses\'       => \''.$viewComposer.'Controller@deletes\',
        ]);
    });
});

';
        $file = "${fileName}.php";
        $path=base_path();

        $file=$path."/Modules/$viewComposer/Routes/$file";
        $composerDir=$path."/Modules/$viewComposer";

        if($this->files->isDirectory($composerDir)){
//                if($this->files->isFile($file))
//                    return $this->error($viewComposer . ' Module ' . $fileName . ' File Already exists!');

            if(!$this->files->put($file, $contents))
                return $this->error('Something went wrong!');
//            $this->info("$viewComposer Module $fileName Route File generated!");
            $this->info("Created :  " . $composerDir . '/' . $fileName . '.php');
        }
        else{
//                $this->files->makeDirectory($composerDir, 0777, true, true);
//                Artisan::call('module:make ' . $viewComposer);
//                if(!$this->files->put($file, $contents))
//                    return $this->error('Something went wrong!');
            $this->error("Something went wrong! Please at fist Create this module ");
//                $this->info("$viewComposer Module $fileName Route generated!");
        }
    }
    protected function ControllerFileCreate($viewComposer){

        $fileName = 'DataController';
        $contents=
            '<?php

namespace Modules\\'.$viewComposer.'\Http\Controllers;

use Illuminate\Routing\Controller;
use Menu;
use Dboard;
use Modules\\'.$viewComposer.'\Http\Models\\'.$viewComposer.';

class '.$fileName.'  extends Controller
{

    /**
     * Adds '.$viewComposer.' menus
     * @return null
     */
    public function modifyAdminMenu()
    {

        Menu::modify(
            \'admin-sidebar-menu\',
            function ($menu){
                if(auth()->user()->can(\''.strtolower($viewComposer).'_access\')) {
                    $menu->url(
                        action(\'\Modules\\'.$viewComposer.'\Http\Controllers\\'.$viewComposer.'Controller@index\'),
                        __(\''.strtolower($viewComposer).'::lang.'.strtolower($viewComposer).'\'),
                        [\'icon\' => \'icon-file-signature\']
                    )->order(20); } //next_lint
            }
        );
    }

    /**
     * Adds KamrulDashboard menus
     * @return null
     */
    public function modifyAdminDashboard()
    {
        if(auth()->user()->can(\''.strtolower($viewComposer).'_access\')) {
            Dboard::modify(\'main-dashboard\', function($menu) {
                // URL, Title, Attributes
                $data = '.$viewComposer.'::get();
                $menu->header(\'Total '.$viewComposer.'\', $data->count());
            });
        }
    }
}';
        $file = "${fileName}.php";
        $path=base_path();

        $file=$path."/Modules/$viewComposer/Http/Controllers/$file";
        $composerDir=$path."/Modules/$viewComposer";

        if($this->files->isDirectory($composerDir)){
//            if($this->files->isFile($file))
//                return $this->error($viewComposer . ' Module ' . $fileName . ' File Already exists!');

//                Artisan::call('kamrul:create-route', ['composer' => "$viewComposer"]);
            if(!$this->files->put($file, $contents))
                return $this->error('Something went wrong!');
//            $this->info("$viewComposer Module $fileName generated!");
            $this->info("Created :  " . $composerDir . '/' . $fileName . '.php');
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

    protected function langFileCreate($viewComposer){
        $fileNameLang = 'lang';
        $contentsLang=
            '<?php
return [
    \''.strtolower($viewComposer).'\' => \''.$viewComposer.'\',
    \''.strtolower($viewComposer).'_add\' => \''.$viewComposer.' add\',
    \''.strtolower($viewComposer).'_create\' => \''.$viewComposer.' create\',
    \''.strtolower($viewComposer).'_edit\' => \''.$viewComposer.' edit\',
    \''.strtolower($viewComposer).'_show\' => \''.$viewComposer.' show\',
    \'name\' => \'Name\',
    \'photo\' => \'Photo\',
    \'status\' => \'Status\',
    \'description\' => \'Description\',
    \'save\' => \'Save\',
    \'update\' => \'Update\',
    \'pdf\' => \'Pdf\',
    \'edit\' => \'Edit\',
    \'order\' => \'Order\',
    \'delete\' => \'Delete\',
    \'record_update_successfully\' => \'Record update successfully\',
    \'record_save_successfully\' => \'Record save successfully\',
    \'something_error_please_try_again_later\' => \'Something error! please try again later\',
    \'record_deleted_successfully\' => \'Record deleted successfully\',
    \'this_record_is_in_use_in_other_modules\' => \'This record is in use in other modules\',
    \''.strtolower($viewComposer).'_import\' => \''.$viewComposer.' Import\',
    \'import\' => \'Import\',
    \'view\' => \'View\',
    \'select_all\' => \'Select All\',
    \'id\' => \'Id\',
    \'action\' => \'Action\',
    \'create_by\' => \'Create By\',
    \'publish\' => \'Publish\',
    \'datatables\' =>[
        \'copy\' => \'Copy\',
        \'csv\' => \'Csv\',
        \'excel\' => \'Excel\',
        \'pdf\' => \'Pdf\',
        \'print\' => \'Print\',
        \'colvis\' => \'Column\',
        \'select_all\' => \'Select all\',
        \'deselect_all\' => \'Deselect all\',
    ],
];
';
        $file = "${fileNameLang}.php";
        $path=base_path();

        $file=$path."/Modules/$viewComposer/Resources/lang/en/$file";
        $composerDir=$path."/Modules/$viewComposer/Resources/lang/en";

        if($this->files->isDirectory($composerDir)){
//            if($this->files->isFile($file))
//                return $this->error($viewComposer . ' Module ' . $fileNameLang . ' File Already exists!');

            if(!$this->files->put($file, $contentsLang))
                return $this->error('Something went wrong!');
//            $this->info("$viewComposer Module $fileNameLang generated!");
            $this->info("Created :  " . $composerDir . '/' . $fileNameLang . '.php');
        }
        else{
                $this->files->makeDirectory($composerDir, 0777, true, true);
//                Artisan::call('module:make ' . $viewComposer);

                if(!$this->files->put($file, $contentsLang))
                    return $this->error('Something went wrong!');
//            $this->error("Something went wrong! Please at fist Create this module ");
                $this->info("$viewComposer Module $fileNameLang generated!");
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
