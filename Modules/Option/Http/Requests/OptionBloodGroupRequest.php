<?php

namespace Modules\Option\Http\Requests;

use Illuminate\Validation\Rule;
use Modules\Option\Enums\OptionBloodGroupStatusEnum;
use Modules\KamrulDashboard\Http\Requests\Request;

class OptionBloodGroupRequest extends Request
{
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:120',
            'short_description' => 'required|string|max:160',
            'description' => 'nullable|string|max:400',
            'status' => Rule::in(OptionBloodGroupStatusEnum::values()),
        ];
    }

    public function attributes(): array
    {
        return [
            'custom_fields.*.name' => trans('optionbloodgroup::custom-fields.name'),
            'custom_fields.*.value' => trans('optionbloodgroup::custom-fields.name'),
        ];
    }
}
