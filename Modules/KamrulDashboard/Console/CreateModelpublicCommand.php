<?php

namespace Modules\KamrulDashboard\Console;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Modules\KamrulDashboard\Http\Models\Systems;
use Modules\KamrulDashboard\Packages\Supports\KamrulComment;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class CreateModelpublicCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'kamrul:modelpublic {composer} {location}';

    protected $files;
    protected $kamrulComment;

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate new All system file.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(Filesystem $files, KamrulComment $kamrulComment)
    {
        $this->kamrulComment=$kamrulComment;
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
        $viewComposer = $this->argument('composer');
        $viewComposer = ucfirst($viewComposer);
        $location = $this->argument('location');
        $location = ucfirst($location);

        if ($viewComposer === '' || is_null($viewComposer) || empty($viewComposer)) {
            return $this->error('Composer Name Invalid..!');
        }

        if ($location === '' || is_null($location) || empty($location)) {
            return $this->error('Location Name Invalid..!');
        }


        if ($this->confirm('Do you wish to create form ' .$location.' Module file?')) {
//            $this->langFileCreate($viewComposer);

            $this->MainControllerCreate($viewComposer, $location);
            $this->MainViewFileCreate($viewComposer, $location);
            $this->MainImportFileCreate($viewComposer, $location);
            $this->MainMigrationFileCreate($viewComposer, $location);
            $this->MainRepositoriesFileCreate($viewComposer, $location);
            $this->TableFileCreate($viewComposer, $location);
            $this->RequestFileCreate($viewComposer, $location);
            $this->FormFileCreate($viewComposer, $location);
            $this->ThemePublicFileCreate($viewComposer, $location);

            // add new Line.
            $this->HookFileAddLineCreate($viewComposer, $location);
            $this->RouteFileCreate($viewComposer, $location);
            $this->MainPermissionFileCreate($viewComposer, $location);
            $this->langFileCreate($viewComposer, $location);
            $this->DataControllerCreate($viewComposer, $location);
            $this->DataConfigCreate($viewComposer, $location);
            $this->helpersFileCreate($viewComposer, $location);
            $this->EnumsStatusFileCreate($viewComposer, $location);
        }
    }

    protected function MainMigrationFileCreate($viewComposer, $location){

        $SixDigitRandomNumber = rand(100000,999999);
        $path=base_path();
        $fileName = date('Y_m_d') . '_' . $SixDigitRandomNumber . '_create_' . strtolower($viewComposer) . '_table';
        $filereplace=$path."/Modules/KamrulDashboard/Console/filereplace/modelpublic/PluginMigration.stub";
        $mainContent = File::get($filereplace);
        $new_item = Str::replace('__PlaginName__', $viewComposer, $mainContent);
        $new_item = Str::replace('__ShortPlaginName__', strtolower($viewComposer), $new_item);
        $model_name = lara_models($viewComposer);
        $new_item = Str::replace('__PluralizePlaginName__', pluralize(strtolower($model_name)), $new_item);

        $file = "${fileName}.php";
        $file=$path."/Modules/$location/Database/Migrations/$file";
        $composerDir=$path."/Modules/$location/Database/Migrations";
        $this->CreateSaveFile($file, $fileName, $new_item, $viewComposer, $composerDir);


        //Install Model Imports blade
        $path_imports=base_path();
        $fileName_imports = $viewComposer;
        $filereplace_imports = $path."/Modules/KamrulDashboard/Console/filereplace/modelpublic/PluginModel.stub";
        $mainContent_imports = File::get($filereplace_imports);
        $new_item_imports = Str::replace('__PlaginName__', $viewComposer, $mainContent_imports);
        $new_item_imports = Str::replace('__ShortPlaginName__', strtolower($viewComposer), $new_item_imports);
        $new_item_imports = Str::replace('__LocationName__', $location, $new_item_imports);
        $new_item_imports = Str::replace('__ShortLocationName__', strtolower($location), $new_item_imports);
        $file_imports = "${fileName_imports}.php";
        $file_imports=$path."/Modules/$location/Http/Models/$file_imports";
        $composerDir_imports=$path."/Modules/$location/Http/Models";
        $this->CreateSaveFile($file_imports, $fileName_imports, $new_item_imports, $viewComposer, $composerDir_imports);

    }
    protected function TableFileCreate($viewComposer, $location){

        //Main Import Create blade
        $path=base_path();
        //Install Controller Create blade
        $path_create=base_path();
        $fileName_create = $viewComposer.'Table';
        $filereplace_create = $path_create."/Modules/KamrulDashboard/Console/filereplace/modelpublic/PluginTable.stub";
        $mainContent_create = File::get($filereplace_create);
        $new_item_create = Str::replace('__PlaginName__', $viewComposer, $mainContent_create);
        $new_item_create = Str::replace('__ShortPlaginName__', strtolower($viewComposer), $new_item_create);
        $new_item_create = Str::replace('__LocationName__', $location, $new_item_create);
        $new_item_create = Str::replace('__ShortLocationName__', strtolower($location), $new_item_create);
        $file_create = "${fileName_create}.php";
        $file_create = $path_create."/Modules/$location/Tables/$file_create";
        $composerDir=$path."/Modules/$location/Tables";
        $this->CreateSaveFile($file_create, $fileName_create, $new_item_create, $viewComposer, $composerDir);

    }
    protected function RequestFileCreate($viewComposer, $location){

        //Main Import Create blade
        $path=base_path();
        //Install Controller Create blade
        $path_create=base_path();
        $fileName_create = $viewComposer.'Request';
        $filereplace_create = $path_create."/Modules/KamrulDashboard/Console/filereplace/modelpublic/PluginRequest.stub";
        $mainContent_create = File::get($filereplace_create);
        $new_item_create = Str::replace('__PlaginName__', $viewComposer, $mainContent_create);
        $new_item_create = Str::replace('__ShortPlaginName__', strtolower($viewComposer), $new_item_create);
        $new_item_create = Str::replace('__LocationName__', $location, $new_item_create);
        $new_item_create = Str::replace('__ShortLocationName__', strtolower($location), $new_item_create);
        $file_create = "${fileName_create}.php";
        $file_create = $path_create."/Modules/$location/Http/Requests/$file_create";
        $composerDir=$path."/Modules/$location/Http/Requests";
        $this->CreateSaveFile($file_create, $fileName_create, $new_item_create, $viewComposer, $composerDir);

    }
    protected function FormFileCreate($viewComposer, $location){

        //Main Import Create blade
        $path=base_path();
        //Install Controller Create blade
        $path_create=base_path();
        $fileName_create = $viewComposer.'Form';
        $filereplace_create = $path_create."/Modules/KamrulDashboard/Console/filereplace/modelpublic/PluginForm.stub";
        $mainContent_create = File::get($filereplace_create);
        $new_item_create = Str::replace('__PlaginName__', $viewComposer, $mainContent_create);
        $new_item_create = Str::replace('__ShortPlaginName__', strtolower($viewComposer), $new_item_create);
        $new_item_create = Str::replace('__LocationName__', $location, $new_item_create);
        $new_item_create = Str::replace('__ShortLocationName__', strtolower($location), $new_item_create);
        $file_create = "${fileName_create}.php";
        $file_create = $path_create."/Modules/$location/Forms/$file_create";
        $composerDir=$path."/Modules/$location/Forms";
        $this->CreateSaveFile($file_create, $fileName_create, $new_item_create, $viewComposer, $composerDir);

    }
    protected function EnumsStatusFileCreate($viewComposer, $location){

        //Main Import Create blade
        $path=base_path();
        //Install Controller Create blade
        $path_create=base_path();
        $fileName_create = $viewComposer.'StatusEnum';
        $filereplace_create = $path_create."/Modules/KamrulDashboard/Console/filereplace/modelpublic/PluginEnumsStatus.stub";
        $mainContent_create = File::get($filereplace_create);
        $new_item_create = Str::replace('__PlaginName__', $viewComposer, $mainContent_create);
        $new_item_create = Str::replace('__ShortPlaginName__', strtolower($viewComposer), $new_item_create);
        $new_item_create = Str::replace('__LocationName__', $location, $new_item_create);
        $new_item_create = Str::replace('__ShortLocationName__', strtolower($location), $new_item_create);
        $file_create = "${fileName_create}.php";
        $file_create = $path_create."/Modules/$location/Enums/$file_create";
        $composerDir=$path."/Modules/$location/Enums";
        $this->CreateSaveFile($file_create, $fileName_create, $new_item_create, $viewComposer, $composerDir);

    }
    protected function MainRepositoriesFileCreate($viewComposer, $location){

        //Main Import Create blade
        $path=base_path();

        //Install Controller Create blade
        $path_create=base_path();
        $fileName_create = $viewComposer.'Repository';
        $filereplace_create=$path_create."/Modules/KamrulDashboard/Console/filereplace/modelpublic/PluginEloquentRepository.stub";
        $mainContent_create = File::get($filereplace_create);
        $new_item_create = Str::replace('__PlaginName__', $viewComposer, $mainContent_create);
        $new_item_create = Str::replace('__ShortPlaginName__', strtolower($viewComposer), $new_item_create);
        $new_item_create = Str::replace('__LocationName__', $location, $new_item_create);
        $new_item_create = Str::replace('__ShortLocationName__', strtolower($location), $new_item_create);
        $file_create = "${fileName_create}.php";
        $file_create = $path_create."/Modules/$location/Repositories/Eloquent/$file_create";
        $composerDir=$path."/Modules/$location/Repositories/Eloquent";
        $this->CreateSaveFile($file_create, $fileName_create, $new_item_create, $viewComposer, $composerDir);

        //Install Controller Imports blade
        $path_imports=base_path();
        $fileName_imports = $viewComposer.'Interface';
        $filereplace_imports=$path_imports."/Modules/KamrulDashboard/Console/filereplace/modelpublic/PluginInterfaceRepository.stub";
        $mainContent_imports = File::get($filereplace_imports);
        $new_item_imports = Str::replace('__PlaginName__', $viewComposer, $mainContent_imports);
        $new_item_imports = Str::replace('__ShortPlaginName__', strtolower($viewComposer), $new_item_imports);
        $new_item_imports = Str::replace('__LocationName__', $location, $new_item_imports);
        $new_item_imports = Str::replace('__ShortLocationName__', strtolower($location), $new_item_imports);
        $file_imports = "${fileName_imports}.php";
        $file_imports = $path_imports."/Modules/$location/Repositories/Interfaces/$file_imports";
        $composerDir_imports=$path."/Modules/$location/Repositories/Interfaces";
        $this->CreateSaveFile($file_imports, $fileName_imports, $new_item_imports, $viewComposer, $composerDir_imports);

        //Install cache
        $path_cache=base_path();
        $fileName_cache = $viewComposer.'CacheDecorator';
        $filereplace_cache=$path_cache."/Modules/KamrulDashboard/Console/filereplace/modelpublic/PluginCacheDecorator.stub";
        $mainContent_cache = File::get($filereplace_cache);
        $new_item_cache = Str::replace('__PlaginName__', $viewComposer, $mainContent_cache);
        $new_item_cache = Str::replace('__ShortPlaginName__', strtolower($viewComposer), $new_item_cache);
        $new_item_cache = Str::replace('__LocationName__', $location, $new_item_cache);
        $new_item_cache = Str::replace('__ShortLocationName__', strtolower($location), $new_item_cache);
        $file_cache = "${fileName_cache}.php";
        $file_cache = $path_cache."/Modules/$location/Repositories/Cache/$file_cache";
        $composerDir_cache=$path."/Modules/$location/Repositories/Cache";
        $this->CreateSaveFile($file_cache, $fileName_cache, $new_item_cache, $viewComposer, $composerDir_cache);
    }

    protected function HookFileAddLineCreate($viewComposer, $location){
        $path=base_path();
        $fileName = 'HookServiceProvider';

        $filereplace_add=$path."/Modules/KamrulDashboard/Console/filereplace/modelpublic/PluginHook.stub";
        $mainContent_add = File::get($filereplace_add);
        $new_item_add = Str::replace('__PlaginName__', $viewComposer, $mainContent_add);
        $new_item_add = Str::replace('__ShortPlaginName__', strtolower($viewComposer), $new_item_add);
//        $new_item_add = Str::replace('__SingularPlaginName__', singularize(strtolower($viewComposer)), $new_item_add);
//        $new_item_add = Str::replace('__LocationName__', $location, $new_item_add);
//        $new_item_add = Str::replace('__ShortLocationName__', strtolower($location), $new_item_add);
        $new_item_call = 'use Modules\\'.$location.'\Http\Models\\'.$viewComposer.';
use Modules\\'.$location.'\Repositories\Eloquent\\'.$viewComposer.'Repository;
use Modules\\'.$location.'\Repositories\Interfaces\\'.$viewComposer.'Interface;
use Modules\\'.$location.'\Repositories\Cache\\'.$viewComposer.'CacheDecorator;';
        $array = array();
        $array2n = '';
        $add_row = 0;
        $filereplace11=$path."/Modules/$location/Providers/HookServiceProvider.php";
        $mainContent11 = File::get($filereplace11);
        $new_item11 = $mainContent11;
        foreach (explode("\n", $mainContent11) as $key=>$line){
            if($line == '//add_new_line_Interface_and_Repository_to_hook'){
                $array[$key + $add_row] = $line;
                $add_row = 1;
                $array[$key + $add_row] = $new_item_add;
                $array2n .= $line .PHP_EOL;
                $array2n .= $new_item_add .PHP_EOL;
            }elseif($line == '//add_new_line_Interface_and_Repository_call'){
                $array[$key + $add_row] = $line;
                $add_row = 1;
                $array[$key + $add_row] = $new_item_call;
                $array2n .= $line .PHP_EOL;
                $array2n .= $new_item_call .PHP_EOL;
            } else{
                $array2n .= $line .PHP_EOL;
                $array[$key + $add_row] = $line;
            }
        }
//        print_r($array2n);
        $new_item_create = $array2n;
        $new_item = $new_item_create;
        $file = "${fileName}.php";
        $file=$path."/Modules/$location/Providers/$file";
        $composerDir=$path."/Modules/$location/Providers";
        $this->CreateSaveFile($file, $fileName, $new_item, $viewComposer, $composerDir);
    }
    protected function RouteFileCreate($viewComposer, $location){

        //Main Controller Create blade
        $path=base_path();
        $fileName = 'web';
//        $filereplace=$path."/Modules/KamrulDashboard/Console/filereplace/modelpublic/PluginMainRoute.stub";
//        $mainContent = File::get($filereplace);
//        $new_item = Str::replace('__PlaginName__', $viewComposer, $mainContent);
//        $new_item = Str::replace('__ShortPlaginName__', strtolower($viewComposer), $new_item);
//        $new_item = Str::replace('__SingularPlaginName__', singularize(strtolower($viewComposer)), $new_item);
//        $new_item = Str::replace('__LocationName__', $location, $new_item);
//        $new_item = Str::replace('__ShortLocationName__', strtolower($location), $new_item);
//        $new_item = Str::replace('__SingularLocationName__', singularize(strtolower($location)), $new_item);


        $filereplace=$path."/Modules/$location/Routes/web.php";
        $mainContent = File::get($filereplace);
        $new_item = $mainContent;

        $filereplace_add=$path."/Modules/KamrulDashboard/Console/filereplace/modelpublic/PluginRoute.stub";
        $mainContent_add = File::get($filereplace_add);
        $new_item_add = Str::replace('__PlaginName__', $viewComposer, $mainContent_add);
        $new_item_add = Str::replace('__ShortPlaginName__', strtolower($viewComposer), $new_item_add);
        $new_item_add = Str::replace('__SingularPlaginName__', singularize(strtolower($viewComposer)), $new_item_add);
        $new_item_add = Str::replace('__ShortLocationName__', strtolower($location), $new_item_add);

        $new_item = $new_item_add . $new_item ;
        $file = "${fileName}.php";
        $file=$path."/Modules/$location/Routes/$file";
        $composerDir=$path."/Modules/$location/Routes";
        $this->CreateSaveFile($file, $fileName, $new_item, $viewComposer, $composerDir);

    }
    protected function MainControllerCreate($viewComposer, $location){

        //Main Controller Create blade
        $path=base_path();
        $fileName = $viewComposer . 'Controller';
        $filereplace=$path."/Modules/KamrulDashboard/Console/filereplace/modelpublic/PluginController.stub";
        $mainContent = File::get($filereplace);
        $new_item = Str::replace('__PlaginName__', $viewComposer, $mainContent);
        $new_item = Str::replace('__AllPlaginName__', strtoupper($viewComposer), $new_item);
        $new_item = Str::replace('__ShortPlaginName__', strtolower($viewComposer), $new_item);
        $new_item = Str::replace('__SingularPlaginName__', singularize(strtolower($viewComposer)), $new_item);
        $new_item = Str::replace('__LocationName__', $location, $new_item);
        $new_item = Str::replace('__ShortLocationName__', strtolower($location), $new_item);
        $file = "${fileName}.php";
        $file=$path."/Modules/$location/Http/Controllers/$file";
        $composerDir=$path."/Modules/$location/Http/Controllers";
        $this->CreateSaveFile($file, $fileName, $new_item, $viewComposer, $composerDir);

    }
    protected function MainPermissionFileCreate($viewComposer, $location)
    {

        //Main Permission Create blade
        $path = base_path();
        $fileName = $viewComposer . 'PermissionSeeder';
        $filereplace = $path . "/Modules/KamrulDashboard/Console/filereplace/modelpublic/PluginPermission.stub";
        $mainContent = File::get($filereplace);
        $new_item = Str::replace('__PlaginName__', $viewComposer, $mainContent);
        $new_item = Str::replace('__ShortPlaginName__', strtolower($viewComposer), $new_item);
        $new_item = Str::replace('__SingularPlaginName__', singularize(strtolower($viewComposer)), $new_item);
        $new_item = Str::replace('__LocationName__', $location, $new_item);
        $file = "${fileName}.php";
        $file = $path . "/Modules/$location/Database/Seeders/$file";
        $composerDir = $path . "/Modules/$location/Database/Seeders/";
        $this->CreateSaveFile($file, $fileName, $new_item, $viewComposer, $composerDir);

        //Install Permission Database Create blade
        ;
        $path_create=base_path();
        $fileName_create = $location . 'DatabaseSeeder';
        $filereplace_create=$path_create."/Modules/KamrulDashboard/Console/filereplace/modelpublic/PluginPermissionDatabase.stub";
        $mainContent_create = File::get($filereplace_create);
        $new_item_create = Str::replace('__PlaginName__', $viewComposer, $mainContent_create);
//        $new_item_create = Str::replace('__ShortPlaginName__', strtolower($viewComposer), $new_item_create);
//        $new_item_create = Str::replace('__LocationName__', $location, $new_item_create);
//

        $array = array();
        $array2n = '';
        $add_row = 0;
        $filereplace11=$path."/Modules/$location/Database/Seeders/$location"."DatabaseSeeder.php";
        $mainContent11 = File::get($filereplace11);
        $new_item11 = $mainContent11;
        foreach (explode("\n", $mainContent11) as $key=>$line){
            if($line == '                '.$location.'PermissionSeeder::class,'){
                $array[$key + $add_row] = $line;
                $add_row = 1;
                $array[$key + $add_row] = $new_item_create;
                $array2n .= $line .PHP_EOL;
                $array2n .= $new_item_create .PHP_EOL;
            }else{
                $array2n .= $line .PHP_EOL;
                $array[$key + $add_row] = $line;
            }
        }
//        print_r($array2n);
        $new_item_create = $array2n;
        $file_create = "${fileName_create}.php";
        $file_create = $path_create."/Modules/$location/Database/Seeders/$file_create";
        $this->CreateSaveFile($file_create, $fileName_create, $new_item_create, $viewComposer, $composerDir);
    }
    protected function MainImportFileCreate($viewComposer, $location){


        //Install Controller Create blade
        $path_create=base_path();
        $fileName_create = 'create_import.blade';
        $filereplace_create=$path_create."/Modules/KamrulDashboard/Console/filereplace/modelpublic/PluginImportBlade.stub";
        $mainContent_create = File::get($filereplace_create);
        $new_item_create = Str::replace('__PlaginName__', $viewComposer, $mainContent_create);
        $new_item_create = Str::replace('__ShortPlaginName__', strtolower($viewComposer), $new_item_create);
        $new_item_create = Str::replace('__LocationName__', $location, $new_item_create);
        $new_item_create = Str::replace('__ShortLocationName__', strtolower($location), $new_item_create);
        $file_create = "${fileName_create}.php";
        $file_create = $path_create."/Modules/$location/Resources/views/" . strtolower($viewComposer) . "/$file_create";
        $composerDir = $path_create."/Modules/$location/Resources/views/" . strtolower($viewComposer);
        $this->CreateSaveFile($file_create, $fileName_create, $new_item_create, $viewComposer, $composerDir);

        //Install Controller Imports blade
        $path_imports=base_path();
        $fileName_imports = $viewComposer . 'Import';
        $filereplace_imports=$path_imports."/Modules/KamrulDashboard/Console/filereplace/modelpublic/PluginImport.stub";
        $mainContent_imports = File::get($filereplace_imports);
        $new_item_imports = Str::replace('__PlaginName__', $viewComposer, $mainContent_imports);
        $new_item_imports = Str::replace('__ShortPlaginName__', strtolower($viewComposer), $new_item_imports);
        $new_item_imports = Str::replace('__LocationName__', $location, $new_item_imports);
        $new_item_imports = Str::replace('__ShortLocationName__', strtolower($location), $new_item_imports);
        $file_imports = "${fileName_imports}.php";
        $file_imports = $path_imports."/Modules/$location/Http/Imports/$file_imports";
        $composerDir_imports=$path_create."/Modules/$location/Http/Imports/";
        $this->CreateSaveFile($file_imports, $fileName_imports, $new_item_imports, $viewComposer, $composerDir_imports);


    }

    protected function ThemePublicFileCreate($viewComposer, $location){
        $path=base_path();
        //Index blade
        $fileName = $this->kamrulComment->pluralize_lower($viewComposer);
        $filereplace=$path."/Modules/KamrulDashboard/Console/filereplace/modelpublic/PluginPublicView.stub";
        $file = "${fileName}.blade.php";
        $composerDir=$path."/Modules/$location/Resources/views/" . strtolower($viewComposer) . "/".$this->kamrulComment->pascalToSnake($location);
        $data = array(
            'file' => $file,
            'fileName' => $fileName,
            'filereplace' => $filereplace,
            'composerDir' => $composerDir,
        );
        $this->kamrulComment->generateBladePhpFile($viewComposer, $location, $data);
        $this->info("Created :  " . $composerDir . '/' . $file);


        $fileName_2 = $this->kamrulComment->pascalToSnake($viewComposer);
        $filereplace_2=$path."/Modules/KamrulDashboard/Console/filereplace/modelpublic/PluginPublicView_2.stub";
        $file_2 = "${fileName_2}.blade.php";
        $composerDir_2=$path."/Modules/$location/Resources/views/" . strtolower($viewComposer) . "/".$this->kamrulComment->pascalToSnake($location);
        $data_2 = array(
            'file' => $file_2,
            'fileName' => $fileName_2,
            'filereplace' => $filereplace_2,
            'composerDir' => $composerDir_2,
        );
        $this->kamrulComment->generateBladePhpFile($viewComposer, $location, $data_2);
        $this->info("Created :  " . $composerDir_2 . '/' . $file_2);

        $fileName_3 = 'item';
        $filereplace_3=$path."/Modules/KamrulDashboard/Console/filereplace/modelpublic/PluginPublicView_3.stub";
        $file_3 = "${fileName_3}.blade.php";
        $composerDir_3=$path."/Modules/$location/Resources/views/" . strtolower($viewComposer) . "/".$this->kamrulComment->pascalToSnake($location). "/". $this->kamrulComment->pascalToSnake($viewComposer);
        $data_3 = array(
            'file' => $file_3,
            'fileName' => $fileName_3,
            'filereplace' => $filereplace_3,
            'composerDir' => $composerDir_3,
        );
        $this->kamrulComment->generateBladePhpFile($viewComposer, $location, $data_3);
        $this->info("Created :  " . $composerDir_3 . '/' . $file_3);

        $fileName_4 = 'items';
        $filereplace_4=$path."/Modules/KamrulDashboard/Console/filereplace/modelpublic/PluginPublicView_4.stub";
        $file_4 = "${fileName_4}.blade.php";
        $composerDir_4=$path."/Modules/$location/Resources/views/" . strtolower($viewComposer) . "/".$this->kamrulComment->pascalToSnake($location). "/". $this->kamrulComment->pascalToSnake($viewComposer);
        $data_4 = array(
            'file' => $file_4,
            'fileName' => $fileName_4,
            'filereplace' => $filereplace_4,
            'composerDir' => $composerDir_4,
        );
        $this->kamrulComment->generateBladePhpFile($viewComposer, $location, $data_4);
        $this->info("Created :  " . $composerDir_4 . '/' . $file_4);

    }
    protected function MainViewFileCreate($viewComposer, $location){

        $path=base_path();
        //Index blade
        $fileName = 'index.blade';
        $filereplace=$path."/Modules/KamrulDashboard/Console/filereplace/modelpublic/PluginIndex.blade.stub";
        $mainContent = File::get($filereplace);
        $new_item = Str::replace('__PlaginName__', $viewComposer, $mainContent);
        $new_item = Str::replace('__ShortPlaginName__', strtolower($viewComposer), $new_item);
        $new_item = Str::replace('__LocationName__', $location, $new_item);
        $new_item = Str::replace('__ShortLocationName__', strtolower($location), $new_item);
        $file = "${fileName}.php";
        $file=$path."/Modules/$location/Resources/views/" . strtolower($viewComposer) . "/$file";
        $composerDir=$path."/Modules/$location/Resources/views/" . strtolower($viewComposer);
        $this->CreateSaveFile($file, $fileName, $new_item, $viewComposer, $composerDir);

        //Create blade
        $fileName_create = 'create.blade';
        $filereplace_create=$path."/Modules/KamrulDashboard/Console/filereplace/modelpublic/PluginCreate.blade.stub";
        $mainContent_create = File::get($filereplace_create);
        $new_item_create = Str::replace('__PlaginName__', $viewComposer, $mainContent_create);
        $new_item_create = Str::replace('__ShortPlaginName__', strtolower($viewComposer), $new_item_create);
        $new_item_create = Str::replace('__LocationName__', $location, $new_item_create);
        $new_item_create = Str::replace('__ShortLocationName__', strtolower($location), $new_item_create);
        $file_create = "${fileName_create}.php";
        $file_create=$path."/Modules/$location/Resources/views/" . strtolower($viewComposer) . "/$file_create";

        $this->CreateSaveFile($file_create, $fileName_create, $new_item_create, $viewComposer, $composerDir);

        // Show Blade blade
        $fileName_show = 'show.blade';
        $filereplace_show=$path."/Modules/KamrulDashboard/Console/filereplace/modelpublic/PluginShowBlade.stub";
        $mainContent_show = File::get($filereplace_show);
        $new_item_show = Str::replace('__PlaginName__', $viewComposer, $mainContent_show);
        $new_item_show = Str::replace('__ShortPlaginName__', strtolower($viewComposer), $new_item_show);
        $new_item_show = Str::replace('__LocationName__', $location, $new_item_show);
        $new_item_show = Str::replace('__ShortLocationName__', strtolower($location), $new_item_show);
        $file_show = "${fileName_show}.php";
        $file_show=$path."/Modules/$location/Resources/views/" . strtolower($viewComposer) . "/$file_show";

        $this->CreateSaveFile($file_show, $fileName_show, $new_item_show, $viewComposer, $composerDir);

        // pdf Blade blade
        $fileName_pdf = 'pdf.blade';
        $filereplace_pdf=$path."/Modules/KamrulDashboard/Console/filereplace/modelpublic/PluginPdfBlade.stub";
        $mainContent_pdf = File::get($filereplace_pdf);
        $new_item_pdf = Str::replace('__PlaginName__', $viewComposer, $mainContent_pdf);
        $new_item_pdf = Str::replace('__ShortPlaginName__', strtolower($viewComposer), $new_item_pdf);
        $new_item_pdf = Str::replace('__LocationName__', $location, $new_item_pdf);
        $new_item_pdf = Str::replace('__ShortLocationName__', strtolower($location), $new_item_pdf);
        $file_pdf = "${fileName_pdf}.php";
        $file_pdf=$path."/Modules/$location/Resources/views/" . strtolower($viewComposer) . "/$file_pdf";

        $this->CreateSaveFile($file_pdf, $fileName_pdf, $new_item_pdf, $viewComposer, $composerDir);

    }

    protected function langFileCreate($viewComposer, $location){

        //Main Controller Create blade
        $path=base_path();
        $fileName = 'lang';


//        $filereplace=$path."/Modules/$location/Resources/lang/en/lang.stub";
//        $mainContent = File::get($filereplace);
//        $new_item = $mainContent;


        $filereplace_add=$path."/Modules/KamrulDashboard/Console/filereplace/modelpublic/PluginLang.stub";
        $mainContent_add = File::get($filereplace_add);
        $new_item_add = Str::replace('__PlaginName__', $viewComposer, $mainContent_add);
        $new_item_add = Str::replace('__ShortPlaginName__', strtolower($viewComposer), $new_item_add);
//        $new_item_add = Str::replace('__SingularPlaginName__', singularize(strtolower($viewComposer)), $new_item_add);
//        $new_item_add = Str::replace('__LocationName__', $location, $new_item_add);
//        $new_item_add = Str::replace('__ShortLocationName__', strtolower($location), $new_item_add);

        $array = array();
        $array2n = '';
        $add_row = 0;
        $filereplace11=$path."/Modules/$location/Resources/lang/en/lang.php";
        $mainContent11 = File::get($filereplace11);
        $new_item11 = $mainContent11;
        foreach (explode("\n", $mainContent11) as $key=>$line){
            if($line == '    ],'){
                $array[$key + $add_row] = $line;
                $add_row = 1;
                $array[$key + $add_row] = $new_item_add;
                $array2n .= $line .PHP_EOL;
                $array2n .= $new_item_add .PHP_EOL;
            }else{
                $array2n .= $line .PHP_EOL;
                $array[$key + $add_row] = $line;
            }
        }
//        print_r($array2n);
        $new_item_create = $array2n;
        $new_item = $new_item_create;
        $file = "${fileName}.php";
        $file=$path."/Modules/$location/Resources/lang/en/$file";
        $composerDir=$path."/Modules/$location/Resources/lang/en";
        $this->CreateSaveFile($file, $fileName, $new_item, $viewComposer, $composerDir);


//        // pdf Blade blade
//        $fileName_pdf = 'pdf.blade';
        $filereplace_pdf=$path."/Modules/KamrulDashboard/Console/filereplace/modelpublic/PluginLangFile.stub";
        $mainContent_pdf = File::get($filereplace_pdf);
        $new_item_pdf = Str::replace('__PlaginName__', $viewComposer, $mainContent_pdf);
        $new_item_pdf = Str::replace('__ShortPlaginName__', strtolower($viewComposer), $new_item_pdf);
        $new_item_pdf = Str::replace('__LocationName__', $location, $new_item_pdf);
        $new_item_pdf = Str::replace('__ShortLocationName__', strtolower($location), $new_item_pdf);
        $fileName_pdf = strtolower($viewComposer);
        $file_pdf = "${fileName_pdf}.php";
        $file_pdf=$path."/Modules/$location/Resources/lang/en/$file_pdf";

        $this->CreateSaveFile($file_pdf, $fileName_pdf, $new_item_pdf, $viewComposer, $composerDir);
    }
    protected function DataControllerCreate($viewComposer, $location){

        //Main Controller Create blade
        $path=base_path();
        $fileName = 'DataController';


//        $filereplace=$path."/Modules/$location/Resources/lang/en/lang.php";
//        $mainContent = File::get($filereplace);
//        $new_item = $mainContent;


        $filereplace_add=$path."/Modules/KamrulDashboard/Console/filereplace/modelpublic/PluginDataController.stub";
        $mainContent_add = File::get($filereplace_add);
        $new_item_add = Str::replace('__PlaginName__', $viewComposer, $mainContent_add);
        $new_item_add = Str::replace('__ShortPlaginName__', strtolower($viewComposer), $new_item_add);
//        $new_item_add = Str::replace('__SingularPlaginName__', singularize(strtolower($viewComposer)), $new_item_add);
        $new_item_add = Str::replace('__LocationName__', $location, $new_item_add);
        $new_item_add = Str::replace('__ShortLocationName__', strtolower($location), $new_item_add);

        $array = array();
        $array2n = '';
        $add_row = 0;
        $filereplace11=$path."/Modules/$location/Http/Controllers/DataController.php";
        $mainContent11 = File::get($filereplace11);
        $new_item11 = $mainContent11;
        foreach (explode("\n", $mainContent11) as $key=>$line){
            if($line == '                    )->order(20); } //next_lint'){
                $array[$key + $add_row] = $line;
                $add_row = 1;
                $array[$key + $add_row] = $new_item_add;
                $array2n .= $line .PHP_EOL;
                $array2n .= $new_item_add .PHP_EOL;
            }else{
                $array2n .= $line .PHP_EOL;
                $array[$key + $add_row] = $line;
            }
        }
//        print_r($array2n);
        $new_item_create = $array2n;
        $new_item = $new_item_create;
        $file = "${fileName}.php";
        $file=$path."/Modules/$location/Http/Controllers/$file";
        $composerDir=$path."/Modules/$location/Http/Controllers";
        $this->CreateSaveFile($file, $fileName, $new_item, $viewComposer, $composerDir);
    }
    protected function helpersFileCreate($viewComposer, $location){

        //Main Controller Create blade
        $path=base_path();
        $fileName = 'helpers';


//        $filereplace=$path."/Modules/$location/Resources/lang/en/lang.php";
//        $mainContent = File::get($filereplace);
//        $new_item = $mainContent;


        $filereplace_add=$path."/Modules/KamrulDashboard/Console/filereplace/modelpublic/PluginHelpers.stub";
        $mainContent_add = File::get($filereplace_add);
        $new_item_add = Str::replace('__PlaginName__', $viewComposer, $mainContent_add);
        $new_item_add = Str::replace('__AllPlaginName__', strtoupper($viewComposer), $new_item_add);
        $new_item_add = Str::replace('__ShortPlaginName__', strtolower($viewComposer), $new_item_add);
//        $new_item_add = Str::replace('__SingularPlaginName__', singularize(strtolower($viewComposer)), $new_item_add);
        $new_item_add = Str::replace('__LocationName__', $location, $new_item_add);
        $new_item_add = Str::replace('__ShortLocationName__', strtolower($location), $new_item_add);

        $array = array();
        $array2n = '';
        $add_row = 0;
        $filereplace11=$path."/Modules/$location/Http/helpers/helpers.php";
        $mainContent11 = File::get($filereplace11);
        $new_item11 = $mainContent11;
        foreach (explode("\n", $mainContent11) as $key=>$line){
            if($line == '//add_next_line'){
                $array[$key + $add_row] = $line;
                $add_row = 1;
                $array[$key + $add_row] = $new_item_add;
                $array2n .= $line .PHP_EOL;
                $array2n .= $new_item_add .PHP_EOL;
            }else{
                $array2n .= $line .PHP_EOL;
                $array[$key + $add_row] = $line;
            }
        }
//        print_r($array2n);
        $new_item_create = $array2n;
        $new_item = $new_item_create;
        $file = "${fileName}.php";
        $file=$path."/Modules/$location/Http/helpers/$file";
        $composerDir=$path."/Modules/$location/Http/helpers";
        $this->CreateSaveFile($file, $fileName, $new_item, $viewComposer, $composerDir);
    }
    protected function DataConfigCreate($viewComposer, $location){

        //Main Controller Create blade
        $path=base_path();
        $fileName = 'config';

        $superadmin_version = Systems::getProperty($location . '_version');
        $new_item_add = "    'module_version' => ";
        $array = array();
        $array2n = '';
        $add_row = 0;
        $filereplace11=$path."/Modules/$location/Config/config.php";
        $mainContent11 = File::get($filereplace11);
        $new_item11 = $mainContent11;
        foreach (explode("\n", $mainContent11) as $key=>$line){
            if($line == '    \'module_version\' => "'.$superadmin_version.'",'){
                $superadmin_version = $superadmin_version + 0.1;
                $array[$key + $add_row] = $line;
                $add_row = 1;
                $array[$key + $add_row] = $new_item_add . "\"$superadmin_version\",";
//                $array2n .= $line .PHP_EOL;
                $array2n .= $new_item_add . "\"$superadmin_version\"," .PHP_EOL;
            }else{
                $array2n .= $line .PHP_EOL;
                $array[$key + $add_row] = $line;
            }
        }
//        print_r($array2n);
        $new_item_create = $array2n;
        $new_item = $new_item_create;
        $file = "${fileName}.php";
        $file=$path."/Modules/$location/Config/$file";
        $composerDir=$path."/Modules/$location/Config";
        $this->CreateSaveFile($file, $fileName, $new_item, $viewComposer, $composerDir);
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
            $this->info("$viewComposer Module $fileName File generated!");
        }
        else{
//            $this->files->makeDirectory($composerDir, 0777, true, true);
//            if(!$this->files->put($file, $new_item))
//                return $this->error('Something went wrong!');
            $this->error("Something went wrong! Please at fist Create this module ");
//            $this->info("$viewComposer Module $fileName File generated!");
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
