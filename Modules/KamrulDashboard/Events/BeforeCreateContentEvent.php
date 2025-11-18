<?php

namespace Modules\KamrulDashboard\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Http\Request;
use Illuminate\Queue\SerializesModels;

class BeforeCreateContentEvent extends Event
{
    use Dispatchable;
    use SerializesModels;

    protected $request;
    protected $data;
    public function __construct(Request $request, $data = null)
    {
        $this->request = $request;
        $this->data = $data;
    }
}
