<?php

namespace App\Livewire\ProductDeliveries;

use App\Models\ProductDelivery;
use App\Models\Product;
use Livewire\WithPagination;
use Livewire\Component;

class Index extends Component
{
    use WithPagination;

    public $delivery;

    public function mount(){
        $delivery = ProductDelivery::with('provider', 'product')->get();
    }

    public function delete(ProductDelivery $delivery)
    {
        // Revertir stock antes de eliminar la entrada
        if ($delivery->product_id && $delivery->delivered_amount > 0) {
            Product::where('id', $delivery->product_id)
                ->decrement('quantity', $delivery->delivered_amount);
        }

        $delivery->delete();

        session()->flash('success', 'Entrada de inventario eliminada satisfactoriamente.');
        $this->redirectRoute('productdeliveries.index', navigate:true);
    }

    public function render()
    {
        return view('livewire.product-deliveries.index', [
            'deliveries' => ProductDelivery::latest()->paginate(10),
        ]);
    }
}
