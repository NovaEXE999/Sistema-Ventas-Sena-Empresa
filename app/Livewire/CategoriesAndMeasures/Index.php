<?php

namespace App\Livewire\CategoriesAndMeasures;

use Livewire\WithPagination;
use Livewire\Component;
use App\Models\Category;
use App\Models\Measure;

class Index extends Component
{
    use WithPagination;

    public function deleteCategory(Category $category)
    {
        $category->delete();

        session()->flash('success', 'Categoria eliminada satisfactoriamente.');
        $this->redirectRoute('categoriesandmeasures.index', navigate:true);
    }

    public function deleteMeasure(Measure $measure)
    {
        $measure->delete();

        session()->flash('success', 'Unidad de medida eliminada satisfactoriamente.');
        $this->redirectRoute('categoriesandmeasures.index', navigate: true);
    }

    public function render()
    {
        return view('livewire.categories-and-measures.index', [
            'categories' => Category::latest()->paginate(10, pageName: 'categoriesPage'),
            'measures' => Measure::latest()->paginate(10, pageName: 'measuresPage')
        ]);
    }
}