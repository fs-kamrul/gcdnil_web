<?php

namespace Modules\Faq\Http\Requests;

use Illuminate\Validation\Rule;
use Modules\KamrulDashboard\Http\Requests\Request;
use Modules\KamrulDashboard\Packages\Supports\DboardStatus;

class FaqCategoryRequest extends Request
{
    public function rules(): array
    {
        return [
            'name' => 'required',
            'order' => 'required|integer|min:0|max:127',
            'status' => Rule::in(DboardStatus::values()),
        ];
    }
}
