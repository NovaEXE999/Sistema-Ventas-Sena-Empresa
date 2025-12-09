<?php

namespace App\Livewire\Providers;

use Livewire\Component;
use App\Models\Provider;
use App\Models\PersonType;
use Illuminate\Validation\Rule;

class Create extends Component
{
    public $identification = '';
    public $name = '';
    public $phone_number = '';
    public bool $status = true;
    public $person_type_id = null;

    public array $personTypes = [];

    public function mount(): void
    {
        $this->personTypes = PersonType::where('status', true)->get(['id','name'])->toArray();
        $this->person_type_id = $this->personTypes[0]['id'] ?? null;
    }

    protected function rules(): array
    {
        return [
            'identification' => ['required', 'digits_between:3,10', 'regex:/^[0-9]+$/'],
            'name' => ['required', 'max:255', 'regex:/^[\\p{L} ]+$/u'],
            'phone_number' => ['required', 'regex:/^3\\d{9}$/'],
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

    public function save(){
        if (! auth()->user()?->isAdmin()) {
            abort(403);
        }

        $this->validate();

        Provider::create([
            'identification' => $this->identification,
            'name' => $this->name, 
            'phone_number' => $this->phone_number,
            'status' => true,
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
