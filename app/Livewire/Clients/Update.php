<?php

namespace App\Livewire\Clients;

use App\Models\Client;
use Livewire\Component;
use App\Models\ClientType;

class Update extends Component
{
    public ?Client $client;
    public bool $showIdentification = false;

    public $identification = '';
    public $name = '';
    public $phone_number = '';
    public $status = true;
    public $client_type_id = null;

    public array $clientTypes = [];


    public function mount(Client $client)
    {
        $this->clientTypes = ClientType::where('status', true)->get(['id','name'])->toArray();
        $this->setClient($client);
        $this->showIdentification = auth()->user()?->isAdmin() ?? false;
    }

    public function setClient (Client $client){
        $this->client = $client;
        $this->identification = $client->identification;
        $this->name = $client->name;
        $this->phone_number = $client->phone_number;
        $this->status = (bool) $client->status;
        $this->client_type_id = $client->client_type_id;
    }

    protected function rules(): array
    {
        $isAdmin = auth()->user()?->isAdmin() ?? false;

        $rules = [
            'name' => ['required', 'max:255', 'regex:/^[\\p{L} ]+$/u'],
            'phone_number' => ['required', 'regex:/^3\\d{9}$/'],
        ];

        if ($isAdmin) {
            $rules['status'] = 'boolean';
            $rules['client_type_id'] = 'required|exists:client_types,id';
        } else {
            $rules['status'] = 'prohibited';
            $rules['client_type_id'] = 'prohibited';
        }

        return $rules;
    }

    protected function messages(): array
    {
        return [
            'name.regex' => 'El nombre solo puede contener letras y espacios.',
            'phone_number.regex' => 'El teléfono debe iniciar en 3 y tener 10 dígitos.',
        ];
    }

    public function update()
    {
        $data = $this->validate();

        $payload = [
            'name' => $this->name,
            'phone_number' => $this->phone_number,
        ];

        if (auth()->user()?->isAdmin()) {
            $payload['status'] = (bool) $this->status;
            $payload['client_type_id'] = $this->client_type_id;
        }

        $this->client->update($payload);
    }

     public function save()
    {
        $this->update();

        session()->flash('success', 'Cliente actualizado correctamente.');
        $this->redirectRoute('clients.index', navigate:true);
    }

    public function render()
    {
        return view('livewire.clients.create', [
            'showIdentification' => $this->showIdentification,
        ]);
    }
}
