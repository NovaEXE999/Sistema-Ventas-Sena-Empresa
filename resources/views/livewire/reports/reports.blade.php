<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        @page {
            size: letter landscape;
            margin: 6mm 7mm;
        }
        * { box-sizing: border-box; }
        body {
            font-family: "DejaVu Sans", Arial, sans-serif;
            color: #111;
            font-size: 10.5px;
            margin: 0;
            padding: 0;
        }

        .no-break { page-break-inside: avoid; }
        .muted { color: #4b5563; }
        .text-right { text-align: right; }

        .header {
            text-align: center;
            margin-bottom: 8px;
        }
        .logo {
            display: inline-block;
            height: 14mm;
            width: auto;
            margin: 0 auto 6px;
        }
        .title {
            font-size: 19px;
            font-weight: 800;
            margin: 0 0 4px;
        }
        .meta {
            font-size: 9px;
            line-height: 1.25;
            margin: 0;
        }

        .section-title {
            font-size: 14px;
            font-weight: 800;
            margin: 10px 0 6px;
        }

        .summary-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 7px;
            margin: 0;
        }
        .summary-table td {
            width: 33.33%;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            background: #f8fafc;
            padding: 7px 9px;
            vertical-align: top;
        }
        .summary-title {
            font-weight: 800;
            font-size: 10px;
            line-height: 1.2;
            margin: 0 0 3px;
        }
        .summary-value {
            font-weight: 900;
            font-size: 14px;
            line-height: 1.15;
            margin: 0 0 3px;
            word-break: break-word;
        }
        .summary-helper {
            font-size: 9px;
            line-height: 1.2;
            color: #475467;
            margin: 0;
        }
        .summary-empty {
            border: 0 !important;
            background: transparent !important;
            padding: 0 !important;
        }

        
        .panels {
            width: 100%;
            border-collapse: separate;
            border-spacing: 7px;
            margin: 0;
        }
        .panel {
            border: 1px solid #d1d5db;
            border-radius: 10px;
            padding: 8px 8px 7px;
            vertical-align: top;
        }
        .panel-title {
            font-size: 11.5px;
            font-weight: 900;
            margin: 0 0 6px;
        }
        .mini-table {
            width: 100%;
            border-collapse: collapse;
            margin: 0;
        }
        .mini-table th, .mini-table td {
            border: 1px solid #e5e7eb;
            padding: 3px 5px;
            font-size: 9.5px;
        }
        .mini-table th {
            background: #f3f4f6;
        }
        .footnote {
            margin: 6px 0 0;
            font-size: 8.5px;
            line-height: 1.25;
        }
    </style>
</head>
<body>
    <div class="header no-break">
        <img class="logo" src="assets/Logosena.png" alt="Logo">
        <div class="title">Reporte mensual</div>
        <p class="meta muted">Periodo: {{ $periodLabel }} ({{ $rangeLabel }})</p>
        <p class="meta muted">Generado el {{ now()->format('d/m/Y H:i') }}</p>
    </div>

    <div class="no-break">
        <div class="section-title">Resumen</div>
        <table class="summary-table">
            <tbody>
                @foreach (array_chunk($summaryCards, 3) as $row)
                    <tr>
                        @foreach ($row as $card)
                            <td>
                                <div class="summary-title">{{ $card['title'] }}</div>
                                <div class="summary-value">{{ $card['value'] }}</div>
                                @if (!empty($card['helper']))
                                    <p class="summary-helper">{{ $card['helper'] }}</p>
                                @endif
                            </td>
                        @endforeach
                        @for ($i = count($row); $i < 3; $i++)
                            <td class="summary-empty"></td>
                        @endfor
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    @php
        
        $maxRows = 6;

        $salesByClientTypeAll = $salesByClientType ?? [];
        $salesByCategoryAll = $salesByCategory ?? [];
        $deliveriesByProviderAll = $deliveriesByProvider ?? [];

        $salesByClientTypeRows = array_slice($salesByClientTypeAll, 0, $maxRows);
        $salesByClientTypeExtra = max(count($salesByClientTypeAll) - $maxRows, 0);

        $salesByCategoryRows = array_slice($salesByCategoryAll, 0, $maxRows);
        $salesByCategoryExtra = max(count($salesByCategoryAll) - $maxRows, 0);

        $deliveriesByProviderRows = array_slice($deliveriesByProviderAll, 0, $maxRows);
        $deliveriesByProviderExtra = max(count($deliveriesByProviderAll) - $maxRows, 0);
    @endphp

    <div class="no-break">
        <table class="panels">
            <tbody>
                <tr>
                    <td class="panel" style="width: 33.33%;">
                        <div class="panel-title">Ventas por tipo de cliente</div>
                        <table class="mini-table">
                            <thead>
                                <tr>
                                    <th>Tipo</th>
                                    <th class="text-right">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($salesByClientTypeRows as $row)
                                    <tr>
                                        <td>{{ $row['name'] }}</td>
                                        <td class="text-right">{{ $row['total'] ?? 0 }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="2">Sin datos</td>
                                    </tr>
                                @endforelse
                                @if ($salesByClientTypeExtra > 0)
                                    <tr>
                                        <td colspan="2" class="muted">+{{ $salesByClientTypeExtra }} mas...</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </td>

                    <td class="panel" style="width: 33.33%;">
                        <div class="panel-title">Productos vendidos por categoria</div>
                        <table class="mini-table">
                            <thead>
                                <tr>
                                    <th>Categoria</th>
                                    <th class="text-right">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($salesByCategoryRows as $row)
                                    <tr>
                                        <td>{{ $row['name'] }}</td>
                                        <td class="text-right">{{ $row['total'] ?? 0 }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="2">Sin datos</td>
                                    </tr>
                                @endforelse
                                @if ($salesByCategoryExtra > 0)
                                    <tr>
                                        <td colspan="2" class="muted">+{{ $salesByCategoryExtra }} mas...</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </td>

                    <td class="panel" style="width: 33.33%;">
                        <div class="panel-title">Entradas por proveedor</div>
                        <table class="mini-table">
                            <thead>
                                <tr>
                                    <th>Proveedor</th>
                                    <th class="text-right">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($deliveriesByProviderRows as $row)
                                    <tr>
                                        <td>{{ $row['name'] }}</td>
                                        <td class="text-right">{{ $row['total'] ?? 0 }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="2">Sin datos</td>
                                    </tr>
                                @endforelse
                                @if ($deliveriesByProviderExtra > 0)
                                    <tr>
                                        <td colspan="2" class="muted">+{{ $deliveriesByProviderExtra }} mas...</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </td>
                </tr>
            </tbody>
        </table>

        <p class="footnote muted">
            Destacados: Categoria top: {{ $topCategory }} · Cliente top: {{ $topClientType }} · Pago top: {{ $topPaymentMethod }} · {{ $importVsSales['sold_pct'] ?? 0 }}% vendidos / {{ $importVsSales['imported_pct'] ?? 0 }}% importados
        </p>
    </div>
</body>
</html>

