<div>
    <form wire:submit="save" class="space-y-4 max-w-2xl p-4 bg-surface-alt dark:bg-surface-dark-alt rounded-lg shadow-md">

        <x-form.input wire:model="total_value" label="Valor total" name="total_value" placeholder="Ingresa el valor total"/>
        <x-form.input wire:model="date" type="date" label="Fecha" name="date" placeholder="Selecciona la fecha"/>
        <x-form.input wire:model="user_id" label="ID del vendedor" name="user_id" placeholder="Ingresa el ID del vendedor"/>
        <x-form.input wire:model="client_id" label="ID del cliente" name="client_id" placeholder="Ingresa el ID del cliente"/>
        <!-- primary Button -->
        <button type="submit" class="whitespace-nowrap rounded-radius bg-primary border border-primary px-4 py-2 text-sm font-medium tracking-wide text-on-primary transition hover:opacity-75 text-center focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary active:opacity-100 active:outline-offset-0 disabled:opacity-75 disabled:cursor-not-allowed dark:bg-primary-dark dark:border-primary-dark dark:text-on-primary-dark dark:focus-visible:outline-primary-dark">
            {{ request()->routeIs('sales.create') ? 'Crear venta' : 'Actualizar venta' }}
        </button>


    </form>
</div>