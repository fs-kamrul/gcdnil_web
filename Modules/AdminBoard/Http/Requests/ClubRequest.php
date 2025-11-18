<?php

namespace Modules\AdminBoard\Http\Requests;

use Illuminate\Validation\Rule;
use Modules\AdminBoard\Enums\ClubStatusEnum;
use Modules\KamrulDashboard\Http\Requests\Request;

class ClubRequest extends Request
{
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:120',
            'short_description' => 'required|string|max:160',
            'description' => 'nullable|string|max:400',
            'status' => Rule::in(ClubStatusEnum::values()),
        ];
    }

    public function attributes(): array
    {
        return [
            'custom_fields.*.name' => trans('club::custom-fields.name'),
            'custom_fields.*.value' => trans('club::custom-fields.name'),
        ];
    }
}
