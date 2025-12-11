<?php

namespace App\Livewire\ClientTypes;

use App\Models\ClientType;
use Livewire\Attributes\Validate;
use Illuminate\Validation\Rule;
use Livewire\Component;

class Update extends Component
{
    public ?ClientType $clienttype;

    public $name = '';

    protected function rules(): array
    {
        return [
            'name' => [
                'required',
                'max:256',
                'regex:/^[\\p{L} ]+$/u',
                Rule::unique('client_types', 'name')->ignore($this->clienttype?->id),
            ],
        ];
    }
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
