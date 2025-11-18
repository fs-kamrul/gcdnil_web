<?php

namespace Modules\KamrulDashboard\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class IsInstalled
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $envPath = base_path('.env');
        if (!file_exists($envPath)) {
            return redirect(url('/') . '/install');
        } else {

        }
        return $next($request);
    }
}
