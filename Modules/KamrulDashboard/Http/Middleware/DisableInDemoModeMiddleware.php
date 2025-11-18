<?php

namespace Modules\KamrulDashboard\Http\Middleware;

use Closure;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\Request;
use Modules\KamrulDashboard\Http\Responses\DboardHttpResponse;

class DisableInDemoModeMiddleware
{
    protected $app;

    protected $httpResponse;

    public function __construct(Application $application, DboardHttpResponse $response)
    {
        $this->app = $application;
        $this->httpResponse = $response;
    }

    public function handle(Request $request, Closure $next)
    {
        if ($this->app->environment('demo')) {
            return $this->httpResponse
                ->setError()
                ->withInput()
                ->setMessage(trans('kamruldashboard::lang.disabled_in_demo_mode'))
                ->toResponse($request);
        }

        return $next($request);
    }
}
