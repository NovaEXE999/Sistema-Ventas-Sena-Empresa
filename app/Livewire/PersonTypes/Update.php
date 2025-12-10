<?php

namespace App\Livewire\PersonTypes;

use Livewire\Component;
use App\Models\PersonType;
use Livewire\Attributes\Validate;

class Update extends Component
{
    public ?PersonType $persontype;

    #[Validate('required|string|max:256|regex:/^[\\pL\\s]+$/u')]
    public $name = '';

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
