<?php

namespace Modules\Analytics\Packages\Supports;

use Carbon\CarbonInterface;
use Modules\Analytics\Exceptions\InvalidPeriod;
use Carbon\Carbon;
//use DateTime;

class Period
{
    /**
     * @var CarbonInterface
     */
    public $startDate;

    /**
     * @var CarbonInterface
     */
    public $endDate;

    /**
     * Period constructor.
     * @param CarbonInterface $startDate
     * @param CarbonInterface $endDate
     * @throws InvalidPeriod
     */
    public function __construct(CarbonInterface $startDate, CarbonInterface $endDate)
    {
        if ($startDate > $endDate) {
            throw InvalidPeriod::startDateCannotBeAfterEndDate($startDate, $endDate);
        }

        $this->startDate = $startDate;

        $this->endDate = $endDate;
    }

    /**
     * @param CarbonInterface $startDate
     * @param CarbonInterface $endDate
     * @return static
     * @throws InvalidPeriod
     */
    public static function create(CarbonInterface $startDate, CarbonInterface $endDate): self
    {
        return new static($startDate, $endDate);
    }

    /**
     * @param int $numberOfDays
     * @return static
     * @throws InvalidPeriod
     */
    public static function days(int $numberOfDays): self
    {
        $endDate = Carbon::today();

        $startDate = Carbon::today()->subDays($numberOfDays)->startOfDay();

        return new static($startDate, $endDate);
    }

    /**
     * @param int $numberOfMonths
     * @return static
     * @throws InvalidPeriod
     */
    public static function months(int $numberOfMonths): self
    {
        $endDate = Carbon::today();

        $startDate = Carbon::today()->subMonths($numberOfMonths)->startOfDay();

        return new static($startDate, $endDate);
    }

    /**
     * @param int $numberOfYears
     * @return static
     * @throws InvalidPeriod
     */
    public static function years(int $numberOfYears): self
    {
        $endDate = Carbon::today();

        $startDate = Carbon::today()->subYears($numberOfYears)->startOfDay();

        return new static($startDate, $endDate);
    }
}
