<div class="flex w-full flex-1 flex-col gap-6 rounded-xl">
    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <div class="flex flex-wrap items-center gap-2 text-sm">
            <label for="monthFilter" class="text-on-surface dark:text-on-surface-dark">Mes</label>
            <input
                id="monthFilter"
                type="month"
                wire:model.live="month"
                class="rounded-radius border border-outline bg-surface-alt px-3 py-2 text-sm focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary dark:border-outline-dark dark:bg-surface-dark-alt/50 dark:focus-visible:outline-primary-dark"
            >
        </div>
        <div class="flex gap-2">
            <button wire:click="refreshData" class="px-4 py-2 bg-primary text-on-primary rounded-radius border border-primary text-sm font-medium transition hover:opacity-80 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary dark:bg-primary-dark dark:text-on-primary-dark dark:border-primary-dark dark:focus-visible:outline-primary-dark">
                Refrescar datos
            </button>
        </div>
    </div>

    <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-3">
        @foreach ($summaryCards as $card)
            <article class="group flex rounded-radius flex-col overflow-hidden border border-outline bg-surface-alt text-on-surface dark:border-outline-dark dark:bg-surface-dark-alt dark:text-on-surface-dark">
                <div class="flex flex-col gap-3 p-6">
                    <h3 class="text-balance text-lg text-center font-semibold text-on-surface-strong dark:text-on-surface-dark-strong">
                        {{ $card['title'] }}
                    </h3>
                    <p class="text-center text-3xl font-bold leading-tight">
                        {{ $card['value'] }}
                    </p>
                    @if (!empty($card['helper']))
                        <p class="text-center text-xs text-on-surface/70 dark:text-on-surface-dark/70">
                            {{ $card['helper'] }}
                        </p>
                    @endif
                </div>
            </article>
        @endforeach
    </div>

    <div class="grid gap-4 lg:grid-cols-2">
        <article class="rounded-radius border border-outline bg-surface-alt text-on-surface dark:border-outline-dark dark:bg-surface-dark-alt dark:text-on-surface-dark">
            <header class="border-b border-outline px-4 py-3 text-sm font-semibold dark:border-outline-dark">
                Ventas por tipo de cliente
            </header>
            <div class="p-4">
                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm">
                        <thead class="text-left text-on-surface-strong dark:text-on-surface-dark-strong">
                            <tr>
                                <th class="pb-2">Tipo de cliente</th>
                                <th class="pb-2 text-right">Ventas</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-outline dark:divide-outline-dark">
                            @forelse ($salesByClientType as $row)
                                <tr>
                                    <td class="py-2 pr-2">{{ $row['name'] }}</td>
                                    <td class="py-2 pl-2 text-right">{{ $row['total'] ?? 0 }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="2" class="py-3 text-center text-xs text-on-surface/70 dark:text-on-surface-dark/70">
                                        Sin ventas en este mes.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </article>

        <article class="rounded-radius border border-outline bg-surface-alt text-on-surface dark:border-outline-dark dark:bg-surface-dark-alt dark:text-on-surface-dark">
            <header class="border-b border-outline px-4 py-3 text-sm font-semibold dark:border-outline-dark">
                Productos vendidos por categoria
            </header>
            <div class="p-4">
                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm">
                        <thead class="text-left text-on-surface-strong dark:text-on-surface-dark-strong">
                            <tr>
                                <th class="pb-2">Categoria</th>
                                <th class="pb-2 text-right">Cantidad</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-outline dark:divide-outline-dark">
                            @forelse ($salesByCategory as $row)
                                <tr>
                                    <td class="py-2 pr-2">{{ $row['name'] }}</td>
                                    <td class="py-2 pl-2 text-right">{{ $row['total'] ?? 0 }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="2" class="py-3 text-center text-xs text-on-surface/70 dark:text-on-surface-dark/70">
                                        Sin ventas en este mes.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </article>
    </div>

    <article class="rounded-radius border border-outline bg-surface-alt text-on-surface dark:border-outline-dark dark:bg-surface-dark-alt dark:text-on-surface-dark">
        <header class="border-b border-outline px-4 py-3 text-sm font-semibold dark:border-outline-dark">
            Cantidad de producto entregada por proveedor
        </header>
        <div class="p-4">
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead class="text-left text-on-surface-strong dark:text-on-surface-dark-strong">
                        <tr>
                            <th class="pb-2">Proveedor</th>
                            <th class="pb-2 text-right">Cantidad entregada</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-outline dark:divide-outline-dark">
                        @forelse ($deliveriesByProvider as $row)
                            <tr>
                                <td class="py-2 pr-2">{{ $row['name'] }}</td>
                                <td class="py-2 pl-2 text-right">{{ $row['total'] ?? 0 }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="2" class="py-3 text-center text-xs text-on-surface/70 dark:text-on-surface-dark/70">
                                    Sin entregas en este mes.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </article>
</div>
