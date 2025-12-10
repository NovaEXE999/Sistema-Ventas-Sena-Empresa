<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input): User
    {
        Validator::make($input, [
            'identification' => [
                'required',
                'string',
                'regex:/^[0-9]{3,10}$/',
                Rule::unique(User::class, 'identification'),
            ],
            'name' => [
                'required',
                'string',
                'max:256',
                'regex:/^[A-Za-zÀ-ÿ ]{1,256}$/',
            ],
            'email' => [
                'required',
                'string',
                'email',
                'max:254',
                'regex:/^[A-Za-z0-9._%+-]+@(gmail\\.com|hotmail\\.com|msn\\.com|outlook\\.com|yahoo\\.com|yahoo\\.es|icloud\\.com|live\\.com)$/i',
                Rule::unique(User::class),
            ],
            'phone_number' => [
                'required',
                'string',
                'size:10',
                'regex:/^3[0-9]{9}$/',
            ],
            'role_id' => [
                'required',
                'integer',
                Rule::exists('roles', 'id')->where('status', true),
            ],
            'password' => $this->passwordRules(),
        ], [
            'identification.regex' => __('La identificación solo puede contener números (entre 3 y 10 dígitos).'),
            'name.regex' => __('El nombre solo puede contener letras y espacios (máximo 256 caracteres).'),
            'email.regex' => __('El correo debe ser de un dominio permitido: gmail.com, hotmail.com, msn.com, outlook.com, yahoo.com, yahoo.es, icloud.com o live.com.'),
            'phone_number.size' => __('El número de teléfono debe tener exactamente 10 dígitos.'),
            'phone_number.regex' => __('El número de teléfono debe iniciar con 3 y contener solo números.'),
            'role_id.required' => __('El nombre del rol es requerido.'),
            'role_id.exists' => __('El rol seleccionado no es válido.'),
        ])->validate();

        return User::create([
            'identification' => $input['identification'],
            'name' => $input['name'],
            'email' => $input['email'],
            'phone_number' => $input['phone_number'],
            'role_id' => $input['role_id'],
            'status' => true,
            'password' => $input['password'],
        ]);
    }
}
