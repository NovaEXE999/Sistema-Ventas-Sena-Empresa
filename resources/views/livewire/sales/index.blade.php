<div class="sales-scope flex h-full w-full flex-1 flex-col gap-4 rounded-xl p-4 sm:p-6">
    <style>
        .sales-scope {
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

        [data-theme="light"] .sales-scope,
        .theme-light .sales-scope {
            --surface: #FFFFFF;
            --surface-2: #F5F7F9;
            --text: #0E1420;
            --muted: #4A5568;
            --border: #E2E8F0;
            --shadow: 0 8px 24px -12px rgba(14, 20, 32, 0.18);
        }

        [data-theme="dark"] .sales-scope,
        .theme-dark .sales-scope {
            --surface: #0F1720;
            --surface-2: #121C27;
            --text: #E6EDF3;
            --muted: #8BA0B5;
            --border: rgba(255, 255, 255, 0.08);
            --shadow: 0 12px 36px -18px rgba(0, 0, 0, 0.6);
            color-scheme: dark;
        }

        .sales-label {
            font-size: 0.8rem;
            font-weight: 600;
            color: var(--muted);
        }

        .sales-muted {
            color: var(--muted);
        }


        .sales-input,
        .sales-select {
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

        .sales-input::placeholder {
            color: rgba(148, 163, 184, 0.9);
        }

        .sales-input:focus-visible,
        .sales-select:focus-visible {
            border-color: rgba(26, 168, 85, 0.9);
            box-shadow: 0 0 0 2px rgba(26, 168, 85, 0.18);
            transform: translateY(-0.5px);
        }

        .sales-input:disabled,
        .sales-select:disabled {
            opacity: 0.65;
            cursor: not-allowed;
        }

        
        [data-theme="dark"] .sales-scope .sales-input,
        .theme-dark .sales-scope .sales-input,
        [data-theme="dark"] .sales-scope .sales-select,
        .theme-dark .sales-scope .sales-select {
            background:
                radial-gradient(circle at 0% 0%, rgba(26, 168, 85, 0.24), transparent 55%),
                #020617;
            border-color: rgba(67, 198, 120, 0.9);
            color: #F9FAFB;
            color-scheme: dark;
        }

        [data-theme="dark"] .sales-scope .sales-input::placeholder,
        .theme-dark .sales-scope .sales-input::placeholder {
            color: rgba(148, 163, 184, 0.9);
        }

        
        .sales-select {
            appearance: none;
            -webkit-appearance: none;
            position: relative;
            padding-right: 2rem;
        }

        .sales-select option {
            background-color: #ffffff;
            color: #0E1420;
        }

        [data-theme="dark"] .sales-scope .sales-select option,
        .theme-dark .sales-scope .sales-select option {
            background-color: #020617;
            color: #E6EDF3;
        }

        [data-theme="dark"] .sales-scope .sales-select option:checked,
        [data-theme="dark"] .sales-scope .sales-select option:focus,
        .theme-dark .sales-scope .sales-select option:checked,
        .theme-dark .sales-scope .sales-select option:focus {
            background-color: rgba(67, 198, 120, 0.30);
            color: #43C678;
        }

        
        .sales-select-wrapper {
            position: relative;
        }
        .sales-select-wrapper::after {
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

        .btn-info {
            background: var(--accent-cyan);
            border-radius: 10px;
            border: 1px solid var(--accent-cyan);
            color: #FFFFFF;
            font-size: 0.75rem;
            font-weight: 600;
            padding: 6px 10px;
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
            transition: filter 0.15s ease, transform 0.12s ease;
        }

        .btn-info:hover {
            filter: brightness(1.05);
            transform: translateY(-1px);
        }

        
        .sales-alert {
            border-radius: 14px;
            border: 1px solid rgba(26, 168, 85, 0.45);
            background: rgba(26, 168, 85, 0.08);
            color: var(--text);
            box-shadow: 0 10px 24px -14px rgba(26, 168, 85, 0.35);
            overflow: hidden;
        }

        .sales-alert-header {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.75rem 1rem;
        }

        .sales-alert-icon {
            background: linear-gradient(135deg, var(--sena-green-500), var(--accent-cyan));
            color: #FFFFFF;
            border-radius: 9999px;
            padding: 4px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 10px 24px -14px rgba(26, 168, 85, 0.65);
        }

        .sales-alert-title {
            font-size: 0.85rem;
            font-weight: 700;
            color: var(--sena-green-500);
        }

        .sales-alert-text {
            font-size: 0.8rem;
            font-weight: 500;
            color: var(--text);
        }

       
        .sales-table-wrapper {
            border-radius: 16px;
            border: 1px solid var(--border);
            overflow: hidden;
            background: var(--surface-2);
        }

        
        .sales-table-title {
            text-align: center;
            padding: 0.75rem 1rem;
            font-weight: 700;
            font-size: 0.9rem;
            color: #ffffff;
            background: var(--sena-green-500);
        }

        .sales-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.85rem;
            color: var(--text);
        }

        .sales-table thead th {
            padding: 0.75rem 1rem;
            text-align: left;
            font-weight: 700;
            font-size: 0.8rem;
            color: var(--muted);
            background: rgba(26, 168, 85, 0.08);
            border-bottom: 1px solid var(--border);
            white-space: nowrap;
        }

        .sales-table tbody td {
            padding: 0.75rem 1rem;
            border-top: 1px solid var(--border);
            vertical-align: middle;
        }

        .sales-table tbody tr:first-child td {
            border-top: none;
        }

        .sales-table tbody tr:nth-child(even) {
            background: rgba(14, 122, 59, 0.03);
        }

        [data-theme="dark"] .sales-scope .sales-table tbody tr:nth-child(even),
        .theme-dark .sales-scope .sales-table tbody tr:nth-child(even) {
            background: rgba(14, 122, 59, 0.05);
        }

        .sales-table tbody tr:hover {
            background: rgba(26, 168, 85, 0.10);
        }

        
        .sales-search-wrapper {
            position: relative;
        }

        .sales-search-icon {
            position: absolute;
            left: 0.75rem;
            top: 50%;
            transform: translateY(-50%);
            opacity: 0.9;
            color: var(--muted);
        }

        .sales-search-input {
            padding-left: 2.25rem;
        }
    </style>

    @if (session('success'))
        <div
            x-data="{ alertIsVisible: true }"
            x-show="alertIsVisible"
            class="sales-alert"
            role="alert"
            x-transition:leave="transition ease-in duration-300"
            x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-90"
        >
            <div class="sales-alert-header">
                <div class="sales-alert-icon" aria-hidden="true">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-5 w-5" aria-hidden="true">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16Zm3.857-9.809a.75.75 0 0 0-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 1 0-1.06 1.061l2.5 2.5a.75.75 0 0 0 1.137-.089l4-5.5Z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="flex flex-col gap-0.5">
                    <h3 class="sales-alert-title">Mensajes de ventas</h3>
                    <p class="sales-alert-text">{{ session('success') }}</p>
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

    @php($isAdmin = auth()->user()?->isAdmin())

    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <a href="{{ route('sales.create') }}" wire:navigate class="btn-primary" role="button">
            Registrar una venta
        </a>

        
        <div class="sales-search-wrapper w-full max-w-xs">
            <span class="sales-search-icon">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true" class="h-5 w-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                </svg>
            </span>
            <input
                type="search"
                wire:model.live.debounce.300ms="search"
                class="sales-input sales-search-input w-full"
                name="search"
                placeholder="Buscar cliente..."
                aria-label="search"
            />
        </div>
    </div>

    
    <div class="grid gap-4 md:grid-cols-3 lg:grid-cols-5">
        <div class="flex flex-col gap-1 text-sm">
            <label class="sales-label">Orden</label>
            <div class="sales-select-wrapper">
                <select wire:model.live="order" class="sales-select w-full">
                    <option value="date_desc">Fecha: nuevo a antiguo</option>
                    <option value="date_asc">Fecha: antiguo a nuevo</option>
                </select>
            </div>
        </div>
        <div class="flex flex-col gap-1 text-sm">
            <label class="sales-label">Tipo de filtro</label>
            <div class="sales-select-wrapper">
                <select wire:model.live="filterDateType" class="sales-select w-full">
                    <option value="date">Fecha especifica</option>
                    <option value="month">Mes</option>
                    <option value="year">Ano</option>
                </select>
            </div>
        </div>
        <div class="flex flex-col gap-1 text-sm" x-data="{ filterType: @entangle('filterDateType') }">
            <label class="sales-label">Valor</label>
            <input
                x-bind:type="filterType === 'date' ? 'date' : (filterType === 'month' ? 'month' : 'number')"
                x-bind:placeholder="filterType === 'year' ? 'YYYY' : ''"
                x-bind:min="filterType === 'year' ? '1900' : null"
                x-bind:max="filterType === 'year' ? '2100' : null"
                x-bind:step="filterType === 'year' ? '1' : null"
                wire:model.live="filterDate"
                class="sales-input w-full"
            >
            <p class="text-xs sales-muted mt-1">
                Usa fecha exacta, un mes (YYYY-MM) o solo ano.
            </p>
        </div>
        <div class="flex flex-col gap-1 text-sm">
            <label class="sales-label">Método de pago</label>
            <div class="sales-select-wrapper">
                <select wire:model.live="paymentMethod" class="sales-select w-full">
                    <option value="all">Todos</option>
                    @foreach($paymentMethods as $method)
                        <option value="{{ $method['id'] }}">{{ $method['name'] }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        @if ($isAdmin)
            <div class="flex flex-col gap-1 text-sm">
                <label class="sales-label">Vendedor</label>
                <div class="sales-select-wrapper">
                    <select wire:model.live="seller" class="sales-select w-full">
                        <option value="all">Todos</option>
                        @foreach($sellers as $user)
                            <option value="{{ $user['id'] }}">{{ $user['name'] }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        @endif
    </div>

    <div class="sales-table-wrapper w-full mt-2">
        <h2 class="sales-table-title">Ventas</h2>

        <div class="overflow-x-auto">
            <table class="sales-table">
                <thead>
                    <tr>
                        <th scope="col">Fecha</th>
                        <th scope="col">Valor Total</th>
                        <th scope="col">Forma de pago</th>
                        <th scope="col">Cliente</th>
                        <th scope="col">Vendedor</th>
                        <th scope="col" class="text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($sales as $sale)
                        <tr>
                            <td>{{ $sale->date }}</td>
                            <td>{{ $sale->total_value }}</td>
                            <td>{{ $sale->paymentMethod->name }}</td>
                            <td>{{ $sale->client->name }}</td>
                            <td>{{ $sale->user->name }}</td>
                            <td class="text-center">
                                <div class="flex justify-center items-center gap-2">
                                    @if ($isAdmin)
                                        <button
                                            wire:click='delete({{ $sale->id }})'
                                            wire:confirm="¿Estás seguro de borrar la venta registrada el {{ $sale->date }}?"
                                            type="button"
                                            class="btn-danger"
                                        >
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-4 w-4">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                                            </svg>
                                            Borrar
                                        </button>
                                    @endif
                                    <a href="{{ route('sales.reports.pdf', $sale) }}" target="_blank">
                                        <button type="button" class="btn-info">
                                            PDF
                                        </button>
                                    </a>
                                    <a href="{{ route('sales.reports.download', $sale) }}">
                                        <button type="button" class="btn-success">
                                            Descargar
                                        </button>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="sales-muted text-center py-4">
                                No hay ventas registradas.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-4">
            {{ $sales->links() }}
        </div>
    </div>
</div>
