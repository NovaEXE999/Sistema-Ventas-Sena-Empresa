<?php

namespace App\Livewire\Sales;

use Livewire\Component;
use App\Models\Sale;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $sale;

    public function mount(){
        $sale = Sale::with(['user', 'client'])->get();
    }

    public function delete(Sale $sale)
    {
        $sale->delete();

        session()->flash('success', 'Venta eliminada satisfactoriamente.');
        $this->redirectRoute('sales.index', navigate: true);
    }

    public function render()
    {
        return view('livewire.sales.index', [
            'sales' => Sale::latest()->paginate(10),
        ]);
    }
}
