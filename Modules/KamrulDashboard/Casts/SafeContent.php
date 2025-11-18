<?php

namespace Modules\KamrulDashboard\Casts;

use DboardHelper;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

class SafeContent implements CastsAttributes
{
    public function set($model, string $key, $value, array $attributes)
    {
        return DboardHelper::clean($value);
    }

    public function get($model, string $key, $value, array $attributes)
    {
        return html_entity_decode(DboardHelper::clean($value));
//        return DboardHelper::clean($value);
    }
}
