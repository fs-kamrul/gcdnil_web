<?php

namespace Modules\Post\Http\Requests;

use Illuminate\Validation\Rule;
use Modules\KamrulDashboard\Http\Requests\Request;
use Modules\KamrulDashboard\Packages\Supports\DboardStatus;
use Modules\Post\Supports\Template;

class PageRequest extends Request
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'                  => 'required|max:120',
//            'description'           => 'required',
            'short_description'     => 'required|max:400',
//            'page_templates_id'     => '',//Rule::in(array_keys(Template::getPageTemplates())),
//            'status'                => Rule::in(DboardStatus::PUBLISHED),
        ];
    }
}
