<?php

namespace App\Livewire\Users;

use App\Actions\Fortify\CreateNewUser;
use App\Models\Role;
use Illuminate\Validation\ValidationException;
use Livewire\Component;

class Create extends Component
{
    public $identification = '';
    public $name = '';
    public $email = '';
    public $phone_number = '';
    public $role_id = '';
    public $password = '';
    public $password_confirmation = '';

    public $roles = [];

    public function mount(): void
    {
        $this->roles = Role::query()
            ->where('status', true)
            ->orderBy('name')
            ->get(['id', 'name'])
            ->toArray();
    }

    public function updated(string $propertyName): void
    {
        // Clear error for the field as soon as it changes
        $this->resetErrorBag($propertyName);
    }

    public function save(CreateNewUser $creator)
    {
        try {
            $creator->create($this->only([
                'identification',
                'name',
                'email',
                'phone_number',
                'role_id',
                'password',
                'password_confirmation',
            ]));
        } catch (ValidationException $e) {
            $this->setErrorBag($e->validator->getMessageBag());
            return;
        }

        session()->flash('success', 'Usuario creado correctamente.');
        $this->redirectRoute('users.index', navigate: true);
    }

    public function render()
    {
        return view('livewire.users.create');
    }
}
