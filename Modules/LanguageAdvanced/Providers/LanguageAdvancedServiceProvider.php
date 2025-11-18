<?php

namespace Modules\LanguageAdvanced\Providers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Factory;
use Illuminate\Support\Str;
use Modules\KamrulDashboard\Http\Models\DboardModel;
use Modules\KamrulDashboard\Traits\LoadAndPublishDataTrait;
use Modules\Language\Http\Models\Language as LanguageModel;
use Modules\LanguageAdvanced\Http\Models\TranslationResolver;
use Modules\LanguageAdvanced\Packages\Supports\LanguageAdvancedManager;
use Language;
use MacroableModels;
use Modules\Post\Http\Models\Category;
use Modules\Post\Http\Models\Page;
use Modules\Post\Http\Models\Post;

class LanguageAdvancedServiceProvider extends ServiceProvider
{
    use LoadAndPublishDataTrait;
    /**
     * @var string $moduleName
     */
    protected $moduleName = 'LanguageAdvanced';

    /**
     * @var string $moduleNameLower
     */
    protected $moduleNameLower = 'languageadvanced';

    /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot()
    {
        if (is_module_active('Language')) {

            $this->setNamespace('Modules/' . $this->moduleName)
                ->loadHelpers()
                ->loadAndPublishTranslations();

            $this->registerTranslations();
            $this->registerConfig();
            $this->registerViews();
            $this->loadMigrationsFrom(module_path($this->moduleName, 'Database/Migrations'));

            $this->app->register(RouteServiceProvider::class);
            $this->app->register(EventServiceProvider::class);


            $this->app->booted(function () {
//                dd(LanguageAdvancedManager::getSupported());
                foreach (LanguageAdvancedManager::getSupported() as $item => $columns) {
                    if (!class_exists($item)) {
                        continue;
                    }

                    /**
                     * @var DboardModel $item
                     */
                    $item::resolveRelationUsing('translations', function ($model) {
//                        dd($model->hasMany(LanguageAdvancedManager::getTranslationModel($model),
//                            $model->getTable() . '_id'));
//                        return $model->hasMany(LanguageAdvancedManager::getTranslationModel($model),
//                            $model->getTable() . '_id');
                        $instance = tap(
                            new TranslationResolver(),
                            function ($instance) {
                                if (! $instance->getConnectionName()) {
                                    $instance->setConnection(DB::getDefaultConnection());
                                }
                            }
                        );

                        $instance->setTable($model->getTable() . '_translations');

                        $instance->fillable(array_merge([
                            'lang_code',
                            $model->getTable() . '_id',
                        ], LanguageAdvancedManager::getTranslatableColumns(get_class($model))));

                        return new HasMany(
                            $instance->newQuery(),
                            $model,
                            $model->getTable() . '_translations.' . $model->getTable() . '_id',
                            $model->getKeyName()
                        );
                    });

                    foreach ($columns as $column) {
                        MacroableModels::addMacro($item, 'get' . Str::title($column) . 'Attribute',
                            function () use ($column) {
                                /**
                                 * @var DboardModel $this
                                 */

                                $locale = Language::getCurrentLocaleCode();
                                if (!$this->lang_code && $locale != Language::getDefaultLocaleCode()) {
                                    $translation = $this->translations->where('lang_code', $locale)->first();

                                    if ($translation) {
                                        return $translation->{$column};
                                    }
                                }

                                return $this->getAttribute($column);
                            });
                    }
                }

            });
            $config = $this->app['config'];

            if ($config->get('languageadvanced.page_use_language_v2', false)) {
                LanguageAdvancedManager::registerModule(Page::class, [
                    'name',
                    'description',
                    'short_description',
                ]);

                $supportedModels = Language::supportedModels();

                if (($key = array_search(Page::class, $supportedModels)) !== false) {
                    unset($supportedModels[$key]);
                }

                $config->set(['language.supported' => $supportedModels]);
            }
            if ($config->get('languageadvanced.post_use_language_v2', false)) {
                LanguageAdvancedManager::registerModule(Post::class, [
                    'name',
                    'description',
                    'short_description',
                ]);

                $supportedModels = Language::supportedModels();

                if (($key = array_search(Post::class, $supportedModels)) !== false) {
                    unset($supportedModels[$key]);
                }

                $config->set(['language.supported' => $supportedModels]);
            }
            if ($config->get('languageadvanced.category_use_language_v2', false)) {
                LanguageAdvancedManager::registerModule(Category::class, [
                    'name',
                    'description',
                    'short_description',
                ]);

                $supportedModels = Language::supportedModels();

                if (($key = array_search(Category::class, $supportedModels)) !== false) {
                    unset($supportedModels[$key]);
                }

                $config->set(['language.supported' => $supportedModels]);
            }

            Event::listen('eloquent.deleted: ' . LanguageModel::class, function (LanguageModel $language) {
                foreach (LanguageAdvancedManager::getSupported() as $model => $columns) {
                    if (class_exists($model)) {
                        DB::table((new $model())->getTable() . '_translations')
                            ->where('lang_code', $language->lang_code)
                            ->delete();
                    }
                }
            });

            foreach (LanguageAdvancedManager::getSupported() as $model => $columns) {
                Event::listen('eloquent.deleted: ' . $model, function (Model $model) {
                    DB::table($model->getTable() . '_translations')
                        ->where($model->getTable() . '_id', $model->getKey())
                        ->delete();
                });
            }
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
