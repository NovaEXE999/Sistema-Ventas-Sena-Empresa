<?php

namespace App\Livewire\Clients;

use Livewire\Attributes\Validate;
use Livewire\Component;
use App\Models\Client;

class Create extends Component
{

    #[Validate('required|string|max:255')]
    public $name = '';

    public function save(){
        $this->validate();

        Client::create([
            'name' => $this->name,
        ]);

        session()->flash('success', 'Cliente creado satisfactoriamente.');
        $this->redirectRoute('clients.index', navigate:true);
    }

    public function render()
    {
        return view('livewire.clients.create');
    }
}
