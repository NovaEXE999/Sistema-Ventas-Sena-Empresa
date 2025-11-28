<?php

namespace App\Livewire\Clients;

use App\Models\Client;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public function delete(Client $client)
    {
        $client->delete();

        session()->flash('success', 'Cliente eliminado satisfactoriamente.');
        $this->redirectRoute('clients.index', navigate: true);
    }
    public function render()
    {
        return view('livewire.clients.index', [
            'clients' => Client::latest()->paginate(10),
        ]);
    }
}
