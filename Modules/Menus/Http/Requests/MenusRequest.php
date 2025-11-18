<?php

namespace Modules\Menus\Http\Requests;

use Illuminate\Validation\Rule;
use Modules\KamrulDashboard\Http\Requests\Request;

class MenusRequest extends Request
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'   => 'required|min:3|max:120',
        ];
    }
}
