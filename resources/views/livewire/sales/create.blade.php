<div class="sales-form-scope flex h-full w-full flex-1 flex-col gap-6 items-stretch">
    <style>
        .sales-form-scope {
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
        }

        [data-theme="light"] .sales-form-scope,
        .theme-light .sales-form-scope {
            --surface: #FFFFFF;
            --surface-2: #F5F7F9;
            --text: #0E1420;
            --muted: #4A5568;
            --border: #E2E8F0;
            --shadow-soft: 0 12px 32px -18px rgba(15, 23, 42, 0.28);
        }

        [data-theme="dark"] .sales-form-scope,
        .theme-dark .sales-form-scope {
            --surface: #0F1720;
            --surface-2: #111827;
            --text: #E6EDF3;
            --muted: #8BA0B5;
            --border: rgba(255, 255, 255, 0.06);
            --shadow-soft: 0 18px 40px -24px rgba(0, 0, 0, 0.95);
        }

        /* TOPBAR: botón volver pegado a la izquierda */
        .sales-form-topbar {
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: flex-start;
            padding-top: 0.5rem;
            padding-left: 0.5rem;
        }

        @media (min-width: 640px) {
            .sales-form-topbar {
                padding-left: 0;
            }
        }

        /* HEADER SOLO PARA EL TÍTULO (centrado) */
        .sales-form-header {
            width: 100%;
            max-width: 52rem;
            margin: 0 auto;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .sales-form-title-badge {
            display: inline-flex;
            align-items: center;
            gap: .5rem;
            padding: .45rem 1.4rem;
            border-radius: 9999px;
            background: radial-gradient(circle at 0% 0%, rgba(26, 168, 85, 0.20), transparent 55%),
                        rgba(15, 23, 42, 0.03);
            border: 1px solid rgba(26, 168, 85, 0.45);
            box-shadow: 0 14px 32px -18px rgba(26, 168, 85, 0.65);
            backdrop-filter: blur(9px);
        }

        [data-theme="dark"] .sales-form-scope .sales-form-title-badge,
        .theme-dark .sales-form-scope .sales-form-title-badge {
            background: radial-gradient(circle at 0% 0%, rgba(26, 168, 85, 0.32), transparent 55%),
                        rgba(15, 23, 42, 0.5);
        }

        .sales-form-title-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 26px;
            height: 26px;
            border-radius: 9999px;
            background: linear-gradient(135deg, var(--sena-green-500), var(--accent-cyan));
            color: #fff;
        }

        .sales-form-title-text {
            font-size: 0.9rem;
            font-weight: 700;
            letter-spacing: .08em;
            text-transform: uppercase;
            color: var(--text);
        }

        .sales-form-subtitle {
            display: block;
            font-size: 0.7rem;
            font-weight: 500;
            letter-spacing: .14em;
            text-transform: uppercase;
            color: var(--muted);
        }

        /* CARD FORM */
        .sales-form {
            width: 100%;
            max-width: 50rem;
            margin: .75rem auto 0 auto;
            padding: 1.75rem 1.75rem 1.5rem;
            border-radius: 20px;
            background: linear-gradient(135deg, rgba(15, 23, 42, 0.02), rgba(26, 168, 85, 0.02));
            border: 1px solid var(--border);
            box-shadow: var(--shadow-soft);
        }

        .sales-form-grid {
            display: grid;
            grid-template-columns: minmax(0, 1fr);
            gap: 1rem;
        }

        @media (min-width: 768px) {
            .sales-form-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        .sales-form-full {
            grid-column: 1 / -1;
        }

        .sales-form-label {
            font-size: 0.78rem;
            font-weight: 600;
            color: var(--muted);
            margin-bottom: 0.2rem;
            display: inline-block;
        }

        .sales-form-helper {
            font-size: 0.70rem;
            color: var(--muted);
            margin-top: 0.15rem;
        }

        /* Inputs dentro del scope */
        .sales-form-scope input[type="text"],
        .sales-form-scope input[type="number"],
        .sales-form-scope input[type="date"],
        .sales-form-scope input[type="month"],
        .sales-form-scope input[type="search"],
        .sales-form-scope input[type="email"],
        .sales-form-scope input[type="password"],
        .sales-form-scope textarea,
        .sales-form-scope select {
            background: var(--surface);
            border-radius: 0.75rem;
            border: 1px solid rgba(148, 163, 184, 0.6);
            padding: 0.55rem 0.8rem;
            font-size: 0.85rem;
            color: var(--text);
            outline: none;
            transition: border-color 0.14s ease, box-shadow 0.14s ease, background 0.14s ease, transform 0.04s ease;
        }

        .sales-form-scope input::placeholder,
        .sales-form-scope textarea::placeholder {
            color: rgba(148, 163, 184, 0.9);
        }

        .sales-form-scope input:focus-visible,
        .sales-form-scope textarea:focus-visible,
        .sales-form-scope select:focus-visible {
            border-color: rgba(26, 168, 85, 0.9);
            box-shadow: 0 0 0 2px rgba(26, 168, 85, 0.18);
            transform: translateY(-0.5px);
        }

        .sales-form-scope input:disabled,
        .sales-form-scope textarea:disabled,
        .sales-form-scope select:disabled {
            opacity: 0.65;
            cursor: not-allowed;
        }

        [data-theme="dark"] .sales-form-scope input[type="text"],
        [data-theme="dark"] .sales-form-scope input[type="number"],
        [data-theme="dark"] .sales-form-scope input[type="date"],
        [data-theme="dark"] .sales-form-scope input[type="month"],
        [data-theme="dark"] .sales-form-scope input[type="search"],
        [data-theme="dark"] .sales-form-scope input[type="email"],
        [data-theme="dark"] .sales-form-scope input[type="password"],
        [data-theme="dark"] .sales-form-scope textarea,
        [data-theme="dark"] .sales-form-scope select,
        .theme-dark .sales-form-scope input[type="text"],
        .theme-dark .sales-form-scope input[type="number"],
        .theme-dark .sales-form-scope input[type="date"],
        .theme-dark .sales-form-scope input[type="month"],
        .theme-dark .sales-form-scope input[type="search"],
        .theme-dark .sales-form-scope input[type="email"],
        .theme-dark .sales-form-scope input[type="password"],
        .theme-dark .sales-form-scope textarea,
        .theme-dark .sales-form-scope select {
            background: #020617;
            border-color: rgba(67, 198, 120, 0.9);
            color: #F9FAFB;
            color-scheme: dark;
        }

        [data-theme="dark"] .sales-form-scope select option,
        .theme-dark .sales-form-scope select option {
            background-color: #020617;
            color: #E6EDF3;
        }

        [data-theme="dark"] .sales-form-scope select option:checked,
        [data-theme="dark"] .sales-form-scope select option:focus,
        .theme-dark .sales-form-scope select option:checked,
        .theme-dark .sales-form-scope select option:focus {
            background-color: rgba(67, 198, 120, 0.30);
            color: #43C678;
        }

        /* Autocomplete/resultados */
        .autocomplete-results {
            margin-top: .25rem;
            border-radius: 14px;
            border: 1px solid var(--border);
            background: radial-gradient(circle at 0% 0%, rgba(26, 168, 85, 0.05), transparent 55%),
                        var(--surface);
            color: var(--text);
            box-shadow: var(--shadow-soft);
            max-height: 12rem;
            overflow-y: auto;
            font-size: 0.82rem;
        }

        .autocomplete-results-item {
            padding: 0.5rem 0.75rem;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: .5rem;
            transition: background 0.12s ease, color 0.12s ease, transform 0.04s ease;
        }

        .autocomplete-results-item span {
            font-size: .72rem;
            color: var(--muted);
        }

        .autocomplete-results-item:hover {
            background: rgba(26, 168, 85, 0.12);
            color: var(--sena-green-300);
            transform: translateY(-0.5px);
        }

        /* Errores de campo */
        .sales-form-scope .text-error,
        .sales-form-scope .form-error {
            color: var(--error);
            font-size: 0.75rem;
        }

        /* Botón submit */
        .sales-form-submit {
            margin-top: .5rem;
            background: linear-gradient(135deg, var(--sena-green-500), var(--sena-green-600));
            border-radius: 9999px;
            border: 1px solid var(--sena-green-500);
            color: #FFFFFF;
            font-size: 0.85rem;
            font-weight: 700;
            padding: 0.65rem 1.4rem;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.45rem;
            white-space: nowrap;
            transition: transform 0.15s ease, filter 0.15s ease, box-shadow 0.15s ease;
            box-shadow: 0 14px 30px -18px rgba(26, 168, 85, 0.85);
        }

        .sales-form-submit:hover {
            filter: brightness(1.03);
            transform: translateY(-1px);
        }

        .sales-form-submit:focus-visible {
            outline: 3px solid rgba(26, 168, 85, 0.32);
            outline-offset: 2px;
        }

        .sales-form-submit:disabled {
            opacity: .7;
            cursor: not-allowed;
            box-shadow: none;
        }

        /* ===========
           BOTÓN VOLVER
           =========== */
        .sales-form-back-btn {
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
            padding: 0.4rem 1.2rem;
            border-radius: 9999px;
            background: radial-gradient(circle at 0% 0%, rgba(26, 168, 85, 0.20), transparent 55%),
                        rgba(15, 23, 42, 0.03);
            border: 1px solid rgba(26, 168, 85, 0.45);
            box-shadow: 0 10px 26px -18px rgba(26, 168, 85, 0.70);
            color: var(--text);
            font-size: 0.78rem;
            font-weight: 600;
            text-decoration: none;
            white-space: nowrap;
            transition: transform 0.15s ease, filter 0.15s ease, box-shadow 0.15s ease, background 0.15s ease;
        }

        .sales-form-back-btn svg {
            width: 18px;
            height: 18px;
        }

        .sales-form-back-btn:hover {
            filter: brightness(1.03);
            transform: translateY(-1px);
            box-shadow: 0 14px 32px -18px rgba(26, 168, 85, 0.85);
        }

        .sales-form-back-btn:focus-visible {
            outline: 2px solid rgba(26, 168, 85, 0.45);
            outline-offset: 2px;
        }

        [data-theme="dark"] .sales-form-scope .sales-form-back-btn,
        .theme-dark .sales-form-scope .sales-form-back-btn {
            background: radial-gradient(circle at 0% 0%, rgba(26, 168, 85, 0.32), transparent 55%),
                        rgba(15, 23, 42, 0.55);
            color: #E6EDF3;
            border-color: rgba(26, 168, 85, 0.65);
        }

        /* Botones de acción */
        .btn-insert {
            background: var(--sena-green-500);
            border-radius: 10px;
            border: 1px solid var(--sena-green-500);
            color: #FFFFFF;
            font-size: 0.8rem;
            font-weight: 600;
            padding: 0.5rem 1rem;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.35rem;
            transition: filter 0.15s ease, transform 0.12s ease;
            white-space: nowrap;
        }

        .btn-insert:hover {
            filter: brightness(1.05);
            transform: translateY(-1px);
        }

        .btn-remove {
            background: var(--error);
            border-radius: 9999px;
            border: 1px solid var(--error);
            color: #FFFFFF;
            padding: 0.5rem;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: filter 0.15s ease, transform 0.12s ease;
        }

        .btn-remove:hover {
            filter: brightness(1.05);
            transform: translateY(-1px);
        }

        /* Tabla de productos */
        .sales-products-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.85rem;
            color: var(--text);
        }

        .sales-products-table thead th {
            padding: 0.5rem;
            text-align: left;
            font-weight: 600;
            font-size: 0.75rem;
            color: var(--muted);
            background: rgba(26, 168, 85, 0.08);
            border-bottom: 1px solid var(--border);
        }

        .sales-products-table tbody td {
            padding: 0.5rem;
            border-top: 1px solid var(--border);
            vertical-align: middle;
        }

        .sales-products-table tbody tr:first-child td {
            border-top: none;
        }

        .sales-products-table tbody tr:nth-child(even) {
            background: rgba(14, 122, 59, 0.03);
        }

        [data-theme="dark"] .sales-form-scope .sales-products-table tbody tr:nth-child(even),
        .theme-dark .sales-form-scope .sales-products-table tbody tr:nth-child(even) {
            background: rgba(14, 122, 59, 0.05);
        }

        /* Sección de productos */
        .sales-products-section {
            border-radius: 16px;
            border: 1px solid var(--border);
            padding: 1rem;
            background: var(--surface-2);
        }
    </style>

    {{-- TOPBAR: botón Volver --}}
    <div class="sales-form-topbar">
        <a href="{{ route('sales.index')}}"
           wire:navigate
           class="sales-form-back-btn"
           role="button">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
            </svg>
            <span class="ml-1">Volver</span>
        </a>
    </div>

    {{-- HEADER: título centrado con badge --}}
    <div class="sales-form-header">
        <div class="sales-form-title-badge">
            <div class="sales-form-title-icon">
                <svg viewBox="0 0 24 24" class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M3 3h18v18H3z" />
                    <path d="M21 9H3" />
                    <path d="M21 15H3" />
                    <path d="M12 3v18" />
                </svg>
            </div>
            <div class="flex flex-col leading-tight">
                <span class="sales-form-title-text">Registro de ventas</span>
                <span class="sales-form-subtitle">Gestiona productos y clientes</span>
            </div>
        </div>
    </div>

    <x-form.error-alert />

    <form wire:submit.prevent="save" class="sales-form">
        <div class="sales-form-grid">
            {{-- Fecha --}}
            <div>
                <label class="sales-form-label">Fecha</label>
                <input type="date" wire:model="date" disabled class="w-full">
            </div>

            {{-- Vendedor --}}
            <div>
                <label class="sales-form-label">Vendedor</label>
                <input type="text" value="{{ $sellerName }}" disabled class="w-full">
            </div>

            {{-- Método de pago --}}
            <div class="sales-form-full">
                <label class="sales-form-label">Método de pago</label>
                <select wire:model="payment_method_id" class="w-full">
                    <option value="">Seleccione...</option>
                    @foreach($paymentMethods as $method)
                        <option value="{{ $method['id'] }}">{{ $method['name'] }}</option>
                    @endforeach
                </select>
                <x-form.field-error for="payment_method_id" />
            </div>
        </div>

        {{-- Cliente --}}
        <div class="sales-form-full mt-4" x-data @click.outside="$wire.hideClientResults()">
            <x-form.input wire:model.live.debounce.300ms="clientSearch"
                          wire:blur="ensureClientSelected"
                          autocomplete="off"
                          label="Cliente" name="clientSearch" placeholder="Busca o escribe el cliente..." />
            @if($clientResults)
                <ul class="autocomplete-results">
                    @foreach($clientResults as $client)
                        <li wire:mousedown.prevent="selectClient({{ $client['id'] }}, @js($client['name']))"
                            class="autocomplete-results-item">
                            <div class="flex flex-col">
                                <span class="font-medium">{{ $client['name'] }}</span>
                                @if(!empty($client['identification']))
                                    <span class="text-xs">ID: {{ $client['identification'] }}</span>
                                @endif
                            </div>
                        </li>
                    @endforeach
                </ul>
            @endif
            <x-form.field-error for="clientSearch" />
        </div>

        {{-- Productos --}}
        <div class="sales-form-full mt-4 sales-products-section">
            <div class="grid gap-3 md:grid-cols-[2fr_120px_auto] items-end mb-4">
                <div x-data @click.outside="$wire.hideProductResults()">
                    <x-form.input wire:model.live.debounce.250ms="productSearch"
                                  wire:blur="hideProductResults"
                                  autocomplete="off"
                                  label="Producto" name="productSearch" placeholder="Busca el producto..." />
                    @if($productResults)
                        <ul class="autocomplete-results">
                            @foreach($productResults as $product)
                                <li wire:mousedown.prevent="selectProduct({{ $product['id'] }})"
                                    class="autocomplete-results-item">
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
                <button type="button" wire:click="addProductLine" class="btn-insert h-10">
                    Insertar
                </button>
            </div>

            <div class="overflow-x-auto">
                <table class="sales-products-table">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Nombre producto</th>
                            <th>Cantidad</th>
                            <th>Precio</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($lineItems as $item)
                            <tr wire:key="product-{{ $item['product_id'] }}">
                                <td>
                                    <button aria-label="Quitar producto" type="button" wire:click="removeLine({{ $item['product_id'] }})" class="btn-remove">
                                        <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M6 6l12 12M6 18L18 6" />
                                        </svg>
                                    </button>
                                </td>
                                <td>
                                    <span class="font-semibold" style="color: var(--sena-green-500);">{{ $item['name'] }}</span>
                                    <p class="text-xs sales-form-helper">Stock: {{ $item['stock'] }}</p>
                                </td>
                                <td>
                                    <span class="text-sm">{{ $item['quantity'] }}</span>
                                </td>
                                <td>${{ number_format($item['price'], 2) }}</td>
                                <td class="font-semibold">${{ number_format($item['subtotal'], 2) }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center sales-form-helper py-3">Agrega productos a la venta.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                <x-form.field-error for="lineItems" />
            </div>

            <div class="flex justify-end text-lg font-semibold mt-3" style="color: var(--sena-green-500);">
                Total: ${{ number_format($total_value, 2) }}
            </div>
        </div>

        @php
            $isEdit = property_exists($this, 'sale') && $this->sale?->exists;
        @endphp

        <div class="sales-form-full mt-4 flex justify-end">
            <button
                type="submit"
                class="sales-form-submit"
            >
                {{ $isEdit ? 'Actualizar venta' : 'Crear venta' }}
            </button>
        </div>
    </form>
</div>
