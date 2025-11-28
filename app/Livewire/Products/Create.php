<?php

namespace App\Livewire\Products;

use App\Models\Product;
use Livewire\Attributes\Validate;
use Livewire\Component;

class Create extends Component
{
    #[Validate('required|string|max:255')]
    public $name = '';
    #[Validate('required|integer|min:0')]
    public $quantity = '';
    #[Validate('required|numeric|min:0')]
    public $price = '';
    #[Validate('required|exists:categories,id')]
    public $category_id = '';
    #[Validate('required|exists:measures,id')]
    public $measure_id = '';

    public function save()
    {
        $this->validate();

        Product::create([
            'name' => $this->name,
            'quantity' => $this->quantity,
            'price' => $this->price,
            'category_id' => $this->category_id,
            'measure_id' => $this->measure_id,
        ]);

        session()->flash('success', 'Producto creado satisfactoriamente.');
        $this->redirectRoute('products.index', navigate:true);
    }
    public function render()
    {
        return view('livewire.products.create');
    }
}
