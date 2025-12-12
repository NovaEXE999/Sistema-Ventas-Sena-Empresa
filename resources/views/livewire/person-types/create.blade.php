<div class="persontypeform-scope flex h-full w-full flex-1 flex-col gap-6 items-stretch">
    <style>
        .persontypeform-scope {
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

        [data-theme="light"] .persontypeform-scope,
        .theme-light .persontypeform-scope {
            --surface: #FFFFFF;
            --surface-2: #F5F7F9;
            --text: #0E1420;
            --muted: #4A5568;
            --border: #E2E8F0;
            --shadow-soft: 0 12px 32px -18px rgba(15, 23, 42, 0.28);
        }

        [data-theme="dark"] .persontypeform-scope,
        .theme-dark .persontypeform-scope {
            --surface: #0F1720;
            --surface-2: #111827;
            --text: #E6EDF3;
            --muted: #8BA0B5;
            --border: rgba(255, 255, 255, 0.06);
            --shadow-soft: 0 18px 40px -24px rgba(0, 0, 0, 0.95);
        }

        .persontypeform-topbar {
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: flex-start;
            padding-top: 0.5rem;
            padding-left: 0.5rem;
        }

        @media (min-width: 640px) {
            .persontypeform-topbar {
                padding-left: 0;
            }
        }

        .persontypeform-header {
            width: 100%;
            max-width: 52rem;
            margin: 0 auto;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .persontypeform-title-badge {
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

        [data-theme="dark"] .persontypeform-scope .persontypeform-title-badge,
        .theme-dark .persontypeform-scope .persontypeform-title-badge {
            background: radial-gradient(circle at 0% 0%, rgba(26, 168, 85, 0.32), transparent 55%),
                        rgba(15, 23, 42, 0.5);
        }

        .persontypeform-title-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 26px;
            height: 26px;
            border-radius: 9999px;
            background: linear-gradient(135deg, var(--sena-green-500), var(--accent-cyan));
            color: #fff;
        }

        .persontypeform-title-text {
            font-size: 0.9rem;
            font-weight: 700;
            letter-spacing: .08em;
            text-transform: uppercase;
            color: var(--text);
        }

        .persontypeform-subtitle {
            display: block;
            font-size: 0.7rem;
            font-weight: 500;
            letter-spacing: .14em;
            text-transform: uppercase;
            color: var(--muted);
        }

        .persontypeform-form {
            width: 100%;
            max-width: 40rem;
            margin: .75rem auto 0 auto;
            padding: 1.75rem 1.75rem 1.5rem;
            border-radius: 20px;
            background: linear-gradient(135deg, rgba(15, 23, 42, 0.02), rgba(26, 168, 85, 0.02));
            border: 1px solid var(--border);
            box-shadow: var(--shadow-soft);
        }

        .persontypeform-label {
            font-size: 0.78rem;
            font-weight: 600;
            color: var(--muted);
            margin-bottom: 0.2rem;
            display: inline-block;
        }

        .persontypeform-scope input[type="text"],
        .persontypeform-scope input[type="search"],
        .persontypeform-scope select {
            background: var(--surface);
            border-radius: 0.75rem;
            border: 1px solid rgba(148, 163, 184, 0.6);
            padding: 0.55rem 0.8rem;
            font-size: 0.85rem;
            color: var(--text);
            outline: none;
            transition: border-color 0.14s ease, box-shadow 0.14s ease, background 0.14s ease, transform 0.04s ease;
        }

        .persontypeform-scope input::placeholder {
            color: rgba(148, 163, 184, 0.9);
        }

        .persontypeform-scope input:focus-visible,
        .persontypeform-scope select:focus-visible {
            border-color: rgba(26, 168, 85, 0.9);
            box-shadow: 0 0 0 2px rgba(26, 168, 85, 0.18);
            transform: translateY(-0.5px);
        }

        .persontypeform-scope input:disabled {
            opacity: 0.65;
            cursor: not-allowed;
        }

        [data-theme="dark"] .persontypeform-scope input[type="text"],
        [data-theme="dark"] .persontypeform-scope input[type="search"],
        [data-theme="dark"] .persontypeform-scope select,
        .theme-dark .persontypeform-scope input[type="text"],
        .theme-dark .persontypeform-scope input[type="search"],
        .theme-dark .persontypeform-scope select {
            background: #020617;
            border-color: rgba(67, 198, 120, 0.9);
            color: #F9FAFB;
            color-scheme: dark;
        }

        .persontypeform-scope .text-error,
        .persontypeform-scope .form-error {
            color: var(--error);
            font-size: 0.75rem;
        }

        .persontypeform-submit {
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

        .persontypeform-submit:hover {
            filter: brightness(1.03);
            transform: translateY(-1px);
        }

        .persontypeform-submit:focus-visible {
            outline: 3px solid rgba(26, 168, 85, 0.32);
            outline-offset: 2px;
        }

        .persontypeform-submit:disabled {
            opacity: .7;
            cursor: not-allowed;
            box-shadow: none;
        }

        .persontypeform-back-btn {
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

        .persontypeform-back-btn svg {
            width: 18px;
            height: 18px;
        }

        .persontypeform-back-btn:hover {
            filter: brightness(1.03);
            transform: translateY(-1px);
            box-shadow: 0 14px 32px -18px rgba(26, 168, 85, 0.85);
        }

        .persontypeform-back-btn:focus-visible {
            outline: 2px solid rgba(26, 168, 85, 0.45);
            outline-offset: 2px;
        }

        [data-theme="dark"] .persontypeform-scope .persontypeform-back-btn,
        .theme-dark .persontypeform-scope .persontypeform-back-btn {
            background: radial-gradient(circle at 0% 0%, rgba(26, 168, 85, 0.32), transparent 55%),
                        rgba(15, 23, 42, 0.55);
            color: #E6EDF3;
            border-color: rgba(26, 168, 85, 0.65);
        }
        .persontypeform-helper {
            font-size: 0.70rem;
            color: var(--muted);
            margin-top: 0.15rem;
        }
    </style>

    {{-- TOPBAR: botón Volver --}}
    <div class="persontypeform-topbar">
        <a href="{{ route('persontypes.index')}}"
           wire:navigate
           class="persontypeform-back-btn"
           role="button">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
            </svg>
            <span class="ml-1">Volver</span>
        </a>
    </div>

    {{-- HEADER: título centrado con badge --}}
    <div class="persontypeform-header">
        <div class="persontypeform-title-badge">
            <div class="persontypeform-title-icon">
                <svg viewBox="0 0 24 24" class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2" />
                    <circle cx="9" cy="7" r="4" />
                    <path d="M22 21v-2a4 4 0 0 0-3-3.87" />
                    <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                </svg>
            </div>
            <div class="flex flex-col leading-tight">
                <span class="persontypeform-title-text">Tipos de persona</span>
                <span class="persontypeform-subtitle">Gestión de clasificaciones</span>
            </div>
        </div>
    </div>

    <x-form.error-alert />

    <form wire:submit="save" class="persontypeform-form">
        <div class="flex flex-col gap-5">
            <x-form.input
                wire:model="name"
                label="Nombre"
                name="name"
                placeholder="Ingresa el tipo de persona, ej: Natural"
                maxlength="256"
                pattern="^[A-Za-zÁÉÍÓÚáéíóúÑñÜü\s]{1,256}$"
                x-on:keydown="if ($event.ctrlKey || $event.metaKey || $event.altKey) { return; } if (!/^[A-Za-zÁÉÍÓÚáéíóúÑñÜü\s]$/.test($event.key) && !['Backspace','Tab','ArrowLeft','ArrowRight','ArrowUp','ArrowDown','Delete','Home','End','Enter'].includes($event.key)) { $event.preventDefault(); }"
                title="Solo se permiten letras y espacios"
            />
            <p class="persontypeform-helper">Solo letras y espacios.</p>

            <div class="flex items-center justify-end mt-3">
                <button type="submit" class="persontypeform-submit">
                    {{ request()->routeIs('persontypes.create') ? 'Crear tipo de persona' : 'Actualizar tipo de persona' }}
                </button>
            </div>
        </div>
    </form>
</div>
