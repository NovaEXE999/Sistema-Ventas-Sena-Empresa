<?php

namespace App\Livewire\PersonTypes;

use Livewire\Component;
use Livewire\Attributes\Validate;
use App\Models\PersonType;
use Illuminate\Validation\Rule;

class Create extends Component
{
    public $name = '';

    protected function rules(): array
    {
        return [
            'name' => ['required', 'max:256', 'regex:/^[\\p{L} ]+$/u', Rule::unique('person_types', 'name')],
        ];
    }
    public function save(){
        $this->validate();

        PersonType::create([
            'name' => $this->name
        ]);

        session()->flash('success', 'Tipo de cliente creado satisfactoriamente.');
        $this->redirectRoute('persontypes.index', navigate:true);
    }

    public function render()
    {
        return view('livewire.person-types.create');
    }
}
