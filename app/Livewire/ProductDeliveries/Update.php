<?php

namespace App\Livewire\ProductDeliveries;

use App\Models\ProductDelivery;
use Livewire\Attributes\Validate;
use Livewire\Component;

class Update extends Component
{
    public ?ProductDelivery $delivery;

    #[Validate('required|date')]
    public $date = '';
    #[Validate('required|integer|min:0')]
    public $delivered_amount = '';
    #[Validate('required|exists:products,id')]
    public $product_id = '';
    #[Validate('required|exists:providers,id')]
    public $provider_id = '';

    public function mount(ProductDelivery $delivery)
    {
        $this->setDelivery($delivery);
    }

    public function setDelivery (ProductDelivery $delivery){
        $this->delivery = $delivery;
        // Input date necesita formato Y-m-d
        $this->date = $delivery->date instanceof \Carbon\Carbon
            ? $delivery->date->format('Y-m-d')
            : $delivery->date;
        $this->delivered_amount = $delivery->delivered_amount;
        $this->product_id = $delivery->product_id;
        $this->provider_id = $delivery->provider_id;
    }

    public function update()
    {
        $this->validate();
        
        $this->delivery->update($this->all());
    }

     public function save()
    {
        $this->update();

        session()->flash('success', 'Entrada de inventario actualizada correctamente.');
        $this->redirectRoute('productdeliveries.index', navigate:true);
    }

    public function render()
    {
        return view('livewire.product-deliveries.create');
    }
}
