<?php

namespace App\Http\Requests\BundleProduct;

use Illuminate\Foundation\Http\FormRequest;

class StoreBundleProductsRequest extends FormRequest
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
            'source_id' => 'required',
            'quantity' => 'required|numeric',
        ];
    }

    public function messages()
    {
        return [
            'source_id.required' => 'This is a required field.',
            'quantity.required' => 'This is a required field.',
        ];
    }
}
