<?php

namespace Modules\Faq\Http\Requests;


use Modules\KamrulDashboard\Http\Requests\Request;

class FaqRequest extends Request
{
    public function rules(): array
    {
        return [
            'category_id' => 'required',
            'question' => 'required',
            'answer' => 'required',
        ];
    }
}
