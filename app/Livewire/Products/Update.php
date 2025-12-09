<?php

namespace App\Livewire\Products;

use App\Models\Product;
use App\Models\Category;
use Livewire\Attributes\Validate;
use Livewire\Component;

class Update extends Component
{
    public ?Product $product = null;

    // Buscador de categoría
    public string $categorySearch = '';
    public string $categoryLabel = '';
    public array $categoryResults = [];

    #[Validate('required|string|max:255')]
    public $name = '';
    #[Validate('required|integer|min:0|max:1000')]
    public $stock = 0;
    #[Validate('required|numeric|min:0|max:500000|regex:/^\\d{1,6}(\\.\\d{1,2})?$/')]
    public $price = 0;
    #[Validate('required|exists:categories,id')]
    public $category_id = null;
    #[Validate('boolean')]
    public $status = true;

    public function mount(Product $product)
    {
        $this->setProduct($product);
    }

    public function setProduct(Product $product): void
    {
        $this->product = $product;
        $this->name = $product->name;
        $this->stock = $product->stock;
        $this->price = $product->price;
        $this->category_id = $product->category_id;
        $this->status = (bool) $product->status;

        $this->categoryLabel = optional($product->category)->name ?? '';
        $this->categorySearch = $this->categoryLabel;
    }

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

    public function update()
    {
        if (! auth()->user()?->isAdmin()) {
            abort(403);
        }

        $this->validate();

        $this->product->update([
            'name' => $this->name,
            'stock' => $this->stock,
            'price' => $this->price,
            'category_id' => $this->category_id,
            'status' => $this->status,
        ]);
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
