<?php

namespace Modules\KamrulDashboard\Http\Controllers\Concerns;


use Modules\KamrulDashboard\Http\Responses\DboardHttpResponse;

trait HasHttpResponse
{
    public function httpResponse(): DboardHttpResponse
    {
        return DboardHttpResponse::make();
    }
}
