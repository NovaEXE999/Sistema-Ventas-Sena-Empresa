<div class="catform-scope flex h-full w-full flex-1 flex-col gap-6 items-stretch">
    <style>
        .catform-scope {
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

        [data-theme="light"] .catform-scope,
        .theme-light .catform-scope {
            --surface: #FFFFFF;
            --surface-2: #F5F7F9;
            --text: #0E1420;
            --muted: #4A5568;
            --border: #E2E8F0;
            --shadow-soft: 0 12px 32px -18px rgba(15, 23, 42, 0.28);
        }

        [data-theme="dark"] .catform-scope,
        .theme-dark .catform-scope {
            --surface: #0F1720;
            --surface-2: #111827;
            --text: #E6EDF3;
            --muted: #8BA0B5;
            --border: rgba(255, 255, 255, 0.06);
            --shadow-soft: 0 18px 40px -24px rgba(0, 0, 0, 0.95);
        }

        .catform-topbar {
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: flex-start;
            padding-top: 0.5rem;
            padding-left: 0.5rem;
        }

        @media (min-width: 640px) {
            .catform-topbar {
                padding-left: 0;
            }
        }

        .catform-header {
            width: 100%;
            max-width: 52rem;
            margin: 0 auto;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .catform-title-badge {
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

        [data-theme="dark"] .catform-scope .catform-title-badge,
        .theme-dark .catform-scope .catform-title-badge {
            background: radial-gradient(circle at 0% 0%, rgba(26, 168, 85, 0.32), transparent 55%),
                        rgba(15, 23, 42, 0.5);
        }

        .catform-title-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 26px;
            height: 26px;
            border-radius: 9999px;
            background: linear-gradient(135deg, var(--sena-green-500), var(--accent-cyan));
            color: #fff;
        }

        .catform-title-text {
            font-size: 0.9rem;
            font-weight: 700;
            letter-spacing: .08em;
            text-transform: uppercase;
            color: var(--text);
        }

        .catform-subtitle {
            display: block;
            font-size: 0.7rem;
            font-weight: 500;
            letter-spacing: .14em;
            text-transform: uppercase;
            color: var(--muted);
        }

        .catform-form {
            width: 100%;
            max-width: 40rem;
            margin: .75rem auto 0 auto;
            padding: 1.75rem 1.75rem 1.5rem;
            border-radius: 20px;
            background: linear-gradient(135deg, rgba(15, 23, 42, 0.02), rgba(26, 168, 85, 0.02));
            border: 1px solid var(--border);
            box-shadow: var(--shadow-soft);
        }

        .catform-label {
            font-size: 0.78rem;
            font-weight: 600;
            color: var(--muted);
            margin-bottom: 0.2rem;
            display: inline-block;
        }

        .catform-scope input[type="text"],
        .catform-scope input[type="search"],
        .catform-scope select {
            background: var(--surface);
            border-radius: 0.75rem;
            border: 1px solid rgba(148, 163, 184, 0.6);
            padding: 0.55rem 0.8rem;
            font-size: 0.85rem;
            color: var(--text);
            outline: none;
            transition: border-color 0.14s ease, box-shadow 0.14s ease, background 0.14s ease, transform 0.04s ease;
        }

        .catform-scope input::placeholder {
            color: rgba(148, 163, 184, 0.9);
        }

        .catform-scope input:focus-visible,
        .catform-scope select:focus-visible {
            border-color: rgba(26, 168, 85, 0.9);
            box-shadow: 0 0 0 2px rgba(26, 168, 85, 0.18);
            transform: translateY(-0.5px);
        }

        .catform-scope input:disabled {
            opacity: 0.65;
            cursor: not-allowed;
        }

        [data-theme="dark"] .catform-scope input[type="text"],
        [data-theme="dark"] .catform-scope input[type="search"],
        [data-theme="dark"] .catform-scope select,
        .theme-dark .catform-scope input[type="text"],
        .theme-dark .catform-scope input[type="search"],
        .theme-dark .catform-scope select {
            background: #020617;
            border-color: rgba(67, 198, 120, 0.9);
            color: #F9FAFB;
            color-scheme: dark;
        }

        [data-theme="dark"] .catform-scope select option,
        .theme-dark .catform-scope select option {
            background-color: #020617;
            color: #E6EDF3;
        }

        .catform-scope .text-error,
        .catform-scope .form-error {
            color: var(--error);
            font-size: 0.75rem;
        }

        .catform-submit {
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

        .catform-submit:hover {
            filter: brightness(1.03);
            transform: translateY(-1px);
        }

        .catform-submit:focus-visible {
            outline: 3px solid rgba(26, 168, 85, 0.32);
            outline-offset: 2px;
        }

        .catform-submit:disabled {
            opacity: .7;
            cursor: not-allowed;
            box-shadow: none;
        }

        .catform-back-btn {
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

        .catform-back-btn svg {
            width: 18px;
            height: 18px;
        }

        .catform-back-btn:hover {
            filter: brightness(1.03);
            transform: translateY(-1px);
            box-shadow: 0 14px 32px -18px rgba(26, 168, 85, 0.85);
        }

        .catform-back-btn:focus-visible {
            outline: 2px solid rgba(26, 168, 85, 0.45);
            outline-offset: 2px;
        }

        [data-theme="dark"] .catform-scope .catform-back-btn,
        .theme-dark .catform-scope .catform-back-btn {
            background: radial-gradient(circle at 0% 0%, rgba(26, 168, 85, 0.32), transparent 55%),
                        rgba(15, 23, 42, 0.55);
            color: #E6EDF3;
            border-color: rgba(26, 168, 85, 0.65);
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
            position: absolute;
            z-index: 10;
            width: 100%;
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

        /* Selector de unidades */
        .measure-select-wrapper {
            position: relative;
        }

        .measure-select {
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

        [data-theme="dark"] .catform-scope .measure-select,
        .theme-dark .catform-scope .measure-select {
            background: #020617;
            border-color: rgba(67, 198, 120, 0.9);
            color: #F9FAFB;
        }

        .measure-mode-toggle {
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

        .measure-mode-toggle:hover {
            transform: translateY(-1px);
            box-shadow: 0 10px 26px -18px rgba(26, 168, 85, 0.60);
        }

        .catform-helper {
            font-size: 0.70rem;
            color: var(--muted);
            margin-top: 0.15rem;
        }
    </style>

    @php
        $isEdit = property_exists($this, 'category') && $this->category?->exists;
    @endphp

    
    <div class="catform-topbar">
        <a href="{{ route('categoriesandmeasures.index')}}"
           wire:navigate
           class="catform-back-btn"
           role="button">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
            </svg>
            <span class="ml-1">Volver</span>
        </a>
    </div>

    
    <div class="catform-header">
        <div class="catform-title-badge">
            <div class="catform-title-icon">
                <svg viewBox="0 0 24 24" class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M4 20h4l10.5 -10.5a1.5 1.5 0 0 0 -4 -4l-10.5 10.5v4" />
                    <line x1="13.5" y1="6.5" x2="17.5" y2="10.5" />
                </svg>
            </div>
            <div class="flex flex-col leading-tight">
                <span class="catform-title-text">{{ $isEdit ? 'Actualizar categoría' : 'Crear categoría' }}</span>
                <span class="catform-subtitle">Gestión de productos</span>
            </div>
        </div>
    </div>

    <x-form.error-alert />

    <form wire:submit="save" class="catform-form">
        <div class="flex flex-col gap-5">
            <x-form.input wire:model.live.debounce.250ms="name"
                          label="Nombre"
                          name="name"
                          placeholder="Ingresa el nombre de la categoría"
                          maxlength="256"
                          pattern="^[A-Za-zÁÉÍÓÚáéíóúÑñÜü\s]{1,256}$"
                          x-on:keydown="if ($event.ctrlKey || $event.metaKey || $event.altKey) { return; } if (!/^[A-Za-zÁÉÍÓÚáéíóúÑñÜü\s]$/.test($event.key) && !['Backspace','Tab','ArrowLeft','ArrowRight','ArrowUp','ArrowDown','Delete','Home','End','Enter'].includes($event.key)) { $event.preventDefault(); }"
                          title="Solo letras y espacios"
                          autocomplete="off"/>
            <p class="catform-helper">El nombre en plural y solo letras y espacios, ej: Frutas</p>

            <div class="relative" x-data="{ mode: 'search' }" @click.outside="$wire.hideMeasureResults()">
                <div class="flex items-center justify-end mb-1">
                    <button type="button" class="measure-mode-toggle" x-on:click="mode = mode === 'search' ? 'select' : 'search'">
                        <span x-text="mode === 'search' ? 'Usar selector' : 'Usar búsqueda'"></span>
                    </button>
                </div>

                <template x-if="mode === 'search'">
                    <div>
                        <x-form.input wire:model.live.debounce.250ms="measureSearch"
                                      wire:blur="ensureMeasureSelected"
                                      autocomplete="off"
                                      label="Unidad de medida"
                                      name="measureSearch"
                                      placeholder="Busca una medida..." />
                        @if($measureResults)
                            <ul class="autocomplete-results">
                                @foreach($measureResults as $measure)
                                    <li wire:mousedown.prevent="selectMeasure({{ $measure['id'] }}, @js($measure['name']))"
                                        class="autocomplete-results-item">
                                        {{ $measure['name'] }}
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                        <p class="catform-helper">Escribe para buscar y selecciona una unidad.</p>
                    </div>
                </template>

                <template x-if="mode === 'select'">
                    <div class="measure-select-wrapper">
                        <select
                            id="measureSelect"
                            wire:model.live="measure_id"
                            class="measure-select"
                            size="10"
                            required
                        >
                            <option value="">Selecciona una unidad</option>
                            @foreach($measureOptions as $measure)
                                <option value="{{ $measure['id'] }}">{{ $measure['name'] }}</option>
                            @endforeach
                        </select>
                        <p class="catform-helper">Desplázate para ver más de 10 unidades.</p>
                    </div>
                </template>

                <x-form.field-error for="measure_id" />
            </div>

            <div class="flex items-center justify-end mt-3">
                <button type="submit" class="catform-submit">
                    {{ $isEdit ? 'Actualizar categoría' : 'Crear categoría' }}
                </button>
            </div>
        </div>
    </form>
</div>
