<?php

namespace Modules\ContactForm\Http\Requests;


use Modules\KamrulDashboard\Http\Requests\Request;

class ContactRequest extends Request
{
    public function rules(): array
    {
        $rules = [
            'name' => 'required',
            'email' => 'required|email',
            'content' => 'required',
        ];

        if (is_module_active('Captcha')) {
            if (setting('enable_captcha')) {
                $rules += [
                    'g-recaptcha-response' => 'required|captcha',
                ];
            }

            if (setting('enable_math_captcha_for_contact_form', 0)) {
                $rules['math-captcha'] = 'required|math_captcha';
            }
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'name.required' => trans('contactform::contact.form.name.required'),
            'email.required' => trans('contactform::contact.form.email.required'),
            'email.email' => trans('contactform::contact.form.email.email'),
            'content.required' => trans('contactform::contact.form.content.required'),
            'g-recaptcha-response.required' => __('Captcha Verification Failed!'),
            'g-recaptcha-response.captcha' => __('Captcha Verification Failed!'),
            'math-captcha.required' => __('Math function Verification Failed!'),
            'math_captcha' => __('Math function Verification Failed!'),
        ];
    }
}
