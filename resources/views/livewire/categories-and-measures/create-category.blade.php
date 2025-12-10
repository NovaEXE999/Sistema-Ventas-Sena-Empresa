<div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
    <div class="flex h-fit w-full justify-between flex-row gap-4 rounded-xl">
        <a href="{{ route('categoriesandmeasures.index')}}" wire:navigate class="flex w-fit justify-center items-center whitespace-nowrap rounded-radius bg-primary border border-primary px-4 py-2 text-center text-sm font-medium tracking-wide text-on-primary transition hover:opacity-75 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary active:opacity-100 active:outline-offset-0 disabled:cursor-not-allowed disabled:opacity-75 dark:border-primary-dark dark:bg-primary-dark dark:text-on-primary-dark dark:focus-visible:outline-primary-dark" role="button">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
            </svg>

            Volver
        </a>
        <h1 class="p-4 text-center">
            Registro de categorias
        </h1>
    </div>
    <x-form.error-alert />
    <form wire:submit="save" class="space-y-4 max-w-2xl p-4 bg-surface-alt dark:bg-surface-dark-alt rounded-lg shadow-md">

        <x-form.input wire:model.live.debounce.250ms="name"
                      label="Nombre"
                      name="name"
                      placeholder="Ingresa el nombre de la categoria"
                      maxlength="256"
                      pattern="^[A-Za-zÁÉÍÓÚáéíóúÑñÜü\s]{1,256}$"
                      x-on:keydown="if ($event.ctrlKey || $event.metaKey || $event.altKey) { return; } if (!/^[A-Za-zÁÉÍÓÚáéíóúÑñÜü\s]$/.test($event.key) && !['Backspace','Tab','ArrowLeft','ArrowRight','ArrowUp','ArrowDown','Delete','Home','End','Enter'].includes($event.key)) { $event.preventDefault(); }"
                      title="Solo letras y espacios"
                      autocomplete="off"/>

        <div class="relative" x-data @click.outside="$wire.hideMeasureResults()">
            <x-form.input wire:model.live.debounce.250ms="measureSearch"
                          wire:blur="ensureMeasureSelected"
                          autocomplete="off"
                          label="Unidad de medida"
                          name="measureSearch"
                          placeholder="Busca una medida..." />
            @if($measureResults)
                <ul class="absolute z-10 w-full border rounded shadow-sm bg-white text-gray-900 max-h-48 overflow-y-auto">
                    @foreach($measureResults as $measure)
                        <li wire:mousedown.prevent="selectMeasure({{ $measure['id'] }}, @js($measure['name']))"
                            class="px-3 py-2 hover:bg-gray-100 cursor-pointer">
                            {{ $measure['name'] }}
                        </li>
                    @endforeach
                </ul>
            @endif
            <x-form.field-error for="measure_id" />
        </div>

        @php
            $isEdit = property_exists($this, 'category') && $this->category?->exists;
        @endphp
        <!-- primary Button -->
        <button type="submit" class="whitespace-nowrap rounded-radius bg-primary border border-primary px-4 py-2 text-sm font-medium tracking-wide text-on-primary transition hover:opacity-75 text-center focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary active:opacity-100 active:outline-offset-0 disabled:opacity-75 disabled:cursor-not-allowed dark:bg-primary-dark dark:border-primary-dark dark:text-on-primary-dark dark:focus-visible:outline-primary-dark">
            {{ $isEdit ? 'Actualizar categoria' : 'Crear categoria' }}
        </button>


    </form>
</div>
