<?php

namespace Modules\Analytics\Packages\Supports\GA4\Traits;

use Google\Analytics\Data\V1beta\Metric;

trait MetricTrait
{
    public $metrics = [];

    public function metric(string $name): self
    {
        $this->metrics[] = (new Metric())
            ->setName($name);

        return $this;
    }

    public function metrics($items): self
    {
        $this->metrics = [];

        $items = $this->validateMetrics($items);

        foreach ((array)$items as $item) {
            $item = trim($item);
            $this->metric($item);
        }

        return $this;
    }

    protected function validateMetrics($metrics)
    {
        $metrics = (array)$metrics;

        foreach ($metrics as $key => $item) {
            switch ($item) {
                case 'visits':
                case 'users':
                    $metrics[$key] = 'totalUsers';

                    break;

                case 'pageviews':
                    $metrics[$key] = 'screenPageViews';

                    break;

                case 'percentNewSessions':
                    $metrics[$key] = 'eventsPerSession';

                    break;

                case 'pageviewsPerVisit':
                    $metrics[$key] = 'activeUsers';

                    break;

                case 'avgSessionDuration':
                    $metrics[$key] = 'averageSessionDuration';

                    break;
            }
        }

        return array_unique($metrics);
    }
}
