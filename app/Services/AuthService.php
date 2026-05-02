<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;

class AuthService
{
    /**
     * Registra um novo usuário aplicando política de senha.
     *
     * Requisitos da senha:
     * - Mínimo de 10 caracteres
     * - Letras maiúsculas e minúsculas
     * - Pelo menos um número
     * - Pelo menos um símbolo especial
     *
     * @throws ValidationException
     */
    public function registrar(array $dados): array
    {
        $validator = Validator::make($dados, [
            'name'                  => ['required', 'string', 'max:255'],
            'email'                 => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password'              => [
                'required',
                'confirmed',
                Password::min(10)
                    ->mixedCase()
                    ->numbers()
                    ->symbols(),
            ],
        ], [
            'password.min'       => 'A senha deve ter no mínimo 10 caracteres.',
            'password.mixed'     => 'A senha deve conter letras maiúsculas e minúsculas.',
            'password.numbers'   => 'A senha deve conter pelo menos um número.',
            'password.symbols'   => 'A senha deve conter pelo menos um símbolo especial.',
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        $user = User::create([
            'name'     => $dados['name'],
            'email'    => $dados['email'],
            'password' => Hash::make($dados['password']),
        ]);

        return [
            'user'  => $user,
            'token' => $user->createToken('auth_token')->plainTextToken,
        ];
    }
}
