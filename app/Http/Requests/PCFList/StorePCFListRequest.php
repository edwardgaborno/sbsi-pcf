<?php

namespace App\Http\Requests\PCFList;

use Illuminate\Foundation\Http\FormRequest;

class StorePCFListRequest extends FormRequest
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
            'pcf_no' => 'required|string',
            'source_id' => 'required',
            'description' => 'required|string',
            'quantity' => 'required|numeric',
            'sales' => 'required|numeric',
            'total_sales' => 'required|numeric',
            'opex' => 'nullable|numeric',
            'net_sales' => 'nullable|numeric',
            'gross_profit' => 'nullable|numeric',
            'total_gross_profit' => 'nullable|numeric',
            'total_net_sales' => 'nullable|numeric',
            'profit_rate' => 'nullable|numeric',
        ];
    }
}
