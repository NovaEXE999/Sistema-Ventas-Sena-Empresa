<?php

namespace App\Livewire\PersonTypes;

use Livewire\Component;
use Livewire\Attributes\Validate;
use App\Models\PersonType;

class Create extends Component
{
    #[Validate('required|string|max:256|regex:/^[\\pL\\s]+$/u')]
    public $name = '';

    public function save(){
        $this->validate();

        PersonType::create([
            'name' => $this->name
        ]);

        session()->flash('success', 'Tipo de cliente creado satisfactoriamente.');
        $this->redirectRoute('persontypes.index', navigate:true);
    }

    public function render()
    {
        return view('livewire.person-types.create');
    }
}
