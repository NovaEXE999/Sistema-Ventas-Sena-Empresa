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
            'identification' => ['required', 'digits_between:3,10', 'regex:/^[0-9]+$/', Rule::unique('providers', 'identification')],
            'name' => ['required', 'max:256', 'regex:/^[\\p{L}\\d\\s\\.]+$/u'],
            'phone_number' => ['required', 'digits:10', 'regex:/^3\\d{9}$/', Rule::unique('providers', 'phone_number')],
            'person_type_id' => ['required', 'exists:person_types,id'],
        ];
    }

    protected function messages(): array
    {
        return [
            'identification.required' => 'La identificación es obligatoria (3 a 10 dígitos numéricos).',
            'identification.digits_between' => 'La identificación debe tener entre 3 y 10 dígitos.',
            'identification.regex' => 'La identificación solo puede contener números (3 a 10 dígitos).',
            'identification.unique' => 'Esta identificación ya está registrada.',
            'name.regex' => 'El nombre solo puede contener letras, espacios y puntos.',
            'phone_number.regex' => 'El teléfono debe iniciar en 3 y tener 10 dígitos.',
            'phone_number.digits' => 'El teléfono debe tener exactamente 10 dígitos.',
            'phone_number.unique' => 'Este teléfono ya está registrada.',
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
