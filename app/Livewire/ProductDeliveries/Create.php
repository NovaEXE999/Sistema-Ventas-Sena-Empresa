<?php

namespace App\Livewire\ProductDeliveries;

use App\Models\ProductDelivery;
use App\Models\Product;
use App\Models\Provider;
use Livewire\Component;
use Illuminate\Support\Facades\DB;

class Create extends Component
{
    public string $date = '';
    public string $providerSearch = '';
    public array $providerResults = [];
    public ?int $provider_id = null;
    public string $providerNotice = '';
    public bool $providerNotFound = false;
    public bool $isAdmin = false;

    public string $productSearch = '';
    public array $productResults = [];
    public ?int $selectedProductId = null;
    public int $productQuantity = 1;
    public array $lineItems = [];

    protected function rules(): array
    {
        return [
            'date' => 'required|date',
            'provider_id' => 'required|exists:providers,id',
            'lineItems' => 'array|min:1',
            'lineItems.*.quantity' => 'integer|min:1|max:1000',
            'lineItems.*.product_id' => 'integer|exists:products,id',
        ];
    }

    public function mount($delivery = null): void
    {
        $this->date = now()->toDateString();
        $this->isAdmin = auth()->user()?->isAdmin() ?? false;
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

        $products = Product::whereIn('id', array_keys($this->lineItems))
            ->select('id', 'name', 'stock', 'status')
            ->get()
            ->keyBy('id');

        foreach ($this->lineItems as $item) {
            $product = $products[$item['product_id']] ?? null;
            if (!$product || !$product->status) {
                $this->addError('lineItems', 'Un producto seleccionado ya no existe o esta inactivo.');
                return;
            }

            $totalAfterEntry = (int) $product->stock + (int) $item['quantity'];
            if ($totalAfterEntry > 1000) {
                $this->addError('lineItems', "No puedes registrar mas de 1000 unidades de {$product->name}. Stock actual: {$product->stock}.");
                return;
            }
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

                Product::where('id', $item['product_id'])->increment('stock', $item['quantity']);
            }
        });
    }

    public function updatedProviderSearch(): void
    {
        $term = trim($this->providerSearch);

        $this->provider_id = null;
        $this->providerNotice = '';
        $this->providerNotFound = false;

        if ($term === '') {
            $this->providerResults = [];
            $this->resetErrorBag(['provider_id', 'providerSearch']);
            return;
        }

        $this->providerResults = Provider::query()
            ->where(function ($query) use ($term) {
                $query->where('name', 'like', '%'.$term.'%')
                    ->orWhere('identification', 'like', '%'.$term.'%');
            })
            ->where('status', true)
            ->limit(5)
            ->get(['id','name','identification'])
            ->toArray();

        if (empty($this->providerResults)) {
            $this->providerNotice = $this->isAdmin
                ? 'El proveedor que intentas usar no existe o esta inactivo. Registralo primero en "Proveedores".'
                : 'El proveedor que intentas usar no existe o esta inactivo. Contacta al administrador para registrarlo.';
            $this->providerNotFound = true;
            return;
        }

        $this->resetErrorBag(['provider_id', 'providerSearch']);
    }

    public function selectProvider(int $id, string $name): void
    {
        $provider = Provider::find($id);
        if (!$provider || !$provider->status) {
            $this->addError('provider_id', 'El proveedor esta inactivo o no existe.');
            return;
        }

        $this->provider_id = $id;
        $this->providerSearch = $name;
        $this->providerResults = [];
        $this->providerNotice = '';
        $this->providerNotFound = false;
        $this->resetErrorBag(['provider_id', 'providerSearch']);
    }

    public function hideProviderResults(): void
    {
        $this->providerResults = [];
    }

    public function ensureProviderSelected(): void
    {
        $this->providerResults = [];
        if (!$this->provider_id) {
            if ($this->providerNotFound && $this->providerNotice !== '') {
                $this->addError('provider_id', $this->providerNotice);
                return;
            }

            $this->providerNotice = $this->isAdmin
                ? 'Selecciona un proveedor de la lista. Si no existe, registralo en "Proveedores".'
                : 'Selecciona un proveedor de la lista. Si no existe, contacta al administrador para registrarlo.';
            $this->providerNotFound = false;
            $this->addError('provider_id', $this->providerNotice);
        }
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
                $this->addError('provider_id', 'El proveedor esta inactivo; no puedes registrar la entrada.');
                return null;
            }
            return $provider;
        }

        $this->addError('provider_id', 'Selecciona un proveedor de la lista.');
        return null;
    }

    public function updatedProductSearch(): void
    {
        $this->productResults = Product::query()
            ->where('name', 'like', '%'.$this->productSearch.'%')
            ->where('status', true)
            ->where('stock', '<', 1000)
            ->limit(5)
            ->get(['id','name','stock'])
            ->toArray();

        $this->selectedProductId = null;

        $this->resetErrorBag(['productSearch']);
        $term = trim($this->productSearch);
        if ($term !== '' && empty($this->productResults)) {
            $this->addError('productSearch', 'El producto no existe, esta inactivo o ya alcanzo el limite de stock (1000).');
        }
    }

    public function ensureProductSelected(): void
    {
        $this->productResults = [];
    }

    public function updatedProductQuantity($value): void
    {
        $clean = (int) filter_var($value, FILTER_SANITIZE_NUMBER_INT);
        if ($clean < 1) {
            $clean = 1;
        } elseif ($clean > 1000) {
            $clean = 1000;
        }

        $this->productQuantity = $clean;
        $this->resetErrorBag(['productQuantity', 'lineItems']);
    }

    public function selectProduct(int $id, string $name): void
    {
        $this->selectedProductId = $id;
        $this->productSearch = $name;
        $this->productResults = [];
        $this->resetErrorBag(['productSearch']);
    }

    public function hideProductResults(): void
    {
        $this->productResults = [];
    }

    public function addProductLine(): void
    {
        $this->resetErrorBag(['productQuantity', 'productSearch', 'lineItems']);

        if (!$this->selectedProductId) {
            $message = $this->productSearch !== ''
                ? 'El producto no existe o esta inactivo. Selecciona uno de la lista.'
                : 'Selecciona un producto de la lista.';
            $this->resetErrorBag(['productSearch']);
            $this->addError('productSearch', $message);
            return;
        }

        $product = Product::select('id', 'name', 'stock')->where('status', true)->find($this->selectedProductId);
        if (!$product) {
            $this->addError('productSearch', 'Producto no encontrado o inactivo.');
            return;
        }

        $currentStock = (int) $product->stock;
        if ($currentStock >= 1000) {
            $this->addError('productSearch', "El producto {$product->name} ya esta en el limite de stock (1000).");
            return;
        }

        $quantity = (int) $this->productQuantity;
        if ($quantity < 1) {
            $this->addError('productQuantity', 'La cantidad debe ser mayor que 0.');
            return;
        }

        if ($quantity > 1000) {
            $this->addError('productQuantity', 'La cantidad maxima que puede entregar un proveedor es 1000.');
            return;
        }

        $existingQuantity = $this->lineItems[$product->id]['quantity'] ?? 0;
        $newQuantity = $existingQuantity + $quantity;

        $availableForEntry = 1000 - $currentStock - $existingQuantity;
        if ($availableForEntry <= 0) {
            $this->addError('lineItems', "El producto {$product->name} alcanzara el limite de 1000 con su stock actual. Quita esta linea.");
            return;
        }

        if ($quantity > $availableForEntry) {
            $this->addError('productQuantity', "Solo puedes agregar {$availableForEntry} unidades para {$product->name} (stock actual: {$currentStock}).");
            return;
        }

        $this->lineItems[$product->id] = [
            'product_id' => $product->id,
            'name' => $product->name,
            'quantity' => $newQuantity,
            'stock' => $currentStock,
        ];

        $this->productQuantity = 1;
    }

    public function updateLineQuantity(int $productId, $quantity): void
    {
        if (!isset($this->lineItems[$productId])) {
            return;
        }

        $quantity = (int) $quantity;
        if ($quantity < 1) {
            $this->addError('lineItems', 'La cantidad debe ser mayor que 0.');
            $quantity = 1;
        }

        $baseStock = (int) ($this->lineItems[$productId]['stock'] ?? 0);
        $maxAllowed = max(0, 1000 - $baseStock);

        if ($quantity > $maxAllowed) {
            $this->addError('lineItems', "La cantidad supera el limite de 1000 con el stock actual ({$baseStock}). Maximo permitido: {$maxAllowed}.");
            $quantity = $maxAllowed;
        }

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
