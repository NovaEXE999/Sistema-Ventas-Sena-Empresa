<?php

namespace App\Livewire\Reports;

use Livewire\Component;
use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleDetail;
use App\Models\ProductDelivery;
use App\Models\ClientType;
use App\Models\PaymentMethod;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class Index extends Component
{
    public int $totalProducts = 0;
    public string $month;

    public array $summaryCards = [];
    public array $salesByCategory = [];
    public array $salesByClientType = [];
    public array $deliveriesByProvider = [];
    public array $importVsSales = [];

    public string $topCategory = '-';
    public string $topClientType = '-';
    public string $topPaymentMethod = '-';

    public function mount(){
        $this->month = now()->format('Y-m');
        $this->loadMetrics();
    }

    public function updatedMonth()
    {
        $this->loadMetrics();
    }

    public function refreshData(){
        $this->loadMetrics();
    }

    private function loadMetrics(): void
    {
        $period = $this->resolveMonth();
        $start = $period->copy()->startOfMonth();
        $end = $period->copy()->endOfMonth();

        $this->totalProducts = Product::whereBetween('created_at', [$start, $end])->count();

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

        $this->salesByClientType = ClientType::select('client_types.name', DB::raw('COUNT(sales.id) as total'))
            ->join('clients', 'clients.client_type_id', '=', 'client_types.id')
            ->leftJoin('sales', function ($join) use ($start, $end) {
                $join->on('sales.client_id', '=', 'clients.id')
                    ->whereBetween('sales.date', [$start, $end]);
            })
            ->groupBy('client_types.id', 'client_types.name')
            ->orderByDesc('total')
            ->get()
            ->toArray();

        $this->deliveriesByProvider = ProductDelivery::select('providers.name', DB::raw('SUM(product_deliveries.delivered_amount) as total'))
            ->join('providers', 'product_deliveries.provider_id', '=', 'providers.id')
            ->whereBetween('product_deliveries.date', [$start, $end])
            ->groupBy('providers.id', 'providers.name')
            ->orderByDesc('total')
            ->get()
            ->toArray();

        $salesByCategoryQuery = SaleDetail::select('categories.name', DB::raw('SUM(sale_details.quantity) as total'))
            ->join('products', 'sale_details.product_id', '=', 'products.id')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->join('sales', 'sale_details.sale_id', '=', 'sales.id')
            ->whereBetween('sales.date', [$start, $end])
            ->groupBy('categories.id', 'categories.name')
            ->orderByDesc('total');

        $this->salesByCategory = $salesByCategoryQuery->get()->toArray();
        $this->topCategory = $this->salesByCategory[0]['name'] ?? '-';
        $this->topClientType = $clientType->name ?? '-';
        $this->topPaymentMethod = $paymentMethod->name ?? '-';

        $this->importVsSales = $this->calculateProportion($productsImported, $productsSold);

        $this->summaryCards = [
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
                'title' => 'Categoria que más vende',
                'value' => $this->topCategory,
                'helper' => 'Según cantidad de productos',
            ],
            [
                'title' => 'Porcentaje de productos vendidos',
                'value' => "{$this->importVsSales['sold_pct']}%",
                'helper' => "Respecto a lo importado",
            ],
            [
                'title' => 'Productos registrados',
                'value' => $this->totalProducts,
                'helper' => 'Registrados en el periodo',
            ],
        ];

    }

    private function resolveMonth(): Carbon
    {
        try {
            return Carbon::createFromFormat('Y-m', $this->month);
        } catch (\Throwable) {
            $this->month = now()->format('Y-m');
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

    public function render()
    {
        return view('livewire.reports.index');
    }
}

