<?php

namespace App\Livewire\PersonTypes;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\PersonType;

class Index extends Component
{
    use WithPagination;
    public function toggleStatus(PersonType $persontype)
    {
        // 1 = Activo, 0 = Inactivo
        $persontype->status = ! $persontype->status;
        $persontype->save();

        $message = $persontype->status
            ? 'Tipo de persona reactivado satisfactoriamente.'
            : 'Tipo de persona inhabilitado satisfactoriamente.';

        session()->flash('success', $message);
        $this->redirectRoute('persontypes.index', navigate: true);
    }

    public function render()
    {
        return view('livewire.person-types.index', [
            'persontypes'=> PersonType::latest()->paginate(10),
        ]);
    }
}
