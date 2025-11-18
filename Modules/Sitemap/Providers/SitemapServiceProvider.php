<?php

namespace Modules\Sitemap\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Factory;
use Illuminate\Support\Facades\Event;
use Modules\KamrulDashboard\Events\CreatedContentEvent;
use Modules\KamrulDashboard\Events\DeletedContentEvent;
use Modules\KamrulDashboard\Events\UpdatedContentEvent;
use Modules\KamrulDashboard\Traits\LoadAndPublishDataTrait;
use Modules\Sitemap\Http\Sitemap;

class SitemapServiceProvider extends ServiceProvider
{
    use LoadAndPublishDataTrait;
    /**
     * @var string $moduleName
     */
    protected $moduleName = 'Sitemap';

    /**
     * @var string $moduleNameLower
     */
    protected $moduleNameLower = 'sitemap';

    /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->setNamespace('Modules/' . $this->moduleName)
//            ->loadAndPublishTranslations()
            ->loadAndPublishViews()
            ->loadAndPublishConfigurations(['config'])
            ->publishAssets();
//            ->loadHelpers();
//        $this->registerTranslations();
        $this->registerCssPublish();
        $this->registerConfig();
        $this->registerViews();
//        $this->loadMigrationsFrom(module_path($this->moduleName, 'Database/Migrations'));

        Event::listen(CreatedContentEvent::class, function () {
            cache()->forget('cache_site_map_key');
        });

        Event::listen(UpdatedContentEvent::class, function () {
            cache()->forget('cache_site_map_key');
        });

        Event::listen(DeletedContentEvent::class, function () {
            cache()->forget('cache_site_map_key');
        });
    }

    protected function registerCssPublish()
    {
        $this->publishes([
            __DIR__.'/../public' => public_path('vendor/' . $this->moduleNameLower),
        ], $this->moduleNameLower . '_public');
    }
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('sitemap', function ($app) {
            $config = config('sitemap');

//            dd(config('sitemap'));
//            dd(config('Modules.Sitemap.config'));
            return new Sitemap(
                $config,
                $app['Illuminate\Cache\Repository'],
                $app['config'],
                $app['files'],
                $app['Illuminate\Contracts\Routing\ResponseFactory'],
                $app['view']
            );
        });

        $this->app->alias('sitemap', Sitemap::class);

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
        return ['sitemap', Sitemap::class];
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
