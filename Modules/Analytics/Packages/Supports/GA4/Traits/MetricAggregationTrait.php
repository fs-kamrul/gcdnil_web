<?php

namespace Modules\Analytics\Packages\Supports\GA4\Traits;

trait MetricAggregationTrait
{
    public $metricAggregations = [];

    public function metricAggregation(int $value): self
    {
        $this->metricAggregations[] = $value;

        return $this;
    }

    public function metricAggregations(int ...$items): self
    {
        foreach ($items as $item) {
            $this->metricAggregation($item);
        }

        return $this;
    }
}
