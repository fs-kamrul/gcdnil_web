<?php

namespace Modules\Table\Http\Requests;


use Modules\KamrulDashboard\Http\Requests\Request;

class BulkChangeRequest extends Request
{
    public function rules(): array
    {
        return [
            'class' => 'required',
        ];
    }
}
