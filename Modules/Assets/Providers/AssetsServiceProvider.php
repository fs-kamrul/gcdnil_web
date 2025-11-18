<?php

namespace Modules\Assets\Providers;

use Illuminate\Support\ServiceProvider;

class AssetsServiceProvider extends ServiceProvider
{
    /**
     * @var string $moduleName
     */
    protected $moduleName = 'Assets';

    /**
     * @var string $moduleNameLower
     */
    protected $moduleNameLower = 'assets';

    /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->mergeConfigFrom(__DIR__ . '/../Config/assets.php', 'assets');
        $this->loadViewsFrom(__DIR__ . '/../Resources/views', 'assets');

        if ($this->app->runningInConsole()) {
            $this->publishes([__DIR__ . '/../config/assets.php' => config_path('assets.php')], 'config');
            $this->publishes([__DIR__ . '/../resources/views' => resource_path('views/vendor/assets')], 'views');
        }
    }
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
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
}
