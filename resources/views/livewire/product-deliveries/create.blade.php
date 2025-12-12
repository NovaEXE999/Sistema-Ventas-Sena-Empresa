<div class="inventory-form-scope flex h-full w-full flex-1 flex-col gap-6 items-stretch">
    <style>
        .inventory-form-scope {
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

        [data-theme="light"] .inventory-form-scope,
        .theme-light .inventory-form-scope {
            --surface: #FFFFFF;
            --surface-2: #F5F7F9;
            --text: #0E1420;
            --muted: #4A5568;
            --border: #E2E8F0;
            --shadow-soft: 0 12px 32px -18px rgba(15, 23, 42, 0.28);
        }

        [data-theme="dark"] .inventory-form-scope,
        .theme-dark .inventory-form-scope {
            --surface: #0F1720;
            --surface-2: #111827;
            --text: #E6EDF3;
            --muted: #8BA0B5;
            --border: rgba(255, 255, 255, 0.06);
            --shadow-soft: 0 18px 40px -24px rgba(0, 0, 0, 0.95);
        }

        .inventory-form-topbar {
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: flex-start;
            padding-top: 0.5rem;
            padding-left: 0.5rem;
        }

        @media (min-width: 640px) {
            .inventory-form-topbar {
                padding-left: 0;
            }
        }

        .inventory-form-header {
            width: 100%;
            max-width: 52rem;
            margin: 0 auto;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .inventory-form-title-badge {
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

        [data-theme="dark"] .inventory-form-scope .inventory-form-title-badge,
        .theme-dark .inventory-form-scope .inventory-form-title-badge {
            background: radial-gradient(circle at 0% 0%, rgba(26, 168, 85, 0.32), transparent 55%),
                        rgba(15, 23, 42, 0.5);
        }

        .inventory-form-title-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 26px;
            height: 26px;
            border-radius: 9999px;
            background: linear-gradient(135deg, var(--sena-green-500), var(--accent-cyan));
            color: #fff;
        }

        .inventory-form-title-text {
            font-size: 0.9rem;
            font-weight: 700;
            letter-spacing: .08em;
            text-transform: uppercase;
            color: var(--text);
        }

        .inventory-form-subtitle {
            display: block;
            font-size: 0.7rem;
            font-weight: 500;
            letter-spacing: .14em;
            text-transform: uppercase;
            color: var(--muted);
        }

        .inventory-form {
            width: 100%;
            max-width: 50rem;
            margin: .75rem auto 0 auto;
            padding: 1.75rem 1.75rem 1.5rem;
            border-radius: 20px;
            background: linear-gradient(135deg, rgba(15, 23, 42, 0.02), rgba(26, 168, 85, 0.02));
            border: 1px solid var(--border);
            box-shadow: var(--shadow-soft);
        }

        .inventory-form-grid {
            display: grid;
            grid-template-columns: minmax(0, 1fr);
            gap: 1rem;
        }

        @media (min-width: 768px) {
            .inventory-form-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        .inventory-form-full {
            grid-column: 1 / -1;
        }

        .inventory-form-label {
            font-size: 0.78rem;
            font-weight: 600;
            color: var(--muted);
            margin-bottom: 0.2rem;
            display: inline-block;
        }

        .inventory-form-helper {
            font-size: 0.70rem;
            color: var(--muted);
            margin-top: 0.15rem;
        }

        .inventory-form-scope input[type="text"],
        .inventory-form-scope input[type="number"],
        .inventory-form-scope input[type="date"],
        .inventory-form-scope input[type="search"],
        .inventory-form-scope textarea,
        .inventory-form-scope select {
            background: var(--surface);
            border-radius: 0.75rem;
            border: 1px solid rgba(148, 163, 184, 0.6);
            padding: 0.55rem 0.8rem;
            font-size: 0.85rem;
            color: var(--text);
            outline: none;
            transition: border-color 0.14s ease, box-shadow 0.14s ease, background 0.14s ease, transform 0.04s ease;
        }

        .inventory-form-scope input::placeholder,
        .inventory-form-scope textarea::placeholder {
            color: rgba(148, 163, 184, 0.9);
        }

        .inventory-form-scope input:focus-visible,
        .inventory-form-scope textarea:focus-visible,
        .inventory-form-scope select:focus-visible {
            border-color: rgba(26, 168, 85, 0.9);
            box-shadow: 0 0 0 2px rgba(26, 168, 85, 0.18);
            transform: translateY(-0.5px);
        }

        .inventory-form-scope input:disabled,
        .inventory-form-scope textarea:disabled,
        .inventory-form-scope select:disabled {
            opacity: 0.65;
            cursor: not-allowed;
        }

        [data-theme="dark"] .inventory-form-scope input[type="text"],
        [data-theme="dark"] .inventory-form-scope input[type="number"],
        [data-theme="dark"] .inventory-form-scope input[type="date"],
        [data-theme="dark"] .inventory-form-scope input[type="search"],
        [data-theme="dark"] .inventory-form-scope textarea,
        [data-theme="dark"] .inventory-form-scope select,
        .theme-dark .inventory-form-scope input[type="text"],
        .theme-dark .inventory-form-scope input[type="number"],
        .theme-dark .inventory-form-scope input[type="date"],
        .theme-dark .inventory-form-scope input[type="search"],
        .theme-dark .inventory-form-scope textarea,
        .theme-dark .inventory-form-scope select {
            background: #020617;
            border-color: rgba(67, 198, 120, 0.9);
            color: #F9FAFB;
            color-scheme: dark;
        }

        [data-theme="dark"] .inventory-form-scope select option,
        .theme-dark .inventory-form-scope select option {
            background-color: #020617;
            color: #E6EDF3;
        }

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

        .autocomplete-results-item:hover {
            background: rgba(26, 168, 85, 0.12);
            color: var(--sena-green-300);
            transform: translateY(-0.5px);
        }

        .inventory-form-scope .text-error,
        .inventory-form-scope .form-error {
            color: var(--error);
            font-size: 0.75rem;
        }

        .inventory-form-submit {
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

        .inventory-form-submit:hover {
            filter: brightness(1.03);
            transform: translateY(-1px);
        }

        .inventory-form-submit:focus-visible {
            outline: 3px solid rgba(26, 168, 85, 0.32);
            outline-offset: 2px;
        }

        .inventory-form-submit:disabled {
            opacity: .7;
            cursor: not-allowed;
            box-shadow: none;
        }

        .inventory-form-back-btn {
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

        .inventory-form-back-btn svg {
            width: 18px;
            height: 18px;
        }

        .inventory-form-back-btn:hover {
            filter: brightness(1.03);
            transform: translateY(-1px);
            box-shadow: 0 14px 32px -18px rgba(26, 168, 85, 0.85);
        }

        .inventory-form-back-btn:focus-visible {
            outline: 2px solid rgba(26, 168, 85, 0.45);
            outline-offset: 2px;
        }

        [data-theme="dark"] .inventory-form-scope .inventory-form-back-btn,
        .theme-dark .inventory-form-scope .inventory-form-back-btn {
            background: radial-gradient(circle at 0% 0%, rgba(26, 168, 85, 0.32), transparent 55%),
                        rgba(15, 23, 42, 0.55);
            color: #E6EDF3;
            border-color: rgba(26, 168, 85, 0.65);
        }

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

        .inventory-products-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.85rem;
            color: var(--text);
        }

        .inventory-products-table thead th {
            padding: 0.5rem;
            text-align: left;
            font-weight: 600;
            font-size: 0.75rem;
            color: var(--muted);
            background: rgba(26, 168, 85, 0.08);
            border-bottom: 1px solid var(--border);
        }

        .inventory-products-table tbody td {
            padding: 0.5rem;
            border-top: 1px solid var(--border);
            vertical-align: middle;
        }

        .inventory-products-table tbody tr:first-child td {
            border-top: none;
        }

        .inventory-products-table tbody tr:nth-child(even) {
            background: rgba(14, 122, 59, 0.03);
        }

        [data-theme="dark"] .inventory-form-scope .inventory-products-table tbody tr:nth-child(even),
        .theme-dark .inventory-form-scope .inventory-products-table tbody tr:nth-child(even) {
            background: rgba(14, 122, 59, 0.05);
        }

        .inventory-products-section {
            border-radius: 16px;
            border: 1px solid var(--border);
            padding: 1rem;
            background: var(--surface-2);
        }
    </style>

    {{-- TOPBAR: botón Volver --}}
    <div class="inventory-form-topbar">
        <a href="{{ route('productdeliveries.index')}}"
           wire:navigate
           class="inventory-form-back-btn"
           role="button">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
            </svg>
            <span class="ml-1">Volver</span>
        </a>
    </div>

    {{-- HEADER: título centrado con badge --}}
    <div class="inventory-form-header">
        <div class="inventory-form-title-badge">
            <div class="inventory-form-title-icon">
                <svg viewBox="0 0 24 24" class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z" />
                    <polyline points="3.27 6.96 12 12.01 20.73 6.96" />
                    <line x1="12" y1="22.08" x2="12" y2="12" />
                </svg>
            </div>
            <div class="flex flex-col leading-tight">
                <span class="inventory-form-title-text">Entrada de inventario</span>
                <span class="inventory-form-subtitle">Registro de productos entregados</span>
            </div>
        </div>
    </div>

    <x-form.error-alert />

    @php($isEdit = property_exists($this, 'delivery') && $this->delivery?->exists)

    <form wire:submit.prevent="save" class="inventory-form">
        <div class="inventory-form-grid">
            {{-- Fecha --}}
            <div>
                <label class="inventory-form-label">Fecha</label>
                <input type="date" wire:model="date" disabled class="w-full">
                <p class="inventory-form-helper">Fecha de la entrada.</p>
            </div>

            {{-- Proveedor --}}
            <div x-data @click.outside="$wire.hideProviderResults()">
                <div class="flex flex-col gap-2">
                    <div class="flex items-start gap-3 flex-wrap">
                        <div class="flex-1 min-w-0">
                            <x-form.input wire:model.live.debounce.300ms="providerSearch"
                                          wire:blur="ensureProviderSelected"
                                          autocomplete="off"
                                          label="Proveedor" name="providerSearch" placeholder="Busca proveedor por nombre o identificación..." />
                        </div>

                        @if($providerNotFound && $isAdmin)
                            <a href="{{ route('providers.create')}}"
                               wire:navigate
                               class="inventory-form-back-btn flex-none"
                               role="button">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5">
                                    <path d="M12 5v14" />
                                    <path d="M5 12h14" />
                                </svg>
                                <span class="ml-1">Crear proveedor</span>
                            </a>
                        @endif
                    </div>

                    @if($providerResults)
                        <ul class="autocomplete-results">
                            @foreach($providerResults as $prov)
                                <li wire:mousedown.prevent="selectProvider({{ $prov['id'] }}, @js($prov['name']))"
                                    class="autocomplete-results-item">
                                    <div class="flex flex-col">
                                        <span class="font-medium">{{ $prov['name'] }}</span>
                                        @if(!empty($prov['identification']))
                                            <span class="text-xs inventory-form-helper">ID: {{ $prov['identification'] }}</span>
                                        @endif
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    @endif

                    <x-form.field-error for="provider_id" :message="$providerNotFound ? $providerNotice : null" />
                    <p class="inventory-form-helper">Busque y seleccione un proveedor.</p>
                </div>
            </div>
        </div>

        {{-- Productos --}}
        <div class="inventory-form-full mt-4 inventory-products-section">
            <div class="grid gap-3 md:grid-cols-[2fr_140px_auto] items-end mb-4">
                <div x-data @click.outside="$wire.hideProductResults()">
                    <x-form.input wire:model.live.debounce.250ms="productSearch"
                                  wire:blur="ensureProductSelected"
                                  autocomplete="off"
                                  label="Producto" name="productSearch" placeholder="Busca producto activo..." />
                                  <p class="inventory-form-helper">Busque y seleccione un producto.</p>
                    @if($productResults)
                        <ul class="autocomplete-results">
                            @foreach($productResults as $product)
                                <li wire:mousedown.prevent="selectProduct({{ $product['id'] }}, @js($product['name']))"
                                    class="autocomplete-results-item">
                                    {{ $product['name'] }}
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
                
                <div x-data>
                    <x-form.input wire:model="productQuantity"
                                  type="number"
                                  min="1"
                                  max="1000"
                                  step="1"
                                  inputmode="numeric"
                                  pattern="[0-9]*"
                                  x-on:keydown="
                                      const allowed = ['Backspace','Tab','ArrowLeft','ArrowRight','Delete','Home','End','Enter'];
                                      if (!allowed.includes($event.key) && !/^[0-9]$/.test($event.key)) {
                                          $event.preventDefault();
                                      }
                                  "
                                  x-on:input="
                                      let val = ($el.value || '').replace(/[^0-9]/g, '');
                                      val = val.slice(0, 4);
                                      if (val === '') {
                                          $el.value = '';
                                          return;
                                      }
                                      let num = parseInt(val, 10);
                                      if (Number.isNaN(num) || num < 1) {
                                          $el.value = '';
                                          return;
                                      }
                                      if (num > 1000) {
                                          num = 1000;
                                      }
                                      $el.value = num;
                                  "
                                  x-on:paste.prevent="
                                      let pasted = (event.clipboardData || window.clipboardData).getData('text');
                                      pasted = pasted.replace(/[^0-9]/g, '').slice(0,4);
                                      if (pasted === '') {
                                          return;
                                      }
                                      let num = parseInt(pasted, 10);
                                      if (Number.isNaN(num) || num < 1) {
                                          num = 1;
                                      } else if (num > 1000) {
                                          num = 1000;
                                      }
                                      $el.value = num;
                                      $el.dispatchEvent(new Event('input'));
                                  "
                                  maxlength="4"
                                  label="Cantidad" name="productQuantity" placeholder="1 - 1000" />
                </div>
                <button type="button" wire:click="addProductLine" class="btn-insert h-10">
                    Insertar
                </button>
            </div>

            <div class="overflow-x-auto">
                <table class="inventory-products-table">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Nombre producto</th>
                            <th>Cantidad</th>
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
                                </td>
                                <td>
                                    <span class="text-sm">{{ $item['quantity'] }}</span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center inventory-form-helper py-3">Agrega productos a la entrada.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                <x-form.field-error for="lineItems" />
            </div>
        </div>

        <div class="inventory-form-full mt-4 flex justify-end">
            <button
                type="submit"
                class="inventory-form-submit"
            >
                {{ $isEdit ? 'Actualizar entrada de inventario' : 'Registrar entrada de inventario' }}
            </button>
        </div>
    </form>
</div>
