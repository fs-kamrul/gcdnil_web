<?php

namespace Modules\ContactForm\Http\Requests;

use Illuminate\Validation\Rule;
use Modules\ContactForm\Enums\ContactStatus;
use Modules\KamrulDashboard\Http\Requests\Request;

class EditContactRequest extends Request
{
    public function rules(): array
    {
        return [
            'status' => Rule::in(ContactStatus::values()),
        ];
    }
}
