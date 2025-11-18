<?php

namespace Modules\ContactForm\Http\Requests;


use Modules\KamrulDashboard\Http\Requests\Request;

class ContactReplyRequest extends Request
{
    public function rules(): array
    {
        return [
            'message' => 'required',
        ];
    }
}
