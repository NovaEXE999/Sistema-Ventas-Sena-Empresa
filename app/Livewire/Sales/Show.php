<?php

namespace App\Livewire\Sales;

use App\Models\Sale;
use Livewire\Component;

class Show extends Component
{
    public Sale $sale;
    public $details;

    public function mount(Sale $sale){
        $this->sale = $sale;

        $this->details = $sale->details()->with(['sale', 'product'])->get();
    }
    public function render()
    {
        return view('livewire.sales.show');
    }
}
