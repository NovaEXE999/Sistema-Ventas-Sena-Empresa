<div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
    <div class="flex h-fit w-full justify-between flex-row gap-4 rounded-xl">
        <a href="{{ route('products.index')}}" wire:navigate class="flex w-fit justify-center items-center whitespace-nowrap rounded-radius bg-primary border border-primary px-4 py-2 text-center text-sm font-medium tracking-wide text-on-primary transition hover:opacity-75 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary active:opacity-100 active:outline-offset-0 disabled:cursor-not-allowed disabled:opacity-75 dark:border-primary-dark dark:bg-primary-dark dark:text-on-primary-dark dark:focus-visible:outline-primary-dark" role="button">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
            </svg>

            Volver
        </a>
        <h1 class="p-4 text-center">
            Registro de productos
        </h1>
    </div>

    <x-form.error-alert />
    <form wire:submit="save" class="space-y-4 max-w-2xl p-4 bg-surface-alt dark:bg-surface-dark-alt rounded-lg shadow-md">
        <x-form.input
            wire:model.live.debounce.300ms="name"
            label="Nombre"
            name="name"
            placeholder="Ingresa el nombre del producto"
            pattern="[A-Za-zÀ-ÿ\s]+"
            title="Solo letras y espacios"
            maxlength="256"
            required
            autocomplete="off"
            x-data
            x-on:keydown="
                const allowed = ['Backspace','Tab','ArrowLeft','ArrowRight','Delete','Home','End','Enter','Escape'];
                if (allowed.includes($event.key)) { return; }
                if (($el.value || '').length >= 256) { $event.preventDefault(); return; }
                if (!/^[A-Za-zÀ-ÿ\s]$/.test($event.key)) { $event.preventDefault(); }
            "
            x-on:input="
                let clean = ($el.value || '').replace(/[^A-Za-zÀ-ÿ\s]/g, '');
                clean = clean.slice(0, 256);
                $el.value = clean;
            "
            x-on:change="
                let clean = ($el.value || '').replace(/[^A-Za-zÀ-ÿ\s]/g, '');
                clean = clean.slice(0, 256);
                $el.value = clean;
            "
            x-on:paste.prevent="
                let pasted = (event.clipboardData || window.clipboardData).getData('text') || '';
                pasted = pasted.replace(/[^A-Za-zÀ-ÿ\s]/g, '').slice(0, 256);
                if (pasted !== '') {
                    $el.value = pasted;
                    $el.dispatchEvent(new Event('input'));
                }
            "
        />

        <x-form.input
            wire:model.lazy="stock"
            type="number"
            min="1"
            max="1000"
            step="1"
            inputmode="numeric"
            pattern="\\d{1,4}"
            label="Stock"
            name="stock"
            placeholder="Ingresa el stock"
            required
            x-data
            x-on:keydown="
                const allowed = ['Backspace','Tab','ArrowLeft','ArrowRight','Delete','Home','End','Enter','Escape'];
                if (allowed.includes($event.key)) { return; }
                if (!/^[0-9]$/.test($event.key)) { $event.preventDefault(); return; }
                const selectionStart = $el.selectionStart ?? 0;
                const selectionEnd = $el.selectionEnd ?? 0;
                const current = $el.value || '';
                const nextValue = current.slice(0, selectionStart) + $event.key + current.slice(selectionEnd);
                const numeric = parseInt(nextValue, 10);
                if (nextValue.length > 4 || Number.isNaN(numeric) || numeric > 1000) {
                    $event.preventDefault();
                }
            "
            x-on:input="
                let val = ($el.value || '').replace(/[^0-9]/g, '').slice(0, 4);
                if (val === '') { $el.value = ''; return; }
                let num = parseInt(val, 10);
                if (Number.isNaN(num) || num < 1) { num = 1; }
                if (num > 1000) { num = 1000; }
                $el.value = num;
            "
            x-on:change="
                let val = ($el.value || '').replace(/[^0-9]/g, '').slice(0, 4);
                if (val === '') { $el.value = ''; return; }
                let num = parseInt(val, 10);
                if (Number.isNaN(num) || num < 1) { num = 1; }
                if (num > 1000) { num = 1000; }
                $el.value = num;
            "
            x-on:paste.prevent="
                let pasted = (event.clipboardData || window.clipboardData).getData('text') || '';
                pasted = pasted.replace(/[^0-9]/g, '').slice(0, 4);
                if (pasted === '') { return; }
                let num = parseInt(pasted, 10);
                if (Number.isNaN(num) || num < 1) { num = 1; }
                if (num > 1000) { num = 1000; }
                $el.value = num;
                $el.dispatchEvent(new Event('input'));
            "
            maxlength="4"
        />

        <x-form.input
            wire:model.lazy="price"
            type="number"
            min="0"
            max="500000"
            step="0.01"
            inputmode="decimal"
            pattern="\\d{1,6}(\\.\\d{1,2})?"
            label="Precio"
            name="price"
            placeholder="Ingresa el precio"
            required
            maxlength="9"
            x-data
            x-on:keydown="
                const allowed = ['Backspace','Tab','ArrowLeft','ArrowRight','Delete','Home','End','Enter','Escape'];
                if (allowed.includes($event.key)) { return; }
                if ($event.key === '.' && ($el.value || '').includes('.')) { $event.preventDefault(); return; }
                if (!/^[0-9.]$/.test($event.key)) { $event.preventDefault(); return; }
                const [intPart = ''] = ($el.value || '').split('.');
                if ($event.key !== '.' && !$el.value.includes('.') && intPart.length >= 6) {
                    $event.preventDefault();
                }
            "
            x-on:input="
                let val = ($el.value || '').replace(/[^0-9.]/g, '');
                let [intPart = '', decPart = ''] = val.split('.');
                intPart = intPart.replace(/^0+(?=\d)/, '').slice(0, 6);
                decPart = decPart.slice(0, 2);
                val = decPart ? `${intPart || '0'}.${decPart}` : (intPart || '');
                let num = parseFloat(val);
                if (Number.isNaN(num)) { $el.value = ''; return; }
                if (num > 500000) {
                    num = 500000;
                    decPart = '';
                }
                const [finalInt, finalDec = ''] = num.toString().split('.');
                const decimals = decPart !== '' ? decPart : finalDec.slice(0, 2);
                $el.value = decimals ? `${finalInt}.${decimals}` : finalInt;
            "
            x-on:change="
                let val = ($el.value || '').replace(/[^0-9.]/g, '');
                let [intPart = '', decPart = ''] = val.split('.');
                intPart = intPart.replace(/^0+(?=\d)/, '').slice(0, 6);
                decPart = decPart.slice(0, 2);
                val = decPart ? `${intPart || '0'}.${decPart}` : (intPart || '');
                let num = parseFloat(val);
                if (Number.isNaN(num)) { $el.value = ''; return; }
                if (num > 500000) { num = 500000; }
                const [finalInt, finalDec = ''] = num.toString().split('.');
                const decimals = decPart !== '' ? decPart : finalDec.slice(0, 2);
                $el.value = decimals ? `${finalInt}.${decimals}` : finalInt;
            "
            x-on:paste.prevent="
                let pasted = (event.clipboardData || window.clipboardData).getData('text') || '';
                pasted = pasted.replace(/[^0-9.]/g, '');
                let [intPart = '', decPart = ''] = pasted.split('.');
                intPart = intPart.replace(/^0+(?=\d)/, '').slice(0, 6);
                decPart = decPart.slice(0, 2);
                let sanitized = decPart ? `${intPart || '0'}.${decPart}` : (intPart || '');
                let num = parseFloat(sanitized);
                if (Number.isNaN(num)) { sanitized = ''; }
                if (num > 500000) { sanitized = '500000'; }
                if (sanitized !== '') {
                    $el.value = sanitized;
                    $el.dispatchEvent(new Event('input'));
                }
            "
        />

        {{-- Categoría --}}
        <div class="space-y-1" x-data @click.outside="$wire.hideCategoryResults()">
            <x-form.input wire:model.live.debounce.300ms="categorySearch"
                          wire:blur="hideCategoryResults"
                          autocomplete="off"
                          label="Categoría" name="categorySearch" placeholder="Escribe para buscar..." required />
            @if($categoryResults)
                <ul class="border rounded shadow-sm bg-white text-gray-900 max-h-48 overflow-y-auto">
                    @foreach($categoryResults as $cat)
                        <li wire:mousedown.prevent="selectCategory({{ $cat['id'] }}, @js($cat['name']))"
                            class="px-3 py-2 hover:bg-gray-100 cursor-pointer">
                            {{ $cat['name'] }}
                        </li>
                    @endforeach
                </ul>
            @endif
            <x-form.field-error for="category_id" />
        </div>

        @php
            $isEdit = property_exists($this, 'product') && $this->product?->exists;
        @endphp
        <!-- primary Button -->
        <button type="submit" class="whitespace-nowrap rounded-radius bg-primary border border-primary px-4 py-2 text-sm font-medium tracking-wide text-on-primary transition hover:opacity-75 text-center focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary active:opacity-100 active:outline-offset-0 disabled:opacity-75 disabled:cursor-not-allowed dark:bg-primary-dark dark:border-primary-dark dark:text-on-primary-dark dark:focus-visible:outline-primary-dark">
            {{ $isEdit ? 'Actualizar producto' : 'Crear producto' }}
        </button>
    </form>
</div>
