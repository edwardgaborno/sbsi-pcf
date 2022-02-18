<?php

namespace App\Http\Requests\UserManagementAccess\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class StoreUserRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            // use email:rfc,dns to check if the user's email is real email address
            'email' => 'required|email:rfc,dns|string|max:255|unique:users',
            'password' => [
                'required', 
                'confirmed', 
                Password::min(8)
                //        ->letters()
                //        ->mixedCase()
                //        ->numbers()
                //        ->symbols()
                        ->uncompromised(3)
            ],
            'role' => 'required',
            'department_id' => 'required|numeric'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'This is a required field.',
            'email.required' => 'This is a required field.',
            'password.required' => 'This is a required field.',
            'role.required' => 'This is a required field.',
            'department_id.required' => 'This is a required field'
        ];
    }
}
