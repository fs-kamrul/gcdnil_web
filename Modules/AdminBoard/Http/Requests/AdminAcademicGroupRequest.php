<?php

namespace Modules\AdminBoard\Http\Requests;

use Illuminate\Validation\Rule;
use Modules\AdminBoard\Enums\AdminAcademicGroupStatusEnum;
use Modules\KamrulDashboard\Http\Requests\Request;

class AdminAcademicGroupRequest extends Request
{
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:120',
            'short_description' => 'required|string|max:160',
            'description' => 'nullable|string|max:400',
            'status' => Rule::in(AdminAcademicGroupStatusEnum::values()),
        ];
    }

    public function attributes(): array
    {
        return [
            'custom_fields.*.name' => trans('adminacademicgroup::custom-fields.name'),
            'custom_fields.*.value' => trans('adminacademicgroup::custom-fields.name'),
        ];
    }
}
