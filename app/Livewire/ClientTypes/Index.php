<?php

namespace App\Livewire\ClientTypes;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\ClientType;

class Index extends Component
{
    use WithPagination;
    public function toggleStatus(ClientType $clienttype)
    {
        if (! auth()->user()?->isAdmin()) {
            abort(403);
        }

        // 1 = Activo, 0 = Inactivo
        $clienttype->status = ! $clienttype->status;
        $clienttype->save();

        $message = $clienttype->status
            ? 'Tipo de cliente reactivado satisfactoriamente.'
            : 'Tipo de cliente inhabilitado satisfactoriamente.';

        session()->flash('success', $message);
        $this->redirectRoute('clienttypes.index', navigate: true);
    }

    public function render()
    {
        return view('livewire.client-types.index',[
            'clienttypes'=> ClientType::latest()->paginate(10),
        ]);
    }
}
