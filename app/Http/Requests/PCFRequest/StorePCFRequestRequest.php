<?php

namespace App\Http\Requests\PCFRequest;

use Illuminate\Foundation\Http\FormRequest;

class StorePCFRequestRequest extends FormRequest
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
            'supplier' => 'required|string',
            'terms' => 'required|string',
            'validity' => 'required|string',
            'delivery' => 'required|string',
            'warranty' => 'nullable|string',
            'contract_duration' => 'sometimes|nullable|string',
            'date_bidding' => 'sometimes|nullable|date',
            'bid_docs_price' => 'sometimes|nullable|numeric',
            'manager' => 'required|string',
            'annual_profit' => 'required|numeric',
            'annual_profit_rate' => 'required|numeric',
            'contact_person' => 'required|string',
            'designation' => 'required|string',
            'thru_contact_person' => 'nullable|string',
            'thru_designation' => 'nullable|string',
        ];
    }

    public function messages()
    {
        return [
            'pcf_no.required' => 'This is a required field.',
            'rfq-no.required' => 'This is a required field.',
            'supplier.required' => 'This is a required field.',
            'terms.required' => 'This is a required field.',
            'validity.required' => 'This is a required field.',
            'delivery.required' => 'This is a required field.',
            'manager.required' => 'This is a required field.',
            'annual_profit.required' => 'This is a required field.',
            'annual_profit_rate.required' => 'This is a required field.',
            'contact_person.required' => 'This is a required field.',
            'designation.required' => 'This is a required field.',
        ];
    }
}
