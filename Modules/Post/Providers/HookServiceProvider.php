<?php

namespace Modules\Post\Providers;

use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Factory;
use Illuminate\Support\Str;
use Modules\KamrulDashboard\Http\Models\DboardModel;
use Modules\KamrulDashboard\Packages\Supports\DashboardWidgetInstance;
use Modules\Post\Http\Models\Category;
use Modules\Post\Http\Models\Page;
use Modules\Post\Repositories\Interfaces\CategoryInterface;
use Modules\Post\Repositories\Interfaces\PageInterface;
use Modules\Post\Services\PageService;
use Eloquent;
use Theme;
use Menus;
use Html;
use Throwable;
use Modules\KamrulDashboard\Packages\Supports\DboardStatus;

class HookServiceProvider extends ServiceProvider
{

    /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot()
    {
        if (defined('MENU_ACTION_SIDEBAR_OPTIONS')) {
            Menus::addMenuOptionModel(Page::class);
            Menus::addMenuOptionModel(Category::class);
            add_action(MENU_ACTION_SIDEBAR_OPTIONS, [$this, 'registerMenuOptions'], 10);
        }
        $this->add_shortcode();

        if (function_exists('theme_option')) {
            add_action(RENDERING_THEME_OPTIONS_PAGE, [$this, 'addThemeOptions'], 31);
            add_filter(DASHBOARD_FILTER_ADMIN_LIST, [$this, 'addPageStatsWidget'], 15, 2);
        }
        if (defined('LANGUAGE_MODULE_SCREEN_NAME')) {
            add_action(BASE_ACTION_META_BOXES, [$this, 'addLanguageChooser'], 55, 2);
        }
    }

    /**
     * Register sidebar options in menu
     * @throws Throwable
     */
    public function registerMenuOptions()
    {
        if (Auth::user()->can('page_access')) {
            Menus::registerMenuOptions(Page::class, trans('post::lang.pages'));
        }
        if (Auth::user()->can('category_access')) {
            Menus::registerMenuOptions(Category::class, trans('post::lang.category'));
        }
    }
    public function addThemeOptions()
    {
//        $pages = Page::get()
//            ->pluck('name', 'id', ['status' => 1])->toarray();
        $pages = $this->app->make(PageInterface::class)
            ->pluck('pages.name', 'id', ['status' => DboardStatus::PUBLISHED]);
        theme_option()
            ->setSection([
                'title'      => 'Page',
                'desc'       => 'Theme options for Page',
                'id'         => 'opt-text-subsection-page',
                'subsection' => true,
                'icon'       => 'fa fa-book',
                'fields'     => [
                    [
                        'id'         => 'homepage_id',
                        'type'       => 'select',
                        'label'      => trans('post::lang.show_on_front'),
                        'attributes' => [
                            'name'    => 'homepage_id',
                            'list'    => ['' => trans('post::lang.select')] + $pages,
                            'value'   => '',
                            'options' => [
                                'class' => 'form-control',
                            ],
                        ],
                    ],
                    [
                        'id'         => 'number_of_posts',
                        'type'       => 'number',
                        'label'      => trans('post::lang.number_posts_per_page'),
                        'attributes' => [
                            'name'    => 'number_of_post',
                            'value'   => 10,
                            'options' => [
                                'class' => 'form-control',
                            ],
                        ],
                    ],
                ],
            ])->setSection([
                'title'      => 'Site',
                'desc'       => 'Theme options for Site',
                'id'         => 'opt-text-subsection-blog',
                'subsection' => true,
                'icon'       => 'fa fa-edit',
                'fields'     => [
                    [
                        'id'         => 'site_page_id',
                        'type'       => 'select',
                        'label'      => trans('post::lang.site_page_id'),
                        'attributes' => [
                            'name'    => 'site_page_id',
                            'list'    => ['' => trans('post::lang.select')] + $pages,
                            'value'   => '',
                            'options' => [
                                'class' => 'form-control',
                            ],
                        ],
                    ],
                ],
            ]);
    }
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function add_shortcode()
    {
        if (defined('PAGE_MODULE_SCREEN_NAME')) {
            add_filter(PAGE_FILTER_FRONT_PAGE_CONTENT, [$this, 'renderPostPage'], 2, 2);
            add_filter(PAGE_FILTER_PAGE_NAME_IN_ADMIN_LIST, [$this, 'addAdditionNameToPageName'], 147, 2);
        }
        add_filter(BASE_FILTER_PUBLIC_SINGLE_DATA, [$this, 'handleSingleView'], 1);
        if (function_exists('add_shortcode')) {
//            add_shortcode('contact-form', trans('contactform::lang.shortcode_name'), trans('contactform::lang.shortcode_description'), [$this, 'form']);
//            shortcode()->setAdminConfig('contact-form', view('contactform::partials.short-code-admin-config')->render());

            add_shortcode('posts', trans('post::lang.short_code_name'),
                trans('post::lang.short_code_description'), [$this, 'renderPosts']);
            shortcode()->setAdminConfig('posts', function ($attributes, $content) {
                return view('post::partials.posts-short-code-admin-config', compact('attributes', 'content'))
                    ->render();
            });
            add_shortcode('categories-with-posts', __('post::lang.categories_with_post'), __('post::lang.categories_with_post'),
                function ($shortcode) {

                    $attributes = $shortcode->toArray();

                    $categories = collect([]);

                    for ($i = 1; $i <= 3; $i++) {
                        if (!Arr::has($attributes, 'category_id_' . $i)) {
                            continue;
                        }

                        $category = app(CategoryInterface::class)->advancedGet([
                            'condition' => ['categories.id' => Arr::get($attributes, 'category_id_' . $i)],
                            'take'      => 1,
                            'with'      => [
////                                'slug',
                                'post' => function ($query) {
                                    return $query
                                        ->latest()
//                                        ->with(['slugable'])
                                        ->where('status', DboardStatus::PUBLISHED)
                                        ->limit(6);
                                },
                            ],
                        ]);
                        if ($category) {
                            $categories[] = $category;
                        }
                    }

                    return Theme::partial('short-codes.categories-with-posts', compact('categories'));
                });

            shortcode()->setAdminConfig('categories-with-posts', function ($attributes) {
                $categories = Category::where('status', 1)->get();

                return view('post::partials.categories-with-posts-admin-config', compact('categories', 'attributes')) ->render();;
//                return Theme::partial('short-codes.categories-with-posts-admin-config', compact('categories', 'attributes'));
            });
        }

    }

