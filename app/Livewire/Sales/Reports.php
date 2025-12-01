<?php

namespace App\Livewire\Sales;

use App\Models\Sale;
use Livewire\Component;
use Barryvdh\DomPDF\Facade\Pdf;

class Reports extends Component
{
    public function pdf(Sale $sale)
    {
        $sale->load(['client', 'user', 'details.product.measure']);

        $pdf = Pdf::loadView('livewire.sales.reports', [
            'sale' => $sale,
            'details' => $sale->details,
        ]);

        $items = $sale->details->count();
        $paperWidth = 215; // ~76mm
        $paperHeight = max(500 + ($items * 45), 500); // puntos tipográficos: base ~176mm + ~16mm por ítem

        $pdf->setPaper([0, 0, $paperWidth, $paperHeight], 'portrait');

        return $pdf->stream('venta-' . $sale->id . '.pdf');
        
    }

    public function download(Sale $sale)
    {
        $sale->load(['client', 'user', 'details.product.measure']);

        $pdf = Pdf::loadView('livewire.sales.reports', [
            'sale' => $sale,
            'details' => $sale->details,
        ]);

        $items = $sale->details->count();
        $paperWidth = 215; // ~76mm
        $paperHeight = max(500 + ($items * 45), 500); // puntos tipográficos: base ~176mm + ~16mm por ítem

        $pdf->setPaper([0, 0, $paperWidth, $paperHeight], 'portrait');

        return $pdf->download('venta-' . $sale->id . '.pdf');

    }

    public function render()
    {
        return view('livewire.sales.reports');
    } 
}
