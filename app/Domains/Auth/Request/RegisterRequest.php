<?php

namespace App\Domains\Auth\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255',

            'email' => 'required|email|max:255|unique:users,email',

            'password' => 'required|string|min:6|confirmed',

            'role' => 'nullable|in:admin,participant,volunteer',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'O nome é obrigatório',

            'email.required' => 'O email é obrigatório',
            'email.email' => 'Informe um email válido',
            'email.unique' => 'Este email já está em uso',

            'password.required' => 'A senha é obrigatória',
            'password.min' => 'A senha deve ter pelo menos 6 caracteres',
            'password.confirmed' => 'As senhas não conferem',
        ];
    }
}