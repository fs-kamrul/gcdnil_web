<?php

namespace Modules\KamrulDashboard\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class KamrulMiddleware
{
    /**
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle($request, $next)
    {
        return $next($request);
    }
}
