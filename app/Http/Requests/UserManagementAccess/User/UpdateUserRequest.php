<?php

namespace App\Http\Requests\UserManagementAccess\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
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
            // use email:rfc,dns to check if the user's email is real email address, otherwise use email:rfc
            'email' => [
                'required',
                'email:rfc,dns',
                'string',
                'max:255',
                Rule::unique('users')->ignore($this->user_id)
            ],
            'password' => [
                'sometimes',
                'nullable',
                'confirmed', 
                Password::min(8)
                //        ->letters()
                //        ->mixedCase()
                //        ->numbers()
                //        ->symbols()
                        ->uncompromised(3)
            ],
            'role' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'This is a required field.',
            'email.required' => 'This is a required field.',
            'role.required' => 'This is a required field.',
        ];
    }
}
