<?php

namespace Modules\Analytics\Packages\Facades;

use Illuminate\Support\Facades\Facade;
use Modules\Analytics\Abstracts\AnalyticsAbstract;
use Modules\Analytics\Packages\Supports\Period;

/**
 * @method static \Illuminate\Support\Collection|\Google\Service\Analytics\GaData|array|null performQuery(Period $period, string $metrics, array $others = [])
 * @method static \Illuminate\Support\Collection fetchMostVisitedPages(Period $period, int $maxResults = 20)
 * @method static \Illuminate\Support\Collection fetchTopReferrers(Period $period, int $maxResults = 20)
 * @method static \Illuminate\Support\Collection fetchUserTypes(Period $period)
 * @method static \Illuminate\Support\Collection fetchTopBrowsers(Period $period, int $maxResults = 10)
 * @method static \Google_Service_Analytics getAnalyticsService()
 * @method static string getPropertyId()
 * @method static static setPropertyId(string $propertyId)
 * @method static void macro(string $name, object|callable $macro)
 * @method static void mixin(object $mixin, bool $replace = true)
 * @method static bool hasMacro(string $name)
 * @method static void flushMacros()
 *
 * @see \Modules\Analytics\Packages\Supports\Analytics
 */
class AnalyticsFacade extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return AnalyticsAbstract::class;
    }
}
