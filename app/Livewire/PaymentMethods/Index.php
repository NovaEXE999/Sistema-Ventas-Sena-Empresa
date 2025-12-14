<?php

namespace App\Livewire\PaymentMethods;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\PaymentMethod;

class Index extends Component
{
    use WithPagination;

    public function mount(): void
    {
        if (! auth()->user()?->isAdmin()) {
            abort(403);
        }
    }

    public function toggleStatus(PaymentMethod $payment)
    {
        if (! auth()->user()?->isAdmin()) {
            abort(403);
        }

        $payment->status = ! $payment->status;
        $payment->save();

        $message = $payment->status
            ? 'Metodo de pago reactivado satisfactoriamente.'
            : 'Metodo de pago inhabilitado satisfactoriamente.';

        session()->flash('success', $message);
        $this->redirectRoute('paymentmethods.index', navigate: true);
    }

    public function render()
    {
        return view('livewire.payment-methods.index', [
            'payments'=> PaymentMethod::latest()->paginate(10)
        ]);
    }
}
