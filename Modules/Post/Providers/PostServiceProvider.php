<?php

namespace Modules\Post\Providers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Factory;
use Modules\KamrulDashboard\Traits\LoadAndPublishDataTrait;
use Modules\Post\Http\Models\Category;
use Modules\Post\Http\Models\Page;
use Modules\Post\Http\Models\PageTemplate;
use Modules\Post\Http\Models\Post;
use Modules\Post\Http\Models\PostType;
use Modules\Post\Repositories\Eloquent\CategoryRepository;
use Modules\Post\Repositories\Eloquent\PageRepository;
use Modules\Post\Repositories\Eloquent\PageTemplateRepository;
use Modules\Post\Repositories\Eloquent\PostRepository;
use Modules\Post\Repositories\Eloquent\PosttypeRepository;
use Modules\Post\Repositories\Interfaces\CategoryInterface;
use Modules\Post\Repositories\Interfaces\PageInterface;
use Modules\Post\Repositories\Interfaces\PageTemplateInterface;
use Modules\Post\Repositories\Interfaces\PostInterface;
use Modules\Post\Repositories\Interfaces\PosttypeInterface;
use Modules\Post\Services\PostService;
use SeoHelper;
use SlugHelper;

class PostServiceProvider extends ServiceProvider
{
    use LoadAndPublishDataTrait;
    /**
     * @var string $moduleName
     */
    protected $moduleName = 'Post';

    /**
     * @var string $moduleNameLower
     */
    protected $moduleNameLower = 'post';

    /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot()
    {
        SlugHelper::registerModule(Post::class, 'Site Posts');
        SlugHelper::registerModule(Page::class, 'Site Pages');
        SlugHelper::registerModule(Category::class, 'Site Categories');

        SlugHelper::setPrefix(Post::class, null, true);
        SlugHelper::setPrefix(Page::class, null, true);
        SlugHelper::setPrefix(Category::class, null, true);

        $this->app->booted(function () {
            SeoHelper::registerModule([
                Post::class,
//                Page::class,
            ]);
        });
        $this->setNamespace('Modules/' . $this->moduleName)
            ->loadAndPublishTranslations()
            ->loadHelpers();

        $this->app->bind(PageInterface::class, function () {
            return new  PageRepository(new Page);
        });

        $this->app->bind(PostInterface::class, function () {
            return new PostRepository(new Post);
        });

        $this->app->bind(CategoryInterface::class, function () {
            return new CategoryRepository(new Category);
        });
        $this->app->bind(PageTemplateInterface::class, function () {
            return new PageTemplateRepository(new PageTemplate);
        });
        $this->app->bind(PosttypeInterface::class, function () {
            return new PosttypeRepository(new PostType);
        });
        $this->registerTranslations();
        $this->registerConfig();
        $this->registerViews();
        $this->loadMigrationsFrom(module_path($this->moduleName, 'Database/Migrations'));

        add_filter(BASE_FILTER_PUBLIC_SINGLE_DATA, [$this, 'handleSingleView'], 2);
//        add_shortcode('kamrul_i','kam', 'Add blog posts',[$this, 'form']);
//        shortcode()->setAdminConfig('kamrul_i', '[kamrul][/kamrul]' );
//        add_shortcode('kamrul_2','kam 2', 'Add blog posts2');
//        shortcode()->setAdminConfig('kamrul_2', '<p>sfgd</p>' );
    }

    /**
     * @param Model $slug
     * @return array|Model
     */
    public function handleSingleView($slug)
    {
        return (new PostService)->handleFrontRoutes($slug);
    }
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(RouteServiceProvider::class);
        $this->app->register(EventServiceProvider::class);
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
