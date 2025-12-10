<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        @page {
            size: 76mm auto;
            margin: 3mm 2mm;
        }
        * {
            box-sizing: border-box;
        }
        html, body {
            width: 76mm;
        }
        body {
            margin: 0;
            padding: 0;
            font-family: "DejaVu Sans", Arial, sans-serif;
            color: #111;
            font-size: 11px;
        }
        .ticket {
            width: 68mm;
            max-width: 68mm;
            margin: 0 auto;
            padding: 3mm 2mm 5mm;
            border-radius: 6mm;
            page-break-inside: avoid;
        }
        .logo-wrap {
            text-align: center;
        }
        .logo {
            display: inline-block;
            margin: 0 auto 2mm;
            height: 16mm;
            max-width: 32mm;
            width: auto;
            object-fit: contain;
        }
        .header {
            text-align: center;
            line-height: 1.4;
            margin-bottom: 2.5mm;
        }
        .header .title {
            font-weight: 700;
            font-size: 12px;
        }
        .header .subtitle {
            font-weight: 600;
            font-size: 11px;
        }
        .hr {
            border-top: 1px solid #444;
            margin: 3mm 0 2.5mm;
        }
        .section-title {
            text-align: center;
            font-weight: 600;
            font-size: 11px;
            margin-bottom: 1mm;
        }
        .info-line {
            font-size: 11px;
            margin: 0.6mm 0;
        }
        .details-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 11px;
        }
        .details-table td:first-child .product-name {
            display: block;
            max-width: 40mm;
            word-break: break-word;
        }
        .details-table th,
        .details-table td {
            padding: 1mm 0;
            vertical-align: top;
        }
        .details-table th {
            text-align: center;
        }
        .details-table th.product-col,
        .details-table td.product-col {
            text-align: left;
        }
        .details-table td {
            word-break: break-word;
        }
        .details-table th {
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .bold { font-weight: 700; }
        .nowrap { white-space: nowrap; }
        .small { font-size: 11px; }
        .notice {
            text-align: center;
            line-height: 1.5;
            margin: 2.5mm 0;
        }
        .date {
            text-align: center;
            font-size: 11px;
            margin-top: 4mm;
        }
    </style>
</head>
<body>
    <div class="ticket">
        <div class="logo-wrap">
            <img class="logo" src="assets/Logosena.png" alt="Logo">
        </div>

        <div class="header">
            <div class="title">Sena Empresa</div>
            <div class="subtitle">Entrega de inventario</div>
        </div>

        <div class="hr"></div>

        <div class="section-title">Proveedor</div>
        <div class="info-line"><span class="bold">Nombre:</span> {{ $provider->name ?? 'N/A' }}</div>
        <div class="info-line"><span class="bold">Identificaci&oacute;n:</span> {{ $provider->identification ?? 'N/A' }}</div>

        <div class="hr"></div>

        <table class="details-table">
            <thead>
                <tr>
                    <th class="product-col" style="width: 70%;">Producto</th>
                    <th class="text-right" style="width: 30%;">Cant.</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($deliveries as $item)
                    <tr>
                        <td class="product-col">
                            <span class="product-name">
                                {{ $item->product->name }}
                            </span>
                            @if ($item->product->category && $item->product->category->measure)
                                x {{ $item->product->category->measure->name }}
                            @endif
                        </td>
                        <td class="text-right">{{ number_format($item->delivered_amount, 0, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="notice small">
            Comprobante por Computador elaborado por<br><span class="bold">SENA EMPRESA</span>
        </div>

        @php
            $fechaHora = $delivery->created_at
                ? $delivery->created_at->timezone(config('app.timezone'))
                : \Carbon\Carbon::parse($delivery->date);
        @endphp
        <div class="date">
            {{ $fechaHora->format('d/m/Y H:i') }}
        </div>
    </div>
</body>
</html>
