<?php

namespace App\Http\Requests\PRofitabilityPercentage;

use Illuminate\Foundation\Http\FormRequest;

class StoreProfitabilityPercentageRequest extends FormRequest
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
            'item_category_id' => 'required|numeric|unique:profitability_percentages,item_category_id',
            'percentage' => 'required|numeric'
        ];
    }

    public function messages()
    {
        return [
            'item_category_id.required' => 'This is a required field.',
            'percentage.required' => 'This is a required field.',
        ];
    }
}
