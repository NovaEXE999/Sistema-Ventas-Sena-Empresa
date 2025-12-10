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
            display: flex;
            justify-content: center;
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
            margin-bottom: 3mm;
        }
        .header .title {
            font-weight: 700;
            font-size: 12px;
        }
        .hr {
            border-top: 1px solid #444;
            margin: 4mm 0 3mm;
        }
        .section-title {
            text-align: center;
            font-weight: 600;
            font-size: 11px;
            margin-bottom: 1.5mm;
        }
        .details-table {
            width: 100%;
            margin: 0 auto;
            border-collapse: collapse;
            font-size: 11px;
            table-layout: fixed;
        }
        .details-table td:first-child .product-name {
            display: block;
            max-width: 40mm;
            word-break: break-word;
        }
        .details-table th,
        .details-table td {
            padding: 1mm 1.5mm;
            vertical-align: top;
        }
        .details-table th.product-col,
        .details-table td.product-col {
            text-align: left;
            width: 40%;
        }
        .details-table th.price-col,
        .details-table td.price-col {
            text-align: right;
            width: 20%;
        }
        .details-table th.qty-col,
        .details-table td.qty-col {
            text-align: center;
            width: 15%;
        }
        .details-table th.subtotal-col,
        .details-table td.subtotal-col {
            text-align: right;
            width: 25%;
        }
        .details-table td {
            word-break: break-word;
        }
        .details-table th {
            font-size: 10px;
            text-transform: none;
            letter-spacing: 0;
            font-weight: 700;
        }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .bold { font-weight: 700; }
        .nowrap { white-space: nowrap; }
        .small { font-size: 11px; }
        .total-row td {
            padding-top: 4mm;
            font-weight: 700;
            font-size: 11px;
        }
        .total-line td {
            border-top: 1px solid #444;
        }
        .notice {
            text-align: center;
            line-height: 1.5;
            margin: 3mm 0;
        }
        .strong-notice {
            text-align: center;
            font-weight: 700;
            font-size: 12px;
            text-transform: uppercase;
            line-height: 1.5;
            margin: 3mm 0;
        }
        .date {
            text-align: center;
            font-size: 11px;
            margin-top: 8mm;
        }
        .separator-row td {
            padding: 0;
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
            <div>servicioalciudadano@sena.edu.co</div>
            <div>https://urabasena.blogspot.com/</div>
        </div>

        <div class="hr"></div>
        <div class="section-title">Atendido por: {{ $sale->user->name }}</div>
        <div class="hr"></div>

        <table class="details-table">
            <thead>
                <tr>
                    <th class="product-col">Producto</th>
                    <th class="price-col">Precio</th>
                    <th class="qty-col">Cant.</th>
                    <th class="subtotal-col">SubTotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($details as $detail)
                    <tr>
                        <td class="product-col">
                            <span class="product-name">
                                {{ $detail->product->name }}
                            </span>
                            @if ($detail->product->category && $detail->product->category->measure)
                                x {{ $detail->product->category->measure->name }}
                            @endif
                        </td>
                        <td class="price-col">{{ number_format($detail->price, 0, ',', '.') }}</td>
                        <td class="qty-col">{{ number_format($detail->quantity, 0, ',', '.') }}</td>
                        <td class="subtotal-col">{{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                    </tr>
                @endforeach
                <tr class="total-row total-line">
                    <td colspan="3" class="bold">TOTAL</td>
                    <td class="text-right bold nowrap">$ {{ number_format($sale->total_value, 0, ',', '.') }}</td>
                </tr>
                <tr class="total-row">
                    <td colspan="3" class="bold">Forma de pago</td>
                    <td class="text-right bold nowrap">{{ $sale->paymentMethod->name ?? 'N/A' }}</td>
                </tr>
            </tbody>
        </table>

        <div class="notice small">
            Gracias por su compra, estamos<br>para servirle
        </div>

        <div class="notice small">
            Factura por Computador elaborada por<br><span class="bold">SENA EMPRESA</span>
        </div>

        <div class="strong-notice">
            Este tiquete es indispensable para la<br>
            salida del complejo,<br>
            por favor<br>
            conservelo
        </div>

        @php
            $fechaHora = $sale->created_at
                ? $sale->created_at->timezone(config('app.timezone'))
                : \Carbon\Carbon::parse($sale->date);
        @endphp
        <div class="date">
            {{ $fechaHora->format('d/m/Y H:i') }}
        </div>
    </div>
</body>
</html>
