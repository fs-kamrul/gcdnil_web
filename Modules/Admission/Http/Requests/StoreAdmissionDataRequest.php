<?php

namespace Modules\Admission\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Modules\Admission\Rules\ImageDimensions;

class StoreAdmissionDataRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'student_id' => 'required|string|max:255|unique:admissions,student_id',
        ];
    }
    public function messages(): array
    {
        return [
            'name' => 'The Name must required',
            'student_id.required' => 'The Student ID is required.',
            'student_id.unique' => 'This Student ID has already been taken.',
        ];
    }
}
