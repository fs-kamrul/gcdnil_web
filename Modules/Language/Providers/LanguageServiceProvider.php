<?php

namespace Modules\Language\Providers;

use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Http\Request;
use Illuminate\Routing\Router;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Factory;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Modules\KamrulDashboard\Traits\LoadAndPublishDataTrait;
use Modules\Language\Http\Middleware\LocaleSessionRedirect;
use Modules\Language\Http\Middleware\LocalizationRedirectFilter;
use Modules\Language\Http\Middleware\LocalizationRoutes;
use Modules\Language\Http\Models\LanguageMeta;
use Modules\Language\Packages\Facades\LanguageFacade;
use Modules\Language\Repositories\Eloquent\LanguageMetaRepository;
use Modules\Language\Repositories\Eloquent\LanguageRepository;
use Modules\Language\Http\Models\Language as LanguageModel;
use Modules\Language\Repositories\Interfaces\LanguageInterface;
use Modules\Language\Repositories\Interfaces\LanguageMetaInterface;
use Language;
use Modules\Menus\Http\Models\Menus;
use Theme;
use Html;
use MetaBox;
use Throwable;
use Yajra\DataTables\EloquentDataTable;

class LanguageServiceProvider extends ServiceProvider
{
    use LoadAndPublishDataTrait;
    /**
     * @var string $moduleName
     */
    protected $moduleName = 'Language';

    /**
     * @var string $moduleNameLower
     */
    protected $moduleNameLower = 'language';

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
        $this->loadMigrationsFrom(module_path($this->moduleName, 'Database/Migrations'));


