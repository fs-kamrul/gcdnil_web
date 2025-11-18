<?php

namespace Modules\Widget\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Modules\KamrulDashboard\Http\Responses\DboardHttpResponse;
use Modules\Widget\Packages\Factories\AbstractWidgetFactory;
use Modules\Widget\Packages\Supports\WidgetId;
use Modules\Widget\Repositories\Interfaces\WidgetInterface;
use Exception;
use Theme;
use Throwable;
use WidgetGroup;
use Language;

class WidgetController extends Controller
{
    /**
    * @var WidgetInterface
     */
    protected $widgetRepository;

    /**
     * @var string|null
     */
    protected $theme = null;

    /**
     * WidgetController constructor.
     * @param WidgetInterface $widgetRepository
     */
    public function __construct(WidgetInterface $widgetRepository)
    {
        $this->widgetRepository = $widgetRepository;
        $this->theme = Theme::getThemeName() . $this->getCurrentLocaleCode();
    }

    /**
     * @return Factory|View
     * @since 24/09/2016 2:10 PM
     */
    public function index()
    {
//        page_title()->setTitle(trans('widget::lang.name'));

        page_title()->setTitle(trans('widget::lang.name'));
        if (!auth()->user()->can('widget_access')) {
            abort(403, 'Unauthorized action.');
        }
        $data = array();
        $data['title']        = __('widget::lang.name');

//        Assets::addScripts(['sortable'])
//            ->addScriptsDirectly('vendor/widget/js/widget.js');

        $widgets = $this->widgetRepository->getByTheme($this->theme);

        foreach ($widgets as $widget) {
            WidgetGroup::group($widget->sidebar_id)
                ->position($widget->position)
                ->addWidget($widget->widget_id, $widget->data);
        }

        return view('widget::list', $data);
    }

    /**
     * @param Request $request
     * @param DboardHttpResponse $response
     * @return DboardHttpResponse
     * @throws Throwable
     * @since 24/09/2016 3:14 PM
     */
    public function postSaveWidgetToSidebar(Request $request, DboardHttpResponse $response)
    {
        try {
            $sidebarId = $request->input('sidebar_id');
            $this->widgetRepository->deleteBy([
                'sidebar_id' => $sidebarId,
                'theme'      => $this->theme,
            ]);
            foreach ($request->input('items', []) as $key => $item) {
                parse_str($item, $data);
                if (empty($data['id'])) {
                    continue;
                }
                $data_set = json_encode($data);

                $this->widgetRepository->createOrUpdate([
                    'sidebar_id' => $sidebarId,
                    'widget_id'  => $data['id'],
                    'theme'      => $this->theme,
                    'position'   => $key,
                    'data'       => $data_set,
                ]);
            }

            $widgetAreas = $this->widgetRepository->allBy([
                'sidebar_id' => $sidebarId,
                'theme'      => $this->theme,
            ]);

            return $response
                ->setData(view('widget::item', compact('widgetAreas'))->render())
                ->setMessage(trans('widget::lang.save_success'));
        } catch (Exception $exception) {
            return $response
                ->setError()
                ->setMessage($exception->getMessage());
        }
    }

    /**
     * @param Request $request
     * @param DboardHttpResponse $response
     * @return DboardHttpResponse
     */
    public function postDelete(Request $request, DboardHttpResponse $response)
    {
        try {
            $this->widgetRepository->deleteBy([
                'theme'      => $this->theme,
                'sidebar_id' => $request->input('sidebar_id'),
                'position'   => $request->input('position'),
                'widget_id'  => $request->input('widget_id'),
            ]);

            return $response->setMessage(trans('widget::lang.delete_success'));
        } catch (Exception $exception) {
            return $response
                ->setError()
                ->setMessage($exception->getMessage());
        }
    }

    /**
     * The action to show widget output via ajax.
     *
     * @param Request $request
     *
     * @param Application $application
     * @return mixed
     * @throws BindingResolutionException
     */
    public function showWidget(Request $request, Application $application)
    {
        $this->prepareGlobals($request);

        $factory = $application->make('kamruldashboard.widget');
        $widgetName = $request->input('name', '');
        $widgetParams = $factory->decryptWidgetParams($request->input('params', ''));

        return call_user_func_array([$factory, $widgetName], $widgetParams);
    }

    /**
     * Set some specials variables to modify the workflow of the widget factory.
     *
     * @param Request $request
     */
    protected function prepareGlobals(Request $request)
    {
        WidgetId::set($request->input('id', 1) - 1);
        AbstractWidgetFactory::$skipWidgetContainer = true;
    }

    /**
     * @return null|string
     */
    protected function getCurrentLocaleCode()
    {
        $languageCode = null;
        if (is_module_active('Language')) {
            $currentLocale = is_in_admin() ? Language::getCurrentAdminLocaleCode() : Language::getCurrentLocaleCode();
            $languageCode = $currentLocale && $currentLocale != Language::getDefaultLocaleCode() ? '-' . $currentLocale : null;
        }

        return $languageCode;
    }
}
