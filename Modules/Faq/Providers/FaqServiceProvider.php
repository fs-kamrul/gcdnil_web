<?php

namespace Modules\Faq\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Factory;
use Modules\Faq\Http\Models\Faq;
use Modules\Faq\Http\Models\FaqCategory;
use Modules\KamrulDashboard\Traits\LoadAndPublishDataTrait;
use Modules\LanguageAdvanced\Packages\Supports\LanguageAdvancedManager;
use Language;

class FaqServiceProvider extends ServiceProvider
{
    use LoadAndPublishDataTrait;
    /**
     * @var string $moduleName
     */
    protected $moduleName = 'Faq';

    /**
     * @var string $moduleNameLower
     */
    protected $moduleNameLower = 'faq';

    /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot()
    {
        if (!defined('LANGUAGE_MODULE_SCREEN_NAME')) {
            define('LANGUAGE_MODULE_SCREEN_NAME', 'language');
        }
        $this->setNamespace('Modules/' . $this->moduleName)
            ->loadAndPublishTranslations()
            ->loadHelpers()
            ->publishAssets();;

        $this->registerTranslations();
        $this->registerConfig();
        $this->registerViews();
        $this->loadMigrationsFrom(module_path($this->moduleName, 'Database/Migrations'));


        $useLanguageV2 = $this->app['config']->get('faq.use_language_v2', false) &&
            defined('LANGUAGE_ADVANCED_MODULE_SCREEN_NAME');

        if (defined('LANGUAGE_MODULE_SCREEN_NAME')) {
            if ($useLanguageV2) {
                LanguageAdvancedManager::registerModule(Faq::class, [
                    'question',
                    'answer',
                ]);
                LanguageAdvancedManager::registerModule(FaqCategory::class, [
                    'name',
                ]);
            } else {
                $this->app->booted(function () {
                    if(is_module_active('Language')) {
                        Language::registerModule([Faq::class, FaqCategory::class]);
                    }
                });
            }
        }
        $this->app->register(EventServiceProvider::class);

    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(RouteServiceProvider::class);
    }

    /**
     * Register config.
     *
     * @return void
     */
    protected function registerConfig()
    {
        $this->publishes([
            module_path($this->moduleName, 'Config/config.php') => config_path($this->moduleNameLower . '.php'),
        ], 'config');
        $this->mergeConfigFrom(
            module_path($this->moduleName, 'Config/config.php'), $this->moduleNameLower
        );
    }

    /**
     * Register views.
     *
     * @return void
     */
    public function registerViews()
    {
        $viewPath = resource_path('views/modules/' . $this->moduleNameLower);

        $sourcePath = module_path($this->moduleName, 'Resources/views');

        $this->publishes([
            $sourcePath => $viewPath
        ], ['views', $this->moduleNameLower . '-module-views']);

        $this->loadViewsFrom(array_merge($this->getPublishableViewPaths(), [$sourcePath]), $this->moduleNameLower);
    }

    /**
     * Register translations.
     *
     * @return void
     */
    public function registerTranslations()
    {
        $langPath = resource_path('lang/modules/' . $this->moduleNameLower);

        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, $this->moduleNameLower);
        } else {
            $this->loadTranslationsFrom(module_path($this->moduleName, 'Resources/lang'), $this->moduleNameLower);
        }
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [];
    }

    private function getPublishableViewPaths(): array
    {
        $paths = [];
        foreach (\Config::get('view.paths') as $path) {
            if (is_dir($path . '/modules/' . $this->moduleNameLower)) {
                $paths[] = $path . '/modules/' . $this->moduleNameLower;
            }
        }
        return $paths;
    }
}
