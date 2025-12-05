<?php

namespace App\Livewire\Products;

use App\Models\Product;
use App\Models\Category;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public string $order = 'created_desc';
    public string $status = 'all';
    public string $stockOrder = 'none';
    public string $search = '';
    public string $category = 'all';
    public array $categories = [];

    public function mount(): void
    {
        $this->categories = Category::orderBy('name')
            ->get(['id', 'name'])
            ->toArray();
    }

    public function toggleStatus(Product $product): void
    {
        $product->status = ! $product->status;
        $product->save();

        $message = $product->status
            ? 'Producto reactivado satisfactoriamente.'
            : 'Producto inhabilitado satisfactoriamente.';

        session()->flash('success', $message);
        $this->redirectRoute('products.index', navigate: true);
    }

    public function updated($propertyName): void
    {
        if (in_array($propertyName, ['order', 'status', 'stockOrder', 'search', 'category'], true)) {
            $this->resetPage();
        }
    }

    public function render()
    {
        $productsQuery = Product::with(['category.measure']);

        if ($this->status !== 'all') {
            $productsQuery->where('products.status', $this->status === 'active');
        }

        if ($this->category !== 'all') {
            $productsQuery->where('products.category_id', $this->category);
        }

        if (trim($this->search) !== '') {
            $term = trim($this->search);
            $productsQuery->where('name', 'like', "%{$term}%");
        }

        if ($this->stockOrder === 'stock_desc') {
            $productsQuery->orderBy('stock', 'desc')->orderBy('id', 'asc');
        } elseif ($this->stockOrder === 'stock_asc') {
            $productsQuery->orderBy('stock', 'asc')->orderBy('id', 'asc');
        } else {
            switch ($this->order) {
                case 'created_asc':
                    $productsQuery->orderBy('created_at', 'asc')->orderBy('id', 'asc');
                    break;
                case 'name_asc':
                    $productsQuery->orderBy('name', 'asc')->orderBy('id', 'asc');
                    break;
                default:
                    $productsQuery->orderBy('created_at', 'desc')->orderBy('id', 'desc');
                    break;
            }
        }

        return view('livewire.products.index', [
            'products' => $productsQuery->paginate(10),
            'categories' => $this->categories,
        ]);
    }
}
