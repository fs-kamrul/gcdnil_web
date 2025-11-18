<?php

namespace Modules\Option\Http\Requests;

use Modules\KamrulDashboard\Http\Requests\Request;
class OptionSubjectRequest extends Request
{
    public function rules(): array
    {
        return [
            'name'              => 'bail|required|max:255',
            'total_mark'        => 'required|numeric|min:0|max:100',
            'code'              => 'required|unique:admission_subjects,code',
        ];
    }
}
