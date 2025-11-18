<?php

namespace Modules\Post\Http\Requests;

use Modules\KamrulDashboard\Http\Requests\Request;

class TemplateRequest extends Request
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
//            'description'           => 'required',
        ];
    }
}
