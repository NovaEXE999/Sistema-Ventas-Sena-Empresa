<?php

namespace App\Livewire\Users;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\User;

class Index extends Component
{
    use WithPagination;
    public function toggleStatus(User $user)
    {
        // 1 = Activo, 0 = Inactivo
        $user->status = ! $user->status;
        $user->save();

        $message = $user->status
            ? 'Usuario reactivado satisfactoriamente.'
            : 'Usuario inhabilitado satisfactoriamente.';

        session()->flash('success', $message);
        $this->redirectRoute('users.index', navigate: true);
    }
    public function render()
    {
        return view('livewire.users.index', [
            'users' => User::with('role')
                ->when(auth()->id(), fn ($query, $id) => $query->whereKeyNot($id))
                ->latest()
                ->paginate(10),
        ]);
    }
}
