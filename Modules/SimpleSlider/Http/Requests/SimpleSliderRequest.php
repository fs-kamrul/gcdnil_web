<?php

namespace Modules\SimpleSlider\Http\Requests;

use Illuminate\Validation\Rule;
use Modules\KamrulDashboard\Http\Requests\Request;
use Modules\KamrulDashboard\Packages\Supports\DboardStatus;

class SimpleSliderRequest extends Request
{
    public function rules(): array
    {
        return [
            'name' => 'required',
            'key' => 'required',
            'description' => 'max:1000',
            'status' => Rule::in(DboardStatus::values()),
        ];
    }
}
