<?php

namespace App\Livewire\Providers;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Provider;
use App\Models\PersonType;

class Index extends Component
{
    use WithPagination;

    public string $order = 'created_desc';
    public string $status = 'all';
    public string $personType = 'all';
    public string $search = '';
    public array $personTypes = [];

    public function mount(): void
    {
        $this->personTypes = PersonType::where('status', true)
            ->orderBy('name')
            ->get(['id', 'name'])
            ->toArray();
    }

    public function updated($propertyName): void
    {
        if (in_array($propertyName, ['order', 'status', 'personType', 'search'], true)) {
            $this->resetPage();
        }
    }

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
        $providersQuery = Provider::with(['personType']);

        if ($this->personType !== 'all') {
            $providersQuery->where('person_type_id', $this->personType);
        }

        if ($this->status !== 'all') {
            $providersQuery->where('status', $this->status === 'active');
        }

        if (trim($this->search) !== '') {
            $term = trim($this->search);
            $providersQuery->where(function ($query) use ($term) {
                $query->where('name', 'like', "%{$term}%")
                    ->orWhere('identification', 'like', "%{$term}%");
            });
        }

        switch ($this->order) {
            case 'created_asc':
                $providersQuery->orderBy('created_at', 'asc')->orderBy('id', 'asc');
                break;
            case 'name_asc':
                $providersQuery->orderBy('name', 'asc')->orderBy('id', 'asc');
                break;
            default:
                $providersQuery->orderBy('created_at', 'desc')->orderBy('id', 'desc');
                break;
        }

        return view('livewire.providers.index', [
            'providers' => $providersQuery->paginate(10),
            'personTypes' => $this->personTypes,
        ]);
    }
}
