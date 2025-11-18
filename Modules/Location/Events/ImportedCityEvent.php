<?php

namespace Modules\Location\Events;

use Illuminate\Queue\SerializesModels;
use Modules\KamrulDashboard\Events\Event;
use Modules\Location\Http\Models\City;

class ImportedCityEvent extends Event
{
    use SerializesModels;

    public $row = [];

    /**
     * @var City
     */
    public $city;

    public function __construct(array $row, City $city)
    {
        $this->row = $row;
        $this->city = $city;
    }
}