        if (! $this->app->runningInConsole() && is_module_active('Language')) {
//            dd(!is_in_admin());
//        if (!is_in_admin()) {
            add_filter(FILTER_GROUP_PUBLIC_ROUTE, [$this, 'addLanguageMiddlewareToPublicRoute'], 958);
//            }
        }
        $this->app->booted(function () {
            if (defined('THEME_OPTIONS_MODULE_SCREEN_NAME')) {
                Language::registerModule(THEME_OPTIONS_MODULE_SCREEN_NAME);
            }

            if (defined('WIDGET_MANAGER_MODULE_SCREEN_NAME')) {
                Language::registerModule(WIDGET_MANAGER_MODULE_SCREEN_NAME);
            }
        });
        $this->defaultLanguage();
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {

        $this->setNamespace('Modules/' . $this->moduleName);

        $this->app->bind(LanguageMetaInterface::class, function () {
            return new LanguageMetaRepository(new LanguageMeta);
        });

        AliasLoader::getInstance()->alias('Language', LanguageFacade::class);

        /**
         * @var Router $router
         */
        $router = $this->app['router'];
        $router->aliasMiddleware('localize', LocalizationRoutes::class);
        $router->aliasMiddleware('localizationRedirect', LocalizationRedirectFilter::class);
        $router->aliasMiddleware('localeSessionRedirect', LocaleSessionRedirect::class);


        $this->app->register(CommandServiceProvider::class);
        $this->app->register(EventServiceProvider::class);
        $this->app->register(RouteServiceProvider::class);
        $this->app->bind(LanguageInterface::class, function () {
            return new LanguageRepository(new LanguageModel);
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
    private function defaultLanguage()
    {
        $defaultLanguage = Language::getDefaultLanguage(['lang_id']);
        if (!empty($defaultLanguage)) {
            add_action(BASE_ACTION_META_BOXES, [$this, 'addLanguageBox'], 50, 2);
            add_filter(FILTER_SLUG_PREFIX, [$this, 'setSlugPrefix'], 500);
            add_action(BASE_ACTION_TOP_FORM_CONTENT_NOTIFICATION, [$this, 'addCurrentLanguageEditingAlert'], 55, 2);
            add_action(BASE_ACTION_BEFORE_EDIT_CONTENT, [$this, 'getCurrentAdminLanguage'], 55, 2);
            if (defined('THEME_OPTIONS_MODULE_SCREEN_NAME')) {
                if (!$this->app->isDownForMaintenance()) {
                    $this->app->booted(function () {
                        Theme::asset()
                            ->usePath(false)
                            ->add('language-css', asset('vendor/kamruldashboard/language/css/language-public.css'), [],
                                [], '1.0.0');

                        Theme::asset()
                            ->container('footer')
                            ->usePath(false)
                            ->add('language-public-js', asset('vendor/kamruldashboard/language/js/language-public.js'),
                                ['jquery'], [], '1.0.0');
                    });
                }
            }

            add_filter(BASE_FILTER_GET_LIST_DATA, [$this, 'addLanguageColumn'], 50, 2);
            add_filter(BASE_FILTER_TABLE_HEADINGS, [$this, 'addLanguageTableHeading'], 50, 2);
            add_filter(LANGUAGE_FILTER_SWITCHER, [$this, 'languageSwitcher']);
            add_filter(BASE_FILTER_BEFORE_GET_FRONT_PAGE_ITEM, [$this, 'checkItemLanguageBeforeShow'], 50, 2);
            if (setting('language_show_default_item_if_current_version_not_existed', true) && !is_in_admin()) {
                add_filter(BASE_FILTER_BEFORE_GET_SINGLE, [$this, 'getRelatedDataForOtherLanguage'], 50, 2);
            }

            add_filter(BASE_FILTER_TABLE_BUTTONS, [$this, 'addLanguageSwitcherToTable'], 247, 2);
            add_filter(BASE_FILTER_TABLE_QUERY, [$this, 'getDataByCurrentLanguage'], 157);
            add_filter(BASE_FILTER_BEFORE_GET_ADMIN_LIST_ITEM, [$this, 'checkItemLanguageBeforeGetAdminListItem'], 50);

            if (defined('THEME_OPTIONS_ACTION_META_BOXES')) {
                add_filter(THEME_OPTIONS_ACTION_META_BOXES, [$this, 'addLanguageMetaBoxForThemeOptionsAndWidgets'],
                    55, 2);
            }

            if (defined('WIDGET_TOP_META_BOXES')) {
                add_filter(WIDGET_TOP_META_BOXES, [$this, 'addLanguageMetaBoxForThemeOptionsAndWidgets'], 55, 2);
            }

            add_filter(BASE_FILTER_SITE_LANGUAGE_DIRECTION, function ($direction) {
                if (Language::getCurrentLocaleRTL()) {
                    return 'rtl';
                }

                return $direction;
            }, 1);

            add_filter(MENU_FILTER_NODE_URL, function ($value) {
                if (is_in_admin()) {
                    return $value;
                }

                return filter_var($value, FILTER_VALIDATE_URL) ? $value : Language::localizeURL($value);
            }, 1);

            add_filter(BASE_FILTER_BEFORE_RENDER_FORM, function ($form, $data) {
                if (is_in_admin() && Language::getCurrentAdminLocaleCode() != Language::getDefaultLocaleCode() && in_array(get_class($data), Language::supportedModels()) && $form) {

                    $refLang = request()->input('ref_lang');
                    $refFrom = request()->input('ref_from');

                    if ($refLang && $refFrom) {
                        $data = $data->getModel()->find($refFrom);

                        if ($data) {
                            $form->setModel($data->replicate());
                        }
                    }
                }

                return $form;
            }, 1134, 2);
        }
    }

    /**
     * @param string $priority
     * @param string|Model $object
     */
    public function addLanguageBox($priority, $object)
    {
        if (!empty($object) && in_array(get_class($object), Language::supportedModels())) {
            MetaBox::addMetaBox('language_wrap', trans('language::lang.name'), [$this, 'languageMetaField'],
                get_class($object), 'top');
        }
    }

    /**
     * @throws Throwable
     */
    public function languageMetaField()
    {
        $languages = Language::getActiveLanguage([
            'lang_code',
            'lang_flag',
            'lang_name',
        ]);

        if ($languages->isEmpty()) {
            return null;
        }

        $related = [];
        $value = null;
        $args = func_get_args();

        $meta = null;

        $request = $this->app->make('request');

        if ($args[0] && $args[0]->id) {
            $meta = $this->app->make(LanguageMetaInterface::class)->getFirstBy(
                [
                    'reference_id'   => $args[0]->id,
                    'reference_type' => get_class($args[0]),
                ],
                [
                    'lang_meta_code',
                    'reference_id',
                    'lang_meta_origin',
                ]
            );

            if (!empty($meta)) {
                $value = $meta->lang_meta_code;
            }
        } elseif ($request->input('ref_from')) {
            $meta = $this->app->make(LanguageMetaInterface::class)->getFirstBy(
                [
                    'reference_id'   => $request->input('ref_from'),
                    'reference_type' => get_class($args[0]),
                ],
                [
                    'lang_meta_code',
                    'reference_id',
                    'lang_meta_origin',
                ]
            );
            $value = $request->input('ref_lang');
        }

        if ($meta) {
            $related = Language::getRelatedLanguageItem($meta->reference_id, $meta->lang_meta_origin);
        }

        $currentLanguage = self::checkCurrentLanguage($languages, $value);

        if (!$currentLanguage) {
            $currentLanguage = Language::getDefaultLanguage([
                'lang_flag',
                'lang_name',
                'lang_code',
            ]);
        }

        $route = $this->getRoutes();

        return view('language::language-box',
            compact('args', 'languages', 'currentLanguage', 'related', 'route'))->render();
    }

    /**
     * @param string $value
     * @param array $languages
     * @return mixed
     * @throws BindingResolutionException
     */
    public function checkCurrentLanguage($languages, $value)
    {
        $request = $this->app->make('request');
        $currentLanguage = null;
        foreach ($languages as $language) {
            if ($value) {
                if ($language->lang_code == $value) {
                    $currentLanguage = $language;
                }
            } elseif ($request->input('ref_lang')) {
                if ($language->lang_code == $request->input('ref_lang')) {
                    $currentLanguage = $language;
                }
            } elseif ($language->lang_is_default) {
                $currentLanguage = $language;
            }
        }

        if (empty($currentLanguage)) {
            foreach ($languages as $language) {
                if ($language->lang_is_default) {
                    $currentLanguage = $language;
                }
            }
        }

        return $currentLanguage;
    }

    /**
     * @return array
     */
    protected function getRoutes(): array
    {
        $currentRoute = implode('.', explode('.', Route::currentRouteName(), -1));

        return apply_filters(LANGUAGE_FILTER_ROUTE_ACTION, [
            'create' => $currentRoute . '.create',
            'edit'   => $currentRoute . '.edit',
        ]);
    }

    /**
     * @param string $slug
     * @return string
     */
    public function setSlugPrefix(string $prefix)
    {
        if (is_in_admin()) {
            $currentLocale = Language::getCurrentAdminLocale();
        } else {
            $currentLocale = Language::getCurrentLocale();
        }

        if ($currentLocale && (!setting('language_hide_default') || $currentLocale != Language::getDefaultLocale())) {
            if (!$prefix) {
                return $currentLocale;
            }

            return $currentLocale . '/' . $prefix;
        }

        return $prefix;
    }
    /**
     * @param string $screen
     * @param Request $request
     * @param string|Model $data
     * @return void
     * @throws Throwable
     * @since 2.1
     */
    public function addCurrentLanguageEditingAlert($request, $data = null)
    {
        $model = $data;
        if (is_object($data)) {
            $model = get_class($data);
        }

        if ($data && in_array($model, Language::supportedModels())) {
            $code = Language::getCurrentAdminLocaleCode();
            if (empty($code)) {
                $code = $this->getCurrentAdminLanguage($request, $data);
            }

            $language = null;
            if (!empty($code)) {
                Language::setCurrentAdminLocale($code);
                $language = $this->app->make(LanguageInterface::class)->getFirstBy(['lang_code' => $code],
                    ['lang_name']);
                if (!empty($language)) {
                    $language = $language->lang_name;
                }
            }

            echo view('language::partials.notification', compact('language'))->render();
        }

        echo null;
    }
    /**
     * @param string $screen
     * @param Request $request
     * @param Model | null $data
     * @return null|string
     * @throws BindingResolutionException
     */
    public function getCurrentAdminLanguage($request, $data = null)
    {
        $code = null;
        if ($request->has('ref_lang')) {
            $code = $request->input('ref_lang');
        } elseif (!empty($data) && $data->id) {
            $meta = $this->app->make(LanguageMetaInterface::class)->getFirstBy([
                'reference_id'   => $data->id,
                'reference_type' => get_class($data),
            ], ['lang_meta_code']);
            if (!empty($meta)) {
                $code = $meta->lang_meta_code;
            }
        }

        if (empty($code)) {
            $code = Language::getDefaultLocaleCode();
        }

        Language::setCurrentAdminLocale($code);

        return $code;
    }
    /**
     * @param EloquentDataTable $data
     * @param string|Model $model
     * @return EloquentDataTable
     */
    public function addLanguageColumn($data, $model)
    {
        if ($model && in_array(get_class($model), Language::supportedModels())) {
            $route = $this->getRoutes();

            $array_route = get_array_replace('.','_',$route);
            if (is_in_admin() && Auth::check() && !auth()->user()->can($array_route)) {
                return $data;
            }

            return $data->addColumn('language', function ($item) use ($model, $route) {
                $relatedLanguages = [];

                if (Language::getCurrentAdminLocaleCode() === 'all') {
                    $currentLanguage = $this->app->make(LanguageMetaInterface::class)->getFirstBy([
                        'reference_id'   => $item->id,
                        'reference_type' => get_class($item),
                    ]);

                    if ($currentLanguage) {
                        $relatedLanguages = Language::getRelatedLanguageItem($currentLanguage->reference_id,
                            $currentLanguage->lang_meta_origin);
                        $currentLanguage = $currentLanguage->lang_meta_code;
                    }
                } else {
                    if ($item->lang_meta_origin) {
                        $relatedLanguages = Language::getRelatedLanguageItem($item->id, $item->lang_meta_origin);
                    }
                    $currentLanguage = $item->lang_meta_code;
                }

                $languages = Language::getActiveLanguage();
                $data = '';

                foreach ($languages as $language) {
                    if ($language->lang_code == $currentLanguage) {
                        $data .= view('language::partials.status.active', compact('route', 'item'))->render();
                    } else {
                        $added = false;
                        if (!empty($relatedLanguages)) {
                            foreach ($relatedLanguages as $key => $relatedLanguage) {
                                if ($key == $language->lang_code) {
                                    $data .= view('language::partials.status.edit',
                                        compact('route', 'relatedLanguage'))->render();
                                    $added = true;
                                }
                            }
                        }
                        if (!$added) {
                            $data .= view('language::partials.status.plus',
                                compact('route', 'item', 'language'))->render();
                        }
                    }
                }

                return view('language::partials.language-column', compact('data'))->render();
            });
        }

        return $data;
    }
    /**
     * @param string $screen
     * @param string $data
     * @return string
     * @throws Throwable
     */
    public function addLanguageMetaBoxForThemeOptionsAndWidgets($data, $screen)
    {
        $route = null;
        switch ($screen) {
            case THEME_OPTIONS_MODULE_SCREEN_NAME:
                $route = 'theme.options';
                break;
            case WIDGET_MANAGER_MODULE_SCREEN_NAME:
                $route = 'widgets.index';
                break;
        }

        if (empty($route)) {
            return $data;
        }

        return $data . view('language::partials.admin-list-language-chooser', compact('route'))->render();
    }
    /**
     * @param array $headings
     * @param string|Model $model
     * @return array
     */
    public function addLanguageTableHeading($headings, $model)
    {
        if (in_array(get_class($model), Language::supportedModels())) {

            $array_route = get_array_replace('.','_',$this->getRoutes());

            if (is_in_admin() && Auth::check() && !auth()->user()->can($array_route)) {
                return $headings;
            }

            $languages = Language::getActiveLanguage(['lang_code', 'lang_name', 'lang_flag']);
            $heading = '';
            foreach ($languages as $language) {
                $heading .= language_flag($language->lang_flag, $language->lang_name);
            }

            return array_merge($headings, [
                'language' => [
                    'name'       => 'language_meta.lang_meta_id',
                    'title'      => $heading,
                    'class'      => 'text-center language-header no-sort',
                    'width'      => (count($languages) * 40) . 'px',
                    'orderable'  => false,
                    'searchable' => false,
                ],
            ]);
        }

        return $headings;
    }
    /**
     * @param array $options
     * @return string
     *
     * @throws Throwable
     */
    public function languageSwitcher($options = [])
    {
        return view('language::partials.switcher', compact('options'))->render();
    }
    /**
     * @param Builder|EloquentBuilder $data
     * @param Model $model
     * @return mixed
     */
    public function checkItemLanguageBeforeShow($data)
    {
        return $this->getDataByCurrentLanguageCode($data, Language::getCurrentLocaleCode());
    }
    /**
     * @param Builder $data
     * @param Model $model
     * @param string $languageCode
     * @return mixed
     */
    protected function getDataByCurrentLanguageCode($data, $languageCode)
    {
        $model = $data->getModel();

        if (in_array(get_class($model), Language::supportedModels()) &&
            !empty($languageCode) &&
            !$model instanceof LanguageModel &&
            !$model instanceof LanguageMeta
        ) {
            if (Language::getCurrentAdminLocaleCode() !== 'all') {

                if ($model instanceof EloquentBuilder) {
                    $model = $model->getModel();
                }

                $table = $model->getTable();

                $joins = $data->getQuery()->joins;
                if ($joins && is_array($joins)) {
                    foreach ($joins as $join) {
                        if ($join->table == 'language_meta') {
                            return $data;
                        }
                    }
                }

                $data = $data
                    ->join('language_meta', 'language_meta.reference_id', $table . '.id')
                    ->where('language_meta.reference_type', get_class($model))
                    ->where('language_meta.lang_meta_code', $languageCode);
            }

            return $data;
        }

        return $data;
    }
    /**
     * @param Builder $query
     * @param EloquentBuilder $model
     * @return Builder|string
     * @throws BindingResolutionException
     */
    public function getRelatedDataForOtherLanguage($query, $model)
    {
        if ($query instanceof Builder || $query instanceof EloquentBuilder) {
            $model = $query->getModel();
        }

        if (in_array(get_class($model), Language::supportedModels()) &&
            !$model instanceof LanguageModel &&
            !$model instanceof LanguageMeta
        ) {
            $data = $query->first();

            if (!empty($data)) {
                $current = $this->app->make(LanguageMetaInterface::class)->getFirstBy([
                    'reference_type' => get_class($model),
                    'reference_id'   => $data->id,
                ]);

                if ($current) {
                    Language::setCurrentAdminLocale($current->lang_meta_code);
                    if ($current->lang_meta_code != Language::getCurrentLocaleCode()) {
                        if (setting('language_show_default_item_if_current_version_not_existed',
                                true) == false && get_class($model) != Menus::class) {
                            return $data;
                        }
                        $meta = $this->app->make(LanguageMetaInterface::class)->getModel()
                            ->where('lang_meta_origin', $current->lang_meta_origin)
                            ->where('reference_id', '!=', $data->id)
                            ->where('reference_type', get_class($model))
                            ->where('lang_meta_code', Language::getCurrentLocaleCode())
                            ->first();
                        if ($meta) {
                            $result = $model->where('id', $meta->reference_id);
                            if ($result) {
                                return $result;
                            }
                        }
                    }
                }
            }
        }

        return $query;
    }
    /**
     * @param array $buttons
     * @param string $model
     * @return array
     * @since 2.2
     */
    public function addLanguageSwitcherToTable($buttons, $model)
    {
        if (in_array($model, Language::supportedModels())) {
            $activeLanguages = Language::getActiveLanguage(['lang_code', 'lang_name', 'lang_flag']);
            $languageButtons = [];
            $currentLanguage = Language::getCurrentAdminLocaleCode();

            foreach ($activeLanguages as $item) {
                $languageButtons[] = [
                    'className' => 'change-data-language-item ' . ($item->lang_code == $currentLanguage ? 'active' : ''),
                    'text'      => Html::tag('span', $item->lang_name,
                        ['data-href' => route('languages.change.data.language', $item->lang_code)])->toHtml(),
                ];
            }

            $languageButtons[] = [
                'className' => 'change-data-language-item ' . ('all' == $currentLanguage ? 'active' : ''),
                'text'      => Html::tag('span', trans('language::lang.show_all'),
                    ['data-href' => route('languages.change.data.language', 'all')])->toHtml(),
            ];

            $flag = $activeLanguages->where('lang_code', $currentLanguage)->first();
            if (!empty($flag)) {
                $flag = language_flag($flag->lang_flag, $flag->lang_name);
            } else {
                $flag = Html::tag('i', '', ['class' => 'fa fa-flag'])->toHtml();
            }

            $language = [
                'language' => [
                    'extend'  => 'collection',
                    'text'    => $flag . Html::tag('span',
                            ' ' . trans('language::lang.change_language') . ' ' . Html::tag('span', '',
                                ['class' => 'caret'])->toHtml())->toHtml(),
                    'buttons' => $languageButtons,
                ],
            ];

            $buttons = array_merge($buttons, $language);
        }

        return $buttons;
    }
    /**
     * @param Builder $query
     * @param Model $model
     * @param array $selectedColumns
     * @return mixed
     * @since 2.2
     */
    public function getDataByCurrentLanguage($query)
    {
        $model = $query->getModel();

        if (in_array(get_class($model), Language::supportedModels()) && Language::getCurrentAdminLocaleCode()) {

            if (Language::getCurrentAdminLocaleCode() !== 'all') {

                $joins = $query->getQuery()->joins;
                if ($joins && is_array($joins)) {
                    foreach ($joins as $join) {
                        if ($join->table == 'language_meta') {
                            return $query;
                        }
                    }
                }

                $query = $query
                    ->addSelect([
                        'language_meta.lang_meta_code',
                        'language_meta.lang_meta_origin',
                    ])
                    ->join('language_meta', 'language_meta.reference_id', $model->getTable() . '.id')
                    ->where('language_meta.reference_type', get_class($model))
                    ->where('language_meta.lang_meta_code', Language::getCurrentAdminLocaleCode());
            }
        }

        return $query;
    }
    /**
     * @param Builder|EloquentBuilder $data
     * @param Model $model
     * @return mixed
     */
    public function checkItemLanguageBeforeGetAdminListItem($data)
    {
        return $this->getDataByCurrentLanguageCode($data, Language::getCurrentAdminLocaleCode());
    }

    /**
     * @param array $data
     * @return array
     */
    public function addLanguageMiddlewareToPublicRoute(array $data): array
    {
        $locale = Language::setLocale();

        if (! isset($data['prefix'])) {
            $data['prefix'] = trim((string)$locale);
        }

        $data['middleware'] = array_merge(Arr::get($data, 'middleware', []), [
            'localeSessionRedirect',
            'localizationRedirect',
        ]);

        $data['middleware'] = array_unique($data['middleware']);

//        dd($data);
        return $data;
    }
//    public function addLanguageMiddlewareToPublicRoute($data)
//    {
//        return array_merge_recursive($data, [
//            'prefix'     => Language::setLocale(),
//            'middleware' => [
//                'localeSessionRedirect',
//                'localizationRedirect',
//            ],
//        ]);
//    }
}
