<?php

namespace App\Livewire\ProductDeliveries;

use App\Models\ProductDelivery;
use Livewire\Attributes\Validate;
use Livewire\Component;

class Create extends Component
{
    #[Validate('required|date')]
    public $date = '';
    #[Validate('required|integer|min:0')]
    public $delivered_amount = '';
    #[Validate('required|exists:products,id')]
    public $product_id = '';
    #[Validate('required|exists:providers,id')]
    public $provider_id = '';

    public function save(){
        $this->validate();

        ProductDelivery::create([
            'date' => $this->date,
            'delivered_amount' => $this->delivered_amount,
            'product_id' => $this->product_id,
            'provider_id' => $this->provider_id,
        ]);

        session()->flash('success', 'Entrada de inventario creada satisfactoriamente.');
        $this->redirectRoute('productdeliveries.index', navigate:true);
    }
    
    public function render()
    {
        return view('livewire.product-deliveries.create');
    }
}
