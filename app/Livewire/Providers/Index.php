<?php

namespace App\Livewire\Providers;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Provider;

class Index extends Component
{
    use WithPagination;

    public function delete(Provider $provider)
    {
        $provider->delete();

        session()->flash('success', 'Proveedor eliminado satisfactoriamente.');
        $this->redirectRoute('providers.index', navigate: true);
    }

    public function render()
    {
        return view('livewire.providers.index', [
            'providers' => Provider::latest()->paginate(10),
        ]);
    }
}
