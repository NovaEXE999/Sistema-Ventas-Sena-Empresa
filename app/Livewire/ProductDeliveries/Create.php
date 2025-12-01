<?php

namespace App\Livewire\ProductDeliveries;

use App\Models\ProductDelivery;
use App\Models\Product;
use App\Models\Provider;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Illuminate\Support\Facades\DB;

class Create extends Component
{
    public string $date = '';
    public string $providerSearch = '';
    public array $providerResults = [];
    public ?int $provider_id = null;
    public bool $providerNotFound = false;
    public ?string $pendingProviderName = null;

    public string $productSearch = '';
    public array $productResults = [];
    public ?int $selectedProductId = null;
    public int $productQuantity = 1;
    public array $lineItems = [];

    protected function rules(): array
    {
        return [
            'date' => 'required|date',
            'provider_id' => 'nullable|exists:providers,id',
            'lineItems' => 'array|min:1',
            'lineItems.*.quantity' => 'integer|min:1',
            'lineItems.*.product_id' => 'integer|exists:products,id',
        ];
    }

    public function mount($delivery = null): void
    {
        $this->date = now()->toDateString();
    }

    public function save(): void
    {
        $this->validate();

        if (empty($this->lineItems)) {
            $this->addError('lineItems', 'Agrega al menos un producto.');
            return;
        }

        $provider = $this->resolveProvider();
        if (!$provider) {
            return;
        }

        $this->persistEntries($provider);

        session()->flash('success', 'Entrada de inventario creada satisfactoriamente.');
        $this->redirectRoute('productdeliveries.index', navigate: true);
    }

    protected function persistEntries(Provider $provider): void
    {
        DB::transaction(function () use ($provider) {
            foreach ($this->lineItems as $item) {
                ProductDelivery::create([
                    'date' => $this->date,
                    'delivered_amount' => $item['quantity'],
                    'product_id' => $item['product_id'],
                    'provider_id' => $provider->id,
                ]);

                Product::where('id', $item['product_id'])->increment('quantity', $item['quantity']);
            }
        });
    }

    // Busqueda de proveedor
    public function updatedProviderSearch(): void
    {
        $this->providerResults = Provider::query()
            ->where('name', 'like', '%'.$this->providerSearch.'%')
            ->where('status', true)
            ->limit(5)
            ->get(['id','name'])
            ->toArray();

        $this->provider_id = null;
        $this->providerNotFound = false;
    }

    public function selectProvider(int $id, string $name): void
    {
        $provider = Provider::find($id);
        if (!$provider || !$provider->status) {
            $this->addError('provider_id', 'El proveedor está inactivo o no existe.');
            return;
        }

        $this->provider_id = $id;
        $this->providerSearch = $name;
        $this->providerResults = [];
        $this->providerNotFound = false;
    }

    protected function resolveProvider(): ?Provider
    {
        if ($this->provider_id) {
            $provider = Provider::find($this->provider_id);
            if (!$provider) {
                $this->addError('provider_id', 'El proveedor seleccionado ya no existe.');
                return null;
            }
            if (!$provider->status) {
                $this->addError('provider_id', 'El proveedor está inactivo; no puedes registrar la entrada.');
                return null;
            }
            return $provider;
        }

        $name = trim($this->providerSearch);
        if ($name === '') {
            $this->addError('providerSearch', 'Ingresa un proveedor.');
            return null;
        }

        $existing = Provider::where('name', $name)->first();
        if ($existing && !$existing->status) {
            $this->addError('providerSearch', 'El proveedor existe pero está inactivo. Actívalo antes de registrar.');
            return null;
        }
        if ($existing) {
            $this->provider_id = $existing->id;
            return $existing;
        }

        $this->pendingProviderName = $name;
        $this->providerNotFound = true;
        return null;
    }

    public function confirmProviderCreation(): void
    {
        if (!$this->pendingProviderName) {
            return;
        }

        $provider = Provider::firstOrCreate(['name' => $this->pendingProviderName], ['status' => true]);
        $this->provider_id = $provider->id;
        $this->providerSearch = $provider->name;
        $this->providerResults = [];
        $this->providerNotFound = false;
        $this->pendingProviderName = null;

        // reintenta guardar si ya estaba en flujo de validación
        $this->resetErrorBag(['providerSearch', 'provider_id']);
    }

    public function resetProviderPrompt(): void
    {
        $this->providerNotFound = false;
        $this->pendingProviderName = null;
    }

    // Busqueda de producto
    public function updatedProductSearch(): void
    {
        $this->productResults = Product::query()
            ->where('name', 'like', '%'.$this->productSearch.'%')
            ->where('status', true)
            ->limit(5)
            ->get(['id','name'])
            ->toArray();

        $this->selectedProductId = null;
    }

    public function selectProduct(int $id, string $name): void
    {
        $this->selectedProductId = $id;
        $this->productSearch = $name;
        $this->productResults = [];
        $this->resetErrorBag(['productSearch']);
    }

    public function addProductLine(): void
    {
        $this->resetErrorBag(['productQuantity', 'productSearch', 'lineItems']);

        if (!$this->selectedProductId) {
            $this->addError('productSearch', 'Selecciona un producto de la lista.');
            return;
        }

        $product = Product::select('id', 'name')->where('status', true)->find($this->selectedProductId);
        if (!$product) {
            $this->addError('productSearch', 'Producto no encontrado o inactivo.');
            return;
        }

        $quantity = max(1, (int) $this->productQuantity);

        $this->lineItems[$product->id] = [
            'product_id' => $product->id,
            'name' => $product->name,
            'quantity' => $quantity,
        ];

        $this->productQuantity = 1;
    }

    public function updateLineQuantity(int $productId, $quantity): void
    {
        if (!isset($this->lineItems[$productId])) {
            return;
        }

        $quantity = (int) $quantity;
        $quantity = $quantity < 1 ? 1 : $quantity;

        $this->lineItems[$productId]['quantity'] = $quantity;
    }

    public function removeLine(int $productId): void
    {
        unset($this->lineItems[$productId]);
    }
    
    public function render()
    {
        return view('livewire.product-deliveries.create');
    }
}
