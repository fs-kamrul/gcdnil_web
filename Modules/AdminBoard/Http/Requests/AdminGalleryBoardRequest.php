<?php

namespace Modules\AdminBoard\Http\Requests;

use Illuminate\Validation\Rule;
use Modules\AdminBoard\Enums\AdminGalleryBoardStatusEnum;
use Modules\KamrulDashboard\Http\Requests\Request;

class AdminGalleryBoardRequest extends Request
{
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:120',
            'short_description' => 'required|string|max:160',
            'description' => 'nullable|string|max:400',
            'status' => Rule::in(AdminGalleryBoardStatusEnum::values()),
        ];
    }

    public function attributes(): array
    {
        return [
            'custom_fields.*.name' => trans('admingalleryboard::custom-fields.name'),
            'custom_fields.*.value' => trans('admingalleryboard::custom-fields.name'),
        ];
    }
}
