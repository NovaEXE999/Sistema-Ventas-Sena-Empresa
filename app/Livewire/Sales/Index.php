<?php

namespace App\Livewire\Sales;

use Livewire\Component;
use App\Models\Sale;
use App\Models\PaymentMethod;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public string $order = 'date_desc';
    public ?string $filterDate = null;
    public string $paymentMethod = 'all';
    public string $seller = 'all';
    public string $search = '';
    public array $paymentMethods = [];
    public array $sellers = [];
    public bool $isAdmin = false;

    public function mount(): void
    {
        $this->isAdmin = auth()->user()?->isAdmin() ?? false;

        $this->paymentMethods = PaymentMethod::where('status', true)
            ->orderBy('name')
            ->get(['id', 'name'])
            ->toArray();

        if ($this->isAdmin) {
            $this->sellers = User::orderBy('name')
                ->get(['id', 'name'])
                ->toArray();
        } else {
            $this->sellers = [];
            $this->seller = auth()->id() ?? 'all';
        }
    }

    public function updated($propertyName): void
    {
        if (in_array($propertyName, ['order', 'filterDate', 'paymentMethod', 'seller', 'search'], true)) {
            $this->resetPage();
        }
    }

    public function delete(Sale $sale)
    {
        if (! $this->isAdmin) {
            abort(403);
        }

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
        $salesQuery = Sale::with(['user', 'client', 'paymentmethod']);

        if ($this->filterDate) {
            $salesQuery->whereDate('date', $this->filterDate);
        }

        if ($this->paymentMethod !== 'all') {
            $salesQuery->where('payment_method_id', $this->paymentMethod);
        }

        if ($this->seller !== 'all') {
            $salesQuery->where('user_id', $this->seller);
        } elseif (! $this->isAdmin) {
            $salesQuery->where('user_id', auth()->id());
        }

        if (trim($this->search) !== '') {
            $term = trim($this->search);
            $salesQuery->whereHas('client', function ($query) use ($term) {
                $query->where('name', 'like', "%{$term}%")
                    ->orWhere('identification', 'like', "%{$term}%");
            });
        }

        switch ($this->order) {
            case 'date_asc':
                $salesQuery->orderBy('date', 'asc')->orderBy('id', 'asc');
                break;
            default:
                $salesQuery->orderBy('date', 'desc')->orderBy('id', 'desc');
                break;
        }

        return view('livewire.sales.index', [
            'sales' => $salesQuery->paginate(10),
            'paymentMethods' => $this->paymentMethods,
            'sellers' => $this->sellers,
        ]);
    }
}
