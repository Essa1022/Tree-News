<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
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
        return [
            'username_or_phone_number' => 'required|string',
            'password' => 'required|string',
            'remember_me' => 'nullable|boolean'
        ];
    }

    public function attributes(): array
    {
        return [
            'username_or_phone_number' => 'نام کاربری یا شماره همراه',
            'password' => 'رمز عبور'
        ];
    }
}