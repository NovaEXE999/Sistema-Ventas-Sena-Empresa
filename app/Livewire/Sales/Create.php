<?php

namespace App\Livewire\Sales;

use App\Models\Sale;
use App\Models\SaleDetail;
use App\Models\Product;
use App\Models\Client;
use App\Models\PaymentMethod;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Illuminate\Support\Facades\DB;

class Create extends Component
{
    public string $sellerName = '';


    public string $clientSearch = '';
    public array $clientResults = [];
    public ?int $client_id = null;
    public string $clientNotice = '';
    public bool $clientNotFound = false;


    public array $paymentMethods = [];
    public ?int $payment_method_id = null;


    public string $productSearch = '';
    public array $productResults = [];
    public ?int $selectedProductId = null;
    public int $productQuantity = 1;
    public array $lineItems = [];

    #[Validate('required|numeric|min:0')]
    public float $total_value = 0;
    #[Validate('required|date')]
    public string $date = '';
    #[Validate('required|exists:users,id')]
    public ?int $user_id = null;

    public function mount(): void
    {
        $user = auth()->user();
        $this->user_id = $user?->id;
        $this->sellerName = $user?->name ?? 'Usuario';
        $this->date = now()->toDateString();

        $this->paymentMethods = PaymentMethod::query()
            ->where('status', true)
            ->select('id', 'name')
            ->orderBy('name')
            ->get()
            ->toArray();

        $this->payment_method_id = $this->paymentMethods[0]['id'] ?? null;
    }

    protected function rules(): array
    {
        return [
            'date' => 'required|date',
            'user_id' => 'required|exists:users,id',
            'clientSearch' => 'required|string',
            'client_id' => 'required|exists:clients,id',
            'total_value' => 'required|numeric|min:0',
            'payment_method_id' => 'required|exists:payment_methods,id',
            'lineItems' => 'array|min:1',
            'lineItems.*.quantity' => 'integer|min:1',
            'lineItems.*.product_id' => 'integer|exists:products,id',
        ];
    }

    public function save(): void
    {
        $this->recalculateTotals();
        $this->validate();

        if (empty($this->lineItems)) {
            $this->addError('lineItems', 'Agrega al menos un producto.');
            return;
        }

        $client = Client::find($this->client_id);
        if (!$client) {
            $this->addError('clientSearch', 'El cliente seleccionado ya no existe.');
            return;
        }

        $this->persistSale($client);
    }

    protected function persistSale(Client $client): void
    {
        $products = Product::whereIn('id', array_keys($this->lineItems))
            ->select('id', 'price', 'stock')
            ->get()
            ->keyBy('id');

        foreach ($this->lineItems as $item) {
            $product = $products[$item['product_id']] ?? null;
            if (!$product) {
                $this->addError('lineItems', 'Un producto seleccionado ya no existe.');
                return;
            }

            if ($item['quantity'] > $product->stock) {
                $this->addError('lineItems', "Stock insuficiente para {$item['name']}. Disponible: {$product->stock}.");
                return;
            }
        }

        DB::transaction(function () use ($client, $products) {
            $sale = Sale::create([
                'total_value' => $this->total_value,
                'date' => $this->date,
                'user_id' => $this->user_id,
                'client_id' => $client->id,
                'payment_method_id' => $this->payment_method_id,
            ]);

            foreach ($this->lineItems as $item) {
                $price = $item['price'];
                $quantity = $item['quantity'];

                SaleDetail::create([
                    'quantity' => $quantity,
                    'price' => $price,
                    'subtotal' => $price * $quantity,
                    'product_id' => $item['product_id'],
                    'sale_id' => $sale->id,
                ]);

                $products[$item['product_id']]->decrement('stock', $quantity);
            }
        });

        session()->flash('success', 'Venta creada satisfactoriamente.');
        $this->redirectRoute('sales.index', navigate: true);
    }

    public function updatedClientSearch(): void
    {
        $term = trim($this->clientSearch);

        $this->client_id = null;
        $this->clientNotice = '';
        $this->clientNotFound = false;

        if ($term === '') {
            $this->clientResults = [];
            $this->resetErrorBag(['clientSearch']);
            return;
        }

        $this->clientResults = Client::query()
            ->where(function ($query) use ($term) {
                $query->where('name', 'like', '%'.$term.'%')
                    ->orWhere('identification', 'like', '%'.$term.'%');
            })
            ->where('status', true)
            ->limit(5)
            ->get(['id','name','identification'])
            ->toArray();

        if (empty($this->clientResults)) {
            $this->clientNotice = 'El cliente que intentas usar no existe. Regístralo primero en la sección "Clientes".';
            $this->clientNotFound = true;
            return;
        }

        $this->resetErrorBag(['clientSearch']);
    }

    public function hideClientResults(): void
    {
        $this->clientResults = [];
    }

