<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        @page {
            size: 76mm 3276mm;
            margin: 4mm 3mm;
        }
        * {
            box-sizing: border-box;
        }
        body {
            margin: 0;
            padding: 0;
            font-family: "DejaVu Sans", Arial, sans-serif;
            color: #111;
            font-size: 11px;
        }
        .ticket {
            width: 66mm;
            margin: 0 auto;
            padding: 3mm 2mm 5mm;
            border-radius: 6mm;
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
            border-collapse: collapse;
            font-size: 11px;
        }
        .details-table th,
        .details-table td {
            padding: 1mm 0;
            vertical-align: top;
        }
        .details-table th {
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .bold { font-weight: 700; }
        .small { font-size: 11px; }
        .total-row td {
            padding-top: 3mm;
            font-weight: 700;
            font-size: 11px;
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
            <div>serviciociudadano@sena.edu.co</div>
            <div>https://urabasena.blogspot.com/</div>
        </div>

        <div class="hr"></div>
        <div class="section-title">Atendido por: {{ $sale->user->name }}</div>
        <div class="hr"></div>

        <table class="details-table">
            <thead>
                <tr>
                    <th style="width: 58%;">Producto</th>
                    <th class="text-right" style="width: 14%;">Cant.</th>
                    <th class="text-right" style="width: 28%;">SubTotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($details as $detail)
                    <tr>
                        <td>
                            {{ $detail->product->name }}
                            @if ($detail->product->measure)
                                x {{ $detail->product->measure->abbreviation ?? $detail->product->measure->name }}
                            @endif
                        </td>
                        <td class="text-right">{{ number_format($detail->quantity, 0, ',', '.') }}</td>
                        <td class="text-right">{{ number_format($detail->total, 0, ',', '.') }}</td>
                    </tr>
                @endforeach
                <tr class="total-row">
                    <td class="bold">TOTAL</td>
                    <td></td>
                    <td class="text-right bold">$ {{ number_format($sale->total_value, 0, ',', '.') }}</td>
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
            Este tiquete es indispensable para<br>
            salida del complejo,<br>
            cambios o devoluciones por favor<br>
            conservelo
        </div>

        <div class="date">
            {{ \Carbon\Carbon::parse($sale->date)->format('d/m/Y H:i') }}
        </div>
    </div>
</body>
</html>
