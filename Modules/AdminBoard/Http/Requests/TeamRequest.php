<?php

namespace Modules\AdminBoard\Http\Requests;

use Illuminate\Validation\Rule;
use Modules\AdminBoard\Enums\AdminTeamStatusEnum;
use Modules\KamrulDashboard\Http\Requests\Request;

class TeamRequest extends Request
{
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:120',
//            'short_description' => 'required|string|max:160',
//            'description' => 'nullable|string|max:400',
            'status' => Rule::in(AdminTeamStatusEnum::values()),
        ];
    }

    public function attributes(): array
    {
        return [
            'custom_fields.*.name' => trans('adminboard::custom-fields.name'),
            'custom_fields.*.value' => trans('adminboard::custom-fields.name'),
        ];
    }
}
