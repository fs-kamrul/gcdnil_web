<?php

namespace Modules\KamrulDashboard\Events;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Queue\SerializesModels;
use stdClass;

class DeletedContentEvent extends Event
{
    use SerializesModels;

    /**
     * @var string
     */
    public $screen;

    /**
     * @var Request
     */
    public $request;

    /**
     * @var Model|false
     */
    public $data;

    /**
     * CreatedContentEvent constructor.
     * @param string $screen
     * @param Request $request
     * @param Model|false|stdClass $data
     */
    public function __construct($screen, $request, $data)
    {
        $this->screen = $screen;
        $this->request = $request;
        $this->data = $data;
    }
}
