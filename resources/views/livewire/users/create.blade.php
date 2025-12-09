<div class="flex flex-col gap-6">
    <div class="flex items-center justify-between">
        <a href="{{ route('users.index') }}" wire:navigate class="whitespace-nowrap rounded-radius bg-surface-alt border border-outline px-4 py-2 text-sm font-medium text-on-surface transition hover:opacity-80 dark:bg-surface-dark-alt dark:text-on-surface-dark">
            ← Volver
        </a>
        <h2 class="text-lg font-semibold">Registrar usuario</h2>
    </div>

    <x-form.error-alert />

    <form wire:submit.prevent="save" class="flex flex-col gap-5">
        <flux:input
            wire:model.defer="identification"
            name="identification"
            :label="__('Identification')"
            type="text"
            required
            minlength="3"
            maxlength="10"
            pattern="^[0-9]{3,10}$"
            title="Solo números, entre 3 y 10 dígitos, sin signos."
            autocomplete="off"
            :placeholder="__('Identification number')"
            :error="$errors->first('identification')"
        />

        <flux:input
            wire:model.defer="name"
            name="name"
            :label="__('Name')"
            type="text"
            required
            autocomplete="name"
            :placeholder="__('Full name')"
            :error="$errors->first('name')"
        />

        <flux:input
            wire:model.defer="email"
            name="email"
            :label="__('Email address')"
            type="email"
            required
            autocomplete="email"
            placeholder="email@example.com"
            :error="$errors->first('email')"
        />

        <flux:input
            wire:model.defer="phone_number"
            name="phone_number"
            :label="__('Phone number')"
            type="tel"
            required
            autocomplete="tel"
            :placeholder="__('Phone number')"
            :error="$errors->first('phone_number')"
        />

        <div class="flex flex-col gap-1">
            <label class="text-sm font-medium text-zinc-700 dark:text-zinc-200">{{ __('Role') }}</label>
            <select
                wire:model.defer="role_id"
                name="role_id"
                required
                class="w-full rounded-md border border-zinc-300 px-3 py-2 text-sm text-zinc-900 shadow-sm focus:border-emerald-500 focus:outline-none focus:ring-2 focus:ring-emerald-200 dark:border-zinc-700 dark:bg-zinc-900 dark:text-zinc-100"
            >
                <option value="">{{ __('Select a role') }}</option>
                @foreach($roles as $role)
                    <option value="{{ $role['id'] }}">{{ $role['name'] }}</option>
                @endforeach
            </select>
            @error('role_id')
                <span class="text-sm text-red-600">{{ $message }}</span>
            @enderror
        </div>

        <flux:input
            wire:model.defer="password"
            name="password"
            :label="__('Password')"
            type="password"
            required
            autocomplete="new-password"
            :placeholder="__('Password')"
            viewable
            :error="$errors->first('password')"
        />

        <flux:input
            wire:model.defer="password_confirmation"
            name="password_confirmation"
            :label="__('Confirm password')"
            type="password"
            required
            autocomplete="new-password"
            :placeholder="__('Confirm password')"
            viewable
            :error="$errors->first('password_confirmation')"
        />

        <div class="flex items-center justify-end">
            <flux:button type="submit" variant="primary" class="w-full">
                {{ __('Create account') }}
            </flux:button>
        </div>
    </form>
</div>
