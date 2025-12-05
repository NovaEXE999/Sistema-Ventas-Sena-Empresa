<div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
    <div class="flex h-fit w-full justify-between flex-row gap-4 rounded-xl">
        <a href="{{ route('products.index')}}" wire:navigate class="flex w-fit justify-center items-center whitespace-nowrap rounded-radius bg-primary border border-primary px-4 py-2 text-center text-sm font-medium tracking-wide text-on-primary transition hover:opacity-75 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary active:opacity-100 active:outline-offset-0 disabled:cursor-not-allowed disabled:opacity-75 dark:border-primary-dark dark:bg-primary-dark dark:text-on-primary-dark dark:focus-visible:outline-primary-dark" role="button">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
            </svg>

            Volver
        </a>
        <h1 class="p-4 text-center">
            Registro de productos
        </h1>
    </div>

    <form wire:submit="save" class="space-y-4 max-w-2xl p-4 bg-surface-alt dark:bg-surface-dark-alt rounded-lg shadow-md">
        <x-form.input wire:model="name" label="Nombre" name="name" placeholder="Ingresa el nombre del producto"/>
        <x-form.input wire:model="stock" type="number" min="0" label="Stock" name="stock" placeholder="Ingresa el stock"/>
        <x-form.input wire:model="price" label="Precio" name="price" placeholder="Ingresa el precio"/>
        <label class="inline-flex items-center gap-2 text-sm">
            <input type="checkbox" wire:model="status" class="rounded border-outline">
            <span>Activo</span>
        </label>

        {{-- Categoría --}}
        <div class="space-y-1">
            <x-form.input wire:model.live.debounce.300ms="categorySearch"
                          label="Categoría" name="categorySearch" placeholder="Escribe para buscar..." />
            @if($categoryResults)
                <ul class="border rounded shadow-sm bg-white text-gray-900 max-h-48 overflow-y-auto">
                    @foreach($categoryResults as $cat)
                        <li wire:click="selectCategory({{ $cat['id'] }}, @js($cat['name']))"
                            class="px-3 py-2 hover:bg-gray-100 cursor-pointer">
                            {{ $cat['name'] }}
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>

        @php
            $isEdit = property_exists($this, 'product') && $this->product?->exists;
        @endphp
        <!-- primary Button -->
        <button type="submit" class="whitespace-nowrap rounded-radius bg-primary border border-primary px-4 py-2 text-sm font-medium tracking-wide text-on-primary transition hover:opacity-75 text-center focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary active:opacity-100 active:outline-offset-0 disabled:opacity-75 disabled:cursor-not-allowed dark:bg-primary-dark dark:border-primary-dark dark:text-on-primary-dark dark:focus-visible:outline-primary-dark">
            {{ $isEdit ? 'Actualizar producto' : 'Crear producto' }}
        </button>
    </form>
</div>
