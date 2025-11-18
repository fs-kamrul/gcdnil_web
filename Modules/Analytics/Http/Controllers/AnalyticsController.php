<?php

namespace Modules\Analytics\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Support\Str;
use Modules\Analytics\Exceptions\InvalidConfiguration;
use Modules\Analytics\Packages\Facades\AnalyticsFacade;
use Modules\Analytics\Packages\Supports\Period;
use Modules\KamrulDashboard\Packages\Supports\DashboardWidgetInstance;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Modules\KamrulDashboard\Http\Responses\DboardHttpResponse;
use Throwable;

class AnalyticsController extends Controller
{

    /**
     * @param Request $request
     * @param DboardHttpResponse $response
     * @return DboardHttpResponse
     * @throws Throwable
     */
    public function getGeneral(Request $request, DboardHttpResponse $response)
    {
        $dashboardInstance = new DashboardWidgetInstance();
        $predefinedRangeFound = $dashboardInstance->getFilterRange($request->input('predefined_range'));
        if ($request->input('changed_predefined_range')) {
            $dashboardInstance->saveSettings(
                'widget_analytics_general',
                ['predefined_range' => $predefinedRangeFound['key']]
            );
        }

        $startDate = $predefinedRangeFound['startDate'];
        $endDate = $predefinedRangeFound['endDate'];
        $dimensions = $this->getDimension($predefinedRangeFound['key']);

        try {
            $period = Period::create($startDate, $endDate);

            $visitorData = [];

            $queryData = AnalyticsFacade::performQuery($period, 'ga:visits,ga:pageviews', ['dimensions' => 'ga:' . $dimensions]);

            $queryRows = property_exists($queryData, 'rows') ? (array)$queryData->rows : $queryData->toArray();

            foreach ($queryRows as $dateRow) {
                $dateRow = array_values($dateRow);

                $visitorData[$dateRow[0]] = [
                    'axis' => $this->getAxisByDimensions($dateRow[0], $dimensions),
                    'visitors' => $dateRow[1],
                    'pageViews' => $dateRow[2],
                ];
            }

            if ($predefinedRangeFound['key'] == 'today') {
                for ($index = 0; $index < 24; $index++) {
                    if (! isset($visitorData[$index])) {
                        $visitorData[$index] = [
                            'axis' => $index . 'h',
                            'visitors' => 0,
                            'pageViews' => 0,
                        ];
                    }
                }
            }

            $stats = collect($visitorData);
            $countryStatsQuery = AnalyticsFacade::performQuery(
                $period,
                'ga:sessions',
                ['dimensions' => 'ga:countryIsoCode']
            );

            $countryStats = property_exists($countryStatsQuery, 'rows') ? (array)$countryStatsQuery->rows : $countryStatsQuery->toArray();

            $metrics = 'ga:sessions, ga:users, ga:pageviews, ga:percentNewSessions, ga:bounceRate, ga:pageviewsPerVisit, ga:avgSessionDuration, ga:newUsers';

            $totalQuery = AnalyticsFacade::performQuery($period, $metrics);

            $total = [];

            if (property_exists($totalQuery, 'totalsForAllResults')) {
                $total = $totalQuery->totalsForAllResults;
            } else {
                foreach (explode(', ', $metrics) as $metric) {
                    $total[$metric] = 0;
                }

                foreach ($totalQuery->toArray() as $item) {
                    $total['ga:sessions'] += $item['sessions'];
                    $total['ga:users'] += $item['totalUsers'];
                    $total['ga:pageviews'] += $item['screenPageViews'];
                    $total['ga:percentNewSessions'] += 0;
                    $total['ga:bounceRate'] += $item['bounceRate'];
                    $total['ga:pageviewsPerVisit'] += 0;
                    $total['ga:avgSessionDuration'] += 0;
                    $total['ga:newUsers'] += $item['newUsers'] ?? 0;
                }

                if ($totalQuery->count()) {
                    $total['ga:bounceRate'] = $total['ga:bounceRate'] / $totalQuery->count();
                }
            }

            foreach ($countryStats as $key => $item) {
                unset($item['countryIsoCode']);
                $countryStats[$key] = array_values($item);
            }

            return $response->setData(
                view(
                    'analytics::widgets.general',
                    compact('stats', 'countryStats', 'total')
                )->render()
            );
        } catch (InvalidConfiguration $exception) {
            return $response
                ->setError()
                ->setMessage($exception->getMessage() ?: trans('analytics::analytics.wrong_configuration'));
        } catch (Exception $exception) {
            return $response
                ->setError()
                ->setMessage($exception->getMessage());
        }
    }

