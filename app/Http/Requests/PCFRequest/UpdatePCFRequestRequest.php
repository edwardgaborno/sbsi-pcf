<?php

namespace App\Http\Requests\PCFRequest;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePCFRequestRequest extends FormRequest
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
            'date' => 'required|date',
            'institution' => 'nullable|string',
            'address' => 'nullable|string',
            'contact_person' => 'nullable|string',
            'designation' => 'nullable|string',
            'thru_designation' => 'nullable|string',
            'supplier' => 'required|string',
            'terms' => 'required|string',
            'validity' => 'required|string',
            'delivery' => 'required|string',
            'warranty' => 'nullable|string',
            'contract_duration' => 'required|string',
            'date_bidding' => 'required|date',
            'bid_docs_price' => 'required|numeric',
            'manager' => 'required|string',
            'annual_profit' => 'required|numeric',
            'annual_profit_rate' => 'required|numeric'
        ];
    }
}
