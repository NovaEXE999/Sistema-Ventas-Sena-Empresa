<div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
    <div class="flex h-fit w-full justify-between flex-row gap-4 rounded-xl">
        <a href="{{ route('sales.index')}}" wire:navigate class="flex w-fit justify-center items-center whitespace-nowrap rounded-radius bg-primary border border-primary px-4 py-2 text-center text-sm font-medium tracking-wide text-on-primary transition hover:opacity-75 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary active:opacity-100 active:outline-offset-0 disabled:cursor-not-allowed disabled:opacity-75 dark:border-primary-dark dark:bg-primary-dark dark:text-on-primary-dark dark:focus-visible:outline-primary-dark" role="button">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
            </svg>

            Volver
        </a>
        <h1 class="p-4 text-center">
            Registro de ventas 
        </h1>
    </div>
    <x-form.error-alert />
    <form wire:submit.prevent="save" class="space-y-6 p-4 bg-surface-alt dark:bg-surface-dark-alt rounded-lg shadow-md">
        <div class="grid gap-4 md:grid-cols-2">
            <div>
                <label class="block text-sm font-medium text-on-surface mb-1">Fecha</label>
                <input type="date" wire:model="date" disabled class="w-full rounded-radius border border-outline bg-gray-100 px-3 py-2 text-sm text-on-surface-strong focus:outline-none disabled:cursor-not-allowed">
            </div>
            <div>
                <label class="block text-sm font-medium text-on-surface mb-1">Vendedor</label>
                <input type="text" value="{{ $sellerName }}" disabled class="w-full rounded-radius border border-outline bg-gray-100 px-3 py-2 text-sm text-on-surface-strong focus:outline-none disabled:cursor-not-allowed">
            </div>
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-on-surface mb-1">Método de pago</label>
                <select wire:model="payment_method_id" class="w-full rounded-radius border border-outline px-3 py-2 text-sm text-on-surface focus:outline-none">
                    <option value="">Seleccione...</option>
                    @foreach($paymentMethods as $method)
                        <option value="{{ $method['id'] }}">{{ $method['name'] }}</option>
                    @endforeach
                </select>
                <x-form.field-error for="payment_method_id" />
            </div>
        </div>

        {{-- Cliente --}}
        <div class="space-y-2" x-data @click.outside="$wire.hideClientResults()">
            <x-form.input wire:model.live.debounce.300ms="clientSearch"
                          wire:blur="ensureClientSelected"
                          autocomplete="off"
                          label="Cliente" name="clientSearch" placeholder="Busca o escribe el cliente..." />
            @if($clientResults)
                <ul class="border rounded shadow-sm bg-white text-gray-900 max-h-48 overflow-y-auto">
                    @foreach($clientResults as $client)
                        <li wire:mousedown.prevent="selectClient({{ $client['id'] }}, @js($client['name']))"
                            class="px-3 py-2 hover:bg-gray-100 cursor-pointer">
                            <div class="flex flex-col">
                                <span class="font-medium">{{ $client['name'] }}</span>
                                @if(!empty($client['identification']))
                                    <span class="text-xs text-gray-600">ID: {{ $client['identification'] }}</span>
                                @endif
                            </div>
                        </li>
                    @endforeach
                </ul>
            @endif
            <x-form.field-error for="clientSearch" />
        </div>

        {{-- Productos --}}
        <div class="space-y-2 rounded-radius border border-outline p-4">
            <div class="grid gap-3 md:grid-cols-[2fr_120px_auto] items-end">
                <div x-data @click.outside="$wire.hideProductResults()">
                    <x-form.input wire:model.live.debounce.250ms="productSearch"
                                  wire:blur="hideProductResults"
                                  autocomplete="off"
                                  label="Producto" name="productSearch" placeholder="Busca el producto..." />
                    @if($productResults)
                        <ul class="border rounded shadow-sm bg-white text-gray-900 max-h-48 overflow-y-auto">
                            @foreach($productResults as $product)
                                <li wire:mousedown.prevent="selectProduct({{ $product['id'] }})"
                                    class="px-3 py-2 hover:bg-gray-100 cursor-pointer">
                                    {{ $product['name'] }} — ${{ number_format($product['price'], 2) }} (Stock: {{ $product['stock'] }})
                                </li>
                            @endforeach
                        </ul>
                    @endif
                    <x-form.field-error for="productSearch" />
                </div>
                <div>
                    <x-form.input wire:model="productQuantity" type="number" min="1"
                                  label="Cantidad" name="productQuantity" placeholder="0" />
                    <x-form.field-error for="productQuantity" />
                </div>
                <button type="button" wire:click="addProductLine" class="h-10 self-end whitespace-nowrap rounded-radius bg-primary border border-primary px-4 py-2 text-sm font-medium tracking-wide text-on-primary transition hover:opacity-90">
                    Insertar
                </button>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-sm text-on-surface">
                    <thead class="border-b border-outline bg-surface">
                        <tr>
                            <th class="p-2"></th>
                            <th class="p-2 text-left">Nombre producto</th>
                            <th class="p-2 text-left">Cantidad</th>
                            <th class="p-2 text-left">Precio</th>
                            <th class="p-2 text-left">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($lineItems as $item)
                            <tr wire:key="product-{{ $item['product_id'] }}" class="border-b border-outline/50">
                                <td class="p-2">
                                    <button aria-label="Quitar producto" type="button" wire:click="removeLine({{ $item['product_id'] }})" class="inline-flex justify-center items-center aspect-square whitespace-nowrap rounded-full border border-danger bg-danger p-2 text-sm font-medium tracking-wide text-on-danger transition hover:opacity-75 text-center focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-danger active:opacity-100 active:outline-offset-0 disabled:opacity-75 disabled:cursor-not-allowed dark:border-danger dark:bg-danger dark:text-on-danger dark:focus-visible:outline-danger">
                                        <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="size-5 stroke-on-danger dark:stroke-on-danger" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M6 6l12 12M6 18L18 6" />
                                        </svg>
                                    </button>
                                </td>
                                <td class="p-2">
                                    <span class="text-primary font-semibold">{{ $item['name'] }}</span>
                                    <p class="text-xs text-gray-500">Stock: {{ $item['stock'] }}</p>
                                </td>
                                <td class="p-2">
                                    <span class="text-sm text-on-surface">{{ $item['quantity'] }}</span>
                                </td>
                                <td class="p-2">${{ number_format($item['price'], 2) }}</td>
                                <td class="p-2 font-semibold">${{ number_format($item['subtotal'], 2) }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="p-3 text-center text-on-surface-variant">Agrega productos a la venta.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                <x-form.field-error for="lineItems" />
            </div>

            <div class="flex justify-end text-lg font-semibold text-primary">
                Total: ${{ number_format($total_value, 2) }}
            </div>
        </div>

        @php
            $isEdit = property_exists($this, 'sale') && $this->sale?->exists;
        @endphp
        <button type="submit" class="whitespace-nowrap rounded-radius bg-primary border border-primary px-4 py-2 text-sm font-medium tracking-wide text-on-primary transition hover:opacity-75 text-center focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary active:opacity-100 active:outline-offset-0 disabled:opacity-75 disabled:cursor-not-allowed dark:bg-primary-dark dark:border-primary-dark dark:text-on-primary-dark dark:focus-visible:outline-primary-dark">
            {{ $isEdit ? 'Actualizar venta' : 'Crear venta' }}
        </button>
    </form>
</div>