    public function ensureClientSelected(): void
    {
        if (!$this->client_id) {
            if ($this->clientNotFound && $this->clientNotice) {
                $this->addError('clientSearch', $this->clientNotice);
                return;
            }

            $this->clientNotice = 'Selecciona un cliente de la lista. Si no existe, regístralo en "Clientes".';
            $this->clientNotFound = false;
            $this->addError('clientSearch', $this->clientNotice);
        }
    }

    public function selectClient(int $id, string $name): void
    {
        $this->client_id = $id;
        $this->clientSearch = $name;
        $this->clientResults = [];
        $this->clientNotice = '';
        $this->clientNotFound = false;
        $this->resetErrorBag(['clientSearch']);
    }

    // Busqueda de producto
    public function updatedProductSearch(): void
    {
        $term = trim($this->productSearch);

        $this->productResults = Product::query()
            ->where(function ($query) use ($term) {
                $query->where('name', 'like', '%'.$term.'%')
                    ->orWhere('id', 'like', '%'.$term.'%');
            })
            ->where('status', true)
            ->where('stock', '>', 0)
            ->limit(5)
            ->get(['id','name','price','stock'])
            ->toArray();

        $this->selectedProductId = null;

        if ($term !== '' && empty($this->productResults)) {
            $this->addError('productSearch', 'El producto no existe. Regístralo en la sección "Productos".');
        }
    }

    public function hideProductResults(): void
    {
        $this->productResults = [];
    }

    public function updatedProductQuantity($value): void
    {
        $this->productQuantity = $this->sanitizeQuantity($value);
    }

    public function selectProduct(int $id): void
    {
        $product = Product::select('id', 'name', 'price', 'stock')->find($id);
        if (!$product) {
            return;
        }

        $this->selectedProductId = $product->id;
        $this->productSearch = $product->name;
        $this->productResults = [];
        $this->resetErrorBag(['productSearch']);
    }

    public function addProductLine(): void
    {
        $this->resetErrorBag(['productQuantity', 'productSearch', 'lineItems']);
        $this->productQuantity = $this->sanitizeQuantity($this->productQuantity);

        if (!$this->selectedProductId) {
            $message = $this->productSearch !== ''
                ? 'El producto no existe. Regístralo en la sección "Productos".'
                : 'Selecciona un producto de la lista.';

            $this->addError('productSearch', $message);
            return;
        }

        $product = Product::select('id', 'name', 'price', 'stock')->find($this->selectedProductId);
        if (!$product) {
            $this->addError('productSearch', 'Producto no encontrado.');
            return;
        }

        $quantity = $this->sanitizeQuantity($this->productQuantity);
        if ($quantity > $product->stock) {
            $this->addError('productQuantity', "Solo hay {$product->stock} unidades en stock.");
            return;
        }

        $existingQuantity = $this->lineItems[$product->id]['quantity'] ?? 0;
        $newQuantity = $existingQuantity + $quantity;

        if ($newQuantity > $product->stock) {
            $this->addError('lineItems', "No puedes agregar {$quantity} unidades mas de {$product->name}. Stock disponible: {$product->stock}.");
            return;
        }

        $this->lineItems[$product->id] = [
            'product_id' => $product->id,
            'name' => $product->name,
            'quantity' => $newQuantity,
            'price' => (float) $product->price,
            'stock' => $product->stock,
            'subtotal' => (float) $product->price * $newQuantity,
        ];

        $this->recalculateTotals();
        $this->productQuantity = 1;
    }

    public function updateLineQuantity(int $productId, $quantity): void
    {
        if (!isset($this->lineItems[$productId])) {
            return;
        }

        $quantity = (int) $quantity;
        $quantity = $quantity < 1 ? 1 : $quantity;

        $stock = $this->lineItems[$productId]['stock'];
        if ($quantity > $stock) {
            $this->addError('lineItems', "La cantidad de {$this->lineItems[$productId]['name']} supera el stock disponible ({$stock}).");
            $quantity = $stock;
        }

        $this->lineItems[$productId]['quantity'] = $quantity;
        $this->lineItems[$productId]['subtotal'] = $this->lineItems[$productId]['price'] * $quantity;

        $this->recalculateTotals();
    }

    public function removeLine(int $productId): void
    {
        unset($this->lineItems[$productId]);
        $this->recalculateTotals();
    }

    protected function recalculateTotals(): void
    {
        foreach ($this->lineItems as $productId => $item) {
            $this->lineItems[$productId]['subtotal'] = $item['price'] * $item['quantity'];
        }

        $this->total_value = collect($this->lineItems)->sum(fn ($item) => $item['subtotal']);
    }

    protected function sanitizeQuantity($value): int
    {
        $qty = (int) $value;
        if ($qty < 1) {
            $qty = 1;
        }
        if ($qty > 1000) {
            $qty = 1000;
        }

        return $qty;
    }

    public function render()
    {
        return view('livewire.sales.create');
    }
}
