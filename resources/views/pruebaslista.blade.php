<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <title>Pruebas|Lista</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    @livewireStyles
</head>
<body class="p-4">

    <div class="container">
        <h1 class="mb-4">Agregar productos</h1>
        <h2>Nueva Venta</h2>

        <!-- Lista dinámica de productos -->
        <livewire:sale-list />

        <div class="mt-4">
            <button type="submit" class="btn btn-primary">
                Guardar Venta
            </button>
        </div>

    </div>

    {{-- Livewire scripts --}}
    @livewireScripts

    {{-- Bootstrap JS (optional) --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
