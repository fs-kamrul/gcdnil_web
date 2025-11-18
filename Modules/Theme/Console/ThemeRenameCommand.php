<?php

namespace Modules\Theme\Console;

use Illuminate\Console\Command;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Filesystem\Filesystem as File;
use Illuminate\Support\Facades\Artisan;
use Modules\KamrulDashboard\Http\Models\SettingData as SettingModel;
use Modules\Theme\Console\Traits\ThemeTrait;
use Modules\Theme\Services\ThemeService;

class ThemeRenameCommand extends Command
{

    use ThemeTrait;

    /**
     * @var ThemeService
     */
    public $themeService;

    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'kamrul:theme:rename {name : The theme that you want to rename} {newName : The new name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Rename theme to the new name';

    /**
     * @var File
     */
    protected $files;

    /**
     * Create a new command instance.
     *
     * @param File $files
     * @param ThemeService $themeService
     */
    public function __construct(File $files, ThemeService $themeService)
    {
        parent::__construct();
        $this->files = $files;
        $this->themeService = $themeService;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     * @throws \League\Flysystem\FileNotFoundException
     * @throws FileNotFoundException
     */
    public function handle()
    {
//        $theme = $this->getTheme();

        $newName = $this->argument('newName');
        $theme = $this->argument('name');

//        $this->error($Name);
//        return 1;
        if ($theme == $newName) {
            $this->error('Theme name are the same!');
            return 1;
        }

//        if ($this->files->isDirectory(theme_path($newName))) {
//            $this->error('Theme "' . $theme . '" is already exists.');
//            return 1;
//        }

//        $this->files->move(theme_path($theme), theme_path($newName));
        $file_name = [
            'Http/Controllers/' . $theme . 'Controller.php',
            'Routes/web.php',
            'Routes/api.php',
            'Resources/lang/en/lang.php',
            'theme.json',
            'layouts/master.blade.php',
            'webpack.mix.js',
            'partials/footer.blade.php',
            'partials/menu_custom.blade.php'
        ];
        foreach ($file_name as $value){
            $this->replaceText($theme, $newName, $value);
        }
        $this->renameFile($theme, $newName);
        $this->renameFolder($theme, $newName);
        Artisan::call('optimize');

        $this->themeService->activate($newName);

        $themeOptions = SettingModel::where('key', 'LIKE', 'theme-' . $theme . '-%')->get();

        foreach ($themeOptions as $option) {
            $option->key = str_replace('theme-' . $theme, 'theme-' . $newName, $option->key);
            $option->save();
        }

//        Widget::where('theme', $theme)->update(['theme' => $newName]);
//
//        $widgets = Widget::where('theme', 'LIKE', $theme . '-%')->get();
//
//        foreach ($widgets as $widget) {
//            $widget->theme = str_replace($theme, $newName, $widget->theme);
//            $widget->save();
//        }

        $this->info('Theme "' . $theme . '" has been renamed to ' . $newName . '!');

        return 0;
    }
    protected function renameFolder($theme, $newName)
    {
        // Find the folder
        $folder = glob(theme_path($theme));

        // Check if the folder was found
        if ($folder) {
            // Rename the folder
            $newName_1 = theme_path($newName);
            rename($folder[0], $newName_1);
        }
//        return $folder;
    }
    protected function renameFile($theme, $newName)
    {
        // Find the file
//        $file = glob('/path/to/file.txt');
        $file = glob(theme_path($theme . '/Http/Controllers/' . $theme . 'Controller.php'));

        // Check if the file was found
        if ($file) {
            // Rename the file
            $newName_1 = theme_path($theme . '/Http/Controllers/' . $newName . 'Controller.php');
            rename($file[0], $newName_1);
        }
//        return $file;
    }
    public function replaceText($theme, $newName, $filename)
    {
        // Read the file into a string
//        $file = file_get_contents('/path/to/file.txt');
        $file_name = theme_path($theme . '/' . $filename);
        $file = file_get_contents($file_name);

        // Replace the text
        $newFile_1 = str_replace($theme, $newName, $file);
        $newFile = str_replace(strtolower($theme), strtolower($newName), $newFile_1);

        // Write the new string back to the file
        file_put_contents($file_name, $newFile);
//        return $file;
    }
}
