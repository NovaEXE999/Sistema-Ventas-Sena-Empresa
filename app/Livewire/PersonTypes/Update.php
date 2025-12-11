<?php

namespace App\Livewire\PersonTypes;

use Livewire\Component;
use Illuminate\Validation\Rule;
use App\Models\PersonType;
use Livewire\Attributes\Validate;

class Update extends Component
{
    public ?PersonType $persontype;

    public $name = '';

    protected function rules(): array
    {
        return [
            'name' => [
                'required',
                'max:256',
                'regex:/^[\\p{L} ]+$/u',
                Rule::unique('person_types', 'name')->ignore($this->persontype?->id),
            ],
        ];
    }

    public function mount(PersonType $persontype): void
    {
        $this->setType($persontype);
    }

    public function setType(PersonType $persontype): void
    {
        $this->persontype = $persontype;
        $this->name = $persontype->name;
    }

    public function update(): void
    {
        $this->validate();

        $this->persontype?->update([
            'name' => $this->name,
        ]);
    }

    public function save(): void
    {
        $this->update();

        session()->flash('success', 'Tipo de persona actualizada correctamente.');
        $this->redirectRoute('persontypes.index', navigate: true);
    }


    public function render()
    {
        return view('livewire.person-types.create');
    }
}
