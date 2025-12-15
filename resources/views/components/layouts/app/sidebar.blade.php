<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen bg-white dark:bg-zinc-800">
        <style>
            .sidebar-sena {
                color: #f7fff9;
            }
            .sidebar-sena a,
            .sidebar-sena button {
                color: #f7fff9;
                font-weight: 600;
            }
            .sidebar-sena [data-slot="heading"],
            .sidebar-sena .navlist-heading,
            .sidebar-sena .flux-navlist-heading {
                color: #f7fff9;
                opacity: 0.92;
                font-weight: 700;
            }
            .sidebar-sena [data-flux-navlist-group] .text-xs {
                color: #ffffff;
                opacity: 0.95;
                letter-spacing: 0.01em;
            }
            .sidebar-sena [data-flux-navlist-group] button {
                color: #f7fff9;
            }
            .sidebar-sena [data-flux-navlist-group] button:hover {
                background-color: rgba(0, 0, 0, 0.12);
                color: #ffffff;
            }
            .sidebar-sena a:hover,
            .sidebar-sena button:hover {
                background-color: rgba(0, 0, 0, 0.12);
                color: #ffffff;
            }
            .sidebar-sena [aria-current="page"],
            .sidebar-sena [data-current="true"],
            .sidebar-sena .active,
            .sidebar-sena [data-flux-navlist-item][data-current],
            .sidebar-sena [data-flux-navlist-item][aria-current="page"] {
                background-color: rgba(0, 0, 0, 0.22);
                color: #ffffff !important;
                border-color: rgba(255, 255, 255, 0.25);
                box-shadow: inset 0 0 0 1px rgba(255, 255, 255, 0.08);
            }
            .sidebar-sena [data-flux-navlist-item]:hover {
                background-color: rgba(0, 0, 0, 0.12);
                color: #ffffff;
            }
            .sidebar-sena [data-flux-navlist-item]:focus-visible {
                outline: 2px solid rgba(255, 255, 255, 0.45);
                outline-offset: 2px;
            }
            .sidebar-sena svg {
                color: inherit;
            }

            .sidebar-profile {
                color: #f7fff9;
            }
            .sidebar-profile .text-sm,
            .sidebar-profile .text-xs,
            .sidebar-profile span {
                color: #f7fff9;
            }
            .sidebar-profile .bg-neutral-200 {
                background-color: rgba(255, 255, 255, 0.2) !important;
                color: #0d381f !important;
            }
            .sidebar-profile [data-flux-menu] {
                background-color: rgba(0, 0, 0, 0.22) !important;
                border-color: rgba(255, 255, 255, 0.2) !important;
                color: #f7fff9 !important;
                box-shadow: 0 12px 28px -16px rgba(0, 0, 0, 0.45);
                backdrop-filter: blur(6px);
            }
            .sidebar-profile [data-flux-menu-item],
            .sidebar-profile [data-flux-menu] [data-flux-menu-item-icon],
            .sidebar-profile [data-flux-menu] .text-xs {
                color: #f7fff9 !important;
            }
            .sidebar-profile [data-flux-menu-item]:hover {
                background-color: rgba(255, 255, 255, 0.08);
                color: #ffffff !important;
            }
            .sidebar-profile [data-flux-menu-separator] {
                background-color: rgba(255, 255, 255, 0.14);
            }
        </style>
        <flux:sidebar sticky stashable class="border-e border-[#158a4c] bg-[#1aa855] text-white">
            <flux:sidebar.toggle class="lg:hidden" icon="x-mark" />

            <a href="{{ route('reports.index') }}" class="me-5 flex items-center space-x-2 rtl:space-x-reverse" wire:navigate>
                <x-app-logo />
            </a>

            <flux:navlist variant="outline" class="sidebar-sena">
                <flux:navlist.group :heading="__('Plataforma')" class="grid">
                    @php($isAdmin = auth()->user()?->isAdmin())
                    {{-- <flux:navlist.item icon="home" :href="route('dashboard')" :current="request()->routeIs('dashboard')" wire:navigate>{{ __('Dashboard') }}</flux:navlist.item> --}}
                    @if ($isAdmin)
                        <flux:navlist.item icon="document" :href="route('reports.index')" :current="request()->routeIs('reports.*')" wire:navigate>Reportes</flux:navlist.item>
                        <flux:navlist.item icon="user-group" :href="route('users.index')" :current="request()->routeIs('users.*')" wire:navigate>Gestion de usuarios</flux:navlist.item>
                    @endif

                    <flux:navlist.group heading="Gestion de clientes" expandable>
                        <flux:navlist.item icon="user" :href="route('clients.index')" :current="request()->routeIs('clients.*')" wire:navigate>Clientes</flux:navlist.item>
                        @if ($isAdmin)
                            <flux:navlist.item icon="users" :href="route('clienttypes.index')" :current="request()->routeIs('clienttypes.*')" wire:navigate>Tipos de cliente</flux:navlist.item>
                        @endif
                    </flux:navlist.group>

                    @if ($isAdmin)
                        <flux:navlist.item icon="tag" :href="route('categoriesandmeasures.index')" :current="request()->routeIs('categoriesandmeasures.*')" wire:navigate>Categorias y Medidas</flux:navlist.item>
                    @endif

                    <flux:navlist.item icon="shopping-cart" :href="route('products.index')" :current="request()->routeIs('products.*')" wire:navigate>Productos</flux:navlist.item>

                    <flux:navlist.item icon="currency-dollar" :href="route('sales.index')" :current="request()->routeIs('sales.*')" wire:navigate>Ventas</flux:navlist.item>

                    
                    <flux:navlist.group heading="Gestion de proveedores" expandable>
                        <flux:navlist.item icon="truck" :href="route('providers.index')" :current="request()->routeIs('providers.*')" wire:navigate>Proveedores</flux:navlist.item>
                        @if ($isAdmin)
                            <flux:navlist.item icon="identification" :href="route('persontypes.index')" :current="request()->routeIs('persontypes.*')" wire:navigate>Tipos de Persona</flux:navlist.item>
                        @endif
                    </flux:navlist.group>
  
                    <flux:navlist.item icon="building-storefront" :href="route('productdeliveries.index')" :current="request()->routeIs('productdeliveries.*')" wire:navigate>Inventario</flux:navlist.item>

                    @if ($isAdmin)
                        <flux:navlist.item icon="credit-card" :href="route('paymentmethods.index')" :current="request()->routeIs('paymentmethods.*')" wire:navigate>Metodos de pago</flux:navlist.item>
                    @endif
                      
                    
                    {{-- <flux:navlist.item icon="information-circle" :href="route('dashboard')" :current="request()->routeIs('dashboard')" wire:navigate>Acerca de</flux:navlist.item> --}}
                </flux:navlist.group>
            </flux:navlist>

            <flux:spacer />

            <flux:dropdown class="hidden lg:block sidebar-profile" position="bottom" align="start">
                <flux:profile
                    :name="auth()->user()->name"
                    :initials="auth()->user()->initials()"
                    icon:trailing="chevrons-up-down"
                    data-test="sidebar-menu-button"
                />

                <flux:menu class="w-[220px]">
                    <flux:menu.radio.group>
                        <div class="p-0 text-sm font-normal">
                            <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">
                                <span class="relative flex h-8 w-8 shrink-0 overflow-hidden rounded-lg">
                                    <span class="flex h-full w-full items-center justify-center rounded-lg bg-neutral-200 text-black dark:bg-neutral-700 dark:text-white">
                                        {{ auth()->user()->initials() }}
                                    </span>
                                </span>

                                <div class="grid flex-1 text-start text-sm leading-tight">
                                    <span class="truncate font-semibold">{{ auth()->user()->name }}</span>
                                    <span class="truncate text-xs">{{ auth()->user()->email }}</span>
                                </div>
                            </div>
                        </div>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <flux:menu.radio.group>
                        <flux:menu.item :href="route('profile.edit')" icon="cog" wire:navigate>{{ __('Configuraciones') }}</flux:menu.item>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle" class="w-full" data-test="logout-button">
                            {{ __('Cerrar sesion') }}
                        </flux:menu.item>
                    </form>
                </flux:menu>
            </flux:dropdown>
        </flux:sidebar>

        <flux:header class="lg:hidden">
            <flux:sidebar.toggle class="lg:hidden" icon="bars-2" inset="left" />

            <flux:spacer />

            <flux:dropdown position="top" align="end">
                <flux:profile
                    :initials="auth()->user()->initials()"
                    icon-trailing="chevron-down"
                />

                <flux:menu>
                    <flux:menu.radio.group>
                        <div class="p-0 text-sm font-normal">
                            <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">
                                <span class="relative flex h-8 w-8 shrink-0 overflow-hidden rounded-lg">
                                    <span class="flex h-full w-full items-center justify-center rounded-lg bg-neutral-200 text-black dark:bg-neutral-700 dark:text-white">
                                        {{ auth()->user()->initials() }}
                                    </span>
                                </span>

                                <div class="grid flex-1 text-start text-sm leading-tight">
                                    <span class="truncate font-semibold">{{ auth()->user()->name }}</span>
                                    <span class="truncate text-xs">{{ auth()->user()->email }}</span>
                                </div>
                            </div>
                        </div>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <flux:menu.radio.group>
                        <flux:menu.item :href="route('profile.edit')" icon="cog" wire:navigate>{{ __('Configuraciones') }}</flux:menu.item>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle" class="w-full" data-test="logout-button">
                            {{ __('Cerrar sesión') }}
                        </flux:menu.item>
                    </form>
                </flux:menu>
            </flux:dropdown>
        </flux:header>

        {{ $slot }}

        @fluxScripts
        @stack('scripts')
    </body>
</html>
