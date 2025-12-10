<div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
    @if (session('success'))
        <div x-data="{ alertIsVisible: true }" x-show="alertIsVisible" class="relative w-full overflow-hidden rounded-radius border border-success bg-surface text-on-surface dark:bg-surface-dark dark:text-on-surface-dark" role="alert" x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-90">
            <div class="flex w-full items-center gap-2 bg-success/10 p-4">
                <div class="bg-success/15 text-success rounded-full p-1" aria-hidden="true">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-6" aria-hidden="true">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16Zm3.857-9.809a.75.75 0 0 0-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 1 0-1.06 1.061l2.5 2.5a.75.75 0 0 0 1.137-.089l4-5.5Z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-2">
                    <h3 class="text-sm font-semibold text-success">Mensajes de inventario</h3>
                    <p class="text-xs font-medium sm:text-sm">{{ session('success') }}</p>
                </div>
                <button type="button" @click="alertIsVisible = false" class="ml-auto" aria-label="dismiss alert">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" aria-hidden="true" stroke="currentColor" fill="none" stroke-width="2.5" class="w-4 h-4 shrink-0">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>
    @endif

    @php($isAdmin = auth()->user()?->isAdmin())
    @php($canCreate = auth()->user()?->hasRole('Administrador', 'Vendedor'))

    <div class="flex h-fit w-full justify-between flex-row gap-4 rounded-xl">
        @if ($canCreate)
            <a href="{{route('productdeliveries.create')}}" wire:navigate class="w-fit whitespace-nowrap rounded-radius bg-primary border border-primary px-4 py-2 text-center text-sm font-medium tracking-wide text-on-primary transition hover:opacity-75 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary active:opacity-100 active:outline-offset-0 disabled:cursor-not-allowed disabled:opacity-75 dark:border-primary-dark dark:bg-primary-dark dark:text-on-primary-dark dark:focus-visible:outline-primary-dark" role="button">
                Registrar una entrada de inventario
            </a>
        @endif
        <div class="relative flex w-full max-w-xs flex-col gap-1 text-on-surface dark:text-on-surface-dark">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true" class="absolute left-2.5 top-1/2 size-5 -translate-y-1/2 text-on-surface/50 dark:text-on-surface-dark/50">
                <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
            </svg>
            <input
                type="search" wire:model.live.debounce.300ms="search" class="w-full rounded-radius border border-outline bg-surface-alt py-2 pl-10 pr-2 text-sm focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary disabled:cursor-not-allowed disabled:opacity-75 dark:border-outline-dark dark:bg-surface-dark-alt/50 dark:focus-visible:outline-primary-dark" name="search" placeholder="Buscar proveedor o producto..." aria-label="search"/>
        </div>
    </div>

    <div class="grid gap-3 md:grid-cols-3 lg:grid-cols-4">
        <div class="flex flex-col gap-1 text-sm">
            <label class="text-on-surface dark:text-on-surface-dark">Orden</label>
            <select wire:model.live="order" class="rounded-radius border border-outline bg-surface-alt px-3 py-2 text-sm dark:border-outline-dark dark:bg-surface-dark-alt/50">
                <option value="date_desc">Fecha: nuevo a antiguo</option>
                <option value="date_asc">Fecha: antiguo a nuevo</option>
            </select>
        </div>
        <div class="flex flex-col gap-1 text-sm">
            <label class="text-on-surface dark:text-on-surface-dark">Tipo de filtro</label>
            <select wire:model.live="filterDateType" class="rounded-radius border border-outline bg-surface-alt px-3 py-2 text-sm dark:border-outline-dark dark:bg-surface-dark-alt/50">
                <option value="date">Fecha específica</option>
                <option value="month">Mes</option>
                <option value="year">Año</option>
            </select>
        </div>
        <div class="flex flex-col gap-1 text-sm" x-data="{ filterType: @entangle('filterDateType') }">
            <label class="text-on-surface dark:text-on-surface-dark">Valor</label>
            <input
                x-bind:type="filterType === 'date' ? 'date' : (filterType === 'month' ? 'month' : 'number')"
                x-bind:placeholder="filterType === 'year' ? 'YYYY' : ''"
                x-bind:min="filterType === 'year' ? '1900' : null"
                x-bind:max="filterType === 'year' ? '2100' : null"
                x-bind:step="filterType === 'year' ? '1' : null"
                wire:model.live="filterDate"
                class="rounded-radius border border-outline bg-surface-alt px-3 py-2 text-sm dark:border-outline-dark dark:bg-surface-dark-alt/50"
            >
            <p class="text-xs text-on-surface/70 dark:text-on-surface-dark/70">
                Usa fecha exacta, un mes (YYYY-MM) o solo año.
            </p>
        </div>
    </div>

    <div class="overflow-hidden w-full overflow-x-auto rounded-radius border border-outline dark:border-outline-dark">
        <h2 class="text-center p-4">Entradas de inventario</h2>
        <table class="w-full text-left text-sm text-on-surface dark:text-on-surface-dark">
            <thead class="border-b border-outline bg-surface-alt text-sm text-on-surface-strong dark:border-outline-dark dark:bg-surface-dark-alt dark:text-on-surface-dark-strong">
                <tr>
                    <th scope="col" class="p-4">Identificacion del proveedor</th>
                    <th scope="col" class="p-4">Proveedor</th>
                    <th scope="col" class="p-4">Producto Entregado</th>
                    <th scope="col" class="p-4">Cantidad Entregada</th>
                    <th scope="col" class="p-4">Fecha</th>
                    <th scope="col" class="p-4 text-center">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-outline dark:divide-outline-dark">
                @forelse ($deliveries as $delivery)
                    <tr>
                        <td class="p-4">{{ $delivery->provider->identification }}</td>
                        <td class="p-4">{{ $delivery->provider->name }}</td>
                        <td class="p-4">{{ $delivery->product->name }} </td>
                        <td class="p-4">{{ $delivery->delivered_amount }} {{ $delivery->product->category->measure->name }}</td>
                        <td class="p-4">{{ $delivery->date }}</td>
                        <td class="p-4 flex justify-center items-center gap-2">
                            {{-- Edición deshabilitada --}}
                            <a href="{{ route('productdeliveries.reports.pdf', $delivery) }}" target="_blank">
                                <button type="button" class="whitespace-nowrap rounded-radius bg-info border border-info px-4 py-2 text-sm font-medium tracking-wide text-onInfo transition hover:opacity-75 text-center focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-info active:opacity-100 active:outline-offset-0 disabled:opacity-75 disabled:cursor-not-allowed dark:bg-info dark:border-info dark:text-onInfo dark:focus-visible:outline-info">
                                    PDF
                                </button>
                            </a>
                            <a href="{{ route('productdeliveries.reports.download', $delivery) }}">
                                <button type="button" class="whitespace-nowrap rounded-radius bg-success border border-success px-4 py-2 text-sm font-medium tracking-wide text-onSuccess transition hover:opacity-75 text-center focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-success active:opacity-100 active:outline-offset-0 disabled:opacity-75 disabled:cursor-not-allowed dark:bg-success dark:border-success dark:text-onSuccess dark:focus-visible:outline-success">
                                    Descargar
                                </button>
                            </a>
                            @if ($isAdmin)
                                <button
                                    wire:click='delete({{ $delivery->id }})'
                                    wire:confirm="Estas seguro de borrar la entrada de inventario del producto {{ $delivery->product->name }} en la fecha {{ $delivery->date }}?"
                                    type="button"
                                    class="inline-flex justify-center items-center gap-2 whitespace-nowrap rounded-radius bg-danger border border-danger dark:border-danger px-4 py-2 text-xs font-medium tracking-wide text-on-danger transition hover:opacity-75 text-center focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-danger active:opacity-100 active:outline-offset-0 disabled:opacity-75 disabled:cursor-not-allowed dark:bg-danger dark:text-on-danger dark:focus-visible:outline-danger"
                                >
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                                    </svg>
                                    Borrar
                                </button>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6">No hay entradas de inventario registradas.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div class="p-4">
            {{ $deliveries->links() }}
        </div>
    </div>

</div>
