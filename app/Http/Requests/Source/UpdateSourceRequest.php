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
        if (empty($this->cost_of_peripherals)) {
            $this->merge([
                'unit_price' =>  Str::replace(',', '', $this->unit_price),
                'currency_rate' =>  Str::replace(',', '', $this->currency_rate),
                'tp_php' =>  Str::replace(',', '', $this->tp_php),
                'tp_php_less_tax' =>  Str::replace(',', '', $this->tp_php_less_tax),
                'standard_price' =>  Str::replace(',', '', $this->standard_price),
            ]);
        } else {
            $this->merge([
                'unit_price' =>  Str::replace(',', '', $this->unit_price),
                'currency_rate' =>  Str::replace(',', '', $this->currency_rate),
                'tp_php' =>  Str::replace(',', '', $this->tp_php),
                'tp_php_less_tax' =>  Str::replace(',', '', $this->tp_php_less_tax),
                'cost_of_peripherals' =>  Str::replace(',', '', $this->cost_of_peripherals),
                'standard_price' =>  Str::replace(',', '', $this->standard_price),
            ]);
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'supplier_id' => 'required|string',
            'item_code' => [
                'required',
                'string',
                Rule::unique('sources')->ignore($this->source_id),
            ],
            'description' => 'required|string',
            'unit_price' => 'required|numeric',
            'currency_rate' => 'required|numeric',
            'tp_php' => 'required|numeric',
            'tp_php_less_tax' => 'required|numeric',
            'uom_id' => 'nullable|numeric',
            'segment_id' => 'nullable|numeric',
            'item_category_id' => 'required|numeric',
            'cost_of_peripherals' => 'sometimes|nullable|numeric',
            'standard_price' => 'required|numeric',
            'profitability' => 'required|string',
            // 'mandatory_peripherals_ids' => 'sometimes|nullable|array'
        ];
    }

    public function messages()
    {
        return [
            'supplier_id.required' => 'This is a required field.',
            'item_category_id.required' => 'This is a required field.',
            'item_code.required' => 'This is a required field.',
            'description.required' => 'This is a required field.',
            'unit_price.required' => 'This is a required field.',
            'currency_rate.required' => 'This is a required field.',
            'tp_php.required' => 'This is a required field.',
            'tp_php_less_tax.required' => 'This is a required field.',
            'standard_price.required' => 'This is a required field.',
            'profitability.required' => 'This is a required field.',
        ];
    }
}
