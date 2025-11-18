<?php

namespace Modules\KamrulDashboard\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller;
use Modules\KamrulDashboard\Http\Controllers\Concerns\HasHttpResponse;

class DboardController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests, HasHttpResponse;
}
