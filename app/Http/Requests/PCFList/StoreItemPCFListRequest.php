<?php

namespace App\Http\Requests\PCFList;

use Illuminate\Foundation\Http\FormRequest;

class StoreItemPCFListRequest extends FormRequest
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
            'pcf_no' => 'required|numeric',
            'item_code' => 'required|string',
            'description' => 'required|string',
            'quantity' => 'required|numeric',
            'sales' => 'required|string',
            'total_sales' => 'required|string',
            'transfer_price' => 'nullable|string',
            'mandatory_peripherals' => 'nullable|string',
            'opex' => 'nullable|string',
            'net_sales' => 'nullable|string',
            'gross_profit' => 'nullable|string',
            'total_gross_profit' => 'nullable|string',
            'total_net_sales' => 'nullable|string',
            'profit_rate' => 'nullable|string',
        ];
    }
}
