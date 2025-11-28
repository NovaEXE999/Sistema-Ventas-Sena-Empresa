<?php

namespace App\Livewire\CategoriesAndMeasures;

use App\Models\Category;
use Livewire\Attributes\Validate;
use Livewire\Component;

class CreateCategory extends Component
{
    #[Validate('required|string|max:255')]
    public $name = '';

    public function save(){
        $this->validate();

        Category::create([
            'name' => $this->name,
        ]);

        session()->flash('success', 'Categoria creada satisfactoriamente.');
        $this->redirectRoute('categoriesandmeasures.index', navigate:true);
    }

    public function render()
    {
        return view('livewire.categories-and-measures.create-category');
    }
}
