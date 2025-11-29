<?php

namespace App\Livewire\Sales;

use App\Models\Sale;
use App\Models\User;
use App\Models\Client;
use Livewire\Attributes\Validate;
use Livewire\Component;

class Update extends Component
{
    public ?Sale $sale;

    // Campos de búsqueda
    public string $userSearch = '';
    public string $userLabel = '';
    public array $userResults = [];

    public string $clientSearch = '';
    public string $clientLabel = '';
    public array $clientResults = [];

    #[Validate('required|numeric|min:0')]
    public $total_value = '';
    #[Validate('required|date')]
    public $date = '';
    #[Validate('required|exists:users,id')]
    public $user_id = '';
    #[Validate('required|exists:clients,id')]
    public $client_id = '';


    public function mount(Sale $sale)
    {
        $this->setSale($sale);
    }

    public function setSale (Sale $sale){
        $this->sale = $sale;
        $this->total_value = $sale->total_value;
        // El input type="date" requiere formato Y-m-d
        $this->date = $sale->date instanceof \Carbon\Carbon
            ? $sale->date->format('Y-m-d')
            : $sale->date;
        $this->user_id = $sale->user_id;
        $this->client_id = $sale->client_id;

        // Precarga nombres en inputs de búsqueda
        $this->userLabel = optional($sale->user)->name ?? '';
        $this->userSearch = $this->userLabel;
        $this->clientLabel = optional($sale->client)->full_name ?? optional($sale->client)->name ?? '';
        $this->clientSearch = $this->clientLabel;
    }

    public function update()
    {
        $this->validate();
        
        $this->sale->update($this->all());
    }

     public function save()
    {
        $this->update();

        session()->flash('success', 'Venta actualizada correctamente.');
        $this->redirectRoute('sales.index', navigate:true);
    }

    // Búsqueda de vendedor
    public function updatedUserSearch(): void
    {
        $this->userResults = User::query()
            ->where('name', 'like', '%'.$this->userSearch.'%')
            ->limit(5)
            ->get(['id','name'])
            ->toArray();
    }

    public function selectUser(int $id, string $name): void
    {
        $this->user_id = $id;
        $this->userLabel = $name;
        $this->userSearch = $name;
        $this->userResults = [];
    }

    // Búsqueda de cliente
    public function updatedClientSearch(): void
    {
        $term = trim($this->clientSearch);

        if ($term === '') {
            $this->clientResults = [];
            return;
        }

        $like = '%'.$term.'%';

        $this->clientResults = Client::query()
            ->select('id', 'first_name', 'middle_name', 'last_name', 'second_last_name')
            ->where(function ($q) use ($term, $like) {
                $q->where('first_name', 'like', $term.'%')
                  ->orWhere('last_name', 'like', $like)
                  ->orWhere('middle_name', 'like', $like)
                  ->orWhere('second_last_name', 'like', $like);
            })
            ->limit(5)
            ->get()
            ->map(fn ($c) => [
                'id' => $c->id,
                'full_name' => collect([$c->first_name, $c->middle_name, $c->last_name, $c->second_last_name])
                    ->filter()
                    ->join(' ')
            ])
            ->toArray();
    }

    public function selectClient(int $id, string $name): void
    {
        $this->client_id = $id;
        $this->clientLabel = $name;
        $this->clientSearch = $name;
        $this->clientResults = [];
    }

    public function render()
    {
        return view('livewire.sales.create');
    }
}
