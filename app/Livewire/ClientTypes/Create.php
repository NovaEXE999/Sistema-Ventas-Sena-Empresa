<?php

namespace App\Livewire\ClientTypes;

use Livewire\Attributes\Validate;
use Livewire\Component;
use App\Models\ClientType;

class Create extends Component
{
    #[Validate('required|string|max:256|regex:/^[\\pL\\s]+$/u')]
    public $name = '';

    public function save(){
        $this->validate();

        ClientType::create([
            'name' => $this->name
        ]);

        session()->flash('success', 'Tipo de cliente creado satisfactoriamente.');
        $this->redirectRoute('clienttypes.index', navigate:true);
    }

    public function render()
    {
        return view('livewire.client-types.create');
    }
}
