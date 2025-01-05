<?php

namespace Modules\Auth\Requests;

use Modules\CustomRequest;

class RegisterRequest extends CustomRequest
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
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email', 'regex:/^[a-zA-Z0-9._%+-]+@pelitabangsa\.ac\.id$/'],
            'password' => 'required|min:6',
        ];
    }

    public function messages()
    {
        return [
            'email.regex' => 'Email harus menggunakan domain pelitabangsa.ac.id',
        ];
    }
}
