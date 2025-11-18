<?php

namespace Modules\Option\Http\Requests;

use Illuminate\Validation\Rule;
use Modules\Option\Enums\OptionSetStatusEnum;
use Modules\KamrulDashboard\Http\Requests\Request;

class OptionSetRequest extends Request
{
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:120',
            'short_description' => 'required|string|max:160',
            'description' => 'nullable|string|max:400',
            'status' => Rule::in(OptionSetStatusEnum::values()),
        ];
    }

    public function attributes(): array
    {
        return [
            'custom_fields.*.name' => trans('optionset::custom-fields.name'),
            'custom_fields.*.value' => trans('optionset::custom-fields.name'),
        ];
    }
}
