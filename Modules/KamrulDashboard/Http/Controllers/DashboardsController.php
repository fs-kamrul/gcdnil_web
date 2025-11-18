<?php

namespace Modules\KamrulDashboard\Http\Controllers;

use Assets;
use App\Http\Requests\StoreDashboardsRequest;
use App\Http\Requests\UpdateDashboardsRequest;
use Illuminate\Contracts\View\Factory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\View\View;
use Modules\KamrulDashboard\Http\Models\Dashboards;
use Modules\KamrulDashboard\Repositories\Interfaces\DashboardWidgetInterface;
use Modules\KamrulDashboard\Repositories\Interfaces\DashboardWidgetSettingInterface;
use function view;

class DashboardsController extends DboardController
{
    /**
     * @var DashboardWidgetSettingInterface
     */
    protected $widgetSettingRepository;

    /**
     * @var DashboardWidgetInterface
     */
    protected $widgetRepository;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    /**
     * DashboardController constructor.
     * @param DashboardWidgetSettingInterface $widgetSettingRepository
     * @param DashboardWidgetInterface $widgetRepository
     */
    public function __construct(
        DashboardWidgetSettingInterface $widgetSettingRepository,
        DashboardWidgetInterface $widgetRepository
    ) {
        $this->widgetSettingRepository = $widgetSettingRepository;
        $this->widgetRepository = $widgetRepository;
    }

    /**
     * @param Request $request
     * @return Factory|View
     */
    public function index(Request $request)
    {
        Assets::addScripts(['stickytableheaders', 'custom-scrollbar', 'blockUI'])
            ->addStyles(['custom-scrollbar'])
            ->addScriptsDirectly([
                'vendor/Modules/KamrulDashboard/js/dashboard.js',
                'vendor/Modules/KamrulDashboard/js/dashboard/Sortable.min.js',
                'vendor/Modules/KamrulDashboard/js/dashboard/jquery.equalheights.js',
                'vendor/Modules/KamrulDashboard/vendor/raphael/raphael.min.js',
                'vendor/Modules/KamrulDashboard/vendor/morris/morris.min.js',
            ])
            ->addStylesDirectly('vendor/Modules/KamrulDashboard/js/dashboard/dashboard.css');

        page_title()->setTitle(trans('kamruldashboard::lang.dashboard'));
        $data = array();
        $title        = 'dashboard';
//        $data['title']        = 'dashboard';

        do_action(DASHBOARD_ACTION_REGISTER_SCRIPTS);
        /**
         * @var Collection $widgets
         */
        $widgets = $this->widgetRepository->getModel()
            ->with([
                'settings' => function (HasMany $query) use ($request) {
                    $query->where('user_id', $request->user()->getKey())
                        ->select(['status', 'order', 'settings', 'widget_id'])
                        ->orderBy('order');
                },
            ])
            ->select(['id', 'name'])
            ->get();

        $widgetData = apply_filters(DASHBOARD_FILTER_ADMIN_LIST, [], $widgets);
        ksort($widgetData);

        $availableWidgetIds = collect($widgetData)->pluck('id')->all();

        $widgets = $widgets->reject(function ($item) use ($availableWidgetIds) {
            return !in_array($item->id, $availableWidgetIds);
        });

        $statWidgets = collect($widgetData)->where('type', '!=', 'widget')->pluck('view')->all();
        $userWidgets = collect($widgetData)->where('type', 'widget')->pluck('view')->all();

        return view('kamruldashboard::dashboard.dashboard',compact('title','widgets', 'userWidgets', 'statWidgets'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreDashboardsRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreDashboardsRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \Modules\KamrulDashboard\Http\Models\Dashboards  $dashboards
     * @return \Illuminate\Http\Response
     */
    public function show(Dashboards $dashboards)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \Modules\KamrulDashboard\Http\Models\Dashboards  $dashboards
     * @return \Illuminate\Http\Response
     */
    public function edit(Dashboards $dashboards)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateDashboardsRequest  $request
     * @param  \Modules\KamrulDashboard\Http\Models\Dashboards  $dashboards
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateDashboardsRequest $request, Dashboards $dashboards)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Modules\KamrulDashboard\Http\Models\Dashboards  $dashboards
     * @return \Illuminate\Http\Response
     */
    public function destroy(Dashboards $dashboards)
    {
        //
    }
}
