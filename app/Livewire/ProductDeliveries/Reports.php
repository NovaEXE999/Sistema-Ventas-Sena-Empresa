<?php

namespace App\Livewire\ProductDeliveries;

use App\Models\ProductDelivery;
use Livewire\Component;
use Barryvdh\DomPDF\Facade\Pdf;

class Reports extends Component
{
    public function pdf(ProductDelivery $delivery)
    {
        $delivery->load('provider');
        $deliveries = ProductDelivery::with('product.category.measure')
            ->where('provider_id', $delivery->provider_id)
            ->whereDate('date', $delivery->date)
            ->orderBy('id')
            ->get();

        $pdf = Pdf::loadView('livewire.product-deliveries.reports', [
            'delivery' => $delivery,
            'deliveries' => $deliveries,
            'provider' => $delivery->provider,
        ]);

        $items = $deliveries->count();
        $paperWidth = 215;
        $paperHeight = max(500 + ($items * 45), 500);

        $pdf->setPaper([0, 0, $paperWidth, $paperHeight], 'portrait');

        return $pdf->stream('entrada-' . $delivery->id . '.pdf');
    }

    public function download(ProductDelivery $delivery)
    {
        $delivery->load('provider');
        $deliveries = ProductDelivery::with('product.category.measure')
            ->where('provider_id', $delivery->provider_id)
            ->whereDate('date', $delivery->date)
            ->orderBy('id')
            ->get();

        $pdf = Pdf::loadView('livewire.product-deliveries.reports', [
            'delivery' => $delivery,
            'deliveries' => $deliveries,
            'provider' => $delivery->provider,
        ]);

        $items = max($deliveries->count(), 1);
        $paperWidth = 215;
        $paperHeight = max(500 + ($items * 45), 500);

        $pdf->setPaper([0, 0, $paperWidth, $paperHeight], 'portrait');

        return $pdf->download('entrada-' . $delivery->id . '.pdf');
    }

    public function render()
    {
        return view('livewire.product-deliveries.reports');
    }
}
