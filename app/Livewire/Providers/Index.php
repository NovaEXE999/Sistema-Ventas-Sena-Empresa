<?php

namespace App\Livewire\Providers;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Provider;

class Index extends Component
{
    use WithPagination;

    public function toggleStatus(Provider $provider)
    {
        $provider->status = ! $provider->status;
        $provider->save();


        $message = $provider->status
            ? 'Proveedor reactivado satisfactoriamente.'
            : 'Proveedor inhabilitado satisfactoriamente.';

        session()->flash('success', $message);
        $this->redirectRoute('providers.index', navigate: true);
    }

    public function render()
    {
        return view('livewire.providers.index', [
            'providers' => Provider::latest()->paginate(10),
        ]);
    }
}
