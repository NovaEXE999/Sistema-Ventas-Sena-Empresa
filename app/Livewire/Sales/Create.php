<?php

namespace App\Livewire\Sales;

use App\Models\Sale;
use Livewire\Attributes\Validate;
use Livewire\Component;

class Create extends Component
{
    #[Validate('required|numeric|min:0')]
    public $total_value = '';
    #[Validate('required|date')]
    public $date = '';
    #[Validate('required|exists:users,id')]
    public $user_id = '';
    #[Validate('required|exists:clients,id')]
    public $client_id = '';

    public function save(){
        $this->validate();

        Sale::create([
            'total_value' => $this->total_value,
            'date' => $this->date,
            'user_id' => $this->user_id,
            'client_id' => $this->client_id,
        ]);

        session()->flash('success', 'Venta creada satisfactoriamente.');
        $this->redirectRoute('sales.index', navigate:true);
    }
    public function render()
    {
        return view('livewire.sales.create');
    }
}
