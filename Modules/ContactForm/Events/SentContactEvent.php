<?php

namespace Modules\ContactForm\Events;

use Eloquent;
use Illuminate\Queue\SerializesModels;
use Modules\KamrulDashboard\Events\Event;

class SentContactEvent extends Event
{
    use SerializesModels;

    /**
     * @var Eloquent|false
     */
    public $data;

    public function __construct($data)
    {
        $this->data = $data;
    }
}
