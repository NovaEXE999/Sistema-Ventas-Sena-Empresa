<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <title>Pruebas|Buscador</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    @livewireStyles
</head>
<body class="p-4">

    <div class="container">
        <h1 class="mb-4">Buscar un producto</h1>

        <form action="" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label">Busca Productos</label>
                <livewire:search-products />    {{-- llamando componente Livewire de busqueda --}}
            </div>

            <button class="btn btn-primary" type="submit">Guardar</button>
        </form>
    </div>

    {{-- Livewire scripts --}}
    @livewireScripts

    {{-- Bootstrap JS (optional) --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
