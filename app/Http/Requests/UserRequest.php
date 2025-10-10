<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'string', 'min:4'],
        ];
        if ($this->routeIs('signup.post')) {
            $rules['is_admin_user'] = ['in:0']; 
        }
        if ($this->routeIs('backend.system-user.store')) {
            $rules['is_admin_user'] = ['in:1']; 
        }
        return $rules;
    }
}