    /**
     * @param string $dateRow
     * @param string $dimensions
     * @return Carbon|string
     */
    protected function getAxisByDimensions($dateRow, $dimensions = 'hour'): string
    {
        switch ($dimensions) {
            case 'date':
                return Carbon::parse($dateRow)->toDateString();
            case 'yearMonth':
                return Carbon::createFromFormat('Ym', $dateRow)->format('Y-m');
            default:
                return (int)$dateRow . 'h';
        }
    }

    /**
     * @param string $key
     * @return string
     */
    protected function getDimension($key): string
    {
        $data = [
            'this_week' => 'date',
            'last_7_days' => 'date',
            'this_month' => 'date',
            'last_30_days' => 'date',
            'this_year' => 'yearMonth',
        ];

        return Arr::get($data, $key, 'hour');
    }

    /**
     * @param Request $request
     * @param DboardHttpResponse $response
     * @return DboardHttpResponse
     */
    public function getTopVisitPages(Request $request, DboardHttpResponse $response)
    {
        $dashboardInstance = new DashboardWidgetInstance();
        $predefinedRangeFound = $dashboardInstance->getFilterRange($request->input('predefined_range'));

        if ($request->input('changed_predefined_range')) {
            $dashboardInstance->saveSettings(
                'widget_analytics_page',
                ['predefined_range' => $predefinedRangeFound['key']]
            );
        }

        $startDate = $predefinedRangeFound['startDate'];
        $endDate = $predefinedRangeFound['endDate'];

        try {
            $period = Period::create($startDate, $endDate);
            $query = AnalyticsFacade::fetchMostVisitedPages($period, 10);

            $pages = [];

            $schema = $request->getScheme() . '://';

            foreach ($query as $item) {
                $pageUrl = $item['fullPageUrl'];

                if (! Str::startsWith($pageUrl, $schema)) {
                    $pageUrl = $schema . $pageUrl;
                }

                $pages[] = [
                    'pageTitle' => $item['pageTitle'],
                    'url' => $pageUrl,
                    'pageViews' => $item['screenPageViews'] ?? $item['pageViews'],
                ];
            }

            return $response->setData(view('analytics::widgets.page', compact('pages'))->render());
        } catch (InvalidConfiguration $exception) {
            return $response
                ->setError()
                ->setMessage($exception->getMessage() ?: trans('analytics::analytics.wrong_configuration'));
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
    public function getTopBrowser(Request $request, DboardHttpResponse $response)
    {
        $dashboardInstance = new DashboardWidgetInstance();
        $predefinedRangeFound = $dashboardInstance->getFilterRange($request->input('predefined_range'));

        if ($request->input('changed_predefined_range')) {
            $dashboardInstance->saveSettings(
                'widget_analytics_browser',
                ['predefined_range' => $predefinedRangeFound['key']]
            );
        }

        $startDate = $predefinedRangeFound['startDate'];
        $endDate = $predefinedRangeFound['endDate'];

        try {
            $period = Period::create($startDate, $endDate);
            $browsers = AnalyticsFacade::fetchTopBrowsers($period);

            return $response->setData(view('analytics::widgets.browser', compact('browsers'))->render());
        } catch (InvalidConfiguration $exception) {
            return $response
                ->setError()
                ->setMessage($exception->getMessage() ?: trans('analytics::analytics.wrong_configuration'));
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
    public function getTopReferrer(Request $request, DboardHttpResponse $response)
    {
        $dashboardInstance = new DashboardWidgetInstance();
        $predefinedRangeFound = $dashboardInstance->getFilterRange($request->input('predefined_range'));

        if ($request->input('changed_predefined_range')) {
            $dashboardInstance->saveSettings(
                'widget_analytics_referrer',
                ['predefined_range' => $predefinedRangeFound['key']]
            );
        }

        $startDate = $predefinedRangeFound['startDate'];
        $endDate = $predefinedRangeFound['endDate'];

        try {
            $period = Period::create($startDate, $endDate);
            $query = AnalyticsFacade::fetchTopReferrers($period, 10);

            $referrers = [];

            foreach ($query as $item) {
                $referrers[] = [
                    'url' => $item['sessionSource'] ?? $item['url'],
                    'pageViews' => $item['screenPageViews'] ?? $item['pageViews'],
                ];
            }

            return $response->setData(view('analytics::widgets.referrer', compact('referrers'))->render());
        } catch (InvalidConfiguration $exception) {
            return $response
                ->setError()
                ->setMessage($exception->getMessage() ?: trans('analytics::analytics.wrong_configuration'));
        } catch (Exception $exception) {
            return $response
                ->setError()
                ->setMessage($exception->getMessage());
        }
    }
}
