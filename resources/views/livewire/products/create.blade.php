<div>
    <form wire:submit="save" class="space-y-4 max-w-2xl p-4 bg-surface-alt dark:bg-surface-dark-alt rounded-lg shadow-md">

        <x-form.input wire:model="name" label="Nombre" name="name" placeholder="Ingresa el nombre del producto"/>
        <x-form.input wire:model="quantity" label="Cantidad" name="quantity" placeholder="Ingresa la cantidad"/>
        <x-form.input wire:model="price" label="Precio" name="price" placeholder="Ingresa el precio"/>
        <x-form.input wire:model="category_id" label="ID de categoria" name="category_id" placeholder="Ingresa el ID de la categoria"/>
        <x-form.input wire:model="measure_id" label="ID de unidad de medida" name="measure_id" placeholder="Ingresa el ID de la unidad de medida"/>
        <!-- primary Button -->
        <button type="submit" class="whitespace-nowrap rounded-radius bg-primary border border-primary px-4 py-2 text-sm font-medium tracking-wide text-on-primary transition hover:opacity-75 text-center focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary active:opacity-100 active:outline-offset-0 disabled:opacity-75 disabled:cursor-not-allowed dark:bg-primary-dark dark:border-primary-dark dark:text-on-primary-dark dark:focus-visible:outline-primary-dark">
            {{ request()->routeIs('products.create') ? 'Crear producto' : 'Actualizar producto' }}
        </button>


    </form>
</div>
