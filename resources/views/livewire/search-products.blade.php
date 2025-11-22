<div>
    <input class="form-control" type="text" placeholder="Buscar..." wire:model.debounce.200ms="searchTerm" wire:keydown='search'>

    <div wire:loading class="mt-2">Buscando...</div>

    <div>
        @if (!empty($products))
            <ul class="list-group mt-2">
                @foreach ($products as $product)
                    <li class="list-group-item list-group-item-action" 
                    style="cursor: pointer;"
                    wire:click="selectProduct({{ $product->id }})">
                        {{ $product->name }}
                    </li>
                    @if ($product)
                        <input type="hidden" name="product_id" value="{{$product->id}}">
                    @endif
                @endforeach
            </ul>

        @else
            <p>No hay resultados</p>
        @endif
    </div>
</div>