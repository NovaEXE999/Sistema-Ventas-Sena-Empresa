<?php

namespace App\Livewire\CategoriesAndMeasures;

use App\Models\Category;
use Livewire\Attributes\Validate;
use Livewire\Component;

class UpdateCategory extends Component
{
    public ?Category $category;

    #[Validate('required|string|max:255')]
    public $name = '';


    public function mount(Category $category)
    {
        $this->setCategory($category);
    }

    public function setCategory (Category $category){
        $this->category = $category;
        $this->name = $category->name;
    }

    public function update()
    {
        $this->validate();
        
        $this->category->update($this->all());
    }

     public function save()
    {
        $this->update();

        session()->flash('success', 'Categoria actualizada correctamente.');
        $this->redirectRoute('categoriesandmeasures.index', navigate:true);
    }

    public function render()
    {
        return view('livewire.categories-and-measures.create-category');
    }
}
