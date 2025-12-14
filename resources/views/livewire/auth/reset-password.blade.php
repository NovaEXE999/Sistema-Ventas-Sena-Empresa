<x-layouts.auth>
    <div class="flex flex-col gap-6">
        <x-auth-header :title="__('Reset password')" :description="__('Please enter your new password below')" />

        
        <x-auth-session-status class="text-center" :status="session('status')" />

        <x-form.error-alert />

        <form method="POST" action="{{ route('password.update') }}" class="flex flex-col gap-6">
            @csrf
            
            <input type="hidden" name="token" value="{{ request()->route('token') }}">

            
            <flux:input
                name="email"
                value="{{ request('email') }}"
                :label="__('Email')"
                type="email"
                required
                autocomplete="email"
                :error="$errors->first('email')"
            />

            
            <flux:input
                name="password"
                :label="__('Contraseña')"
                type="password"
                required
                autocomplete="new-password"
                :placeholder="__('Contraseña')"
                viewable
                :error="$errors->first('password')"
            />

            
            <flux:input
                name="password_confirmation"
                :label="__('Confirmar contraseña')"
                type="password"
                required
                autocomplete="new-password"
                :placeholder="__('Confirmar contraseña')"
                viewable
                :error="$errors->first('password_confirmation')"
            />

            <div class="flex items-center justify-end">
                <flux:button type="submit" variant="primary" class="w-full" data-test="reset-password-button">
                    {{ __('Reestablecer contraseña') }}
                </flux:button>
            </div>
        </form>
    </div>
</x-layouts.auth>
