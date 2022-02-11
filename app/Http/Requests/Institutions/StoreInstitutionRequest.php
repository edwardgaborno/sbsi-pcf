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
            'institution' => 'required|string',
            'address' => 'required|string',
            'contact_person' => 'required|string',
            'designation' => 'required|string',
            'thru_contact_person' => 'nullable|string',
            'thru_designation' => 'nullable|string',
            'email' => 'nullable|string',
            'contact_number' => 'nullable|string',
            'telephone_number' => 'nullable|string',
        ];
    }

    public function messages()
    {
        return [
            'institution.required' => 'This is a required field.',
            'address.required' => 'This is a required field.',
            'contact_person.required' => 'This is a required field.',
            'designation.required' => 'This is a required field.',
        ];
    }
}
