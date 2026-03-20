<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Jetstream\Jetstream;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    public function create(array $input): User
    {
        Validator::make($input, [
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => $this->passwordRules(),
            'terms'    => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['accepted', 'required'] : '',
            'role'     => ['nullable', 'string', 'in:admin,cidadao'],
        ])->validate();

        // Se tenta criar um admin, verifica se quem está autenticado é admin
        if (!empty($input['role']) && $input['role'] === 'admin') {
            if (!auth()->check() || !auth()->user()->hasRole('admin')) {
                abort(403, 'Apenas administradores podem criar outros administradores.');
            }
        }

        $user = User::create([
            'name'     => $input['name'],
            'email'    => $input['email'],
            'password' => Hash::make($input['password']),
        ]);

        // Se não foi passado role, ou não é admin a criar, atribui 'cidadao'
        $role = (!empty($input['role']) && auth()->check() && auth()->user()->hasRole('admin'))
            ? $input['role']
            : 'cidadao';

        $user->assignRole($role);

        return $user;
    }
}