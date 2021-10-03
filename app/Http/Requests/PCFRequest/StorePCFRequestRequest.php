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
            'date' => 'required|date',
            'institution' => 'required|string',
            'address' => 'nullable|string',
            'contact_person' => 'required|string',
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

    public function messages()
    {
        return [
            'pcf_no.required' => 'This is a required field.',
            'date.required' => 'This is a required field.',
            'contact_person.required' => 'This is a required field.',
            'institution.required' => 'This is a required field.',
            'supplier.required' => 'This is a required field.',
            'terms.required' => 'This is a required field.',
            'validity.required' => 'This is a required field.',
            'delivery.required' => 'This is a required field.',
            'contract_duration.required' => 'This is a required field.',
            'date_bidding.required' => 'This is a required field.',
            'bid_docs_price.required' => 'This is a required field.',
            'manager.required' => 'This is a required field.',
            'annual_profit.required' => 'This is a required field.',
            'annual_profit_rate.required' => 'This is a required field.',
        ];
    }
}
