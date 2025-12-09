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
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
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
            'phone_number.size' => __('El número de teléfono debe tener exactamente 10 dígitos.'),
            'phone_number.regex' => __('El número de teléfono debe iniciar con 3 y contener solo números.'),
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
