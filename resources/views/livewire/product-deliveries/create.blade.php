<div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
    <div class="flex h-fit w-full justify-between flex-row gap-4 rounded-xl">
        <a href="{{ route('productdeliveries.index')}}" wire:navigate class="flex w-fit justify-center items-center whitespace-nowrap rounded-radius bg-primary border border-primary px-4 py-2 text-center text-sm font-medium tracking-wide text-on-primary transition hover:opacity-75 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary active:opacity-100 active:outline-offset-0 disabled:cursor-not-allowed disabled:opacity-75 dark:border-primary-dark dark:bg-primary-dark dark:text-on-primary-dark dark:focus-visible:outline-primary-dark" role="button">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
            </svg>

            Volver
        </a>
        <h1 class="p-4 text-center">
            Registro de Entrada de inventario
        </h1>
    </div>
    <form wire:submit.prevent="save" class="space-y-6 p-4 bg-surface-alt dark:bg-surface-dark-alt rounded-lg shadow-md">
        <div class="grid gap-4 md:grid-cols-2">
            <div>
                <label class="block text-sm font-medium text-on-surface mb-1">Fecha</label>
                <input type="date" wire:model="date" disabled class="w-full rounded-radius border border-outline bg-gray-100 px-3 py-2 text-sm text-on-surface-strong focus:outline-none disabled:cursor-not-allowed">
            </div>
            <div class="space-y-2">
                <x-form.input wire:model.live.debounce.300ms="providerSearch"
                              label="Proveedor" name="providerSearch" placeholder="Busca proveedor activo..." />
                @if($providerResults)
                    <ul class="border rounded shadow-sm bg-white text-gray-900">
                        @foreach($providerResults as $prov)
                            <li wire:click="selectProvider({{ $prov['id'] }}, @js($prov['name']))"
                                class="px-3 py-2 hover:bg-gray-100 cursor-pointer">
                                {{ $prov['name'] }}
                            </li>
                        @endforeach
                    </ul>
                @endif
                @if($providerNotFound && $pendingProviderName)
                    <div class="flex items-center gap-3 rounded-radius border border-amber-400 bg-amber-50 px-3 py-2 text-sm text-amber-700">
                        <span>El proveedor "{{ $pendingProviderName }}" no existe. ¿Deseas crearlo?</span>
                        <div class="flex gap-2">
                            <button type="button" wire:click="confirmProviderCreation" class="rounded-radius bg-amber-500 px-3 py-1 text-white text-xs font-semibold">Crear</button>
                            <button type="button" wire:click="resetProviderPrompt" class="rounded-radius border border-outline px-3 py-1 text-xs font-semibold text-on-surface">Cancelar</button>
                        </div>
                    </div>
                @endif
                @error('providerSearch') <p class="text-sm text-danger">{{ $message }}</p> @enderror
                @error('provider_id') <p class="text-sm text-danger">{{ $message }}</p> @enderror
            </div>
        </div>

        <div class="space-y-2 rounded-radius border border-outline p-4">
            <div class="grid gap-3 md:grid-cols-[2fr_140px_auto] items-end">
                <div>
                    <x-form.input wire:model.live.debounce.250ms="productSearch"
                                  label="Producto" name="productSearch" placeholder="Busca producto activo..." />
                    @if($productResults)
                        <ul class="border rounded shadow-sm bg-white text-gray-900 max-h-48 overflow-y-auto">
                            @foreach($productResults as $product)
                                <li wire:click="selectProduct({{ $product['id'] }}, @js($product['name']))"
                                    class="px-3 py-2 hover:bg-gray-100 cursor-pointer">
                                    {{ $product['name'] }}
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
                <div>
                    <x-form.input wire:model="productQuantity" type="number" min="1"
                                  label="Cantidad" name="productQuantity" placeholder="0" />
                </div>
                <button type="button" wire:click="addProductLine" class="h-10 self-end whitespace-nowrap rounded-radius bg-primary border border-primary px-4 py-2 text-sm font-medium tracking-wide text-on-primary transition hover:opacity-90">
                    Insertar
                </button>
            </div>
            @error('productSearch') <p class="text-sm text-danger">{{ $message }}</p> @enderror
            @error('productQuantity') <p class="text-sm text-danger">{{ $message }}</p> @enderror

            <div class="overflow-x-auto">
                <table class="w-full text-sm text-on-surface">
                    <thead class="border-b border-outline bg-surface">
                        <tr>
                            <th class="p-2"></th>
                            <th class="p-2 text-left">Nombre producto</th>
                            <th class="p-2 text-left">Cantidad</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($lineItems as $item)
                            <tr wire:key="product-{{ $item['product_id'] }}" class="border-b border-outline/50">
                                <td class="p-2">
                                    <button type="button" wire:click="removeLine({{ $item['product_id'] }})" class="text-danger font-bold">-</button>
                                </td>
                                <td class="p-2">
                                    <span class="text-primary font-semibold">{{ $item['name'] }}</span>
                                </td>
                                <td class="p-2">
                                    <input type="number" min="1" class="w-24 rounded-radius border border-outline px-2 py-1 text-sm"
                                           value="{{ $item['quantity'] }}"
                                           wire:change="updateLineQuantity({{ $item['product_id'] }}, $event.target.value)">
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="p-3 text-center text-on-surface-variant">Agrega productos a la entrada.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                @error('lineItems') <p class="text-sm text-danger mt-2">{{ $message }}</p> @enderror
            </div>
        </div>

        @php
            $isEdit = property_exists($this, 'delivery') && $this->delivery?->exists;
        @endphp
        <button type="submit" class="whitespace-nowrap rounded-radius bg-primary border border-primary px-4 py-2 text-sm font-medium tracking-wide text-on-primary transition hover:opacity-75 text-center focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary active:opacity-100 active:outline-offset-0 disabled:opacity-75 disabled:cursor-not-allowed dark:bg-primary-dark dark:border-primary-dark dark:text-on-primary-dark dark:focus-visible:outline-primary-dark">
            {{ $isEdit ? 'Actualizar entrada de inventario' : 'Registrar entrada de inventario' }}
        </button>
    </form>
</div>
