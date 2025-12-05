<?php

namespace App\Livewire\ProductDeliveries;

use App\Models\ProductDelivery;
use App\Models\Product;
use Livewire\WithPagination;
use Livewire\Component;

class Index extends Component
{
    use WithPagination;

    public string $order = 'date_desc';
    public ?string $filterDate = null;
    public string $search = '';

    public function updated($propertyName): void
    {
        if (in_array($propertyName, ['order', 'filterDate', 'search'], true)) {
            $this->resetPage();
        }
    }

    public function delete(ProductDelivery $delivery)
    {
        // Revertir stock antes de eliminar la entrada
        if ($delivery->product_id && $delivery->delivered_amount > 0) {
            Product::where('id', $delivery->product_id)
                ->decrement('stock', $delivery->delivered_amount);
        }

        $delivery->delete();

        session()->flash('success', 'Entrada de inventario eliminada satisfactoriamente.');
        $this->redirectRoute('productdeliveries.index', navigate:true);
    }

    public function render()
    {
        $deliveriesQuery = ProductDelivery::with(['provider', 'product.category.measure']);

        if ($this->filterDate) {
            $deliveriesQuery->whereDate('date', $this->filterDate);
        }

        if (trim($this->search) !== '') {
            $term = trim($this->search);
            $deliveriesQuery->where(function ($query) use ($term) {
                $query->whereHas('provider', function ($q) use ($term) {
                    $q->where('name', 'like', "%{$term}%")
                        ->orWhere('identification', 'like', "%{$term}%");
                })->orWhereHas('product', function ($q) use ($term) {
                    $q->where('name', 'like', "%{$term}%");
                });
            });
        }

        switch ($this->order) {
            case 'date_asc':
                $deliveriesQuery->orderBy('date', 'asc')->orderBy('id', 'asc');
                break;
            default:
                $deliveriesQuery->orderBy('date', 'desc')->orderBy('id', 'desc');
                break;
        }

        return view('livewire.product-deliveries.index', [
            'deliveries' => $deliveriesQuery->paginate(10),
        ]);
    }
}
