<?php

namespace App\Livewire\Providers;

use Livewire\Component;
use Livewire\Attributes\Validate;
use App\Models\Provider;

class Create extends Component
{
    #[Validate('required|string|max:255')]
    public $name = '';

    public function save(){
        $this->validate();

        Provider::create([
            'name' => $this->name, 
        ]);

        session()->flash('success', 'Proveedor creado satisfactoriamente.');
        $this->redirectRoute('providers.index', navigate:true);
    }

    public function render()
    {
        return view('livewire.providers.create');
    }
}
