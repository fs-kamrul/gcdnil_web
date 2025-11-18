<?php

namespace Modules\Admission\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Modules\Admission\Rules\ImageDimensions;

class StoreAdmissionRequest extends FormRequest
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
            'bl_name' => 'required|string|max:255',
//            'phone' => 'required|number|max:11',
            'father_name' => 'required|string|max:255',
            'bl_father_name' => 'required|string|max:255',
            'bl_mother_nane' => 'required|string|max:255',
            'mother_nane' => 'required|string|max:255',
//            'phone' => 'required|digits:11',
//            'phone' => ['required', 'regex:/^[0-9]{11}$/'],
            'dob' => 'required|string',
            'class' => 'required|string|max:255',
            'year' => 'required|string|max:255',
            'pre_institution' => 'required|string|max:255',
            'birth_registration' => 'required|string|max:255',

            'father_phone' => 'required',
            'religion' => 'required',
            'blood_group' => 'required',
            'gender' => 'required',
            'nationality' => 'required',
            'admission_group' => 'required',
            'pre_gpa' => 'required',
            'pre_country' => 'required',
            'pre_states' => 'required',
            'pre_city' => 'required',
            'per_country' => 'required',
            'per_states' => 'required',
            'per_city' => 'required',
//            'pre_gpa' => 'required|string|max:255',
            'pre_address' => 'required|string|max:255',
            'pre_postcode' => 'required|string|max:255',
            'per_address' => 'required|string|max:255',
            'per_postcode' => 'required|string|max:255',
//            'loc_name' => 'required|string|max:255',
//            'loc_phone' => 'required|string|max:255',
//            'loc_relation' => 'required',
//            'tex_id' => 'required|string|max:255',
            'pre_class' => 'required|integer',
            'ssc_year' => 'required',
//            'photo' => 'required|image|mimes:jpeg,jpg,png|max:150',
            'photo' => [
                'required',
                'image',
                'mimes:jpeg,png,jpg,gif',
                'max:151',
//                new ImageDimensions(301, 301), // Adjust the dimensions as needed
            ],
//            'payment_img' => [
//                'required',
//                'image',
//                'mimes:jpeg,png,jpg,gif',
////                'max:150',
////                new ImageDimensions(300, 300), // Adjust the dimensions as needed
//            ],
        ];
    }
    public function messages(): array
    {
        return [
            'phone.max' => 'The phone number must not exceed 11.',
            'phone.required' => 'The phone number is required.',
        ];
    }
}
