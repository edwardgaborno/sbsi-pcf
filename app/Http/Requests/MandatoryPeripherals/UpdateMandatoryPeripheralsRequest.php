<?php

namespace App\Http\Requests\MandatoryPeripherals;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateMandatoryPeripheralsRequest extends FormRequest
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
            'item_code' => [
                'required',
                'string',
                Rule::unique('mandatory_peripherals')->ignore($this->mp_id),
            ],
            'item_description' => 'required|string',
            'quantity' => 'required|numeric|min:1',
            'peripherals_category_id' => 'required|numeric',
        ];
    }

    public function messages()
    {
        return [
            'item_code.required' => 'This is a required field.',
            'item_description.required' => 'This is a required field.',
            'quantity.required' => 'This is a required field.',
            'peripherals_category_id.required' => 'This is a required field.',
        ];
    }
}
