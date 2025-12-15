<div class="products-scope flex h-full w-full flex-1 flex-col gap-4 rounded-xl p-4 sm:p-6">
    <style>
        .products-scope {
            --sena-green-600: #0E7A3B;
            --sena-green-500: #1AA855;
            --sena-green-300: #43C678;
            --accent-amber: #F6A300;
            --accent-cyan: #2EC7D6;
            --error: #E5484D;
            --warning: #F6A300;
            --success: #1AA855;

            background: var(--surface);
            color: var(--text);
            border-radius: 16px;
            box-shadow: var(--shadow);
        }

        [data-theme="light"] .products-scope,
        .theme-light .products-scope {
            --surface: #FFFFFF;
            --surface-2: #F5F7F9;
            --text: #0E1420;
            --muted: #4A5568;
            --border: #E2E8F0;
            --shadow: 0 8px 24px -12px rgba(14, 20, 32, 0.18);
        }

        [data-theme="dark"] .products-scope,
        .theme-dark .products-scope {
            --surface: #0F1720;
            --surface-2: #121C27;
            --text: #E6EDF3;
            --muted: #8BA0B5;
            --border: rgba(255, 255, 255, 0.08);
            --shadow: 0 12px 36px -18px rgba(0, 0, 0, 0.6);
            color-scheme: dark;
        }

        .products-label {
            font-size: 0.8rem;
            font-weight: 600;
            color: var(--muted);
        }

        .products-muted {
            color: var(--muted);
        }

        .products-input,
        .products-select {
            border-radius: 0.75rem;
            padding: 0.55rem 0.8rem;
            font-size: 0.85rem;
            color: var(--text);
            outline: none;
            border: 1px solid rgba(148, 163, 184, 0.6);
            background:
                radial-gradient(circle at 0% 0%, rgba(26, 168, 85, 0.12), transparent 55%),
                var(--surface);
            transition:
                border-color 0.14s ease,
                box-shadow 0.14s ease,
                background 0.14s ease,
                transform 0.05s ease;
        }

        .products-input::placeholder {
            color: rgba(148, 163, 184, 0.9);
        }

        .products-input:focus-visible,
        .products-select:focus-visible {
            border-color: rgba(26, 168, 85, 0.9);
            box-shadow: 0 0 0 2px rgba(26, 168, 85, 0.18);
            transform: translateY(-0.5px);
        }

        .products-input:disabled,
        .products-select:disabled {
            opacity: 0.65;
            cursor: not-allowed;
        }

        [data-theme="dark"] .products-scope .products-input,
        .theme-dark .products-scope .products-input,
        [data-theme="dark"] .products-scope .products-select,
        .theme-dark .products-scope .products-select {
            background:
                radial-gradient(circle at 0% 0%, rgba(26, 168, 85, 0.24), transparent 55%),
                #020617;
            border-color: rgba(67, 198, 120, 0.9);
            color: #F9FAFB;
            color-scheme: dark;
        }

        [data-theme="dark"] .products-scope .products-input::placeholder,
        .theme-dark .products-scope .products-input::placeholder {
            color: rgba(148, 163, 184, 0.9);
        }

        
        .products-select {
            appearance: none;
            -webkit-appearance: none;
            position: relative;
            padding-right: 2rem;
        }

        .products-select option {
            background-color: #ffffff;
            color: #0E1420;
        }

        [data-theme="dark"] .products-scope .products-select option,
        .theme-dark .products-scope .products-select option {
            background-color: #020617;
            color: #E6EDF3;
        }

        [data-theme="dark"] .products-scope .products-select option:checked,
        [data-theme="dark"] .products-scope .products-select option:focus,
        .theme-dark .products-scope .products-select option:checked,
        .theme-dark .products-scope .products-select option:focus {
            background-color: rgba(67, 198, 120, 0.30);
            color: #43C678;
        }

        
        .products-select-wrapper {
            position: relative;
        }
        .products-select-wrapper::after {
            content: "";
            position: absolute;
            right: 0.75rem;
            top: 50%;
            width: 0.55rem;
            height: 0.55rem;
            border-right: 2px solid rgba(148, 163, 184, 0.85);
            border-bottom: 2px solid rgba(148, 163, 184, 0.85);
            transform: translateY(-60%) rotate(45deg);
            pointer-events: none;
        }

        .btn-primary {
            background: var(--sena-green-500);
            border-radius: 12px;
            border: 1px solid var(--sena-green-500);
            color: #FFFFFF;
            font-size: 0.85rem;
            font-weight: 700;
            padding: 8px 14px;
            box-shadow: 0 12px 22px -14px rgba(26, 168, 85, 0.7);
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
            transition: transform 0.15s ease, filter 0.15s ease, box-shadow 0.15s ease;
            white-space: nowrap;
        }

        .btn-primary:hover {
            filter: brightness(1.03);
            transform: translateY(-1px);
        }

        .btn-primary:focus-visible {
            outline: 3px solid rgba(26, 168, 85, 0.28);
            outline-offset: 2px;
        }

        .btn-secondary {
            background: var(--surface-2);
            border-radius: 10px;
            border: 1px solid var(--border);
            color: var(--text);
            font-size: 0.75rem;
            font-weight: 600;
            padding: 6px 10px;
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
            transition: background 0.15s ease, border-color 0.15s ease, transform 0.12s ease;
        }

        .btn-secondary:hover {
            background: rgba(26, 168, 85, 0.08);
            border-color: rgba(26, 168, 85, 0.45);
        }

        .btn-danger {
            background: var(--error);
            border-radius: 10px;
            border: 1px solid var(--error);
            color: #FFFFFF;
            font-size: 0.75rem;
            font-weight: 600;
            padding: 6px 10px;
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
            transition: filter 0.15s ease, transform 0.12s ease;
        }

        .btn-danger:hover {
            filter: brightness(1.05);
            transform: translateY(-1px);
        }

        .btn-success {
            background: var(--success);
            border-radius: 10px;
            border: 1px solid var(--success);
            color: #FFFFFF;
            font-size: 0.75rem;
            font-weight: 600;
            padding: 6px 10px;
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
            transition: filter 0.15s ease, transform 0.12s ease;
        }

        .btn-success:hover {
            filter: brightness(1.05);
            transform: translateY(-1px);
        }

        
        .products-alert {
            border-radius: 14px;
            border: 1px solid rgba(26, 168, 85, 0.45);
            background: rgba(26, 168, 85, 0.08);
            color: var(--text);
            box-shadow: 0 10px 24px -14px rgba(26, 168, 85, 0.35);
            overflow: hidden;
        }

        .products-alert-header {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.75rem 1rem;
        }

        .products-alert-icon {
            background: linear-gradient(135deg, var(--sena-green-500), var(--accent-cyan));
            color: #FFFFFF;
            border-radius: 9999px;
            padding: 4px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 10px 24px -14px rgba(26, 168, 85, 0.65);
        }

        .products-alert-title {
            font-size: 0.85rem;
            font-weight: 700;
            color: var(--sena-green-500);
        }

        .products-alert-text {
            font-size: 0.8rem;
            font-weight: 500;
            color: var(--text);
        }

        .products-table-wrapper {
            border-radius: 16px;
            border: 1px solid var(--border);
            overflow: hidden;
            background: var(--surface-2);
        }

        .products-table-title {
            text-align: center;
            padding: 0.75rem 1rem;
            font-weight: 700;
            font-size: 0.9rem;
            color: #ffffff;
            background: var(--sena-green-500);
        }

        .products-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.85rem;
            color: var(--text);
        }

	        .products-table thead th {
	            padding: 0.75rem 1rem;
	            text-align: left;
	            font-weight: 700;
	            font-size: 0.8rem;
	            color: var(--muted);
	            background: rgba(26, 168, 85, 0.08);
	            border-bottom: 1px solid var(--border);
	            white-space: nowrap;
	        }

	        .products-table th.products-actions-cell,
	        .products-table td.products-actions-cell {
	            width: 1%;
	            white-space: nowrap;
	            text-align: center;
	        }

	        .products-table tbody td {
	            padding: 0.75rem 1rem;
	            border-top: 1px solid var(--border);
	            vertical-align: middle;
	        }

        .products-table tbody tr:first-child td {
            border-top: none;
        }

        .products-table tbody tr:nth-child(even) {
            background: rgba(14, 122, 59, 0.03);
        }

        [data-theme="dark"] .products-scope .products-table tbody tr:nth-child(even),
        .theme-dark .products-scope .products-table tbody tr:nth-child(even) {
            background: rgba(14, 122, 59, 0.05);
        }

        .products-table tbody tr:hover {
            background: rgba(26, 168, 85, 0.10);
        }

        
        .badge {
            display: inline-flex;
            align-items: center;
            border-radius: 9999px;
            padding: 4px 10px;
            font-size: 0.7rem;
            font-weight: 700;
            white-space: nowrap;
        }

        .badge-stock-error {
            background: rgba(229, 72, 77, 0.12);
            color: #B4232A;
            border: 1px solid rgba(229, 72, 77, 0.4);
        }

        .badge-stock-warning {
            background: rgba(246, 163, 0, 0.16);
            color: #A86A00;
            border: 1px solid rgba(246, 163, 0, 0.45);
        }

        .badge-stock-success {
            background: rgba(26, 168, 85, 0.12);
            color: #0E7A3B;
            border: 1px solid rgba(26, 168, 85, 0.45);
        }

        .badge-status-active {
            background: rgba(26, 168, 85, 0.14);
            color: #0E7A3B;
            border: 1px solid rgba(26, 168, 85, 0.4);
        }

        .badge-status-inactive {
            background: rgba(229, 72, 77, 0.14);
            color: #B4232A;
            border: 1px solid rgba(229, 72, 77, 0.4);
        }

        
        .products-search-wrapper {
            position: relative;
        }

        .products-search-icon {
            position: absolute;
            left: 0.75rem;
            top: 50%;
            transform: translateY(-50%);
            opacity: 0.9;
            color: var(--muted);
        }

        .products-search-input {
            padding-left: 2.25rem;
        }
    </style>

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
            <a href="{{ route('products.create') }}" wire:navigate class="btn-primary self-start sm:self-auto" role="button">
                Registrar un producto
            </a>
        @endif

        
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
                    <option value="stock_desc">Stock: má­s a menos</option>
                    <option value="stock_asc">Stock: menos a má­s</option>
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
            <label class="products-label">Categoria</label>
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

        <div class="overflow-x-auto">
            <table class="products-table">
                <thead>
                    <tr>
                        <th scope="col">Nombre</th>
                        <th scope="col">Stock</th>
                        <th scope="col">Precio</th>
                        <th scope="col">Categoría</th>
                        <th scope="col">Estado</th>
                        @if ($isAdmin)
	                            <th scope="col" class="products-actions-cell">Acciones</th>
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
	                            <td class="products-actions-cell">
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
        </div>

        <div class="p-4">
            {{ $products->links() }}
        </div>
    </div>
</div>
