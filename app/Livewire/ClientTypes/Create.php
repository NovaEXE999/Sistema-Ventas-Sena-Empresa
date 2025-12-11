<?php

namespace App\Livewire\ClientTypes;

use Livewire\Attributes\Validate;
use Illuminate\Validation\Rule;
use Livewire\Component;
use App\Models\ClientType;

class Create extends Component
{
    public $name = '';

    protected function rules(): array
    {
        return [
            'name' => ['required', 'max:256', 'regex:/^[\\p{L} ]+$/u', Rule::unique('client_types', 'name')],
        ];
    }
    public function save(){
        $this->validate();

        ClientType::create([
            'name' => $this->name
        ]);

        session()->flash('success', 'Tipo de cliente creado satisfactoriamente.');
        $this->redirectRoute('clienttypes.index', navigate:true);
    }

    public function render()
    {
        return view('livewire.client-types.create');
    }
}
