<?php

namespace Modules\KamrulDashboard\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Dboard;
use Modules\KamrulDashboard\Utils\PluginUtil;

class DboardMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Request  $request
     * @param  Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if ($request->ajax()) {
            return $next($request);
        }
        Dboard::create('main-dashboard', function($menu) {
            // URL, Title, Attributes
//            $menu->header('Test Menu', 100);
        });
        $moduleUtil = new PluginUtil;
        $moduleUtil->getModuleData('modifyAdminDashboard');
        return $next($request);
    }
}
