<?php

namespace Modules\KamrulDashboard\Packages\Supports;

use Illuminate\Console\Command;
use Illuminate\Contracts\Cache\Repository as CacheRepository;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Modules\KamrulDashboard\Events\SystemUpdateCachesCleared;
use Modules\KamrulDashboard\Events\SystemUpdateCachesClearing;
use Throwable;
use DboardHelper;

final class KamrulComment
{
    private $files;
    private $cache;
    private $comment;
    private $basePath;
    private $coreDataFilePath;
    private $licenseFilePath;
    private $productId;
    private $productSource;
    private $version = '1.0.0';
    private $minimumPhpVersion = '8.1.0';
    private $verificationPeriod = 1;
    public function __construct(CacheRepository $cache, Filesystem $files) {
        $this->basePath = base_path();
        $this->cache = $cache;
        $this->files = $files;
        $this->coreDataFilePath = core_path('kamrul.json');
    }
    public static function make(): self
    {
        return app(self::class);
    }
    public function minimumPhpVersion(): string
    {
        return $this->minimumPhpVersion;
    }

    public function cleanCaches(): void
    {
        try {
            SystemUpdateCachesClearing::dispatch();

            ClearCacheService::make()->purgeAll();

            SystemUpdateCachesCleared::dispatch();
        } catch (Throwable $exception) {
            $this->logError($exception);
        }
    }

    public function cleanUp(): void
    {
        $this->cleanCaches();
    }

    public function logError(Throwable $exception): void
    {
        DboardHelper::logError($exception);
    }
    public function pascalToSnake($string)
    {
        return strtolower(preg_replace('/([a-z])([A-Z])/', '$1_$2', $string));
    }
    public function pluralize($word)
    {
        // If word ends with 'y', replace 'y' with 'ies'
        if (preg_match('/y$/', $word)) {
            return preg_replace('/y$/', 'ies', $word);
        }
        // If word ends with 's', 'sh', or 'ch', add 'es'
        elseif (preg_match('/(s|sh|ch)$/', $word)) {
            return $word . 'es';
        }
        // Default: add 's'
        else {
            return $word . 's';
        }
    }
    public function pluralize_lower($word)
    {
        $word = $this->pascalToSnake($word);
        // If word ends with 'y', replace 'y' with 'ies'
        if (preg_match('/y$/', $word)) {
            return preg_replace('/y$/', 'ies', $word);
        }
        // If word ends with 's', 'sh', or 'ch', add 'es'
        elseif (preg_match('/(s|sh|ch)$/', $word)) {
            return $word . 'es';
        }
        // Default: add 's'
        else {
            return $word . 's';
        }
    }
    public function generateBladePhpFile($viewComposer, $location, $data)
    {
        // Set the base path and file paths
        $path = base_path();
        $fileName = $this->pluralize_lower($viewComposer);
        $filereplace = $data['filereplace'];
        $composerDir = $data['composerDir'];
        $file = "$composerDir/{$data['file']}";

        // Check if the stub file exists
        if (!File::exists($filereplace)) {
            throw new Exception("File not found: " . $filereplace);
        }

        // Get the content of the stub file
        $mainContent = File::get($filereplace);

        // Perform the replacements in the stub content
        $new_item = Str::replace('__PlaginName__', $viewComposer, $mainContent);
        $new_item = Str::replace('__SingularPlaginName__', $this->pascalToSnake($viewComposer), $new_item);
        $new_item = Str::replace('__PluralPluginName__', $this->pluralize_lower($viewComposer), $new_item);
        $new_item = Str::replace('__ShortPlaginName__', strtolower($viewComposer), $new_item);
        $new_item = Str::replace('__LocationName__', $location, $new_item);
        $new_item = Str::replace('__pascalLocationName__', $this->pascalToSnake($location), $new_item);
        $new_item = Str::replace('__ShortLocationName__', strtolower($location), $new_item);

        // Create the directory if it doesn't exist
        if (!File::exists($composerDir)) {
            File::makeDirectory($composerDir, 0755, true, true);
        }

        // Save the file
        $this->CreateSaveFile($file, $fileName, $new_item, $viewComposer, $composerDir);
    }
    public function CreateSaveFile($file, $fileName, $new_item, $viewComposer, $composerDir){
        if($this->files->isDirectory($composerDir)){
            if(!$this->files->put($file, $new_item))
                return $this->error('Something went wrong!');
//            $this->info("$viewComposer Module $fileName File generated!");
            Log::info("This is an informational message from KamrulComment.");
//            $this->info("Created :  " . $composerDir . '/' . $fileName . '.php');
        }
        else{
            $this->files->makeDirectory($composerDir, 0777, true, true);
            if(!$this->files->put($file, $new_item))
                return $this->error('Something went wrong!');
//            $this->error("Something went wrong! Please at fist Create this module ");
//            $this->info("$viewComposer Module $fileName File generated!");
//            $this->info("Created :  " . $composerDir . '/' . $fileName . '.php');
        }
    }
}
