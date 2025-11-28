<div>
    <form wire:submit="save" class="space-y-4 max-w-2xl p-4 bg-surface-alt dark:bg-surface-dark-alt rounded-lg shadow-md">

        <x-form.input wire:model="date" type="date" label="Fecha" name="date" placeholder="Selecciona la fecha"/>
        <x-form.input wire:model="delivered_amount" label="Cantidad entregada" name="delivered_amount" placeholder="Ingresa la cantidad entregada"/>
        <x-form.input wire:model="product_id" label="ID del producto" name="product_id" placeholder="Ingresa el ID del producto"/>
        <x-form.input wire:model="provider_id" label="ID del proveedor" name="provider_id" placeholder="Ingresa el ID del proveedor"/>
        <!-- primary Button -->
        <button type="submit" class="whitespace-nowrap rounded-radius bg-primary border border-primary px-4 py-2 text-sm font-medium tracking-wide text-on-primary transition hover:opacity-75 text-center focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary active:opacity-100 active:outline-offset-0 disabled:opacity-75 disabled:cursor-not-allowed dark:bg-primary-dark dark:border-primary-dark dark:text-on-primary-dark dark:focus-visible:outline-primary-dark">
            {{ request()->routeIs('productdeliveries.create') ? 'Crear entrada de inventario' : 'Actualizar entrada de inventario' }}
        </button>


    </form>
</div>