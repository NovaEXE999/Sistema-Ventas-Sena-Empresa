<?php

namespace App\Livewire;

use App\Models\Product;
use Livewire\Component;

class SearchProducts extends Component
{
    public $products = [];
    public $searchTerm = '';
    public $selectedId = null;

    public function render()
    {
        return view('livewire.search-products');
    }

    public function search()
    {
        if (trim($this->searchTerm) === '') {
            $this->products = [];
            return;
        }

        $this->products = Product::where('name', 'LIKE', "%{$this->searchTerm}%")
            ->limit(8)
            ->get();
    }

    public function selectProduct($id)
    {
        $product = Product::find($id);

        $this->selectedId = $product->id;
        $this->searchTerm = $product->name;

        // 🔥 HIDE RESULTS IMMEDIATELY
        $this->products = [];
    }
}