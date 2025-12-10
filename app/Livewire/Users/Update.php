<?php

namespace App\Livewire\Users;

use App\Models\Role;
use App\Models\User;
use Illuminate\Validation\Rule;
use Livewire\Component;

class Update extends Component
{
    public User $user;

    public $identification = '';
    public $name = '';
    public $email = '';
    public $phone_number = '';
    public $role_id = '';

    public $roles = [];

    public function mount(User $user): void
    {
        $this->user = $user;

        $this->identification = $user->identification;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->phone_number = $user->phone_number;
        $this->role_id = $user->role_id;

        $this->roles = Role::query()
            ->where('status', true)
            ->orderBy('name')
            ->get(['id', 'name'])
            ->toArray();
    }

    public function updated(string $propertyName): void
    {
        $this->resetErrorBag($propertyName);
    }

    public function save(): void
    {
        $this->validate([
            'role_id' => [
                'required',
                'integer',
                Rule::exists('roles', 'id')->where('status', true),
            ],
        ], [
            'role_id.required' => __('El nombre del rol es requerido.'),
            'role_id.exists' => __('El rol seleccionado no es válido.'),
        ]);

        $this->user->update([
            'role_id' => $this->role_id,
        ]);

        session()->flash('success', __('Rol actualizado correctamente.'));
        $this->redirectRoute('users.index', navigate: true);
    }

    public function render()
    {
        return view('livewire.users.update');
    }
}
