<?php

namespace Modules\Menus\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Factory;
use Modules\KamrulDashboard\Traits\LoadAndPublishDataTrait;
use Modules\Menus\Http\Models\Menus;
use Modules\Menus\Http\Models\Menus as MenuModel;
use Modules\Menus\Http\Models\MenusLocation;
use Modules\Menus\Http\Models\MenusNode;
use Modules\Menus\Repositories\Eloquent\MenusLocationRepository;
use Modules\Menus\Repositories\Eloquent\MenusNodeRepository;
use Modules\Menus\Repositories\Eloquent\MenusRepository;
use Modules\Menus\Repositories\Interfaces\MenusInterface;
use Modules\Menus\Repositories\Interfaces\MenusLocationInterface;
use Modules\Menus\Repositories\Interfaces\MenusNodeInterface;

class MenusServiceProvider extends ServiceProvider
{
    use LoadAndPublishDataTrait;
    /**
     * @var string $moduleName
     */
    protected $moduleName = 'Menus';

    /**
     * @var string $moduleNameLower
     */
    protected $moduleNameLower = 'menus';

    /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerRepository();

        $this->registerTranslations();
        $this->registerConfig();
        $this->registerViews();
        $this->loadMigrationsFrom(module_path($this->moduleName, 'Database/Migrations'));

        $this
            ->loadAndPublishTranslations()
            ->loadAndPublishViews()
            ->publishAssets();

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

        $this->setNamespace('Modules/' . $this->moduleName)
            ->loadHelpers();
    }
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function registerRepository()
    {
        $this->app->bind(MenusInterface::class, function () {
                return new MenusRepository(new Menus);
        });

        $this->app->bind(MenusNodeInterface::class, function () {
            return new MenusNodeRepository(new MenusNode);
        });

        $this->app->bind(MenusLocationInterface::class, function () {
            return new MenusLocationRepository(new MenusLocation);
        });
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
