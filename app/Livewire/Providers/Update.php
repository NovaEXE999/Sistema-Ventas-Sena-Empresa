<?php

namespace App\Livewire\Providers;

use Livewire\Component;
use App\Models\Provider;
use App\Models\PersonType;

class Update extends Component
{
    public ?Provider $provider;

    public $identification = '';
    public $name = '';
    public $phone_number = '';
    public $status = true;
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

    protected function rules(): array
    {
        return [
            'identification' => ['required', 'digits_between:3,10', 'regex:/^[0-9]+$/'],
            'name' => ['required', 'max:255', 'regex:/^[\\p{L} ]+$/u'],
            'phone_number' => ['required', 'regex:/^3\\d{9}$/'],
            'status' => ['boolean'],
            'person_type_id' => ['required', 'exists:person_types,id'],
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

    public function update(){
        if (! auth()->user()?->isAdmin()) {
            abort(403);
        }

        $this->validate();
        
        $this->provider->update([
            'identification' => $this->identification,
            'name' => $this->name,
            'phone_number' => $this->phone_number,
            'status' => (bool) $this->status,
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
