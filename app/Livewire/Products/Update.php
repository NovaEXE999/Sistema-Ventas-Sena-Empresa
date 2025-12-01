<?php

namespace App\Livewire\Products;

use App\Models\Product;
use App\Models\Category;
use App\Models\Measure;
use Livewire\Attributes\Validate;
use Livewire\Component;

class Update extends Component
{
    public ?Product $product;

    // Campos para buscador interactivo
    public string $categorySearch = '';
    public string $categoryLabel = '';
    public array $categoryResults = [];

    public string $measureSearch = '';
    public string $measureLabel = '';
    public array $measureResults = [];

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

        // Precargar nombres en los inputs de búsqueda
        $this->categoryLabel = optional($product->category)->name ?? '';
        $this->categorySearch = $this->categoryLabel;
        $this->measureLabel = optional($product->measure)->name ?? '';
        $this->measureSearch = $this->measureLabel;
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

    // Buscador de categorías
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

    // Buscador de medidas
    public function updatedMeasureSearch(): void
    {
        $this->measureResults = Measure::query()
            ->where('name', 'like', '%'.$this->measureSearch.'%')
            ->where('status', true)
            ->limit(5)
            ->get(['id','name'])
            ->toArray();
    }

    public function selectMeasure(int $id, string $name): void
    {
        $this->measure_id = $id;
        $this->measureLabel = $name;
        $this->measureSearch = $name;
        $this->measureResults = [];
    }

    public function render()
    {
        return view('livewire.products.create');
    }
}
