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
            'rfq_no' => 'required|string',
            'source_id' => 'required',
            'product_segment_id' => 'required',
            'quantity' => 'required|numeric',
            'sales' => 'required|numeric',
            'total_sales' => 'required|numeric',
            'opex' => 'nullable|numeric',
            'net_sales' => 'nullable|numeric',
            'gross_profit' => 'nullable|numeric',
            'total_gross_profit' => 'nullable|numeric',
            'total_net_sales' => 'nullable|numeric',
            'profit_rate' => 'nullable|numeric',
            'p_c_f_request_id' => 'nullable|numeric'
        ];
    }

    public function messages()
    {
        return [
            'pcf_no.required' => 'This is a required field.',
            'source_id.required' => 'This is a required field.',
            'product_segment_id.required' => 'This is a required field.',
            'quantity.required' => 'This is a required field.',
            'sales.required' => 'This is a required field.',
            'total_sales.required' => 'This is a required field.',
        ];
    }
}
