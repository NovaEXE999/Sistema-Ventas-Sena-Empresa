<?php

namespace App\Livewire\ClientTypes;

use App\Models\ClientType;
use Livewire\Attributes\Validate;
use Livewire\Component;

class Update extends Component
{
    public ?ClientType $clienttype;

    #[Validate('required|string|max:200|regex:/^[\\pL\\s]+$/u')]
    public $name = '';

    public function mount(ClientType $clienttype): void
    {
        $this->setType($clienttype);
    }

    public function setType(ClientType $clienttype): void
    {
        $this->clienttype = $clienttype;
        $this->name = $clienttype->name;
    }

    public function update(): void
    {
        $this->validate();

        $this->clienttype?->update([
            'name' => $this->name,
        ]);
    }

    public function save(): void
    {
        $this->update();

        session()->flash('success', 'Tipo de cliente actualizado correctamente.');
        $this->redirectRoute('clienttypes.index', navigate: true);
    }

    public function render()
    {
        return view('livewire.client-types.create');
    }
}
