<?php

namespace App\Livewire\Providers;

use Livewire\Attributes\Validate;
use Livewire\Component;
use App\Models\Provider;
use App\Models\PersonType;


class Update extends Component
{
    public ?Provider $provider;

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


    public function mount(Provider $provider){
        $this->personTypes = PersonType::where('status', true)->get(['id','name'])->toArray();
        $this->setProvider($provider);
    }

    public function setProvider(Provider $provider){
        $this->provider = $provider;
        $this->identification = $provider->identification;
        $this->name = $provider->name;
        $this->phone_number = $provider->phone_number;
        $this->status = (bool) $provider->status;
        $this->person_type_id = $provider->person_type_id;
    }

    public function update(){
        if (! auth()->user()?->isAdmin()) {
            abort(403);
        }

        $this->validate();
        
        $this->provider->update([
            'identification' => $this->identification,
            'name' => $this->name,
            'phone_number' => $this->phone_number,
            'status' => $this->status,
            'person_type_id' => $this->person_type_id,
        ]);
    }
    
    public function save(){
        $this->update();

        session()->flash('success', 'Proveedor actualizado satisfactoriamente.');
        $this->redirectRoute('providers.index', navigate:true);
    }

    public function render()    
    {
        return view('livewire.providers.create');
    }
}
