<?php

namespace App\Livewire\Clients;

use App\Models\Client;
use Livewire\Attributes\Validate;
use Livewire\Component;
use App\Models\Clients;

class Update extends Component
{
    public ?Client $client;

    #[Validate('required|string|max:255')]
    public $name = '';


    public function mount(Client $client)
    {
        $this->setClient($client);
    }

    public function setClient (Client $client){
        $this->client = $client;
        $this->name = $client->name;
    }

    public function update()
    {
        $this->validate();
        
        $this->client->update($this->all());
    }

     public function save()
    {
        $this->update();

        session()->flash('success', 'Cliente actualizado correctamente.');
        $this->redirectRoute('clients.index', navigate:true);
    }

    public function render()
    {
        return view('livewire.clients.create');
    }
}
