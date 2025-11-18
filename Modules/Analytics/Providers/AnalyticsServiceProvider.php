<?php

namespace Modules\Analytics\Providers;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Factory;
use Modules\Analytics\Abstracts\AnalyticsAbstract;
use Modules\Analytics\Exceptions\InvalidConfiguration;
use Modules\Analytics\Packages\Facades\AnalyticsFacade;
use Modules\Analytics\Packages\Supports\Analytics;
use Modules\Analytics\Packages\Supports\AnalyticsClient;
use Modules\Analytics\Packages\Supports\AnalyticsClientFactory;
use Modules\Analytics\Packages\Supports\GA4\Analytics as AnalyticsGA4;
use Modules\KamrulDashboard\Traits\LoadAndPublishDataTrait;

class AnalyticsServiceProvider extends ServiceProvider
{
    use LoadAndPublishDataTrait;
    /**
     * @var string $moduleName
     */
    protected $moduleName = 'Analytics';

    /**
     * @var string $moduleNameLower
     */
    protected $moduleNameLower = 'analytics';

    /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->setNamespace('Modules/' . $this->moduleName)
            ->loadAndPublishTranslations()
            ->loadHelpers()
            ->publishAssets();;

        $this->registerTranslations();
        $this->registerConfig();
        $this->registerViews();
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        if (! class_exists('Google\Service\Analytics\GaData')) {
            return;
        }

        $this->app->bind(AnalyticsClient::class, function () {
            return AnalyticsClientFactory::createForConfig(config('analytics'));
        });

        $this->app->bind(AnalyticsAbstract::class, function () {
            $credentials = setting('analytics_service_account_credentials');

            if (! $credentials) {
                throw InvalidConfiguration::credentialsIsNotValid();
            }

            if ($propertyId = setting('analytics_property_id')) {
                if (! is_numeric($propertyId)) {
                    throw InvalidConfiguration::invalidPropertyId();
                }

                return new AnalyticsGA4($propertyId, $credentials);
            }

            $viewId = setting('analytics_view_id');

            if (empty($viewId)) {
                throw InvalidConfiguration::propertyIdNotSpecified();
            }

            return new Analytics($this->app->make(AnalyticsClient::class), $viewId);
        });

        AliasLoader::getInstance()->alias('Analytics', AnalyticsFacade::class);

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
