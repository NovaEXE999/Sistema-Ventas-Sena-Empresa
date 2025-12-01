<?php

namespace App\Livewire\Clients;

use App\Models\Client;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public function toggleStatus(Client $client)
    {
        // 1 = Activo, 0 = Inactivo
        $client->status = ! $client->status;
        $client->save();

        $message = $client->status
            ? 'Cliente reactivado satisfactoriamente.'
            : 'Cliente inhabilitado satisfactoriamente.';

        session()->flash('success', $message);
        $this->redirectRoute('clients.index', navigate: true);
    }
    public function render()
    {
        return view('livewire.clients.index', [
            'clients' => Client::latest()->paginate(10),
        ]);
    }
}
