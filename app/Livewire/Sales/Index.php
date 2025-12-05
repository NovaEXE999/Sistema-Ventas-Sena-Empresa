<?php

namespace App\Livewire\Sales;

use Livewire\Component;
use App\Models\Sale;
use Illuminate\Support\Facades\DB;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $sale;

    public function mount(){
        $sale = Sale::with(['user', 'client', 'paymentmethod'])->get();
    }

    public function delete(Sale $sale)
    {
        DB::transaction(function () use ($sale) {
            foreach ($sale->details as $detail) {
                $detail->product?->increment('stock', $detail->quantity);
            }

            $sale->details()->delete();
            $sale->delete();
        });

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
