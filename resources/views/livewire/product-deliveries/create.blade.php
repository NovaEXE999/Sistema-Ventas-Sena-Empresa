<div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
    <div class="flex h-fit w-full justify-between flex-row gap-4 rounded-xl">
        <a href="{{ route('productdeliveries.index')}}" wire:navigate class="flex w-fit justify-center items-center whitespace-nowrap rounded-radius bg-primary border border-primary px-4 py-2 text-center text-sm font-medium tracking-wide text-on-primary transition hover:opacity-75 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary active:opacity-100 active:outline-offset-0 disabled:cursor-not-allowed disabled:opacity-75 dark:border-primary-dark dark:bg-primary-dark dark:text-on-primary-dark dark:focus-visible:outline-primary-dark" role="button">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
            </svg>

            Volver
        </a>
        <h1 class="p-4 text-center">
            Registro de Entrada de inventario
        </h1>
    </div>
    <x-form.error-alert />
    @php($isEdit = property_exists($this, 'delivery') && $this->delivery?->exists)
    <form wire:submit.prevent="save" class="space-y-6 p-4 bg-surface-alt dark:bg-surface-dark-alt rounded-lg shadow-md">
        <div class="grid gap-4 md:grid-cols-2">
            <div>
                <label class="block text-sm font-medium text-on-surface mb-1">Fecha</label>
                <input type="date" wire:model="date" disabled class="w-full rounded-radius border border-outline bg-gray-100 px-3 py-2 text-sm text-on-surface-strong focus:outline-none disabled:cursor-not-allowed">
            </div>
            <div class="space-y-2" x-data @click.outside="$wire.hideProviderResults()">
                <x-form.input wire:model.live.debounce.300ms="providerSearch"
                              wire:blur="ensureProviderSelected"
                              autocomplete="off"
                              label="Proveedor" name="providerSearch" placeholder="Busca proveedor por nombre o identificación..." />
                @if($providerResults)
                    <ul class="border rounded shadow-sm bg-white text-gray-900 max-h-48 overflow-y-auto">
                        @foreach($providerResults as $prov)
                            <li wire:mousedown.prevent="selectProvider({{ $prov['id'] }}, @js($prov['name']))"
                                class="px-3 py-2 hover:bg-gray-100 cursor-pointer">
                                <div class="flex flex-col">
                                    <span class="font-medium">{{ $prov['name'] }}</span>
                                    @if(!empty($prov['identification']))
                                        <span class="text-xs text-gray-600">ID: {{ $prov['identification'] }}</span>
                                    @endif
                                </div>
                            </li>
                        @endforeach
                    </ul>
                @endif
                <x-form.field-error for="provider_id" />
            </div>
        </div>

        <div class="space-y-2 rounded-radius border border-outline p-4">
            <div class="grid gap-3 md:grid-cols-[2fr_140px_auto] items-end">
                <div x-data @click.outside="$wire.hideProductResults()">
                    <x-form.input wire:model.live.debounce.250ms="productSearch"
                                  wire:blur="ensureProductSelected"
                                  autocomplete="off"
                                  label="Producto" name="productSearch" placeholder="Busca producto activo..." />
                    @if($productResults)
                        <ul class="border rounded shadow-sm bg-white text-gray-900 max-h-48 overflow-y-auto">
                            @foreach($productResults as $product)
                                <li wire:mousedown.prevent="selectProduct({{ $product['id'] }}, @js($product['name']))"
                                    class="px-3 py-2 hover:bg-gray-100 cursor-pointer">
                                    {{ $product['name'] }}
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
                <div x-data>
                    <x-form.input wire:model="productQuantity"
                                  type="number"
                                  min="1"
                                  max="1000"
                                  step="1"
                                  inputmode="numeric"
                                  pattern="[0-9]*"
                                  x-on:keydown="
                                      const allowed = ['Backspace','Tab','ArrowLeft','ArrowRight','Delete','Home','End','Enter'];
                                      if (!allowed.includes($event.key) && !/^[0-9]$/.test($event.key)) {
                                          $event.preventDefault();
                                      }
                                  "
                                  x-on:input="
                                      let val = ($el.value || '').replace(/[^0-9]/g, '');
                                      val = val.slice(0, 4);
                                      if (val === '') {
                                          $el.value = '';
                                          return;
                                      }
                                      let num = parseInt(val, 10);
                                      if (Number.isNaN(num) || num < 1) {
                                          $el.value = '';
                                          return;
                                      }
                                      if (num > 1000) {
                                          num = 1000;
                                      }
                                      $el.value = num;
                                  "
                                  x-on:paste.prevent="
                                      let pasted = (event.clipboardData || window.clipboardData).getData('text');
                                      pasted = pasted.replace(/[^0-9]/g, '').slice(0,4);
                                      if (pasted === '') {
                                          return;
                                      }
                                      let num = parseInt(pasted, 10);
                                      if (Number.isNaN(num) || num < 1) {
                                          num = 1;
                                      } else if (num > 1000) {
                                          num = 1000;
                                      }
                                      $el.value = num;
                                      $el.dispatchEvent(new Event('input'));
                                  "
                                  maxlength="4"
                                  label="Cantidad" name="productQuantity" placeholder="1 - 1000" />
                </div>
                <button type="button" wire:click="addProductLine" class="h-10 self-end whitespace-nowrap rounded-radius bg-primary border border-primary px-4 py-2 text-sm font-medium tracking-wide text-on-primary transition hover:opacity-90">
                    Insertar
                </button>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-sm text-on-surface">
                    <thead class="border-b border-outline bg-surface">
                        <tr>
                            <th class="p-2"></th>
                            <th class="p-2 text-left">Nombre producto</th>
                            <th class="p-2 text-left">Cantidad</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($lineItems as $item)
                            <tr wire:key="product-{{ $item['product_id'] }}" class="border-b border-outline/50">
                                <td class="p-2">
                                    <button aria-label="Quitar producto" type="button" wire:click="removeLine({{ $item['product_id'] }})" class="inline-flex justify-center items-center aspect-square whitespace-nowrap rounded-full border border-danger bg-danger p-2 text-sm font-medium tracking-wide text-on-danger transition hover:opacity-75 text-center focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-danger active:opacity-100 active:outline-offset-0 disabled:opacity-75 disabled:cursor-not-allowed dark:border-danger dark:bg-danger dark:text-on-danger dark:focus-visible:outline-danger">
                                        <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="size-5 stroke-on-danger dark:stroke-on-danger" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M6 6l12 12M6 18L18 6" />
                                        </svg>
                                    </button>
                                </td>
                                <td class="p-2">
                                    <span class="text-primary font-semibold">{{ $item['name'] }}</span>
                                </td>
                                <td class="p-2">
                                    <span class="text-sm text-on-surface">{{ $item['quantity'] }}</span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="p-3 text-center text-on-surface-variant">Agrega productos a la entrada.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                <x-form.field-error for="lineItems" />
            </div>
        </div>
        <button type="submit" class="whitespace-nowrap rounded-radius bg-primary border border-primary px-4 py-2 text-sm font-medium tracking-wide text-on-primary transition hover:opacity-75 text-center focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary active:opacity-100 active:outline-offset-0 disabled:opacity-75 disabled:cursor-not-allowed dark:bg-primary-dark dark:border-primary-dark dark:text-on-primary-dark dark:focus-visible:outline-primary-dark">
            {{ $isEdit ? 'Actualizar entrada de inventario' : 'Registrar entrada de inventario' }}
        </button>
    </form>
</div>
