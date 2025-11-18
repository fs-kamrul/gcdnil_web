<?php

namespace Modules\Table\Http\Requests;


use Modules\KamrulDashboard\Http\Requests\Request;

class FilterRequest extends Request
{
    public function rules(): array
    {
        return [
            'class' => 'required',
        ];
    }
}
