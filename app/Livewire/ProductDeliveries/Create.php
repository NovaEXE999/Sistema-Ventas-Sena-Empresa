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

                Product::where('id', $item['product_id'])->increment('stock', $item['quantity']);
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

        if (trim($this->providerSearch) !== '' && empty($this->providerResults)) {
            $this->addError('provider_id', 'El proveedor no existe o está inactivo. Selecciona uno de la lista.');
        } else {
            $this->resetErrorBag(['provider_id', 'providerSearch']);
        }
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
            $this->addError('provider_id', 'Selecciona un proveedor de la lista.');
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
                $this->addError('provider_id', 'El proveedor está inactivo; no puedes registrar la entrada.');
                return null;
            }
            return $provider;
        }

        $this->addError('provider_id', 'Selecciona un proveedor de la lista.');
        return null;
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

        $this->resetErrorBag(['productSearch']);
        $term = trim($this->productSearch);
        if ($term !== '' && empty($this->productResults)) {
            $this->addError('productSearch', 'El producto no existe o está inactivo. Selecciona uno de la lista.');
        }
    }

    public function ensureProductSelected(): void
    {
        $this->productResults = [];
        // no-op if no selección; mensaje ya lo maneja updatedProductSearch/addProductLine
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
                ? 'El producto no existe o está inactivo. Selecciona uno de la lista.'
                : 'Selecciona un producto de la lista.';
            $this->resetErrorBag(['productSearch']);
            $this->addError('productSearch', $message);
            return;
        }

        $product = Product::select('id', 'name')->where('status', true)->find($this->selectedProductId);
        if (!$product) {
            $this->addError('productSearch', 'Producto no encontrado o inactivo.');
            return;
        }

        $quantity = max(1, (int) $this->productQuantity);

        // si ya existe en la lista, sumamos cantidades
        if (isset($this->lineItems[$product->id])) {
            $this->lineItems[$product->id]['quantity'] += $quantity;
        } else {
            $this->lineItems[$product->id] = [
                'product_id' => $product->id,
                'name' => $product->name,
                'quantity' => $quantity,
            ];
        }

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
