<?php

namespace App\Livewire\Clients;

use Livewire\Attributes\Validate;
use Livewire\Component;
use App\Models\Client;
use App\Models\ClientType;

class Create extends Component
{

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

    public function mount(): void
    {
        $this->clientTypes = ClientType::where('status', true)->get(['id','name'])->toArray();
        $this->client_type_id = $this->clientTypes[0]['id'] ?? null;
    }

    public function save(){
        $this->validate();

        Client::create([
            'identification' => $this->identification,
            'name' => $this->name,
            'phone_number' => $this->phone_number,
            'status' => $this->status,
            'client_type_id' => $this->client_type_id,
        ]);

        session()->flash('success', 'Cliente creado satisfactoriamente.');
        $this->redirectRoute('clients.index', navigate:true);
    }

    public function render()
    {
        return view('livewire.clients.create');
    }
}
