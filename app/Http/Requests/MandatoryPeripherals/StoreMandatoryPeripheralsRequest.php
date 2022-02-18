<?php

namespace App\Http\Requests\MandatoryPeripherals;

use Illuminate\Foundation\Http\FormRequest;

class StoreMandatoryPeripheralsRequest extends FormRequest
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
            'source_id' => 'required|string|unique:mandatory_peripherals,source_id',
            'item_description' => 'required|string',
            'quantity' => 'required|numeric|min:1',
            'peripherals_category_id' => 'required|numeric',
        ];
    }

    public function messages()
    {
        return [
            'source_id.required' => 'This is a required field.',
            'item_description.required' => 'This is a required field.',
            'quantity.required' => 'This is a required field.',
            'peripherals_category_id.required' => 'This is a required field.',
        ];
    }
}
