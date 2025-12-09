<?php

namespace App\Livewire\Clients;

use Livewire\Component;
use App\Models\Client;
use App\Models\ClientType;

class Create extends Component
{
    public bool $showIdentification = true;

    public $identification = '';
    public $name = '';
    public $phone_number = '';
    public $client_type_id = null;
    public bool $status = true;

    public array $clientTypes = [];

    public function mount(): void
    {
        $this->clientTypes = ClientType::where('status', true)->get(['id','name'])->toArray();
        $this->client_type_id = $this->clientTypes[0]['id'] ?? null;
    }

    protected function rules(): array
    {
        return [
            'identification' => ['required', 'digits_between:3,10', 'regex:/^[0-9]+$/'],
            'name' => ['required', 'max:255', 'regex:/^[\\p{L} ]+$/u'],
            'phone_number' => ['required', 'regex:/^3\\d{9}$/'],
            'client_type_id' => ['required', 'exists:client_types,id'],
        ];
    }

    protected function messages(): array
    {
        return [
            'identification.required' => 'La identificación es obligatoria (3 a 10 dígitos numéricos).',
            'identification.digits_between' => 'La identificación debe tener entre 3 y 10 dígitos.',
            'identification.regex' => 'La identificación solo puede contener números (3 a 10 dígitos).',
            'name.regex' => 'El nombre solo puede contener letras y espacios.',
            'phone_number.regex' => 'El teléfono debe iniciar en 3 y tener 10 dígitos.',
        ];
    }

    public function save(){
        $this->validate();

        Client::create([
            'identification' => $this->identification,
            'name' => $this->name,
            'phone_number' => $this->phone_number,
            'status' => true,
            'client_type_id' => $this->client_type_id,
        ]);

        session()->flash('success', 'Cliente creado satisfactoriamente.');
        $this->redirectRoute('clients.index', navigate:true);
    }

    public function render()
    {
        return view('livewire.clients.create', [
            'showIdentification' => $this->showIdentification,
        ]);
    }
}
