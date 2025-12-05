<?php

namespace App\Livewire\Products;

use App\Models\Product;
use App\Models\Category;
use Livewire\Attributes\Validate;
use Livewire\Component;

class Create extends Component
{
    // Buscador de categoría
    public string $categorySearch = '';
    public string $categoryLabel = '';
    public array $categoryResults = [];

    #[Validate('required|string|max:255')]
    public $name = '';
    #[Validate('required|integer|min:0')]
    public $stock = 0;
    #[Validate('required|numeric|min:0')]
    public $price = 0;
    #[Validate('required|exists:categories,id')]
    public $category_id = null;
    #[Validate('boolean')]
    public $status = true;

    public function updatedCategorySearch(): void
    {
        $this->categoryResults = Category::query()
            ->where('name', 'like', '%'.$this->categorySearch.'%')
            ->where('status', true)
            ->limit(5)
            ->get(['id','name'])
            ->toArray();
    }

    public function selectCategory(int $id, string $name): void
    {
        $this->category_id = $id;
        $this->categoryLabel = $name;
        $this->categorySearch = $name;
        $this->categoryResults = [];
    }

    public function save()
    {
        $this->validate();

        Product::create([
            'name' => $this->name,
            'stock' => $this->stock,
            'price' => $this->price,
            'category_id' => $this->category_id,
            'status' => $this->status,
        ]);

        session()->flash('success', 'Producto creado satisfactoriamente.');
        $this->redirectRoute('products.index', navigate:true);
    }

    public function render()
    {
        return view('livewire.products.create');
    }
}
