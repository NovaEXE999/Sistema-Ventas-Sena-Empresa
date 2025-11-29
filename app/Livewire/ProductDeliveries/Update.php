<?php

namespace App\Livewire\ProductDeliveries;

use App\Models\ProductDelivery;
use App\Models\Product;
use App\Models\Provider;
use Livewire\Attributes\Validate;
use Livewire\Component;

class Update extends Component
{
    public ?ProductDelivery $delivery;

    // Campos de búsqueda
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

    public function mount(ProductDelivery $delivery)
    {
        $this->setDelivery($delivery);
    }

    public function setDelivery (ProductDelivery $delivery){
        $this->delivery = $delivery;
        // Input date necesita formato Y-m-d
        $this->date = $delivery->date instanceof \Carbon\Carbon
            ? $delivery->date->format('Y-m-d')
            : $delivery->date;
        $this->delivered_amount = $delivery->delivered_amount;
        $this->product_id = $delivery->product_id;
        $this->provider_id = $delivery->provider_id;

        // Precarga nombres en inputs de búsqueda
        $this->productLabel = optional($delivery->product)->name ?? '';
        $this->productSearch = $this->productLabel;
        $this->providerLabel = optional($delivery->provider)->name ?? '';
        $this->providerSearch = $this->providerLabel;
    }

    public function update()
    {
        $this->validate();
        
        $this->delivery->update($this->all());
    }

     public function save()
    {
        $this->update();

        session()->flash('success', 'Entrada de inventario actualizada correctamente.');
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
