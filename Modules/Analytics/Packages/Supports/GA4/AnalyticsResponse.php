<?php

namespace Modules\Analytics\Packages\Supports\GA4;

use Google\Analytics\Data\V1beta\RunReportResponse;
use Illuminate\Support\Collection;

class AnalyticsResponse
{
    public $googleResponse;

    public $table;

    public array $metricAggregationsTable;

    public function setGoogleResponse(RunReportResponse $googleResponse): self
    {
        $this->googleResponse = $googleResponse;

        return $this;
    }

    public function setTable(array $table): self
    {
        $this->table = collect($table);

        return $this;
    }

    public function setMetricAggregationsTable(array $metricAggregationsTable): self
    {
        $this->metricAggregationsTable = $metricAggregationsTable;

        return $this;
    }
}
