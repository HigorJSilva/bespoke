<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required',
            'email' => ['required','email', 'unique:users'],
            'password' => ['required', 'confirmed'],
            'password_confirmation' => 'required',
        ];
    }
}
