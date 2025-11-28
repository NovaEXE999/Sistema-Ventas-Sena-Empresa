<?php

namespace App\Livewire\Products;

use App\Models\Product;
use Livewire\Component;
use Livewire\WithPagination;


class Index extends Component
{
    use WithPagination;
  
    public $product;
    // Este proceso aquí realizado funciona cómo un Join. Plaga la variable producto junto a Categoria 
    // y medidas.
    public function mount(){
        $product = Product::with(['category', 'measure'])->get();
    }

    public function delete(Product $product)
    {
        $product->delete();

        session()->flash('success', 'Producto eliminado satisfactoriamente.');
        $this->redirectRoute('products.index', navigate: true);
    }

    public function render()
    {
        return view('livewire.products.index', [
            // 'products' => Product::simplePaginate(10),
            'products' => Product::latest()->paginate(10),
        ]);
    }
}
