<?php

namespace App\Livewire\Clients;

use Livewire\Attributes\Validate;
use Livewire\Component;
use App\Models\Client;

class Create extends Component
{

    #[Validate('required|string|max:255')]
    public $first_name = '';
    #[Validate('nullable|string|max:255')]
    public $middle_name = '';
    #[Validate('required|string|max:255')]
    public $last_name='';
    #[Validate('nullable|string|max:255')]
    public $second_last_name = '';

    public function save(){
        $this->validate();

        Client::create([
            'first_name' => $this->first_name,
            'middle_name' => $this->middle_name,
            'last_name' => $this->last_name,
            'second_last_name' => $this->second_last_name,
        ]);

        session()->flash('success', 'Cliente creado satisfactoriamente.');
        $this->redirectRoute('clients.index', navigate:true);
    }

    public function render()
    {
        return view('livewire.clients.create');
    }
}
