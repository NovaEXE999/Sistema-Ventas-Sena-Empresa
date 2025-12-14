<div class="users-form-scope flex h-full w-full flex-1 flex-col gap-6 items-stretch">
    <style>
        .users-form-scope {
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

        [data-theme="light"] .users-form-scope,
        .theme-light .users-form-scope {
            --surface: #FFFFFF;
            --surface-2: #F5F7F9;
            --text: #0E1420;
            --muted: #4A5568;
            --border: #E2E8F0;
            --shadow-soft: 0 12px 32px -18px rgba(15, 23, 42, 0.28);
        }

        [data-theme="dark"] .users-form-scope,
        .theme-dark .users-form-scope {
            --surface: #0F1720;
            --surface-2: #111827;
            --text: #E6EDF3;
            --muted: #8BA0B5;
            --border: rgba(255, 255, 255, 0.06);
            --shadow-soft: 0 18px 40px -24px rgba(0, 0, 0, 0.95);
        }

        
        .users-form-topbar {
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: flex-start;
            padding-top: 0.5rem;
            padding-left: 0.5rem;
        }

        @media (min-width: 640px) {
            .users-form-topbar {
                padding-left: 0;
            }
        }

        
        .users-form-header {
            width: 100%;
            max-width: 52rem;
            margin: 0 auto;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .users-form-title-badge {
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

        [data-theme="dark"] .users-form-scope .users-form-title-badge,
        .theme-dark .users-form-scope .users-form-title-badge {
            background: radial-gradient(circle at 0% 0%, rgba(26, 168, 85, 0.32), transparent 55%),
                        rgba(15, 23, 42, 0.5);
        }

        .users-form-title-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 26px;
            height: 26px;
            border-radius: 9999px;
            background: linear-gradient(135deg, var(--sena-green-500), var(--accent-cyan));
            color: #fff;
        }

        .users-form-title-text {
            font-size: 0.9rem;
            font-weight: 700;
            letter-spacing: .08em;
            text-transform: uppercase;
            color: var(--text);
        }

        .users-form-subtitle {
            display: block;
            font-size: 0.7rem;
            font-weight: 500;
            letter-spacing: .14em;
            text-transform: uppercase;
            color: var(--muted);
        }

        
        .users-form {
            width: 100%;
            max-width: 40rem;
            margin: .75rem auto 0 auto;
            padding: 1.75rem 1.75rem 1.5rem;
            border-radius: 20px;
            background: linear-gradient(135deg, rgba(15, 23, 42, 0.02), rgba(26, 168, 85, 0.02));
            border: 1px solid var(--border);
            box-shadow: var(--shadow-soft);
        }

        .users-form-label {
            font-size: 0.78rem;
            font-weight: 600;
            color: var(--muted);
            margin-bottom: 0.2rem;
            display: inline-block;
        }

        .users-form-helper{
            font-size: 0.70rem;
            color: var(--muted);
            margin-top: 0.15rem;
        }

        
        .users-form-scope input[type="text"],
        .users-form-scope input[type="email"],
        .users-form-scope input[type="tel"],
        .users-form-scope input[type="password"],
        .users-form-scope select {
            background: var(--surface);
            border-radius: 0.75rem;
            border: 1px solid rgba(148, 163, 184, 0.6);
            padding: 0.55rem 0.8rem;
            font-size: 0.85rem;
            color: var(--text);
            outline: none;
            transition: border-color 0.14s ease, box-shadow 0.14s ease, background 0.14s ease, transform 0.04s ease;
        }

        .users-form-scope input::placeholder {
            color: rgba(148, 163, 184, 0.9);
        }

        .users-form-scope input:focus-visible,
        .users-form-scope select:focus-visible {
            border-color: rgba(26, 168, 85, 0.9);
            box-shadow: 0 0 0 2px rgba(26, 168, 85, 0.18);
            transform: translateY(-0.5px);
        }

        .users-form-scope input:disabled {
            opacity: 0.65;
            cursor: not-allowed;
        }

        
        .users-select-wrapper {
            position: relative;
        }

        .users-select-wrapper::after {
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

        .users-select {
            width: 100%;
            border-radius: 0.75rem;
            padding: 0.55rem 0.8rem;
            padding-right: 2rem;
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
        }

        .users-select option {
            background-color: #ffffff;
            color: #0E1420;
        }

        .users-select:focus-visible {
            border-color: rgba(26, 168, 85, 0.9);
            box-shadow: 0 0 0 2px rgba(26, 168, 85, 0.18);
            transform: translateY(-0.5px);
        }

        .users-select-error {
            border-color: rgba(229, 72, 77, 0.9);
            box-shadow: 0 0 0 2px rgba(229, 72, 77, 0.18);
        }

        [data-theme="dark"] .users-form-scope input[type="text"],
        [data-theme="dark"] .users-form-scope input[type="email"],
        [data-theme="dark"] .users-form-scope input[type="tel"],
        [data-theme="dark"] .users-form-scope input[type="password"],
        [data-theme="dark"] .users-form-scope select,
        .theme-dark .users-form-scope input[type="text"],
        .theme-dark .users-form-scope input[type="email"],
        .theme-dark .users-form-scope input[type="tel"],
        .theme-dark .users-form-scope input[type="password"],
        .theme-dark .users-form-scope select {
            background: #020617;
            border-color: rgba(67, 198, 120, 0.9);
            color: #F9FAFB;
            color-scheme: dark;
        }

        [data-theme="dark"] .users-form-scope select option,
        .theme-dark .users-form-scope select option {
            background-color: #020617;
            color: #E6EDF3;
        }

        [data-theme="dark"] .users-form-scope .users-select,
        .theme-dark .users-form-scope .users-select {
            background:
                radial-gradient(circle at 0% 0%, rgba(26, 168, 85, 0.24), transparent 55%),
                #020617;
            border-color: rgba(67, 198, 120, 0.9);
            color: #E6EDF3;
            color-scheme: dark;
        }

        [data-theme="dark"] .users-form-scope .users-select option,
        .theme-dark .users-form-scope .users-select option {
            background-color: #020617;
            color: #E6EDF3;
        }

        
        .users-form-scope .text-error,
        .users-form-scope .form-error {
            color: var(--error);
            font-size: 0.75rem;
        }

        
        .users-form-submit {
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

        .users-form-submit:hover {
            filter: brightness(1.03);
            transform: translateY(-1px);
        }

        .users-form-submit:focus-visible {
            outline: 3px solid rgba(26, 168, 85, 0.32);
            outline-offset: 2px;
        }

        .users-form-submit:disabled {
            opacity: .7;
            cursor: not-allowed;
            box-shadow: none;
        }

        
        .users-form-back-btn {
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

        .users-form-back-btn:hover {
            filter: brightness(1.03);
            transform: translateY(-1px);
            box-shadow: 0 14px 32px -18px rgba(26, 168, 85, 0.85);
        }

        .users-form-back-btn:focus-visible {
            outline: 2px solid rgba(26, 168, 85, 0.45);
            outline-offset: 2px;
        }

        [data-theme="dark"] .users-form-scope .users-form-back-btn,
        .theme-dark .users-form-scope .users-form-back-btn {
            background: radial-gradient(circle at 0% 0%, rgba(26, 168, 85, 0.32), transparent 55%),
                        rgba(15, 23, 42, 0.55);
            color: #E6EDF3;
            border-color: rgba(26, 168, 85, 0.65);
        }
    </style>

    
    <div class="users-form-topbar">
        <a href="{{ route('users.index') }}" wire:navigate class="users-form-back-btn">
            ← Volver
        </a>
    </div>

    
    <div class="users-form-header">
        <div class="users-form-title-badge">
            <div class="users-form-title-icon">
                <svg viewBox="0 0 24 24" class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2" />
                    <circle cx="9" cy="7" r="4" />
                    <path d="M22 21v-2a4 4 0 0 0-3-3.87" />
                    <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                </svg>
            </div>
            <div class="flex flex-col leading-tight">
                <span class="users-form-title-text">Registrar usuario</span>
                <span class="users-form-subtitle">Gestión de accesos</span>
            </div>
        </div>
    </div>

    <x-form.error-alert />

    <form wire:submit.prevent="save" class="users-form" novalidate>
        <div class="flex flex-col gap-5">
            <flux:input
                wire:model.live="identification"
                name="identification"
                :label="__('Identificación')"
                type="text"
                required
                minlength="3"
                maxlength="10"
                pattern="^[0-9]{3,10}$"
                title="Solo números, entre 3 y 10 dígitos, sin signos."
                x-on:input="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10)"
                x-on:keydown="
                    const allowedKeys = ['Backspace','Tab','ArrowLeft','ArrowRight','Delete','Home','End'];
                    if (!/^[0-9]$/.test($event.key) && !allowedKeys.includes($event.key)) { $event.preventDefault(); }
                "
                autocomplete="off"
                :placeholder="__('Número de identificación, ej: 1032119426')"
                :error="$errors->first('identification')"
            />
            <p class="users-form-helper">Solo números, mínimo 5 máximo 10.</p>

            <flux:input
                wire:model.live="name"
                name="name"
                :label="__('Nombre')"
                type="text"
                required
                maxlength="256"
                pattern="^[A-Za-zÀ-ÿ ]{1,256}$"
                title="Solo letras y espacios. Máximo 256 caracteres."
                x-on:input="this.value = this.value.replace(/[^A-Za-zÀ-ÿ ]/g, '').slice(0, 256)"
                x-on:keydown="
                    const allowedKeys = ['Backspace','Tab','ArrowLeft','ArrowRight','Delete','Home','End'];
                    if (!/^[A-Za-zÀ-ÿ ]$/.test($event.key) && !allowedKeys.includes($event.key)) { $event.preventDefault(); }
                "
                autocomplete="name"
                :placeholder="__('Nombre completo')"
                :error="$errors->first('name')"
            />
            <p class="users-form-helper">Solo letras y espacios. Máximo 256 caracteres.</p>

            <flux:input
                wire:model.live="email"
                name="email"
                :label="__('Dirección de correo electrónico')"
                type="email"
                required
                maxlength="254"
                pattern="^[A-Za-z0-9._%+-]+@(gmail\.com|hotmail\.com|msn\.com|outlook\.com|yahoo\.com|yahoo\.es|icloud\.com|live\.com)$"
                title="Usa un correo de: gmail.com, hotmail.com, msn.com, outlook.com, yahoo.com, yahoo.es, icloud.com o live.com."
                autocomplete="email"
                placeholder="Ejemplo@gmail.com"
                :error="$errors->first('email')"
            />
            <p class="users-form-helper">Ingrese una dirección de correo válida (ej. usuario@gmail.com).</p>

            <flux:input
                wire:model.live="phone_number"
                name="phone_number"
                :label="__('Número telefónico')"
                type="tel"
                required
                minlength="10"
                maxlength="10"
                pattern="^3[0-9]{9}$"
                title="Debe iniciar con 3 y tener exactamente 10 dígitos."
                x-on:input="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10)"
                x-on:keydown="
                    const allowedKeys = ['Backspace','Tab','ArrowLeft','ArrowRight','Delete','Home','End'];
                    if (!/^[0-9]$/.test($event.key) && !allowedKeys.includes($event.key)) { $event.preventDefault(); }
                "
                autocomplete="tel"
                :placeholder="__('Número telefónico, ej: 3014879502')"
                :error="$errors->first('phone_number')"
            />
            <p class="users-form-helper">Solo números, el número debe iniciar en 3 y tener 10 dígitos.</p>

            <div class="flex flex-col gap-1">
                <label class="users-form-label">{{ __('Rol') }}</label>
                <div class="users-select-wrapper">
                    <select
                        wire:model.live="role_id"
                        name="role_id"
                        required
                        @class([
                            'users-select',
                            'users-select-error' => $errors->has('role_id'),
                        ])
                    >
                        <option value="">{{ __('Selecciona un rol') }}</option>
                        @foreach($roles as $role)
                            <option value="{{ $role['id'] }}">{{ $role['name'] }}</option>
                        @endforeach
                    </select>
                </div>
                <p class="users-form-helper">Seleccione un rol.</p>
                @error('role_id')
                    <div class="mt-1 flex items-center gap-2 text-sm text-error">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z" />
                        </svg>
                        <span>{{ $message }}</span>
                    </div>
                @enderror
            </div>

            <flux:input
                wire:model.live="password"
                name="password"
                :label="__('Contraseña')"
                type="password"
                required
                minlength="12"
                pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[^\w\s]).{12,}$"
                title="Mínimo 12 caracteres, incluye mayúsculas, minúsculas, números y símbolos."
                autocomplete="new-password"
                :placeholder="__('Contraseña')"
                viewable
                :error="$errors->first('password')"
            />
            <p class="users-form-helper">Mínimo 12 caracteres, al menos una mayúscula, una minúscula, un número y un signo.</p>

            <flux:input
                wire:model.live="password_confirmation"
                name="password_confirmation"
                :label="__('Confirmar contraseña')"
                type="password"
                required
                minlength="12"
                pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[^\w\s]).{12,}$"
                title="Mínimo 12 caracteres, incluye mayúsculas, minúsculas, números y símbolos."
                autocomplete="new-password"
                :placeholder="__('Confirmar contraseña')"
                viewable
                :error="$errors->first('password_confirmation')"
            />
            <p class="users-form-helper">Repita la contraseña ingresada anteriormente.</p>

            <div class="flex items-center justify-end mt-3">
                <button type="submit" class="users-form-submit w-full">
                    {{ __('Crear usuario') }}
                </button>
            </div>
        </div>
    </form>
</div>
