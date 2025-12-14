<div class="products-form-scope flex h-full w-full flex-1 flex-col gap-6 items-stretch">
    <style>
        .products-form-scope {
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

        [data-theme="light"] .products-form-scope,
        .theme-light .products-form-scope {
            --surface: #FFFFFF;
            --surface-2: #F5F7F9;
            --text: #0E1420;
            --muted: #4A5568;
            --border: #E2E8F0;
            --shadow-soft: 0 12px 32px -18px rgba(15, 23, 42, 0.28);
        }

        [data-theme="dark"] .products-form-scope,
        .theme-dark .products-form-scope {
            --surface: #0F1720;
            --surface-2: #111827;
            --text: #E6EDF3;
            --muted: #8BA0B5;
            --border: rgba(255, 255, 255, 0.06);
            --shadow-soft: 0 18px 40px -24px rgba(0, 0, 0, 0.95);
        }

        
        .products-form-topbar {
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: flex-start;
            padding-top: 0.5rem;
            padding-left: 0.5rem;
        }

        @media (min-width: 640px) {
            .products-form-topbar {
                padding-left: 0;
            }
        }

        
        .products-form-header {
            width: 100%;
            max-width: 52rem;
            margin: 0 auto;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .products-form-title-badge {
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

        [data-theme="dark"] .products-form-scope .products-form-title-badge,
        .theme-dark .products-form-scope .products-form-title-badge {
            background: radial-gradient(circle at 0% 0%, rgba(26, 168, 85, 0.32), transparent 55%),
                        rgba(15, 23, 42, 0.5);
        }

        .products-form-title-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 26px;
            height: 26px;
            border-radius: 9999px;
            background: linear-gradient(135deg, var(--sena-green-500), var(--accent-cyan));
            color: #fff;
        }

        .products-form-title-text {
            font-size: 0.9rem;
            font-weight: 700;
            letter-spacing: .08em;
            text-transform: uppercase;
            color: var(--text);
        }

        .products-form-subtitle {
            display: block;
            font-size: 0.7rem;
            font-weight: 500;
            letter-spacing: .14em;
            text-transform: uppercase;
            color: var(--muted);
        }

        
        .products-form {
            width: 100%;
            max-width: 40rem;
            margin: .75rem auto 0 auto;
            padding: 1.75rem 1.75rem 1.5rem;
            border-radius: 20px;
            background: linear-gradient(135deg, rgba(15, 23, 42, 0.02), rgba(26, 168, 85, 0.02));
            border: 1px solid var(--border);
            box-shadow: var(--shadow-soft);
        }

        .products-form-grid {
            display: grid;
            grid-template-columns: minmax(0, 1fr);
            gap: 1rem;
        }

        @media (min-width: 768px) {
            .products-form-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        .products-form-full {
            grid-column: 1 / -1;
        }

        .products-form-label {
            font-size: 0.78rem;
            font-weight: 600;
            color: var(--muted);
            margin-bottom: 0.2rem;
            display: inline-block;
        }

        .products-form-helper {
            font-size: 0.70rem;
            color: var(--muted);
            margin-top: 0.15rem;
        }

        
        .products-form-scope input[type="text"],
        .products-form-scope input[type="number"],
        .products-form-scope input[type="search"],
        .products-form-scope input[type="email"],
        .products-form-scope input[type="password"],
        .products-form-scope textarea,
        .products-form-scope select {
            background: var(--surface);
            border-radius: 0.75rem;
            border: 1px solid rgba(148, 163, 184, 0.6);
            padding: 0.55rem 0.8rem;
            font-size: 0.85rem;
            color: var(--text);
            outline: none;
            transition: border-color 0.14s ease, box-shadow 0.14s ease, background 0.14s ease, transform 0.04s ease;
        }

        .products-form-scope input::placeholder,
        .products-form-scope textarea::placeholder {
            color: rgba(148, 163, 184, 0.9);
        }

        .products-form-scope input:focus-visible,
        .products-form-scope textarea:focus-visible,
        .products-form-scope select:focus-visible {
            border-color: rgba(26, 168, 85, 0.9);
            box-shadow: 0 0 0 2px rgba(26, 168, 85, 0.18);
            transform: translateY(-0.5px);
        }

        .products-form-scope input:disabled,
        .products-form-scope textarea:disabled,
        .products-form-scope select:disabled {
            opacity: 0.65;
            cursor: not-allowed;
        }

        [data-theme="dark"] .products-form-scope input[type="text"],
        [data-theme="dark"] .products-form-scope input[type="number"],
        [data-theme="dark"] .products-form-scope input[type="search"],
        [data-theme="dark"] .products-form-scope input[type="email"],
        [data-theme="dark"] .products-form-scope input[type="password"],
        [data-theme="dark"] .products-form-scope textarea,
        [data-theme="dark"] .products-form-scope select,
        .theme-dark .products-form-scope input[type="text"],
        .theme-dark .products-form-scope input[type="number"],
        .theme-dark .products-form-scope input[type="search"],
        .theme-dark .products-form-scope input[type="email"],
        .theme-dark .products-form-scope input[type="password"],
        .theme-dark .products-form-scope textarea,
        .theme-dark .products-form-scope select {
            background: #020617;
            border-color: rgba(67, 198, 120, 0.9);
            color: #F9FAFB;
            color-scheme: dark;
        }

        [data-theme="dark"] .products-form-scope select option,
        .theme-dark .products-form-scope select option {
            background-color: #020617;
            color: #E6EDF3;
        }

        [data-theme="dark"] .products-form-scope select option:checked,
        [data-theme="dark"] .products-form-scope select option:focus,
        .theme-dark .products-form-scope select option:checked,
        .theme-dark .products-form-scope select option:focus {
            background-color: rgba(67, 198, 120, 0.30);
            color: #43C678;
        }

        
        .category-results {
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

        .category-results-item {
            padding: 0.5rem 0.75rem;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: .5rem;
            transition: background 0.12s ease, color 0.12s ease, transform 0.04s ease;
        }

        .category-results-item span {
            font-size: .72rem;
            color: var(--muted);
        }

        .category-results-item:hover {
            background: rgba(26, 168, 85, 0.12);
            color: var(--sena-green-300);
            transform: translateY(-0.5px);
        }

        .category-results-item .category-info {
            display: flex;
            flex-direction: column;
            gap: 0.15rem;
        }

        .category-results-item .category-title {
            font-weight: 600;
            color: var(--text);
        }

        .category-results-item .category-measure {
            font-size: 0.74rem;
            font-weight: 600;
            color: var(--sena-green-500);
        }

        .category-results-item .category-meta {
            font-size: 0.72rem;
            color: var(--muted);
            white-space: nowrap;
        }

        
        .category-select-wrapper {
            position: relative;
        }

        .category-select {
            width: 100%;
            max-height: 15rem;
            overflow-y: auto;
            background: var(--surface);
            border-radius: 0.75rem;
            border: 1px solid rgba(148, 163, 184, 0.6);
            padding: 0.45rem 0.7rem;
            font-size: 0.85rem;
            color: var(--text);
            outline: none;
        }

        [data-theme="dark"] .products-form-scope .category-select,
        .theme-dark .products-form-scope .category-select {
            background: #020617;
            border-color: rgba(67, 198, 120, 0.9);
            color: #F9FAFB;
        }

        .category-mode-toggle {
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
            padding: 0.35rem 0.9rem;
            border-radius: 9999px;
            background: radial-gradient(circle at 0% 0%, rgba(26, 168, 85, 0.14), transparent 55%),
                        rgba(15, 23, 42, 0.03);
            border: 1px solid rgba(26, 168, 85, 0.45);
            color: var(--text);
            font-size: 0.75rem;
            font-weight: 600;
            transition: transform 0.12s ease, box-shadow 0.12s ease, background 0.12s ease;
        }

        .category-mode-toggle:hover {
            transform: translateY(-1px);
            box-shadow: 0 10px 26px -18px rgba(26, 168, 85, 0.60);
        }

        
        .products-form-scope .text-error,
        .products-form-scope .form-error {
            color: var(--error);
            font-size: 0.75rem;
        }

        
        .products-form-submit {
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

        .products-form-submit:hover {
            filter: brightness(1.03);
            transform: translateY(-1px);
        }

        .products-form-submit:focus-visible {
            outline: 3px solid rgba(26, 168, 85, 0.32);
            outline-offset: 2px;
        }

        .products-form-submit:disabled {
            opacity: .7;
            cursor: not-allowed;
            box-shadow: none;
        }

        
        .products-form-back-btn {
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

        .products-form-back-btn svg {
            width: 18px;
            height: 18px;
        }

        .products-form-back-btn:hover {
            filter: brightness(1.03);
            transform: translateY(-1px);
            box-shadow: 0 14px 32px -18px rgba(26, 168, 85, 0.85);
        }

        .products-form-back-btn:focus-visible {
            outline: 2px solid rgba(26, 168, 85, 0.45);
            outline-offset: 2px;
        }

        [data-theme="dark"] .products-form-scope .products-form-back-btn,
        .theme-dark .products-form-scope .products-form-back-btn {
            background: radial-gradient(circle at 0% 0%, rgba(26, 168, 85, 0.32), transparent 55%),
                        rgba(15, 23, 42, 0.55);
            color: #E6EDF3;
            border-color: rgba(26, 168, 85, 0.65);
        }
    </style>

    
    <div class="products-form-topbar">
        <a href="{{ route('products.index')}}"
           wire:navigate
           class="products-form-back-btn"
           role="button">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
            </svg>
            <span class="ml-1">Volver</span>
        </a>
    </div>

    
    <div class="products-form-header">
        <div class="products-form-title-badge">
            <div class="products-form-title-icon">
                <svg viewBox="0 0 24 24" class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M3 7h18" />
                    <path d="M5 11h14" />
                    <path d="M7 15h10" />
                    <path d="M9 19h6" />
                </svg>
            </div>
            <div class="flex flex-col leading-tight">
                <span class="products-form-title-text">Registro de productos</span>
                <span class="products-form-subtitle">Define stock, precio y categoría</span>
            </div>
        </div>
    </div>

    <x-form.error-alert />

    <form wire:submit="save" class="products-form">
        <div class="products-form-grid">
            
            <div class="products-form-full">
                <x-form.input
                    wire:model.live.debounce.300ms="name"
                    label="Nombre"
                    name="name"
                    placeholder="Ingresa el nombre del producto"
                    pattern="[A-Za-zÀ-ÿ\s]+"
                    title="Solo letras y espacios"
                    maxlength="256"
                    required
                    autocomplete="off"
                    x-data
                    x-on:keydown="
                        const allowed = ['Backspace','Tab','ArrowLeft','ArrowRight','Delete','Home','End','Enter','Escape'];
                        if (allowed.includes($event.key)) { return; }
                        if (($el.value || '').length >= 256) { $event.preventDefault(); return; }
                        if (!/^[A-Za-zÀ-ÿ\s]$/.test($event.key)) { $event.preventDefault(); }
                    "
                    x-on:input="
                        let clean = ($el.value || '').replace(/[^A-Za-zÀ-ÿ\s]/g, '');
                        clean = clean.slice(0, 256);
                        $el.value = clean;
                    "
                    x-on:change="
                        let clean = ($el.value || '').replace(/[^A-Za-zÀ-ÿ\s]/g, '');
                        clean = clean.slice(0, 256);
                        $el.value = clean;
                    "
                    x-on:paste.prevent="
                        let pasted = (event.clipboardData || window.clipboardData).getData('text') || '';
                        pasted = pasted.replace(/[^A-Za-zÀ-ÿ\s]/g, '').slice(0, 256);
                        if (pasted !== '') {
                            $el.value = pasted;
                            $el.dispatchEvent(new Event('input'));
                        }
                    "
                />
                <p class="products-form-helper">Usa un nombre descriptivo que identifique claramente el producto.</p>
            </div>

            
            <div>
                <x-form.input
                    wire:model.lazy="stock"
                    type="number"
                    min="0"
                    max="1000"
                    step="1"
                    inputmode="numeric"
                    pattern="\\d{1,4}"
                    label="Stock"
                    name="stock"
                    placeholder="Ingresa el stock"
                    required
                    x-data
                    x-on:keydown="
                        const allowed = ['Backspace','Tab','ArrowLeft','ArrowRight','Delete','Home','End','Enter','Escape'];
                        if (allowed.includes($event.key)) { return; }
                        if (!/^[0-9]$/.test($event.key)) { $event.preventDefault(); return; }
                        const selectionStart = $el.selectionStart ?? 0;
                        const selectionEnd = $el.selectionEnd ?? 0;
                        const current = $el.value || '';
                        const nextValue = current.slice(0, selectionStart) + $event.key + current.slice(selectionEnd);
                        const numeric = parseInt(nextValue, 10);
                        if (nextValue.length > 4 || Number.isNaN(numeric) || numeric > 1000) {
                            $event.preventDefault();
                        }
                    "
                    x-on:input="
                        let val = ($el.value || '').replace(/[^0-9]/g, '').slice(0, 4);
                        if (val === '') { $el.value = ''; return; }
                        let num = parseInt(val, 10);
                        if (Number.isNaN(num) || num < 0) { num = 0; }
                        if (num > 1000) { num = 1000; }
                        $el.value = num;
                    "
                    x-on:change="
                        let val = ($el.value || '').replace(/[^0-9]/g, '').slice(0, 4);
                        if (val === '') { $el.value = ''; return; }
                        let num = parseInt(val, 10);
                        if (Number.isNaN(num) || num < 0) { num = 0; }
                        if (num > 1000) { num = 1000; }
                        $el.value = num;
                    "
                    x-on:paste.prevent="
                        let pasted = (event.clipboardData || window.clipboardData).getData('text') || '';
                        pasted = pasted.replace(/[^0-9]/g, '').slice(0, 4);
                        if (pasted === '') { return; }
                        let num = parseInt(pasted, 10);
                        if (Number.isNaN(num) || num < 0) { num = 0; }
                        if (num > 1000) { num = 1000; }
                        $el.value = num;
                        $el.dispatchEvent(new Event('input'));
                    "
                    maxlength="4"
                />
                <p class="products-form-helper">Rango permitido: 0 a 1000 unidades.</p>
            </div>

            
            <div>
                <x-form.input
                    wire:model.lazy="price"
                    type="number"
                    min="0"
                    max="999999999"
                    step="0.01"
                    inputmode="decimal"
                    pattern="\d{1,9}(\.\d{1,2})?"
                    label="Precio"
                    name="price"
                    placeholder="Ingresa el precio"
                    required
                    maxlength="12"
                    x-data
                    x-on:keydown="
                        const allowed = ['Backspace','Tab','ArrowLeft','ArrowRight','Delete','Home','End','Enter','Escape','.'];
                        if (allowed.includes($event.key)) { return; }
                        if ($event.key === '.' && ($el.value || '').includes('.')) { $event.preventDefault(); return; }
                        if (!/^[0-9.]$/.test($event.key)) { $event.preventDefault(); return; }
                        const [intPart = ''] = ($el.value || '').split('.');
                        }
                    "
                    x-on:input="
                        let val = ($el.value || '').replace(/[^0-9.]/g, '');
                        let [intPart = '', decPart = ''] = val.split('.');
                        intPart = intPart.replace(/^0+(?=\d)/, '').slice(0, 9);
                        decPart = decPart.slice(0, 2);
                        val = decPart ? `${intPart || '0'}.${decPart}` : (intPart || '');
                        let num = parseFloat(val);
                        if (Number.isNaN(num)) { $el.value = ''; return; }
                        if (num > 999999999) {
                            num = 999999999;
                            decPart = '';
                        }
                        const [finalInt, finalDec = ''] = num.toString().split('.');
                        const decimals = decPart !== '' ? decPart : finalDec.slice(0, 2);
                        $el.value = decimals ? `${finalInt}.${decimals}` : finalInt;
                    "
                    x-on:change="
                        let val = ($el.value || '').replace(/[^0-9.]/g, '');
                        let [intPart = '', decPart = ''] = val.split('.');
                        intPart = intPart.replace(/^0+(?=\d)/, '').slice(0, 9);
                        decPart = decPart.slice(0, 2);
                        val = decPart ? `${intPart || '0'}.${decPart}` : (intPart || '');
                        let num = parseFloat(val);
                        if (Number.isNaN(num)) { $el.value = ''; return; }
                        if (num > 999999999) { num = 999999999; }
                        const [finalInt, finalDec = ''] = num.toString().split('.');
                        const decimals = decPart !== '' ? decPart : finalDec.slice(0, 2);
                        $el.value = decimals ? `${finalInt}.${decimals}` : finalInt;
                    "
                    x-on:paste.prevent="
                        let pasted = (event.clipboardData || window.clipboardData).getData('text') || '';
                        pasted = pasted.replace(/[^0-9.]/g, '');
                        let [intPart = '', decPart = ''] = pasted.split('.');
                        intPart = intPart.replace(/^0+(?=\d)/, '').slice(0, 9);
                        decPart = decPart.slice(0, 2);
                        let sanitized = decPart ? `${intPart || '0'}.${decPart}` : (intPart || '');
                        let num = parseFloat(sanitized);
                        if (Number.isNaN(num)) { sanitized = ''; }
                        if (num > 999999999) { sanitized = '999999999'; }
                        if (sanitized !== '') {
                            $el.value = sanitized;
                            $el.dispatchEvent(new Event('input'));
                        }
                    "
                />
                <p class="products-form-helper">Hasta 999,999,999 con máximo dos decimales.</p>
            </div>

            
            <div class="products-form-full" x-data="{ mode: 'search' }" @click.outside="$wire.hideCategoryResults()">
                <div class="flex items-center justify-end mb-1">
                    <button type="button" class="category-mode-toggle" x-on:click="mode = mode === 'search' ? 'select' : 'search'">
                        <span x-text="mode === 'search' ? 'Usar selector' : 'Usar búsqueda'"></span>
                    </button>
                </div>

                <template x-if="mode === 'search'">
                    <div>
                        <x-form.input
                            wire:model.live.debounce.300ms="categorySearch"
                            wire:blur="hideCategoryResults"
                            autocomplete="off"
                            label="Categoría"
                            name="categorySearch"
                            placeholder="Escribe para buscar..."
                            required
                        />
                        <p class="products-form-helper">Escribe y elige una categoría con su unidad de medida.</p>
                        @if($categoryResults)
                            <ul class="category-results">
                                @foreach($categoryResults as $cat)
                                    <li
                                        wire:mousedown.prevent="selectCategory({{ $cat['id'] }}, @js($cat['name']))"
                                        class="category-results-item"
                                    >
                                        <div class="category-info">
                                            <span class="category-title">{{ $cat['name'] }}</span>
                                            <span class="category-measure">Unidad: {{ $cat['measure'] }}</span>
                                        </div>
                                        <span class="category-meta">#{{ $cat['id'] }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                </template>

                <template x-if="mode === 'select'">
                    <div class="category-select-wrapper">
                        <select
                            id="categorySelect"
                            wire:model.live="category_id"
                            class="category-select"
                            size="10"
                            required
                        >
                            <option value="">Selecciona una categoría</option>
                            @foreach($categoryOptions as $cat)
                                <option value="{{ $cat['id'] }}">{{ $cat['name'] }} - {{ $cat['measure'] }}</option>
                            @endforeach
                        </select>
                        <p class="products-form-helper">Desplázate para ver más de 10 categorías.</p>
                    </div>
                </template>

                <x-form.field-error for="category_id" />
            </div>
        </div>

        @php
            $isEdit = property_exists($this, 'product') && $this->product?->exists;
        @endphp

        <div class="products-form-full mt-3 flex justify-end">
            <button
                type="submit"
                class="products-form-submit"
            >
                {{ $isEdit ? 'Actualizar producto' : 'Crear producto' }}
            </button>
        </div>
    </form>
</div>
