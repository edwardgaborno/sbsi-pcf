<?php

namespace App\Http\Requests\Source;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;


class UpdateSourceRequest extends FormRequest
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
     * Prepare the data for validation.
     * remove commas on numbers to prevent error when saving
     * @return void
     */
    protected function prepareForValidation()
    {
        $this->merge([
            'unit_price' =>  Str::replace(',', '', $this->unit_price),
            'currency_rate' =>  Str::replace(',', '', $this->currency_rate),
            'tp_php' =>  Str::replace(',', '', $this->tp_php),
            'cost_of_peripherals' =>  Str::replace(',', '', $this->cost_of_peripherals),
            'standard_price' =>  Str::replace(',', '', $this->standard_price),
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'supplier' => 'required|string',
            'item_code' => [
                'required',
                'string',
                Rule::unique('sources')->ignore($this->source_id),
            ],
            'description' => 'required|string',
            'unit_price' => 'required|numeric',
            'currency_rate' => 'required|numeric',
            'tp_php' => 'required|numeric',
            'item_group' => 'sometimes|nullable|string',
            'uom' => 'sometimes|nullable|string',
            'mandatory_peripherals' => 'sometimes|nullable|string',
            'cost_of_peripherals' => 'sometimes|nullable|numeric',
            'segment' => 'sometimes|nullable|string',
            'item_category' => 'required|string',
            'standard_price' => 'required|numeric',
            'profitability' => 'required|string',
        ];
    }

    public function messages()
    {
        return [
            'supplier.required' => 'This is a required field.',
            'item_code.required' => 'This is a required field.',
            'description.required' => 'This is a required field.',
            'unit_price.required' => 'This is a required field.',
            'currency_rate.required' => 'This is a required field.',
            'item_category.required' => 'This is a required field.',
            'tp_php.required' => 'This is a required field.',
            'standard_price.required' => 'This is a required field.',
            'profitability.required' => 'This is a required field.',
        ];
    }
}
