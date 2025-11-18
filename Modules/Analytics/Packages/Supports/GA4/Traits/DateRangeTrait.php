<?php

namespace Modules\Analytics\Packages\Supports\GA4\Traits;

use Google\Analytics\Data\V1beta\DateRange;
use Modules\Analytics\Packages\Supports\Period;

trait DateRangeTrait
{
    public $dateRanges = [];

    public function dateRange(Period $period): self
    {
        $this->dateRanges[] = (new DateRange())
            ->setStartDate($period->startDate->toDateString())
            ->setEndDate($period->endDate->toDateString());

        return $this;
    }

    public function dateRanges(Period ...$items): self
    {
        foreach ($items as $item) {
            $this->dateRange($item);
        }

        return $this;
    }
}
