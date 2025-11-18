<?php

namespace Modules\Widget\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Factory;
use Modules\KamrulDashboard\Traits\LoadAndPublishDataTrait;
use Modules\Widget\Http\Models\Widget;
use Modules\Widget\Misc\LaravelApplicationWrapper;
use Modules\Widget\Packages\Factories\WidgetFactory;
use Modules\Widget\Packages\Supports\WidgetGroupCollection;
use Modules\Widget\Repositories\Eloquent\WidgetRepository;
use Modules\Widget\Repositories\Interfaces\WidgetInterface;
use Modules\Widget\Widgets\Text;
use Theme;
use File;
use WidgetGroup;

class WidgetServiceProvider extends ServiceProvider
{
    use LoadAndPublishDataTrait;
    /**
     * @var string $moduleName
     */
    protected $moduleName = 'Widget';

    /**
     * @var string $moduleNameLower
     */
    protected $moduleNameLower = 'widget';

    /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot()
    {

        $this->registerTranslations();
        $this->registerConfig();
        $this->registerViews();
        $this->loadMigrationsFrom(module_path($this->moduleName, 'Database/Migrations'));
        $this->app->booted(function () {

//            WidgetGroup::setGroup([
//                'id'          => 'primary_sidebar',
//                'name'        => trans('widget::lang.primary_sidebar_name'),
//                'description' => trans('widget::lang.primary_sidebar_description'),
//            ]);

            register_widget(Text::class);

            $widgetPath = theme_path(Theme::getThemeName() . '/widgets');
            $widgets = scan_folder($widgetPath);
            if (!empty($widgets) && is_array($widgets)) {
                foreach ($widgets as $widget) {
                    $registration = $widgetPath . '/' . $widget . '/registration.php';
                    if (File::exists($registration)) {
                        File::requireOnce($registration);
                    }
                }
            }
        });
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(WidgetInterface::class, function () {
            return new WidgetRepository(new Widget);
        });
        $this->app->bind('kamruldashboard.widget', function () {
            return new WidgetFactory(new LaravelApplicationWrapper);
        });
        $this->app->singleton('kamruldashboard.widget-group-collection', function () {
            return new WidgetGroupCollection(new LaravelApplicationWrapper);
        });

        $this->setNamespace('Modules/' . $this->moduleName)
            ->loadAndPublishTranslations()
            ->loadHelpers();
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
