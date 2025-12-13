<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />

@php
    $routeName = request()->route()?->getName();
    $pageTitles = [
        'dashboard' => 'Dashboard',
        'clients.index' => 'Clientes',
        'clients.create' => 'Crear cliente',
        'clients.update' => 'Actualizar cliente',
        'products.index' => 'Productos',
        'products.create' => 'Crear producto',
        'products.update' => 'Actualizar producto',
        'sales.index' => 'Ventas',
        'sales.create' => 'Crear venta',
        'sales.update' => 'Actualizar venta',
        'sales.show' => 'Detalle de venta',
        'providers.index' => 'Proveedores',
        'providers.create' => 'Crear proveedor',
        'providers.update' => 'Actualizar proveedor',
        'productdeliveries.index' => 'Inventario',
        'productdeliveries.create' => 'Crear inventario',
        'productdeliveries.update' => 'Actualizar inventario',
        'categoriesandmeasures.index' => 'Categorias y medidas',
        'categories.create' => 'Crear categoria',
        'categories.update' => 'Actualizar categoria',
        'measures.create' => 'Crear medida',
        'measures.update' => 'Actualizar medida',
        'paymentmethods.index' => 'Metodos de pago',
        'paymentmethods.create' => 'Crear metodo de pago',
        'paymentmethods.update' => 'Actualizar metodo de pago',
        'clienttypes.index' => 'Tipos de cliente',
        'clienttypes.create' => 'Crear tipo de cliente',
        'clienttypes.update' => 'Actualizar tipo de cliente',
        'persontypes.index' => 'Tipos de persona',
        'persontypes.create' => 'Crear tipo de persona',
        'persontypes.update' => 'Actualizar tipo de persona',
        'users.index' => 'Gestion de usuarios',
        'users.create' => 'Crear usuario',
        'users.update' => 'Actualizar usuario',
        'reports.index' => 'Reportes',
    ];

    $pageTitle = $title
        ?? ($routeName && isset($pageTitles[$routeName]) ? $pageTitles[$routeName] : config('app.name'));
@endphp

<title>{{ $pageTitle }}</title>
<link rel="icon" href="/favicon.ico" sizes="any">
<link rel="icon" href="/favicon.svg" type="image/svg+xml">
<link rel="apple-touch-icon" href="/apple-touch-icon.png">

<link rel="preconnect" href="https://fonts.bunny.net">
<link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

@vite(['resources/css/app.css', 'resources/js/app.js'])
@fluxAppearance
