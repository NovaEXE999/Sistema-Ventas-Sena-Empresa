<?php

namespace App\Livewire\ProductDeliveries;

use App\Models\ProductDelivery;
use App\Models\Product;
use App\Models\Provider;
use Livewire\Attributes\Validate;
use Livewire\Component;

class Create extends Component
{
    // Campos de búsqueda para producto y proveedor
    public string $productSearch = '';
    public string $productLabel = '';
    public array $productResults = [];

    public string $providerSearch = '';
    public string $providerLabel = '';
    public array $providerResults = [];

    #[Validate('required|date')]
    public $date = '';
    #[Validate('required|integer|min:0')]
    public $delivered_amount = '';
    #[Validate('required|exists:products,id')]
    public $product_id = '';
    #[Validate('required|exists:providers,id')]
    public $provider_id = '';

    public function save(){
        $this->validate();

        ProductDelivery::create([
            'date' => $this->date,
            'delivered_amount' => $this->delivered_amount,
            'product_id' => $this->product_id,
            'provider_id' => $this->provider_id,
        ]);

        session()->flash('success', 'Entrada de inventario creada satisfactoriamente.');
        $this->redirectRoute('productdeliveries.index', navigate:true);
    }

    // Búsqueda de producto
    public function updatedProductSearch(): void
    {
        $this->productResults = Product::query()
            ->where('name', 'like', '%'.$this->productSearch.'%')
            ->limit(5)
            ->get(['id','name'])
            ->toArray();
    }

    public function selectProduct(int $id, string $name): void
    {
        $this->product_id = $id;
        $this->productLabel = $name;
        $this->productSearch = $name;
        $this->productResults = [];
    }

    // Búsqueda de proveedor
    public function updatedProviderSearch(): void
    {
        $this->providerResults = Provider::query()
            ->where('name', 'like', '%'.$this->providerSearch.'%')
            ->limit(5)
            ->get(['id','name'])
            ->toArray();
    }

    public function selectProvider(int $id, string $name): void
    {
        $this->provider_id = $id;
        $this->providerLabel = $name;
        $this->providerSearch = $name;
        $this->providerResults = [];
    }
    
    public function render()
    {
        return view('livewire.product-deliveries.create');
    }
}
