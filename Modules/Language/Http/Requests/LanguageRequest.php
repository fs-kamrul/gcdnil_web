<?php

namespace Modules\Language\Http\Requests;

use Modules\KamrulDashboard\Http\Requests\Request;

class LanguageRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'lang_name'   => 'required|max:30|min:2',
            'lang_code'   => 'required|max:10|min:2|max:10',
            'lang_locale' => 'required|max:10|min:2',
            'lang_flag'   => 'required',
            'lang_is_rtl' => 'required',
            'lang_order'  => 'required|numeric',
        ];
    }
    public function messages()
    {
        return [
            'lang_name.required' => 'The :attribute field is required.',
            'lang_code.required' => 'The :attribute field is required.',
            'lang_locale.required' => 'The :attribute field is required.',
            'lang_flag.required' => 'The :attribute field is required.',
            'lang_is_rtl.required' => 'The :attribute field is required.',
            'lang_order.required' => 'The :attribute field is required.',
            'lang_name.min' => 'The :attribute field must be at least :min characters.',
            'lang_code.min' => 'The :attribute field must be at least :min characters.',
            'lang_code.max' => 'The :attribute field must be at maximum :max characters.',
            'lang_locale.min' => 'The :attribute field must be at least :min characters.',
            'lang_order.numeric' => 'The :attribute field must be numeric.',
        ];
    }
}
