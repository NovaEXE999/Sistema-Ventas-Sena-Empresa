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

    // Busqueda de cliente
    public string $clientSearch = '';
    public array $clientResults = [];
    public ?int $client_id = null;
    public bool $clientNotFound = false;
    public ?string $pendingClientName = null;

    // Metodo de pago
    public array $paymentMethods = [];
    public ?int $payment_method_id = null;

    // Productos y lineas de venta
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

        $client = $this->resolveClient();
        if (!$client) {
            $this->clientNotFound = true;
            return;
        }

        $this->persistSale($client);
    }

    protected function resolveClient(): ?Client
    {
        if ($this->client_id) {
            $client = Client::find($this->client_id);

            if (!$client) {
                $this->addError('clientSearch', 'El cliente seleccionado ya no existe.');
            }

            return $client;
        }

        $clientName = trim($this->clientSearch);
        if ($clientName === '') {
            $this->addError('clientSearch', 'Ingresa un cliente.');
            return null;
        }

        $existing = Client::where('name', $clientName)->first();
        if ($existing) {
            $this->client_id = $existing->id;
            return $existing;
        }

        $this->pendingClientName = $clientName;
        return null;
    }

    public function confirmClientCreation(): void
    {
        if (!$this->pendingClientName) {
            return;
        }

        $client = Client::firstOrCreate(['name' => $this->pendingClientName]);
        $this->client_id = $client->id;
        $this->clientSearch = $client->name;
        $this->clientResults = [];
        $this->clientNotFound = false;
        $this->pendingClientName = null;

        $this->persistSale($client);
    }

    public function resetClientPrompt(): void
    {
        $this->clientNotFound = false;
        $this->pendingClientName = null;
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
                $price = $products[$item['product_id']]->price;
                $quantity = $item['quantity'];

                SaleDetail::create([
                    'quantity' => $quantity,
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

    // Busqueda de cliente
    public function updatedClientSearch(): void
    {
        $term = trim($this->clientSearch);

        $this->clientResults = Client::query()
            ->where(function ($query) use ($term) {
                $query->where('name', 'like', '%'.$term.'%')
                    ->orWhere('identification', 'like', '%'.$term.'%');
            })
            ->where('status', true)
            ->limit(5)
            ->get(['id','name','identification'])
            ->toArray();

        $this->client_id = null;
        $this->clientNotFound = false;
    }

    public function selectClient(int $id, string $name): void
    {
        $this->client_id = $id;
        $this->clientSearch = $name;
        $this->clientResults = [];
        $this->clientNotFound = false;
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
    }

    public function addProductLine(): void
    {
        $this->resetErrorBag(['productQuantity', 'productSearch', 'lineItems']);

        if (!$this->selectedProductId) {
            $this->addError('productSearch', 'Selecciona un producto de la lista.');
            return;
        }

        $product = Product::select('id', 'name', 'price', 'stock')->find($this->selectedProductId);
        if (!$product) {
            $this->addError('productSearch', 'Producto no encontrado.');
            return;
        }

        $quantity = max(1, (int) $this->productQuantity);
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

    public function render()
    {
        return view('livewire.sales.create');
    }
}
