<?php

namespace Modules\Translation\Http\Requests;

use Modules\KamrulDashboard\Http\Requests\Request;
use Modules\KamrulDashboard\Packages\Supports\Language;

class LocaleRequest extends Request
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'locale' => 'required|in:' . implode(',', collect(Language::getListLanguages())->pluck(0)->unique()->all()),
        ];
    }
}