    /**
     * @param string|null $content
     * @param Page $page
     * @return array|string|null
     */
    public function renderPostPage(?string $content, Page $page)
    {

        if ($page->id == theme_option('site_page_id', setting('site_page_id'))) {
            $view = 'post::themes.loop';

            if (view()->exists(Theme::getThemeNamespace() . '::views.loop')) {
                $view = Theme::getThemeNamespace() . '::views.loop';
            }
            return view($view, [
                'posts' => get_all_posts(
                    true,
                    theme_option('number_of_posts', 10),
                    ['categories', 'user']
                ),
            ])
                ->render();
        }

        return $content;
    }
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        //
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
    /**
     * @param stdClass $shortcode
     * @return array|string
     */
    public function renderPosts($shortcode)
    {
        $posts = get_all_posts(true, $shortcode->paginate);

        $view = 'post::themes.templates.posts';
        $themeView = Theme::getThemeNamespace() . '::views.templates.posts';
        if (view()->exists($themeView)) {
            $view = $themeView;
        }

        return view($view, compact('posts'))->render();
    }

    /**
     * @param array $widgets
     * @param Collection $widgetSettings
     * @return array
     *
     * @throws BindingResolutionException
     * @throws Throwable
     */
    public function addPageStatsWidget($widgets, $widgetSettings)
    {
        $pages = $this->app->make(PageInterface::class)->count(['status' => dboardStatus::PUBLISHED]);

        return (new DashboardWidgetInstance)
            ->setType('stats')
            ->setPermission('page_index')
            ->setTitle(trans('post::lang.pages'))
            ->setKey('widget_total_pages')
            ->setIcon('fa fa-file')
            ->setColor('#32c5d2')
            ->setStatsTotal($pages)
            ->setRoute(route('page.index'))
            ->init($widgets, $widgetSettings);
    }
    /**
     * @param Model $slug
     * @return array|Model
     *
     * @throws BindingResolutionException
     */
    public function handleSingleView($slug)
    {
        return (new PageService)->handleFrontRoutes($slug);
    }

    /**
     * @param string|null $name
     * @param Page $page
     * @return string|null
     */
    public function addAdditionNameToPageName(?string $name, Page $page)
    {
        if ($page->id == theme_option('site_page_id', setting('site_page_id'))) {
            $subTitle = Html::tag('span', trans('post::lang.site_page'), ['class' => 'additional-page-name'])
                ->toHtml();

            if (Str::contains($name, ' —')) {
                return $name . ', ' . $subTitle;
            }

            return $name . ' —' . $subTitle;
        }

        return $name;
    }
    /**
     * @param DboardModel $model
     * @param string $priority
     * @return string
     */
    public function addLanguageChooser($priority, $model)
    {
        if ($priority == 'head' && $model instanceof Category) {

            $route = 'categories.index';

            if ($route) {
                echo view('language::partials.admin-list-language-chooser', compact('route'))->render();
            }
        }
    }
}
