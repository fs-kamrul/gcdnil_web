<?php

namespace Modules\KamrulDashboard\Services;

use Illuminate\Http\Request;

interface ProduceServiceInterface
{
    public function execute(Request $request);
}
