<?php

namespace App\Livewire\ProductDeliveries;

use App\Models\ProductDelivery;
use App\Models\Product;
use Illuminate\Support\Carbon;
use Livewire\WithPagination;
use Livewire\Component;

class Index extends Component
{
    use WithPagination;

    public string $order = 'date_desc';
    public ?string $filterDate = null;
    public string $filterDateType = 'date'; // date | month | year
    public string $search = '';

    public function updated($propertyName): void
    {
        if ($propertyName === 'filterDateType') {
            $this->filterDate = null;
        }

        if (in_array($propertyName, ['order', 'filterDate', 'filterDateType', 'search'], true)) {
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

        $dateValue = trim((string) $this->filterDate);
        switch ($this->filterDateType) {
            case 'month':
                if (preg_match('/^\d{4}-\d{2}$/', $dateValue)) {
                    $carbon = Carbon::createFromFormat('Y-m', $dateValue);
                    $deliveriesQuery->whereYear('date', $carbon->year)
                        ->whereMonth('date', $carbon->month);
                }
                break;
            case 'year':
                if (preg_match('/^\d{4}$/', $dateValue)) {
                    $deliveriesQuery->whereYear('date', (int) $dateValue);
                }
                break;
            case 'date':
            default:
                if (!empty($dateValue)) {
                    $deliveriesQuery->whereDate('date', $dateValue);
                }
                break;
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
