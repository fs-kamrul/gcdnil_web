<?php

namespace Modules\KamrulDashboard\Events;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Queue\SerializesModels;
use stdClass;

class BeforeEditContentEvent extends Event
{
    use SerializesModels;

    /**
     * @var Request
     */
    public $request;

    /**
     * @var Model|false
     */
    public $data;

    /**
     * BeforeEditContentEvent constructor.
     * @param Request $request
     * @param Model|false|stdClass $data
     */
    public function __construct($request, $data)
    {
        $this->request = $request;
        $this->data = $data;
    }
}
