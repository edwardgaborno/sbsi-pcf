<?php

namespace App\Http\Requests\Source;

use Illuminate\Foundation\Http\FormRequest;

class StoreSourceRequest extends FormRequest
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
            'supplier' => 'required|string|unique:sources,supplier',
            'item_code' => 'nullable|string',
            'description' => 'nullable|string',
            'unit_price' => 'nullable|string',
            'currency_rate' => 'nullable|string',
            'tp_php' => 'nullable|numeric',
            'item_group' => 'nullable|string',
            'uom' => 'nullable|string',
            'mandatory_peripherals' => 'nullable|string',
            'cost_of_peripherals' => 'nullable|numeric',
        ];
    }
}
