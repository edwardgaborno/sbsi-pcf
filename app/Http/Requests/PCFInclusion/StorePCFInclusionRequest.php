<?php

namespace App\Http\Requests\PCFInclusion;

use Illuminate\Foundation\Http\FormRequest;

class StorePCFInclusionRequest extends FormRequest
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
            'pcf_no' => 'required',
            'source_id' => 'required',
            'serial_no' => 'required|string',
            'type' => 'required|string',
            'quantity' => 'required|numeric',
            'opex' => 'sometimes|nullable|numeric',
            'total_cost' => 'sometimes|nullable|numeric',
            'depreciable_life' => 'sometimes|nullable|numeric',
            'cost_year' => 'sometimes|nullable|numeric'
        ];
    }
}
