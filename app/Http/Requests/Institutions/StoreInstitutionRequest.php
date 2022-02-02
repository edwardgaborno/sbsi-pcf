<?php

namespace App\Http\Requests\Institutions;

use Illuminate\Foundation\Http\FormRequest;

class StoreInstitutionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'institution' => 'required|string|unique:p_c_f_institutions,institution',
            'address' => 'required|string',
            'contact_person' => 'required|string',
            'designation' => 'required|string',
            'thru_designation' => 'required|string',
        ];
    }

    public function messages()
    {
        return [
            'institution.required' => 'This is a required field.',
            'address.required' => 'This is a required field.',
            'contact_person.required' => 'This is a required field.',
            'designation.required' => 'This is a required field.',
            'thru_designation.required' => 'This is a required field.',
        ];
    }
}
