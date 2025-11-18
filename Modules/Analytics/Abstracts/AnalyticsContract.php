<?php

namespace Modules\Analytics\Abstracts;

use Google\Service\Analytics\GaData;
use Illuminate\Support\Collection;
use Modules\Analytics\Packages\Supports\Period;

interface AnalyticsContract
{
    public function fetchMostVisitedPages(Period $period, int $maxResults = 20): Collection;

    public function fetchTopReferrers(Period $period, int $maxResults = 20): Collection;

    public function fetchTopBrowsers(Period $period, int $maxResults = 10): Collection;

    public function performQuery(Period $period, string $metrics, array $others = []);
}
