<?php

namespace App\Livewire\Reports;

use App\Models\ClientType;
use App\Models\PaymentMethod;
use App\Models\Product;
use App\Models\ProductDelivery;
use App\Models\Sale;
use App\Models\SaleDetail;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Reports extends Component
{
    public function pdf(string $report)
    {
        $data = $this->buildReportData($report);

        $pdf = Pdf::loadView('livewire.reports.reports', $data)
            ->setPaper('letter', 'landscape');

        return $pdf->stream('reporte-' . $data['periodSlug'] . '.pdf');
    }

    public function download(string $report)
    {
        $data = $this->buildReportData($report);

        $pdf = Pdf::loadView('livewire.reports.reports', $data)
            ->setPaper('letter', 'landscape');

        return $pdf->download('reporte-' . $data['periodSlug'] . '.pdf');
    }

    public function render()
    {
        return view('livewire.reports.reports');
    }

    private function buildReportData(string $report): array
    {
        $period = $this->resolveMonth($report);
        $start = $period->copy()->startOfMonth();
        $end = $period->copy()->endOfMonth();

        $totalProducts = Product::whereBetween('created_at', [$start, $end])->count();

        $monthlySalesQuery = Sale::whereBetween('date', [$start, $end]);
        $saleDetailsQuery = SaleDetail::whereHas('sale', function ($query) use ($start, $end) {
            $query->whereBetween('date', [$start, $end]);
        });
        $deliveriesQuery = ProductDelivery::whereBetween('date', [$start, $end]);

        $salesCount = (clone $monthlySalesQuery)->count();
        $productsSold = (clone $saleDetailsQuery)->sum('quantity');
        $productsImported = (clone $deliveriesQuery)->sum('delivered_amount');
        $revenue = (clone $monthlySalesQuery)->sum('total_value');

        $paymentMethod = PaymentMethod::select('payment_methods.name', DB::raw('COUNT(sales.id) as total'))
            ->join('sales', 'sales.payment_method_id', '=', 'payment_methods.id')
            ->whereBetween('sales.date', [$start, $end])
            ->groupBy('payment_methods.id', 'payment_methods.name')
            ->orderByDesc('total')
            ->first();

        $clientType = ClientType::select('client_types.name', DB::raw('COUNT(sales.id) as total'))
            ->join('clients', 'clients.client_type_id', '=', 'client_types.id')
            ->join('sales', 'sales.client_id', '=', 'clients.id')
            ->whereBetween('sales.date', [$start, $end])
            ->groupBy('client_types.id', 'client_types.name')
            ->orderByDesc('total')
            ->first();

        $salesByClientType = ClientType::select('client_types.name', DB::raw('COUNT(sales.id) as total'))
            ->join('clients', 'clients.client_type_id', '=', 'client_types.id')
            ->leftJoin('sales', function ($join) use ($start, $end) {
                $join->on('sales.client_id', '=', 'clients.id')
                    ->whereBetween('sales.date', [$start, $end]);
            })
            ->groupBy('client_types.id', 'client_types.name')
            ->orderByDesc('total')
            ->get()
            ->toArray();

        $deliveriesByProvider = ProductDelivery::select('providers.name', DB::raw('SUM(product_deliveries.delivered_amount) as total'))
            ->join('providers', 'product_deliveries.provider_id', '=', 'providers.id')
            ->whereBetween('product_deliveries.date', [$start, $end])
            ->groupBy('providers.id', 'providers.name')
            ->orderByDesc('total')
            ->get()
            ->toArray();

        $salesByCategory = SaleDetail::select('categories.name', DB::raw('SUM(sale_details.quantity) as total'))
            ->join('products', 'sale_details.product_id', '=', 'products.id')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->join('sales', 'sale_details.sale_id', '=', 'sales.id')
            ->whereBetween('sales.date', [$start, $end])
            ->groupBy('categories.id', 'categories.name')
            ->orderByDesc('total')
            ->get()
            ->toArray();

        $topCategory = $salesByCategory[0]['name'] ?? '-';
        $topClientType = $clientType->name ?? '-';
        $topPaymentMethod = $paymentMethod->name ?? '-';

        $importVsSales = $this->calculateProportion($productsImported, $productsSold);

        $summaryCards = [
            [
                'title' => 'Ventas del mes',
                'value' => $salesCount,
                'helper' => 'Operaciones del periodo seleccionado',
            ],
            [
                'title' => 'Productos vendidos',
                'value' => $productsSold,
                'helper' => 'Sumatoria de cantidades vendidas',
            ],
            [
                'title' => 'Productos importados',
                'value' => $productsImported,
                'helper' => 'Entradas registradas a inventario',
            ],
            [
                'title' => 'Ingresos del mes',
                'value' => number_format($revenue, 2),
                'helper' => 'Valor total de ventas',
            ],
            [
                'title' => 'Tipo de cliente top',
                'value' => $clientType->name ?? 'Sin ventas',
                'helper' => isset($clientType->total) ? "{$clientType->total} ventas" : 'N/A',
            ],
            [
                'title' => 'Metodo de pago favorito',
                'value' => $paymentMethod->name ?? 'Sin datos',
                'helper' => isset($paymentMethod->total) ? "{$paymentMethod->total} usos" : 'N/A',
            ],
            [
                'title' => 'Categoria que mas vende',
                'value' => $topCategory,
                'helper' => 'Segun cantidad de productos',
            ],
            [
                'title' => 'Porcentaje de productos vendidos',
                'value' => "{$importVsSales['sold_pct']}%",
                'helper' => "Respecto a lo importado",
            ],
            [
                'title' => 'Productos registrados',
                'value' => $totalProducts,
                'helper' => 'Registrados en el periodo',
            ],
        ];

        $periodLabel = ucfirst($period->locale(config('app.locale'))->translatedFormat('F Y'));
        $rangeLabel = $start->format('d/m/Y') . ' - ' . $end->format('d/m/Y');

        return [
            'period' => $period,
            'periodLabel' => $periodLabel,
            'rangeLabel' => $rangeLabel,
            'periodSlug' => $period->format('Y-m'),
            'summaryCards' => $summaryCards,
            'salesByCategory' => $salesByCategory,
            'salesByClientType' => $salesByClientType,
            'deliveriesByProvider' => $deliveriesByProvider,
            'importVsSales' => $importVsSales,
            'topCategory' => $topCategory,
            'topClientType' => $topClientType,
            'topPaymentMethod' => $topPaymentMethod,
            'salesCount' => $salesCount,
            'productsSold' => $productsSold,
            'productsImported' => $productsImported,
            'revenue' => $revenue,
            'totalProducts' => $totalProducts,
        ];
    }

    private function resolveMonth(string $month): Carbon
    {
        try {
            return Carbon::createFromFormat('Y-m', $month);
        } catch (\Throwable) {
            return now()->startOfMonth();
        }
    }

    private function calculateProportion(int $imported, int $sold): array
    {
        $total = $imported + $sold;

        if ($total === 0) {
            return [
                'imported_pct' => 0,
                'sold_pct' => 0,
            ];
        }

        return [
            'imported_pct' => round(($imported / $total) * 100, 1),
            'sold_pct' => round(($sold / $total) * 100, 1),
        ];
    }
}
