<div class="reports-scope flex w-full flex-1 flex-col gap-6 rounded-xl p-4 sm:p-6">
    <style>
        .reports-scope {
            --sena-green-600: #0e7a3b;
            --sena-green-500: #1aa855;
            --sena-green-300: #43c678;
            --accent-amber: #f6a300;
            --accent-cyan: #2ec7d6;
            --error: #e5484d;
            --warning: #f6a300;
            --success: #1aa855;
            --surface: #0f1720;
            --surface-2: #121c27;
            --text: #e6edf3;
            --muted: #8ba0b5;
            --border: rgba(255, 255, 255, 0.08);
            --shadow: 0 12px 36px -18px rgba(0, 0, 0, 0.6);
            --input-bg: rgba(255, 255, 255, 0.02);
            --card-glow: 0 12px 28px -16px rgba(14, 122, 59, 0.55);
            color: var(--text);
        }

        [data-theme="light"] .reports-scope,
        .theme-light .reports-scope {
            --surface: #ffffff;
            --surface-2: #f5f7f9;
            --text: #0e1420;
            --muted: #4a5568;
            --border: #e2e8f0;
            --shadow: 0 8px 24px -12px rgba(14, 20, 32, 0.18);
            --input-bg: #ffffff;
            --card-glow: 0 10px 24px -14px rgba(26, 168, 85, 0.35);
        }

        .reports-label {
            color: var(--sena-green-500);
            font-weight: 700;
        }

        .filter-input {
            background: var(--input-bg);
            border: 1px solid rgba(26, 168, 85, 0.65);
            border-radius: 12px;
            color: var(--sena-green-500);
            caret-color: var(--sena-green-500);
            font-weight: 700;
            padding: 10px 12px;
            min-width: 220px;
            transition: border-color 0.15s ease, box-shadow 0.15s ease, background 0.15s ease;
        }
        .filter-input:focus-visible {
            border-color: var(--sena-green-500);
            outline: none;
            box-shadow: 0 0 0 3px rgba(26, 168, 85, 0.18);
        }

        .btn-primary {
            background: var(--sena-green-500);
            border: 1px solid var(--sena-green-500);
            border-radius: 12px;
            color: #fff;
            font-weight: 700;
            padding: 10px 14px;
            box-shadow: 0 12px 22px -14px rgba(26, 168, 85, 0.7);
            transition: transform 0.15s ease, filter 0.15s ease, box-shadow 0.15s ease;
        }
        .btn-primary:hover { filter: brightness(1.03); transform: translateY(-1px); }
        .btn-primary:focus-visible { outline: 3px solid rgba(26, 168, 85, 0.28); outline-offset: 2px; }

        .btn-blue {
            background: #2563eb;
            border: 1px solid #2563eb;
            border-radius: 12px;
            color: #fff;
            font-weight: 700;
            padding: 10px 14px;
            box-shadow: 0 12px 22px -14px rgba(37, 99, 235, 0.7);
            transition: transform 0.15s ease, filter 0.15s ease, box-shadow 0.15s ease;
        }
        .btn-blue:hover { filter: brightness(1.03); transform: translateY(-1px); }
        .btn-blue:focus-visible { outline: 3px solid rgba(37, 99, 235, 0.28); outline-offset: 2px; }

        .btn-green {
            background: #1aa855;
            border: 1px solid #1aa855;
            border-radius: 12px;
            color: #fff;
            font-weight: 700;
            padding: 10px 14px;
            box-shadow: 0 12px 22px -14px rgba(26, 168, 85, 0.7);
            transition: transform 0.15s ease, filter 0.15s ease, box-shadow 0.15s ease;
        }
        .btn-green:hover { filter: brightness(1.03); transform: translateY(-1px); }
        .btn-green:focus-visible { outline: 3px solid rgba(26, 168, 85, 0.28); outline-offset: 2px; }

        .summary-card,
        .panel-card {
            background: var(--surface-2);
            border-radius: 16px;
            border: 1px solid var(--border);
            box-shadow: var(--shadow);
            color: var(--text);
        }

        .summary-card {
            position: relative;
            overflow: hidden;
        }
        .summary-card::after {
            content: "";
            position: absolute;
            inset: 0;
            background: radial-gradient(circle at 20% 20%, rgba(26, 168, 85, 0.08), transparent 40%);
            pointer-events: none;
        }

        .pill-icon {
            background: linear-gradient(135deg, var(--sena-green-500), var(--accent-cyan));
            color: #fff;
            box-shadow: var(--card-glow);
        }

        .badge-chip {
            border-radius: 9999px;
            padding: 6px 12px;
            font-weight: 700;
            border: 1px solid rgba(26, 168, 85, 0.35);
            background: rgba(26, 168, 85, 0.15);
            color: var(--text);
        }
        .badge-chip.blue {
            background: rgba(46, 199, 214, 0.15);
            border-color: rgba(46, 199, 214, 0.45);
        }
        .badge-chip.orange {
            background: rgba(246, 163, 0, 0.18);
            border-color: rgba(246, 163, 0, 0.45);
        }
        .badge-chip.green {
            background: rgba(26, 168, 85, 0.18);
            border-color: rgba(26, 168, 85, 0.45);
            color: #0e7a3b;
        }

        .chart-container {
            background: linear-gradient(180deg, rgba(14, 20, 32, 0.65) 0%, rgba(12, 18, 34, 0.9) 100%);
            border-radius: 14px;
            border: 1px solid var(--border);
        }
        [data-theme="light"] .reports-scope .chart-container,
        .theme-light .reports-scope .chart-container {
            background: #ffffff;
        }

        .reports-muted {
            color: var(--muted);
        }
        .reports-helper {
            color: var(--sena-green-300);
            font-weight: 700;
        }

        .reports-border {
            border: 1px solid var(--border);
        }

        .reports-table {
            width: 100%;
            color: var(--text);
            border-collapse: collapse;
        }
        .reports-table thead th {
            color: var(--muted);
            background: rgba(26, 168, 85, 0.08);
            border-bottom: 1px solid var(--border);
            font-weight: 700;
        }
        [data-theme="light"] .reports-scope .reports-table thead th,
        .theme-light .reports-scope .reports-table thead th {
            background: rgba(26, 168, 85, 0.12);
        }
        .reports-table tbody td {
            border-top: 1px solid var(--border);
            color: var(--text);
        }
        .reports-table tbody tr:hover {
            background: rgba(26, 168, 85, 0.07);
        }
    </style>

    @php
        use Illuminate\Support\Str;

        $cardIcons = [
            'ventas-del-mes' => '<path d="M12 3v18m0-18c3.31 0 6 2.69 6 6 0 4.5-6 8-6 8m0-14c-3.31 0-6 2.69-6 6 0 4.5 6 8 6 8" /><circle cx="12" cy="9" r="1.25" />',
            'productos-vendidos' => '<path d="M3 7.5 12 3l9 4.5-9 4.5-9-4.5Z" /><path d="m3 12 9 4.5 9-4.5" /><path d="m3 16.5 9 4.5 9-4.5" />',
            'productos-importados' => '<path d="M3 8l9-5 9 5v8l-9 5-9-5V8Z" /><path d="M3 8l9 5 9-5" /><path d="M12 13v10" />',
            'ingresos-del-mes' => '<path d="M12 3v18" /><path d="M17 9c0-2.21-2.24-4-5-4s-5 1.79-5 4 2.24 4 5 4 5 1.79 5 4-2.24 4-5 4-5-1.79-5-4" />',
            'tipo-de-cliente-top' => '<path d="M16 21v-2a4 4 0 0 0-8 0v2" /><circle cx="12" cy="11" r="4" /><path d="M20 21v-2a4 4 0 0 0-3-3.87" /><path d="M7 15.13A4 4 0 0 0 4 19v2" />',
            'metodo-de-pago-favorito' => '<rect x="2" y="5" width="20" height="14" rx="2" /><path d="M2 10h20" /><path d="M6 15h2" />',
            'categoria-que-mas-vende' => '<path d="M21 12a9 9 0 1 1-9-9" /><path d="M21 12A9 9 0 0 0 12 3v9Z" />',
            'proporcion-imp-vend' => '<path d="M4 20h16" /><path d="M8 20V10" /><path d="M12 20V4" /><path d="M16 20v-6" />',
            'productos-registrados' => '<path d="m7.5 4.21 4.5-2.5 4.5 2.5v4.58l-4.5 2.5-4.5-2.5Z" /><path d="m3 6.5 4.5 2.5v5l4.5 2.5 4.5-2.5v-5L21 6.5" />',
            'default' => '<path d="m12 2 3 7h7l-5.5 4.25 2 7L12 16l-6.5 4.25 2-7L2 9h7Z" />',
        ];
    @endphp

    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <div class="flex flex-wrap items-center gap-2 text-sm">
            <input
                id="monthFilter"
                type="month"
                wire:model.live="month"
                class="filter-input text-sm"
            >
        </div>
        <div class="flex gap-2">
            <button wire:click="refreshData" class="btn-primary">
                Refrescar datos
            </button>
        </div>
    </div>

    <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
        @foreach ($summaryCards as $card)
            @php
                $key = Str::slug($card['title'] ?? 'default');
                $icon = $cardIcons[$key] ?? $cardIcons['default'];
            @endphp
            <article class="relative flex flex-col overflow-hidden summary-card">
                <div class="absolute right-4 top-4 flex h-10 w-10 items-center justify-center rounded-xl pill-icon shadow-lg">
                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        {!! $icon !!}
                    </svg>
                </div>
                <div class="flex flex-col gap-1 p-6">
                    <p class="text-sm font-semibold reports-muted">{{ $card['title'] }}</p>
                    <p class="text-3xl font-bold leading-tight">{{ $card['value'] }}</p>
                    @if (!empty($card['helper']))
                        <p class="text-xs font-semibold reports-helper">{{ $card['helper'] }}</p>
                    @endif
                </div>
            </article>
        @endforeach
    </div>

    <div class="grid gap-4 lg:grid-cols-2">
        <article class="panel-card relative p-5">
            <div class="flex items-start justify-between">
                <div>
                    <h3 class="text-sm font-semibold reports-muted">Ventas por tipo de cliente</h3>
                    <p class="text-xs reports-helper mt-1">Ordenado desc. por periodo</p>
                </div>
                <span class="badge-chip blue rounded-full px-3 py-1 text-xs font-semibold shadow-lg">Clientes</span>
            </div>
            <div class="mt-4 chart-container p-3">
                <div class="overflow-hidden rounded-xl reports-border">
                    <table class="reports-table text-sm">
                        <thead>
                            <tr class="text-left">
                                <th class="px-3 py-2">Tipo de cliente</th>
                                <th class="px-3 py-2 text-right">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($salesByClientType as $row)
                                <tr class="transition">
                                    <td class="px-3 py-2 font-semibold">{{ $row['name'] }}</td>
                                    <td class="px-3 py-2 text-right">{{ $row['total'] ?? 0 }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="px-3 py-3 reports-muted" colspan="2">Sin datos para este periodo.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </article>

        <article class="panel-card relative p-5">
            <div class="flex items-start justify-between">
                <div>
                    <h3 class="text-sm font-semibold reports-muted">Productos vendidos por categoria</h3>
                    <p class="text-xs reports-helper mt-1">Cantidades vendidas del periodo</p>
                </div>
                <span class="badge-chip orange rounded-full px-3 py-1 text-xs font-semibold shadow-lg">Top ventas</span>
            </div>
            <div class="mt-4 chart-container p-3">
                <div class="overflow-hidden rounded-xl reports-border">
                    <table class="reports-table text-sm">
                        <thead>
                            <tr class="text-left">
                                <th class="px-3 py-2">Categoria</th>
                                <th class="px-3 py-2 text-right">Total vendido</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($salesByCategory as $row)
                                <tr class="transition">
                                    <td class="px-3 py-2 font-semibold">{{ $row['name'] }}</td>
                                    <td class="px-3 py-2 text-right">{{ $row['total'] ?? 0 }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="px-3 py-3 reports-muted" colspan="2">Sin datos para este periodo.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </article>
    </div>

    <article class="panel-card relative p-5">
        <div class="flex items-start justify-between">
            <div>
                <h3 class="text-sm font-semibold reports-muted">Cantidad de producto entregada por proveedor</h3>
                <p class="text-xs reports-helper mt-1">Entradas registradas del periodo</p>
            </div>
            <span class="badge-chip green rounded-full px-3 py-1 text-xs font-semibold shadow-lg">Entregas</span>
        </div>
        <div class="mt-4 chart-container p-3">
            <div class="overflow-hidden rounded-xl reports-border">
                <table class="reports-table text-sm">
                    <thead>
                        <tr class="text-left">
                            <th class="px-3 py-2">Proveedor</th>
                            <th class="px-3 py-2 text-right">Cantidad entregada</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($deliveriesByProvider as $row)
                            <tr class="transition">
                                <td class="px-3 py-2 font-semibold">{{ $row['name'] }}</td>
                                <td class="px-3 py-2 text-right">{{ $row['total'] ?? 0 }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td class="px-3 py-3 reports-muted" colspan="2">Sin datos para este periodo.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </article>

    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-end gap-3 mt-2">
        <button type="button" class="btn-blue">Ver PDF</button>
        <button type="button" class="btn-green">Descargar PDF</button>
    </div>
</div>
