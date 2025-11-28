<?php

namespace App\Livewire\Sales;

use App\Models\Sale;
use Livewire\Attributes\Validate;
use Livewire\Component;

class Update extends Component
{
    public ?Sale $sale;

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
    public function render()
    {
        return view('livewire.sales.create');
    }
}
