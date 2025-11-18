<?php

namespace Modules\Post\Http\Requests;

use Illuminate\Validation\Rule;
use Modules\KamrulDashboard\Http\Requests\Request;
use Modules\KamrulDashboard\Packages\Supports\DboardStatus;
use Modules\Post\Supports\Template;

class CategoryRequest extends Request
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'                  => 'required|max:120',
            'short_description'     => 'required|max:400',
        ];
    }
}
