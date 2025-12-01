<?php

namespace App\Livewire\Products;

use App\Models\Product;
use Livewire\Attributes\Validate;
use Livewire\Component;


use App\Models\Category;
use App\Models\Measure;

class Create extends Component
{

    // Campos de búsqueda para categoría y medida
public string $categorySearch = '';
public string $categoryLabel  = '';
public array $categoryResults = [];

public string $measureSearch = '';
public string $measureLabel  = '';
public array $measureResults = [];

// Actualiza resultados cuando el usuario escribe en la caja de categoría
public function updatedCategorySearch()
{
    $this->categoryResults = Category::query()
        ->where('name', 'like', '%'.$this->categorySearch.'%')
        ->where('status', true)
        ->limit(5)
        ->get(['id','name'])
        ->toArray();
}

public function selectCategory(int $id, string $name)
{
    $this->category_id = $id;   // valor que se guardará
    $this->categoryLabel = $name;
    $this->categorySearch = $name; // mostrar el nombre elegido en el input
    $this->categoryResults = [];
}

// Actualiza resultados para unidad de medida
public function updatedMeasureSearch()
{
    $this->measureResults = Measure::query()
        ->where('name', 'like', '%'.$this->measureSearch.'%')
        ->where('status', true)
        ->limit(5)
        ->get(['id','name'])
        ->toArray();
}

public function selectMeasure(int $id, string $name)
{
    $this->measure_id = $id;            // id que se persiste
    $this->measureLabel = $name;
    $this->measureSearch = $name;       // pinta el nombre elegido en el input
    $this->measureResults = [];         // limpia la lista desplegable
}




    //-------------------------------------------------------------------------------------------------------------

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
