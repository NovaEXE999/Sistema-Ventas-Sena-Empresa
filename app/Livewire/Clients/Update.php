<?php

namespace App\Livewire\Clients;

use App\Models\Client;
use Livewire\Attributes\Validate;
use Livewire\Component;
use App\Models\ClientType;

class Update extends Component
{
    public ?Client $client;

    #[Validate('required|string|max:10')]
    public $identification = '';
    #[Validate('required|string|max:255')]
    public $name = '';
    #[Validate('required|string|max:20')]
    public $phone_number = '';
    #[Validate('boolean')]
    public $status = true;
    #[Validate('required|exists:client_types,id')]
    public $client_type_id = null;

    public array $clientTypes = [];


    public function mount(Client $client)
    {
        $this->clientTypes = ClientType::where('status', true)->get(['id','name'])->toArray();
        $this->setClient($client);
    }

    public function setClient (Client $client){
        $this->client = $client;
        $this->identification = $client->identification;
        $this->name = $client->name;
        $this->phone_number = $client->phone_number;
        $this->status = (bool) $client->status;
        $this->client_type_id = $client->client_type_id;
    }

    public function update()
    {
        $this->validate();
        
        $this->client->update([
            'identification' => $this->identification,
            'name' => $this->name,
            'phone_number' => $this->phone_number,
            'status' => $this->status,
            'client_type_id' => $this->client_type_id,
        ]);
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
