<?php

namespace Modules\Location\Providers;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Factory;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Schema;
use Modules\KamrulDashboard\Http\Models\DboardModel;
use Modules\KamrulDashboard\Traits\LoadAndPublishDataTrait;
use Modules\LanguageAdvanced\Packages\Supports\LanguageAdvancedManager;
use Modules\Location\Http\Models\City;
use Modules\Location\Http\Models\Country;
use Modules\Location\Http\Models\State;
use Location;
use MacroableModels;
use Modules\Location\Packages\Facades\LocationFacade;

class LocationServiceProvider extends ServiceProvider
{
    use LoadAndPublishDataTrait;
    /**
     * @var string $moduleName
     */
    protected $moduleName = 'Location';

    /**
     * @var string $moduleNameLower
     */
    protected $moduleNameLower = 'location';

    /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->setNamespace('Modules/' . $this->moduleName)
            ->loadAndPublishTranslations()
            ->loadAndPublishViews()
            ->publishAssets()
            ->loadHelpers();

        $this->registerTranslations();
        $this->registerConfig();
        $this->registerViews();
        $this->loadMigrationsFrom(module_path($this->moduleName, 'Database/Migrations'));


        if (defined('LANGUAGE_MODULE_SCREEN_NAME') && defined('LANGUAGE_ADVANCED_MODULE_SCREEN_NAME')) {
            LanguageAdvancedManager::registerModule(Country::class, [
                'name',
                'nationality',
            ]);

            LanguageAdvancedManager::registerModule(State::class, [
                'name',
                'abbreviation',
            ]);

            LanguageAdvancedManager::registerModule(City::class, [
                'name',
            ]);
        }


        $this->app->booted(function () {
            Blueprint::macro('location', function ($item = null, $keys = []) {
                if ($item) {
                    if (class_exists($item) && Location::isSupported($item)) {
                        $data = Location::getSupported($item);
                        $model = new $item();
                        $table = $model->getTable();
                        $connection = $model->getConnectionName();
                        $keys = [];
                        foreach ($data as $key => $column) {
                            if (! Schema::connection($connection)->hasColumn($table, $column)) {
                                $keys[$key] = $column;
                            }
                        }
                    }
                } else {
                    $keys = array_filter(array_merge([
                        'country' => 'country_id',
                        'state' => 'state_id',
                        'city' => 'city_id',
                    ], $keys));
                }

                /**
                 * @var Blueprint $this
                 */
                if ($columnName = Arr::get($keys, 'country')) {
                    $this->integer($columnName)->unsigned()->default(1)->nullable();
                }

                if ($columnName = Arr::get($keys, 'state')) {
                    $this->integer($columnName)->unsigned()->nullable();
                }

                if ($columnName = Arr::get($keys, 'city')) {
                    $this->integer($columnName)->unsigned()->nullable();
                }

                return true;
            });

            foreach (Location::getSupported() as $item => $keys) {
                if (! class_exists($item)) {
                    continue;
                }

                if ($foreignKey = Arr::get($keys, 'country')) {
                    /**
                     * @var DboardModel $item
                     */
                    $item::resolveRelationUsing('country', function ($model) use ($foreignKey) {
                        return $model->belongsTo(Country::class, $foreignKey)->withDefault();
                    });

                    MacroableModels::addMacro($item, 'getCountryNameAttribute', function () {
                        /**
                         * @var DboardModel $this
                         */
                        return $this->country->name;
                    });
                }

                if ($foreignKey = Arr::get($keys, 'state')) {
                    /**
                     * @var DboardModel $item
                     */
                    $item::resolveRelationUsing('state', function ($model) use ($foreignKey) {
                        return $model->belongsTo(State::class, $foreignKey)->withDefault();
                    });

                    MacroableModels::addMacro($item, 'getStateNameAttribute', function () {
                        /**
                         * @var DboardModel $this
                         */
                        return $this->state->name;
                    });
                }

                if ($foreignKey = Arr::get($keys, 'city')) {
                    /**
                     * @var DboardModel $item
                     */
                    $item::resolveRelationUsing('city', function ($model) use ($foreignKey) {
                        return $model->belongsTo(City::class, $foreignKey)->withDefault();
                    });

                    MacroableModels::addMacro($item, 'getCityNameAttribute', function () {
                        /**
                         * @var DboardModel $this
                         */
                        return $this->city->name;
                    });
                }

                MacroableModels::addMacro($item, 'getFullAddressAttribute', function () {
                    /**
                     * @var DboardModel $this
                     */
                    return ($this->address ? $this->address . ', ' : null) .
                        ($this->city_name ? $this->city_name . ', ' : null) .
                        ($this->state_name ? $this->state_name . ', ' : null) .
                        $this->country_name;
                });
            }
        });

        $this->app->register(CommandServiceProvider::class);
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(RouteServiceProvider::class);
        AliasLoader::getInstance()->alias('Location', LocationFacade::class);
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
