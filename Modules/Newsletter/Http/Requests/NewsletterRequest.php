<?php

namespace Modules\Newsletter\Http\Requests;

use Illuminate\Validation\Rule;
use Modules\KamrulDashboard\Http\Requests\Request;
use Modules\Newsletter\Http\packages\NewsletterStatus;

class NewsletterRequest extends Request
{
    public function rules(): array
    {
        $rules = [
            'email' => 'required|email|unique:newsletters',
            'newsletter_agree'   => 'required',
            'status' => Rule::in(NewsletterStatus::values()),
        ];

        if (is_module_active('Captcha') && setting('enable_captcha')) {
            $rules += ['g-recaptcha-response' => 'required|captcha'];
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'g-recaptcha-response.required' => __('Captcha Verification Failed!'),
            'g-recaptcha-response.captcha' => __('Captcha Verification Failed!'),
        ];
    }
}
