<?php

namespace Modules\KamrulDashboard\Http\Requests;


class SendTestEmailRequest extends Request
{
    public function rules(): array
    {
        return [
            'email' => 'required|email',
        ];
    }
}
