<?php

namespace Modules\AdminBoard\Http\Requests;

use Illuminate\Validation\Rule;
use Modules\AdminBoard\Enums\AdminCategoryStatusEnum;
use Modules\KamrulDashboard\Http\Requests\Request;

class AdminCategoryRequest extends Request
{
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:220',
            'description' => 'nullable|string|max:400',
            'is_default' => 'sometimes|boolean',
            'status' => Rule::in(AdminCategoryStatusEnum::values()),
        ];
    }
}
