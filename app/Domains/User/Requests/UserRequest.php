<?php

namespace App\Domains\User\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $userId = $this->route('id'); // 👈 ajuste importante

        return [
            'name' => 'required|string|max:255',

            'email' => 'required|email|max:255|unique:users,email,' . $userId,

            'password' => $userId
                ? 'nullable|string|min:6'
                : 'required|string|min:6',

            'document' => 'nullable|string|max:20',

            'phone' => 'nullable|string|max:20',

            'birthday' => 'nullable|date',

            'role' => 'required|in:admin,user',
        ];
    }

    public function messages(): array
    {
        return [
            'email.unique' => 'Este e-mail já está cadastrado.',
            'password.confirmed' => 'A confirmação de senha não confere.',
        ];
    }
}