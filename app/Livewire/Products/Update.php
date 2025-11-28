<?php

namespace App\Livewire\Products;

use App\Models\Product;
use Livewire\Attributes\Validate;
use Livewire\Component;

class Update extends Component
{
    public ?Product $product;

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

    public function mount(Product $product)
    {
        $this->setProduct($product);
    }

    public function setProduct(Product $product)
    {
        $this->product = $product;
        $this->name = $product->name;
        $this->quantity = $product->quantity;
        $this->price = $product->price;
        $this->category_id = $product->category_id;
        $this->measure_id = $product->measure_id;
    }

    public function update()
    {
        $this->validate();
        
        $this->product->update($this->all());
    }

    public function save()
    {
        $this->update();

        session()->flash('success', 'Producto actualizado correctamente.');
        $this->redirectRoute('products.index', navigate:true);
    }
    public function render()
    {
        return view('livewire.products.create');
    }
}
