<?php

namespace App\Livewire\Providers;

use Livewire\Component;
use Livewire\Attributes\Validate;
use App\Models\Provider;
use App\Models\PersonType;

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
    #[Validate('required|exists:person_types,id')]
    public $person_type_id = null;

    public array $personTypes = [];

    public function mount(): void
    {
        $this->personTypes = PersonType::where('status', true)->get(['id','name'])->toArray();
        $this->person_type_id = $this->personTypes[0]['id'] ?? null;
    }

    public function save(){
        $this->validate();

        Provider::create([
            'identification' => $this->identification,
            'name' => $this->name, 
            'phone_number' => $this->phone_number,
            'status' => $this->status,
            'person_type_id' => $this->person_type_id,
        ]);

        session()->flash('success', 'Proveedor creado satisfactoriamente.');
        $this->redirectRoute('providers.index', navigate:true);
    }

    public function render()
    {
        return view('livewire.providers.create');
    }
}
