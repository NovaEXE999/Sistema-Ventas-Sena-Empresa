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
    <form wire:submit="save" class="space-y-4 max-w-2xl p-4 bg-surface-alt dark:bg-surface-dark-alt rounded-lg shadow-md">

        <x-form.input wire:model="date" type="date" label="Fecha" name="date" placeholder="Selecciona la fecha"/>
        <x-form.input wire:model="delivered_amount" label="Cantidad entregada" name="delivered_amount" placeholder="Ingresa la cantidad entregada"/>
        
        {{-- Producto --}}
        <div class="space-y-1">
            <x-form.input wire:model.live.debounce.300ms="productSearch"
                          label="Producto" name="productSearch" placeholder="Escribe para buscar..." />
            @if($productResults)
                <ul class="border rounded shadow-sm bg-black">
                    @foreach($productResults as $product)
                        <li wire:click="selectProduct({{ $product['id'] }}, '{{ $product['name'] }}')"
                            class="px-3 py-2 hover:bg-gray-100 cursor-pointer">
                            {{ $product['name'] }}
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>

        {{-- Proveedor --}}
        <div class="space-y-1 mt-3">
            <x-form.input wire:model.live.debounce.300ms="providerSearch"
                          label="Proveedor" name="providerSearch" placeholder="Escribe para buscar..." />
            @if($providerResults)
                <ul class="border rounded shadow-sm bg-black">
                    @foreach($providerResults as $prov)
                        <li wire:click="selectProvider({{ $prov['id'] }}, '{{ $prov['name'] }}')"
                            class="px-3 py-2 hover:bg-gray-100 cursor-pointer">
                            {{ $prov['name'] }}
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>

        @php
            $isEdit = property_exists($this, 'delivery') && $this->delivery?->exists;
        @endphp
        <!-- primary Button -->
        <button type="submit" class="whitespace-nowrap rounded-radius bg-primary border border-primary px-4 py-2 text-sm font-medium tracking-wide text-on-primary transition hover:opacity-75 text-center focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary active:opacity-100 active:outline-offset-0 disabled:opacity-75 disabled:cursor-not-allowed dark:bg-primary-dark dark:border-primary-dark dark:text-on-primary-dark dark:focus-visible:outline-primary-dark">
            {{ $isEdit ? 'Actualizar entrada de inventario' : 'Crear entrada de inventario' }}
        </button>


    </form>
</div>
