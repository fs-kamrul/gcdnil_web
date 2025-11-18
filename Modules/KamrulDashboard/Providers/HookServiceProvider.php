<?php

namespace Modules\KamrulDashboard\Providers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Database\Query\Builder;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Support\ServiceProvider;
//use Illuminate\Database\Eloquent\Factory;
//use Eloquent;
//use Theme;
use Modules\KamrulDashboard\Forms\Fields\PermalinkField;
use Modules\KamrulDashboard\Forms\FormAbstract;
use Modules\KamrulDashboard\Http\Models\DboardModel;
use Modules\KamrulDashboard\Packages\Supports\DashboardWidgetInstance;
use Modules\KamrulDashboard\Repositories\Interfaces\UserInterface;
use SlugHelper;
use Assets;
use Throwable;

class HookServiceProvider extends ServiceProvider
{

    /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->add_shortcode();
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function add_shortcode()
    {
//        add_filter(BASE_FILTER_SLUG_AREA, [$this, 'addSlugBox'], 17, 2);
        FormAbstract::beforeRendering([$this, 'addSlugBox'], 17);
        add_filter(BASE_FILTER_BEFORE_GET_FRONT_PAGE_ITEM, [$this, 'getItemSlug'], 3, 2);
        add_filter(DASHBOARD_FILTER_ADMIN_LIST, [$this, 'addUserStatsWidget'], 12, 2);
        add_filter(DASHBOARD_FILTER_ADMIN_LIST, [$this, 'addStatsWidgets'], 15, 2);
    }

    public function addSlugBox(FormAbstract $form): FormAbstract
    {
        $model = $form->getModel();

        if (! $model instanceof DboardModel || ! SlugHelper::isSupportedModel($model::class)) {
            return $form;
        }

        if (array_key_exists('slug', $form->getFields())) {
            return $form;
        }

        return $form
            ->addAfter(SlugHelper::getColumnNameToGenerateSlug($model), 'slug', PermalinkField::class, [
                'model' => $model,
                'colspan' => 'full',
            ]);
    }

//    public function addSlugBox(?string $html = null, ?Model $object = null): ?string
//    {
//        if ($object && SlugHelper::isSupportedModel(get_class($object))) {
//            Assets::addScriptsDirectly('vendor/Modules/KamrulDashboard/slug/slug.js')
//                ->addStylesDirectly('vendor/Modules/KamrulDashboard/slug/slug.css');
//
//            $prefix = SlugHelper::getPrefix(get_class($object));
//
//            return $html . view('kamruldashboard::partials.slug', compact('object', 'prefix'))->render();
//        }
//
//        return $html;
//    }
    /**
     * @param Builder $data
     * @param Model $model
     * @return mixed
     */
    public function getItemSlug($data, $model)
    {
        if ($data && SlugHelper::isSupportedModel(get_class($data))) {
            $table = $model->getTable();
            $select = [$table . '.*'];
            /**
             * @var Eloquent $data
             */
            $rawBindings = $data->getRawBindings();
            /**
             * @var Eloquent $rawBindings
             */
            $query = $rawBindings->getQuery();
            if ($query instanceof Builder) {
                $querySelect = $data->getQuery()->columns;
                if (!empty($querySelect)) {
                    $select = $querySelect;
                }
            }

            foreach ($select as &$column) {
                if (strpos($column, '.') === false) {
                    $column = $table . '.' . $column;
                }
            }

            $select = array_merge($select, ['slugs.key']);

            return $data
                ->leftJoin('slugs', function (JoinClause $join) use ($table) {
                    $join->on('slugs.reference_id', '=', $table . '.id');
                })
                ->select($select)
                ->where('slugs.reference_type', get_class($model));
        }

        return $data;
    }
    /**
     * @param array $widgets
     * @param Collection $widgetSettings
     * @return array
     * @throws Throwable
     */
    public function addUserStatsWidget($widgets, $widgetSettings)
    {
        $users = $this->app->make(UserInterface::class)->count();

        return (new DashboardWidgetInstance)
            ->setType('stats')
            ->setPermission('user_index')
            ->setTitle(trans('kamruldashboard::lang.users'))
            ->setKey('widget_total_users')
            ->setIcon('fa fa-users')
            ->setColor('#3598dc')
            ->setStatsTotal($users)
            ->setRoute(route('user.index'))
            ->init($widgets, $widgetSettings);
    }

    /**
     * @param array $widgets
     * @param Collection $widgetSettings
     * @return array
     * @throws Throwable
     */
    public function addStatsWidgets($widgets, $widgetSettings)
    {
        $plugins = count(scan_folder(plugin_path()));

        return (new DashboardWidgetInstance)
            ->setType('stats')
            ->setPermission('manage_plugins_index')
            ->setTitle(trans('kamruldashboard::lang.plugins'))
            ->setKey('widget_total_plugins')
            ->setIcon('fa fa-plug')
            ->setColor('#8e44ad')
            ->setStatsTotal($plugins)
            ->setRoute(route('plugins.index'))
            ->init($widgets, $widgetSettings);
    }
}
