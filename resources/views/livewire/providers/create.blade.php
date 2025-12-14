<div class="providers-form-scope flex h-full w-full flex-1 flex-col gap-6 items-stretch">
    <style>
        .providers-form-scope {
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

        [data-theme="light"] .providers-form-scope,
        .theme-light .providers-form-scope {
            --surface: #FFFFFF;
            --surface-2: #F5F7F9;
            --text: #0E1420;
            --muted: #4A5568;
            --border: #E2E8F0;
            --shadow-soft: 0 12px 32px -18px rgba(15, 23, 42, 0.28);
        }

        [data-theme="dark"] .providers-form-scope,
        .theme-dark .providers-form-scope {
            --surface: #0F1720;
            --surface-2: #111827;
            --text: #E6EDF3;
            --muted: #8BA0B5;
            --border: rgba(255, 255, 255, 0.06);
            --shadow-soft: 0 18px 40px -24px rgba(0, 0, 0, 0.95);
        }

        .providers-form-topbar {
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: flex-start;
            padding-top: 0.5rem;
            padding-left: 0.5rem;
        }

        @media (min-width: 640px) {
            .providers-form-topbar {
                padding-left: 0;
            }
        }

        .providers-form-header {
            width: 100%;
            max-width: 52rem;
            margin: 0 auto;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .providers-form-title-badge {
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

        [data-theme="dark"] .providers-form-scope .providers-form-title-badge,
        .theme-dark .providers-form-scope .providers-form-title-badge {
            background: radial-gradient(circle at 0% 0%, rgba(26, 168, 85, 0.32), transparent 55%),
                        rgba(15, 23, 42, 0.5);
        }

        .providers-form-title-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 26px;
            height: 26px;
            border-radius: 9999px;
            background: linear-gradient(135deg, var(--sena-green-500), var(--accent-cyan));
            color: #fff;
        }

        .providers-form-title-text {
            font-size: 0.9rem;
            font-weight: 700;
            letter-spacing: .08em;
            text-transform: uppercase;
            color: var(--text);
        }

        .providers-form-subtitle {
            display: block;
            font-size: 0.7rem;
            font-weight: 500;
            letter-spacing: .14em;
            text-transform: uppercase;
            color: var(--muted);
        }

        .providers-form {
            width: 100%;
            max-width: 40rem;
            margin: .75rem auto 0 auto;
            padding: 1.75rem 1.75rem 1.5rem;
            border-radius: 20px;
            background: linear-gradient(135deg, rgba(15, 23, 42, 0.02), rgba(26, 168, 85, 0.02));
            border: 1px solid var(--border);
            box-shadow: var(--shadow-soft);
        }

        .providers-form-label {
            font-size: 0.78rem;
            font-weight: 600;
            color: var(--muted);
            margin-bottom: 0.2rem;
            display: inline-block;
        }

        .providers-form-helper{
            font-size: 0.70rem;
            color: var(--muted);
            margin-top: 0.15rem;
        }

        .providers-form-scope input[type="text"],
        .providers-form-scope input[type="number"],
        .providers-form-scope input[type="tel"],
        .providers-form-scope select {
            background: var(--surface);
            border-radius: 0.75rem;
            border: 1px solid rgba(148, 163, 184, 0.6);
            padding: 0.55rem 0.8rem;
            font-size: 0.85rem;
            color: var(--text);
            outline: none;
            transition: border-color 0.14s ease, box-shadow 0.14s ease, background 0.14s ease, transform 0.04s ease;
        }

        .providers-form-scope input::placeholder {
            color: rgba(148, 163, 184, 0.9);
        }

        .providers-form-scope input:focus-visible,
        .providers-form-scope select:focus-visible {
            border-color: rgba(26, 168, 85, 0.9);
            box-shadow: 0 0 0 2px rgba(26, 168, 85, 0.18);
            transform: translateY(-0.5px);
        }

        .providers-form-scope input:disabled {
            opacity: 0.65;
            cursor: not-allowed;
        }

        
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
            transition: border-color 0.14s ease, box-shadow 0.14s ease, background 0.14s ease, transform 0.05s ease;
            appearance: none;
            -webkit-appearance: none;
            padding-right: 2rem;
        }

        .sales-select option {
            background-color: #ffffff;
            color: #0E1420;
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

        [data-theme="dark"] .providers-form-scope input[type="text"],
        [data-theme="dark"] .providers-form-scope input[type="number"],
        [data-theme="dark"] .providers-form-scope input[type="tel"],
        [data-theme="dark"] .providers-form-scope select,
        .theme-dark .providers-form-scope input[type="text"],
        .theme-dark .providers-form-scope input[type="number"],
        .theme-dark .providers-form-scope input[type="tel"],
        .theme-dark .providers-form-scope select {
            background: #020617;
            border-color: rgba(67, 198, 120, 0.9);
            color: #F9FAFB;
            color-scheme: dark;
        }

        [data-theme="dark"] .providers-form-scope .sales-select,
        .theme-dark .providers-form-scope .sales-select {
            background:
                radial-gradient(circle at 0% 0%, rgba(26, 168, 85, 0.24), transparent 55%),
                #020617;
            border-color: rgba(67, 198, 120, 0.9);
            color: #F9FAFB;
        }

        [data-theme="dark"] .providers-form-scope select option,
        .theme-dark .providers-form-scope select option {
            background-color: #020617;
            color: #E6EDF3;
        }

        [data-theme="dark"] .providers-form-scope .sales-select option,
        .theme-dark .providers-form-scope .sales-select option {
            background-color: #020617;
            color: #E6EDF3;
        }

        .providers-form-scope .text-error,
        .providers-form-scope .form-error {
            color: var(--error);
            font-size: 0.75rem;
        }

        .providers-form-submit {
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

        .providers-form-submit:hover {
            filter: brightness(1.03);
            transform: translateY(-1px);
        }

        .providers-form-submit:focus-visible {
            outline: 3px solid rgba(26, 168, 85, 0.32);
            outline-offset: 2px;
        }

        .providers-form-submit:disabled {
            opacity: .7;
            cursor: not-allowed;
            box-shadow: none;
        }

        .providers-form-back-btn {
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

        .providers-form-back-btn svg {
            width: 18px;
            height: 18px;
        }

        .providers-form-back-btn:hover {
            filter: brightness(1.03);
            transform: translateY(-1px);
            box-shadow: 0 14px 32px -18px rgba(26, 168, 85, 0.85);
        }

        .providers-form-back-btn:focus-visible {
            outline: 2px solid rgba(26, 168, 85, 0.45);
            outline-offset: 2px;
        }

        [data-theme="dark"] .providers-form-scope .providers-form-back-btn,
        .theme-dark .providers-form-scope .providers-form-back-btn {
            background: radial-gradient(circle at 0% 0%, rgba(26, 168, 85, 0.32), transparent 55%),
                        rgba(15, 23, 42, 0.55);
            color: #E6EDF3;
            border-color: rgba(26, 168, 85, 0.65);
        }
    </style>

    @php($isEdit = property_exists($this, 'provider') && $this->provider?->exists)

    
    <div class="providers-form-topbar">
        <a href="{{ route('providers.index')}}"
           wire:navigate
           class="providers-form-back-btn"
           role="button">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
            </svg>
            <span class="ml-1">Volver</span>
        </a>
    </div>

    
    <div class="providers-form-header">
        <div class="providers-form-title-badge">
            <div class="providers-form-title-icon">
                <svg viewBox="0 0 24 24" class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" />
                    <circle cx="9" cy="7" r="4" />
                    <path d="M23 21v-2a4 4 0 0 0-3-3.87" />
                    <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                </svg>
            </div>
            <div class="flex flex-col leading-tight">
                <span class="providers-form-title-text">Registro de Proveedores</span>
                <span class="providers-form-subtitle">Datos del proveedor</span>
            </div>
        </div>
    </div>

    <x-form.error-alert />

    <form wire:submit="save" class="providers-form">
        <div class="flex flex-col gap-5">
            <x-form.input wire:model="identification"
                          label="Identificación"
                          name="identification"
                          placeholder="Documento del proveedor, ej: 1001348132"
                          pattern="\d{3,10}"
                          minlength="3"
                          maxlength="10"
                          inputmode="numeric"
                          required
                          title="Solo números, 3 a 10 dígitos"
                          onkeydown="return window.allowDigitsOnly(event);"
                          oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10);" />
            <p class="providers-form-helper">Solo números, mínimo 3 máximo 10.</p>

            <x-form.input wire:model.live.debounce.250ms="name"
                          label="Nombre del proveedor"
                          name="name"
                          placeholder="Ingresa el nombre del proveedor"
                          pattern="[A-Za-zÀ-ÿ0-9\s\.]+"
                          maxlength="256"
                          required
                          title="Solo letras, números, espacios y puntos"
                          onkeydown="return window.allowLettersSpacesDots(event);"
                          oninput="this.value = this.value.replace(/[^A-Za-zÀ-ÿ0-9\.\s]/g, '').slice(0, 256);"
                          autocomplete="off" />
            <p class="providers-form-helper">Solo letras y espacios.</p>

            <x-form.input wire:model="phone_number"
                          label="Teléfono"
                          name="phone_number"
                          placeholder="Teléfono del proveedor, ej: 3209875684"
                          pattern="3\d{9}"
                          maxlength="10"
                          inputmode="numeric"
                          minlength="10"
                          required
                          title="Debe iniciar en 3 y tener 10 dígitos"
                          onkeydown="return window.allowDigitsOnly(event);"
                          oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10);" />
            <p class="providers-form-helper">Solo números, el número debe iniciar en 3 y tener 10 dígitos.</p>

            <div>
                <label class="providers-form-label">Tipo de persona</label>
                <div class="sales-select-wrapper">
                    <select wire:model="person_type_id" required class="sales-select w-full">
                        <option value="">Seleccione...</option>
                        @foreach($personTypes as $type)
                            <option value="{{ $type['id'] }}">{{ $type['name'] }}</option>
                        @endforeach
                    </select>
                </div>
                <x-form.field-error for="person_type_id" />
                <p class="providers-form-helper">Seleccione el tipo de persona.</p>
            </div>

            <div class="flex items-center justify-end mt-3">
                <button type="submit" class="providers-form-submit">
                    {{ $isEdit ? 'Actualizar proveedor' : 'Crear proveedor' }}
                </button>
            </div>
        </div>
    </form>

    <script>
        window.allowDigitsOnly = function(event) {
            const navigationKeys = ['Backspace', 'Tab', 'ArrowLeft', 'ArrowRight', 'Delete', 'Home', 'End', 'Enter'];
            if (event.ctrlKey || event.metaKey) {
                return true;
            }
            if (navigationKeys.includes(event.key)) {
                return true;
            }
            return /^[0-9]$/.test(event.key);
        };

        window.allowLettersSpacesDots = function(event) {
            const navigationKeys = ['Backspace', 'Tab', 'ArrowLeft', 'ArrowRight', 'Delete', 'Home', 'End', 'Enter'];
            if (event.ctrlKey || event.metaKey) {
                return true;
            }
            if (navigationKeys.includes(event.key)) {
                return true;
            }
            return /^[A-Za-zÀ-ÿ0-9\\. ]$/.test(event.key);
        };
    </script>
</div>
