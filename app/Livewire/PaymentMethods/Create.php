<?php

namespace App\Livewire\PaymentMethods;

use Livewire\Attributes\Validate;
use Livewire\Component;
use App\Models\PaymentMethod;
use Illuminate\Validation\Rule;

class Create extends Component
{
    public $name = '';

    protected function rules(): array
    {
        return [
            'name' => ['required', 'max:256', 'regex:/^[\\p{L} ]+$/u', Rule::unique('payment_methods', 'name')],
        ];
    }
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
