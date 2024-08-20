<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            'username' => ['required','max:191','unique:users'],
            'name' => ['required','string','max:191'],
            'phone' => ['required','string','max:191','unique:users'],
            'email' => ['required','string','email','max:191','unique:users'],
            'password' => ['required','string','min:8','confirmed'],
        ];
    }
    public function messages()
    {
        return [
            'username.required' => 'Username is required!',
            'username.unique' => 'Username is already taken!',
            'name.required' => 'Name is required!',
            'phone.required' => 'Phone number is required!',
            'phone.unique' => 'Phone number is already taken!',
            'email.required' => 'Email is required!',
            'email.unique' => 'Email is already taken!',
            'password.required' => 'Password is required!',
            'password.min' => 'Password must be at least 8 characters!',
            'password.confirmed' => 'Password confirmation does not match!',
        ];
    }
}
