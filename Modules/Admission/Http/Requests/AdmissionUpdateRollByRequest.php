<?php

namespace Modules\Admission\Http\Requests;

use Modules\KamrulDashboard\Http\Requests\Request;
class AdmissionUpdateRollByRequest extends Request
{
    public function rules(): array
    {
        return [
            'value' => 'required|numeric|min:0|max:1000',
        ];
    }
}
