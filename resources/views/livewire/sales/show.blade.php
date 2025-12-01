<div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
    <div class="flex h-fit w-full justify-between flex-row gap-4 rounded-xl">
        <a href="{{ route('sales.index')}}" wire:navigate class="flex w-fit justify-center items-center whitespace-nowrap rounded-radius bg-primary border border-primary px-4 py-2 text-center text-sm font-medium tracking-wide text-on-primary transition hover:opacity-75 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary active:opacity-100 active:outline-offset-0 disabled:cursor-not-allowed disabled:opacity-75 dark:border-primary-dark dark:bg-primary-dark dark:text-on-primary-dark dark:focus-visible:outline-primary-dark" role="button">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
            </svg>

            Volver
        </a>
        <h1 class="p-4 text-center">
            Venta #{{$sale->id}} 
        </h1>
    </div>
    <br>
    <p>
        Fecha: {{$sale->date}}
    </p>
    <br>
    <div class="overflow-hidden w-full overflow-x-auto rounded-radius border border-outline dark:border-outline-dark">
        <table class="w-full text-left text-sm text-on-surface dark:text-on-surface-dark">
            <thead class="border-b border-outline bg-surface-alt text-sm text-on-surface-strong dark:border-outline-dark dark:bg-surface-dark-alt dark:text-on-surface-dark-strong">
                <tr>
                    <th scope="col" class="p-4">Producto</th>
                    <th scope="col" class="p-4">Cantidad</th>
                    <th scope="col" class="p-4">Precio</th>
                    <th scope="col" class="p-4">SubTotal</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-outline dark:divide-outline-dark">
                @forelse ($details as $detail)
                    <tr>
                        <td class="p-4">{{ $detail->product->name }}</td>
                        <td class="p-4">{{ $detail->quantity }}</td>
                        <td class="p-4">{{ $detail->product->price }}</td>
                        {{-- Debido a que productos viene con categoria y nombre, podemos llamar las variables de esas tablas
                        por cualquier campo dentro de estas y mostrarla en la vista. --}}
                        <td class="p-4">{{ $detail->total }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5">Error al encontrar productos.</td>
                    </tr>
                @endforelse
                  
            </tbody>
        </table>
    </div>

    <p>
        Valor total: {{$sale->total_value}}
    </p>
    <br>
    <p>
        Cliente: {{$sale->client->name}}
    </p>
    <p>
        Vendedor: {{$sale->user->name}}
    </p>
</div>