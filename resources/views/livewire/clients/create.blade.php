<div>
    <form wire:submit="save" class="space-y-4 max-w-2xl p-4 bg-surface-alt dark:bg-surface-dark-alt rounded-lg shadow-md">

        <x-form.input wire:model="first_name" label="Primer nombre" name="first_name" placeholder="Ingresa tu primer nombre"/>
        <x-form.input wire:model="middle_name" label="Segundo nombre" name="middle_name" placeholder="Ingresa tu segundo nombre"/>
        <x-form.input wire:model="last_name" label="Primer apellido" name="last_name" placeholder="Ingresa tu primer apellido"/>
        <x-form.input wire:model="second_last_name" label="Segundo apellido" name="second_last_name" placeholder="Ingresa tu segundo apellido"/>
        <!-- primary Button -->
        <button type="submit" class="whitespace-nowrap rounded-radius bg-primary border border-primary px-4 py-2 text-sm font-medium tracking-wide text-on-primary transition hover:opacity-75 text-center focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary active:opacity-100 active:outline-offset-0 disabled:opacity-75 disabled:cursor-not-allowed dark:bg-primary-dark dark:border-primary-dark dark:text-on-primary-dark dark:focus-visible:outline-primary-dark">
            {{ request()->routeIs('clients.create') ? 'Crear cliente' : 'Actualizar cliente' }}
        </button>


    </form>
</div>