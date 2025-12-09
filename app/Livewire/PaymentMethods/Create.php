<?php

namespace App\Livewire\PaymentMethods;

use Livewire\Attributes\Validate;
use Livewire\Component;
use App\Models\PaymentMethod;

class Create extends Component
{
    #[Validate('required|string|max:255')]
    public $name = '';

    public function save(){
        if (! auth()->user()?->isAdmin()) {
            abort(403);
        }

        $this->validate();

        PaymentMethod::create([
            'name' => $this->name
        ]);

        session()->flash('success', 'Método de pago creado satisfactoriamente.');
        $this->redirectRoute('paymentmethods.index', navigate:true);
    }

    public function render()
    {
        return view('livewire.payment-methods.create');
    }
}
