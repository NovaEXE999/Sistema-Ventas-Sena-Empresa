<div class="flex flex-col gap-6">
    <div class="flex items-center justify-between">
        <a href="{{ route('users.index') }}" wire:navigate class="whitespace-nowrap rounded-radius bg-surface-alt border border-outline px-4 py-2 text-sm font-medium text-on-surface transition hover:opacity-80 dark:bg-surface-dark-alt dark:text-on-surface-dark">
            ← Volver
        </a>
        <h2 class="text-lg font-semibold">Editar rol de usuario</h2>
    </div>

    <x-form.error-alert />

    <form wire:submit.prevent="save" class="flex flex-col gap-5" novalidate>
        <flux:input
            wire:model.live="identification"
            name="identification"
            :label="__('Identificación')"
            type="text"
            disabled
            autocomplete="off"
            :error="$errors->first('identification')"
        />

        <flux:input
            wire:model.live="name"
            name="name"
            :label="__('Nombre')"
            type="text"
            disabled
            autocomplete="off"
            :error="$errors->first('name')"
        />

        <flux:input
            wire:model.live="email"
            name="email"
            :label="__('Dirección de correo electrónico')"
            type="email"
            disabled
            autocomplete="off"
            :error="$errors->first('email')"
        />

        <flux:input
            wire:model.live="phone_number"
            name="phone_number"
            :label="__('Número telefónico')"
            type="tel"
            disabled
            autocomplete="off"
            :error="$errors->first('phone_number')"
        />

        <div class="flex flex-col gap-1">
            <label class="text-sm font-medium text-zinc-700 dark:text-zinc-200">{{ __('Rol') }}</label>
            <select
                wire:model.live="role_id"
                name="role_id"
                required
                @class([
                    'w-full rounded-md px-3 py-2 text-sm shadow-sm focus:outline-none focus:ring-2',
                    'border border-zinc-300 text-zinc-900 focus:border-emerald-500 focus:ring-emerald-200 dark:border-zinc-700 dark:bg-zinc-900 dark:text-zinc-100' => !$errors->has('role_id'),
                    'border border-danger text-danger focus:border-danger focus:ring-danger/40 dark:border-danger dark:text-danger' => $errors->has('role_id'),
                ])
            >
                <option value="">{{ __('Select a role') }}</option>
                @foreach($roles as $role)
                    <option value="{{ $role['id'] }}">{{ $role['name'] }}</option>
                @endforeach
            </select>
            @error('role_id')
                <div class="mt-1 flex items-center gap-2 text-sm text-danger">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z" />
                    </svg>
                    <span>{{ $message }}</span>
                </div>
            @enderror
        </div>

        <div class="flex items-center justify-end">
            <flux:button type="submit" variant="primary" class="w-full">
                {{ __('Actualizar rol') }}
            </flux:button>
        </div>
    </form>
</div>
