<?php

namespace Modules\Analytics\Abstracts;

use Illuminate\Support\Collection;
use Illuminate\Support\Traits\Macroable;
use Modules\Analytics\Packages\Supports\Period;

abstract class AnalyticsAbstract
{
    use Macroable;

    public $propertyId = null;

    public $credentials = null;

    public function getPropertyId(): string
    {
        return $this->propertyId;
    }

    public function setPropertyId(string $propertyId)
    {
        $this->propertyId = $propertyId;

        return $this;
    }

    abstract public function fetchMostVisitedPages(Period $period, int $maxResults = 20): Collection;

    abstract public function fetchTopReferrers(Period $period, int $maxResults = 20): Collection;

    abstract public function fetchTopBrowsers(Period $period, int $maxResults = 10): Collection;
}
