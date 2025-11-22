<div>

    {{-- ========================= --}}
    {{--  BUSCADOR DENTRO DEL COMPONENTE  --}}
    {{-- ========================= --}}

    <div class="mb-3">
        <label class="form-label">Buscar producto</label>

        {{-- Aquí insertamos tu buscador tal cual --}}
        <livewire:search-products :wire:key="'search-products-'.uniqid()" />

        <button type="button" class="btn btn-success mt-2" disabled>
            Agregar producto (selección desde buscador)
        </button>

        <small class="text-muted d-block mt-1">
            Selecciona un producto del listado para agregarlo.
        </small>
    </div>

    <h5 class="mt-4">Productos agregados</h5>

    @if(empty($items))
        <p class="text-muted">No se han agregado productos.</p>
    @else
        <table class="table table-bordered mt-2">
            <thead>
                <tr>
                    <th>Producto</th>
                    <th width="100">Precio</th>
                    <th width="100">Cant.</th>
                    <th width="120">Total</th>
                    <th width="50"></th>
                </tr>
            </thead>

            <tbody>
                @foreach($items as $productId => $item)
                    <tr>
                        <td>{{ $item['name'] }}</td>

                        <td>${{ number_format($item['price'], 2) }}</td>

                        <td>
                            <input type="number"
                                   min="1"
                                   wire:change="updateQuantity({{ $productId }}, $event.target.value)"
                                   value="{{ $item['quantity'] }}"
                                   class="form-control form-control-sm">
                        </td>

                        <td>
                            ${{ number_format($item['total'], 2) }}
                        </td>

                        <td>
                            <button class="btn btn-danger btn-sm"
                                    wire:click="removeItem({{ $productId }})">
                                X
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>

        </table>
    @endif

    <script>
        window.addEventListener('productSelected', function (event) {
            Livewire.find(@this.__instance.id)
                .call('addItemFromBrowser', event.detail.id);
        });
    </script>

</div>
