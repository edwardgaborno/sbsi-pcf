<?php

namespace App\Http\Requests\Supplier;

use Illuminate\Foundation\Http\FormRequest;

class StoreSupplierRequest extends FormRequest
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
     * Determine if the validaton is failed
     *
     * @return bool
     */
    public $validator = null;
    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        $this->validator = $validator;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'supplier_name' => 'required|string|unique:suppliers,supplier_name',
            'address' => 'nullable|string',
            'email' => 'nullable|email',
            'contact_number' => 'nullable|numeric',
            'telephone_number' => 'nullable|numeric',
        ];
    }

    public function messages()
    {
        return [
            'supplier_name.required' => 'This is a required field.',
        ];
    }
}
