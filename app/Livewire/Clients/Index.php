<?php

namespace App\Livewire\Clients;

use App\Models\Client;
use App\Models\ClientType;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public string $order = 'created_desc';
    public string $status = 'all';
    public string $clientType = 'all';
    public string $search = '';
    public array $clientTypes = [];

    public function mount(): void
    {
        $this->clientTypes = ClientType::where('status', true)
            ->orderBy('name')
            ->get(['id', 'name'])
            ->toArray();
    }

    public function updated($propertyName): void
    {
        if (in_array($propertyName, ['order', 'status', 'clientType', 'search'], true)) {
            $this->resetPage();
        }
    }

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
        $clientsQuery = Client::with(['clienttype']);

        if ($this->clientType !== 'all') {
            $clientsQuery->where('client_type_id', $this->clientType);
        }

        if ($this->status !== 'all') {
            $clientsQuery->where('status', $this->status === 'active');
        }

        if (trim($this->search) !== '') {
            $term = trim($this->search);
            $clientsQuery->where(function ($query) use ($term) {
                $query->where('name', 'like', "%{$term}%")
                    ->orWhere('identification', 'like', "%{$term}%");
            });
        }

        switch ($this->order) {
            case 'created_asc':
                $clientsQuery->orderBy('created_at', 'asc')->orderBy('id', 'asc');
                break;
            case 'name_asc':
                $clientsQuery->orderBy('name', 'asc')->orderBy('id', 'asc');
                break;
            default:
                $clientsQuery->orderBy('created_at', 'desc')->orderBy('id', 'desc');
                break;
        }

        return view('livewire.clients.index', [
            'clients' => $clientsQuery->paginate(10),
            'clientTypes' => $this->clientTypes,
        ]);
    }
}
