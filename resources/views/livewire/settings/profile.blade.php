<?php

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;
use Livewire\Volt\Component;

new class extends Component {
    public string $name = '';
    public string $email = '';
    public $phone_number = '';

    /**
     * Mount the component.
     */
    public function mount(): void
    {
        $this->name = Auth::user()->name;
        $this->email = Auth::user()->email;
        $this->phone_number = Auth::user()->phone_number;
    }

    /**
     * Update the profile information for the currently authenticated user.
     */
    public function updateProfileInformation(): void
    {
        $user = Auth::user();

        $validated = $this->validate([
            'name' => [
                'required',
                'string',
                'max:256',
                'regex:/^[A-Za-zÇ?-Ç¨ ]{1,256}$/',
            ],

            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:254',
                'regex:/^[A-Za-z0-9._%+-]+@(gmail\\.com|hotmail\\.com|msn\\.com|outlook\\.com|yahoo\\.com|yahoo\\.es|icloud\\.com|live\\.com)$/i',
                Rule::unique(User::class)->ignore($user->id)
            ],
            'phone_number' => [
                'required', 
                'digits:10', 
                'regex:/^3\\d{9}$/',
                Rule::unique(User::class)->ignore($user->id)
            ]
        ]);

        $user->fill($validated);

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        $this->dispatch('profile-updated', name: $user->name);
    }

    /**
     * Send an email verification notification to the current user.
     */
    public function resendVerificationNotification(): void
    {
        $user = Auth::user();

        if ($user->hasVerifiedEmail()) {
            $this->redirectIntended(default: route('dashboard', absolute: false));

            return;
        }

        $user->sendEmailVerificationNotification();

        Session::flash('status', 'verification-link-sent');
    }
}; ?>

<section class="w-full">
    @include('partials.settings-heading')

    <x-settings.layout :heading="__('Perfil')" :subheading="__('Actualiza tu nombre y correo electrónico')">
        <x-form.error-alert />
        <form wire:submit="updateProfileInformation" class="my-6 w-full space-y-6">
            <flux:input
                wire:model="name"
                :label="__('Nombre')"
                type="text"
                required
                maxlength="256"
                pattern="^[A-Za-zÇ?-Ç¨ ]{1,256}$"
                title="Solo letras y espacios. Maximo 256 caracteres."
                x-on:input="this.value = this.value.replace(/[^A-Za-zÇ?-Ç¨ ]/g, '').slice(0, 256)"
                x-on:keydown="
                    const allowedKeys = ['Backspace','Tab','ArrowLeft','ArrowRight','Delete','Home','End'];
                    if (!/^[A-Za-zÇ?-Ç¨ ]$/.test($event.key) && !allowedKeys.includes($event.key)) { $event.preventDefault(); }
                "
                autofocus
                autocomplete="name"
                :error="$errors->first('name')"
            />

            <div>
                <flux:input
                    wire:model="email"
                    :label="__('Email')"
                    type="email"
                    required
                    maxlength="254"
                    pattern="^[A-Za-z0-9._%+-]+@(gmail\\.com|hotmail\\.com|msn\\.com|outlook\\.com|yahoo\\.com|yahoo\\.es|icloud\\.com|live\\.com)$"
                    title="Usa un correo de: gmail.com, hotmail.com, msn.com, outlook.com, yahoo.com, yahoo.es, icloud.com o live.com."
                    autocomplete="email"
                    :error="$errors->first('email')"
                />

                @if (auth()->user() instanceof \Illuminate\Contracts\Auth\MustVerifyEmail &&! auth()->user()->hasVerifiedEmail())
                    <div>
                        <flux:text class="mt-4">
                            {{ __('Tu correo electrónico está sin verificar.') }}

                            <flux:link class="text-sm cursor-pointer" wire:click.prevent="resendVerificationNotification">
                                {{ __('Da click aquí para re-enviar el email de verificación.') }}
                            </flux:link>
                        </flux:text>

                        @if (session('status') === 'verification-link-sent')
                            <flux:text class="mt-2 font-medium !dark:text-green-400 !text-green-600">
                                {{ __('Un nuevo link de verificación ha sido enviado a tu correo electrónico.') }}
                            </flux:text>
                        @endif
                    </div>
                @endif
            </div>
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
                :placeholder="__('Número telefónico')"
                :error="$errors->first('phone_number')"
            />
            <div class="flex items-center gap-4">
                <div class="flex items-center justify-end">
                    <flux:button variant="primary" type="submit" class="w-full" data-test="update-profile-button">
                        {{ __('Guardar') }}
                    </flux:button>
                </div>

                <x-action-message class="me-3" on="profile-updated">
                    {{ __('Guardado.') }}
                </x-action-message>
            </div>
        </form>

        {{-- <livewire:settings.delete-user-form /> --}}
    </x-settings.layout>
</section>
