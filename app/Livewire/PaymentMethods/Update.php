<?php

namespace App\Livewire\PaymentMethods;

use App\Models\PaymentMethod;
use Livewire\Attributes\Validate;
use Livewire\Component;

class Update extends Component
{
    public ?PaymentMethod $payment;

    #[Validate('required|string|max:256|regex:/^[\\pL\\s]+$/u')]
    public $name = '';

    public function mount(PaymentMethod $payment){
        $this->setPaymentMethod($payment);
    }
    public function setPaymentMethod(PaymentMethod $payment){
        $this->payment = $payment;
        $this->name = $payment->name;
    }

    public function update()
    {
        if (! auth()->user()?->isAdmin()) {
            abort(403);
        }

        $this->validate();
        
        $this->payment->update([
            'name' => $this->name,
        ]);
    }

     public function save()
    {
        $this->update();

        session()->flash('success', 'Método de pago actualizado correctamente.');
        $this->redirectRoute('paymentmethods.index', navigate:true);
    }

    public function render()
    {
        return view('livewire.payment-methods.create');
    }
}
