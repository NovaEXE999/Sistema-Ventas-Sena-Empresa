<div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
    @php($isAdmin = auth()->user()?->isAdmin())
    @php($isEdit = property_exists($this, 'client') && $this->client?->exists)

    <div class="flex h-fit w-full justify-between flex-row gap-4 rounded-xl">
        <a href="{{ route('clients.index')}}" wire:navigate class="flex w-fit justify-center items-center whitespace-nowrap rounded-radius bg-primary border border-primary px-4 py-2 text-center text-sm font-medium tracking-wide text-on-primary transition hover:opacity-75 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary active:opacity-100 active:outline-offset-0 disabled:cursor-not-allowed disabled:opacity-75 dark:border-primary-dark dark:bg-primary-dark dark:text-on-primary-dark dark:focus-visible:outline-primary-dark" role="button">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
            </svg>
            Volver
        </a>
        <h1 class="p-4 text-center">
            Registro de clientes
        </h1>
    </div>
    <x-form.error-alert />
    <form wire:submit="save" class="space-y-4 max-w-2xl p-4 bg-surface-alt dark:bg-surface-dark-alt rounded-lg shadow-md">

        <div class="flex flex-col gap-1 text-sm">
            <label class="text-on-surface dark:text-on-surface-dark">Identificacion</label>
            <input
                wire:model="identification"
                type="text"
                name="identification"
                placeholder="Documento del cliente"
                pattern="\d{3,10}"
                minlength="3"
                maxlength="10"
                inputmode="numeric"
                title="Solo números, 3 a 10 dígitos"
                class="w-full rounded-radius border border-outline px-3 py-2 text-sm text-on-surface focus:outline-none dark:border-outline-dark dark:bg-surface-dark-alt/50"
                @if (request()->routeIs('clients.update')) disabled @endif
            />
            <x-form.field-error for="identification" />
        </div>

        <x-form.input
            wire:model.live.debounce.250ms="name"
            label="Nombre"
            name="name"
            placeholder="Ingresa tu nombre"
            pattern="[A-Za-zÀ-ÿ\s]+"
            title="Solo letras y espacios"
            autocomplete="off"
        />
        <x-form.input
            wire:model="phone_number"
            label="Telefono"
            name="phone_number"
            placeholder="Telefono del cliente"
            pattern="3\d{9}"
            maxlength="10"
            inputmode="numeric"
            title="Debe iniciar en 3 y tener 10 dígitos"
        />

        <div>
            <label class="block text-sm font-medium text-on-surface mb-1">Tipo de cliente</label>
            <select
                wire:model="client_type_id"
                class="w-full rounded-radius border border-outline px-3 py-2 text-sm text-on-surface focus:outline-none"
                @if (request()->routeIs('clients.update') && ! $isAdmin) disabled @endif
            >
                <option value="">Seleccione...</option>
                @foreach($clientTypes as $type)
                    <option value="{{ $type['id'] }}">{{ $type['name'] }}</option>
                @endforeach
            </select>
            <x-form.field-error for="client_type_id" />
        </div>

        <button type="submit" class="whitespace-nowrap rounded-radius bg-primary border border-primary px-4 py-2 text-sm font-medium tracking-wide text-on-primary transition hover:opacity-75 text-center focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary active:opacity-100 active:outline-offset-0 disabled:opacity-75 disabled:cursor-not-allowed dark:bg-primary-dark dark:border-primary-dark dark:text-on-primary-dark dark:focus-visible:outline-primary-dark">
            {{ $isEdit ? 'Actualizar cliente' : 'Crear cliente' }}
        </button>
    </form>
</div>
