<div class="products-scope flex h-full w-full flex-1 flex-col gap-4 rounded-xl p-4 sm:p-6">
        @include('partials.sena-ui')

    @if (session('success'))
        <div
            x-data="{ alertIsVisible: true }"
            x-show="alertIsVisible"
            class="products-alert"
            role="alert"
            x-transition:leave="transition ease-in duration-300"
            x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-90"
        >
            <div class="products-alert-header">
                <div class="products-alert-icon" aria-hidden="true">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-5 w-5" aria-hidden="true">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16Zm3.857-9.809a.75.75 0 0 0-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 1 0-1.06 1.061l2.5 2.5a.75.75 0 0 0 1.137-.089l4-5.5Z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="flex flex-col gap-0.5">
                    <h3 class="products-alert-title">Mensajes de producto</h3>
                    <p class="products-alert-text">{{ session('success') }}</p>
                </div>
                <button
                    type="button"
                    @click="alertIsVisible = false"
                    class="ml-auto btn-secondary"
                    aria-label="dismiss alert"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" aria-hidden="true" stroke="currentColor" fill="none" stroke-width="2" class="w-4 h-4 shrink-0">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                    Cerrar
                </button>
            </div>
        </div>
    @endif

    @php
        $isAdmin = auth()->user()?->isAdmin();
    @endphp

    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        @if ($isAdmin)
            <a href="{{ route('products.create') }}" wire:navigate class="btn-primary" role="button">
                Registrar un producto
            </a>
        @endif

        {{-- BUSCADOR CON ESTILO TIPO BADGE --}}
        <div class="products-search-wrapper w-full max-w-xs">
            <span class="products-search-icon">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true" class="h-5 w-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                </svg>
            </span>
            <input
                type="search"
                wire:model.live.debounce.300ms="search"
                class="products-input products-search-input w-full"
                name="search"
                placeholder="Buscar producto..."
                aria-label="search"
            />
        </div>
    </div>

    {{-- FILTROS: Orden / Stock / Estado / Categoría con el mismo lenguaje visual --}}
    <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-4">
        <div class="flex flex-col gap-1 text-sm">
            <label class="products-label">Orden</label>
            <div class="products-select-wrapper">
                <select wire:model.live="order" class="products-select w-full">
                    <option value="created_desc">Creación: nuevo a antiguo</option>
                    <option value="created_asc">Creación: antiguo a nuevo</option>
                    <option value="name_asc">Nombre: A a Z</option>
                </select>
            </div>
        </div>
        <div class="flex flex-col gap-1 text-sm">
            <label class="products-label">Stock</label>
            <div class="products-select-wrapper">
                <select wire:model.live="stockOrder" class="products-select w-full">
                    <option value="none">Sin ordenar por stock</option>
                    <option value="stock_desc">Stock: más a menos</option>
                    <option value="stock_asc">Stock: menos a más</option>
                </select>
            </div>
        </div>
        <div class="flex flex-col gap-1 text-sm">
            <label class="products-label">Estado</label>
            <div class="products-select-wrapper">
                <select wire:model.live="status" class="products-select w-full">
                    <option value="all">Todos</option>
                    <option value="active">Activos</option>
                    <option value="inactive">Inactivos</option>
                </select>
            </div>
        </div>
        <div class="flex flex-col gap-1 text-sm">
            <label class="products-label">Categoría</label>
            <div class="products-select-wrapper">
                <select wire:model.live="category" class="products-select w-full">
                    <option value="all">Todas</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat['id'] }}">{{ $cat['name'] }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>

    <div class="products-table-wrapper w-full mt-2">
        <h2 class="products-table-title">Productos</h2>

        <table class="products-table">
            <thead>
                <tr>
                    <th scope="col">Nombre</th>
                    <th scope="col">Stock</th>
                    <th scope="col">Precio</th>
                    <th scope="col">Categoría</th>
                    <th scope="col">Estado</th>
                    @if ($isAdmin)
                        <th scope="col" class="text-center">Acciones</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @forelse ($products as $product)
                    <tr>
                        <td>{{ $product->name }}</td>
                        <td>
                            @php
                                $maxStock = 1000;
                                $stock = (int) $product->stock;
                                if ($stock < 0) {
                                    $stock = 0;
                                }
                                $lowThreshold = (int) floor($maxStock * 0.2);
                                $midThreshold = (int) floor($maxStock * 0.6);

                                if ($stock === 0) {
                                    $stockBadge = ['label' => 'Stock agotado', 'classes' => 'badge badge-stock-error', 'icon' => true];
                                } elseif ($stock < $lowThreshold) {
                                    $stockBadge = ['label' => 'Stock bajo', 'classes' => 'badge badge-stock-error', 'icon' => false];
                                } elseif ($stock < $midThreshold) {
                                    $stockBadge = ['label' => 'Reabastecer pronto', 'classes' => 'badge badge-stock-warning', 'icon' => false];
                                } else {
                                    $stockBadge = ['label' => 'Stock lleno', 'classes' => 'badge badge-stock-success', 'icon' => false];
                                }
                            @endphp
                            <div class="flex items-center gap-2">
                                <span class="text-sm">{{ $product->stock }} {{ $product->category->measure->name }}</span>
                                <span class="{{ $stockBadge['classes'] }}">
                                    @if (!empty($stockBadge['icon']))
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v4m0 4h.01m-6.938 0h13.856c1.54 0 2.502-1.667 1.732-3L13.732 5c-.77-1.333-2.694-1.333-3.464 0L4.34 14c-.77 1.333.192 3 1.732 3z" />
                                        </svg>
                                    @endif
                                    {{ $stockBadge['label'] }}
                                </span>
                            </div>
                        </td>
                        <td>{{ $product->price }}</td>
                        <td>{{ $product->category->name }}</td>

                        <td>
                            <span class="badge {{ $product->status ? 'badge-status-active' : 'badge-status-inactive' }}">
                                {{ $product->status ? 'Activo' : 'Inactivo' }}
                            </span>
                        </td>

                        @if ($isAdmin)
                            <td class="text-center">
                                <div class="flex justify-center items-center gap-2">
                                    <a href="{{ route('products.update', $product)}}" wire:navigate>
                                        <button type="button" class="btn-secondary">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-4 w-4">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L6.832 19.82a4.5 4.5 0 0 1-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 0 1 1.13-1.897L16.863 4.487Zm0 0L19.5 7.125" />
                                            </svg>
                                            Editar
                                        </button>
                                    </a>
                                    @if ($product->status)
                                        <button
                                            wire:click="toggleStatus({{ $product->id }})"
                                            wire:confirm="¿Estás seguro de inhabilitar el producto {{ $product->name }}?"
                                            type="button"
                                            class="btn-danger"
                                        >
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-4 w-4">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                                            </svg>
                                            Inhabilitar
                                        </button>
                                    @else
                                        <button
                                            wire:click="toggleStatus({{ $product->id }})"
                                            wire:confirm="¿Estás seguro de habilitar al producto {{ $product->name }}?"
                                            type="button"
                                            class="btn-success"
                                        >
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-4 w-4">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16Zm3.857-9.809a.75.75 0 0 0-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 1 0-1.06 1.061l2.5 2.5a.75.75 0 0 0 1.137-.089l4-5.5Z" clip-rule="evenodd" />
                                            </svg>
                                            Habilitar
                                        </button>
                                    @endif
                                </div>
                            </td>
                        @endif
                    </tr>
                @empty
                    <tr>
                        <td colspan="{{ $isAdmin ? 6 : 5 }}" class="products-muted text-center py-4">
                            No hay productos registrados.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="p-4">
            {{ $products->links() }}
        </div>
    </div>
</div>

