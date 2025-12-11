<?php

namespace App\Livewire\CategoriesAndMeasures;

use Livewire\WithPagination;
use Livewire\Component;
use App\Models\Category;
use App\Models\Measure;

class Index extends Component
{
    use WithPagination;

    public function mount(): void
    {
        if (! auth()->user()?->isAdmin()) {
            abort(403);
        }
    }

    public function toggleCategoryStatus(Category $category)
    {
        if (! auth()->user()?->isAdmin()) {
            abort(403);
        }

        $category->status = ! $category->status;
        $category->save();

        $message = $category->status
            ? 'Categoria reactivada satisfactoriamente.'
            : 'Categoria inhabilitada satisfactoriamente.';

        session()->flash('success', $message);

        $this->redirectRoute('categoriesandmeasures.index', navigate: true);
    }

    public function toggleMeasureStatus(Measure $measure)
    {
        if (! auth()->user()?->isAdmin()) {
            abort(403);
        }

        $measure->status = ! $measure->status;
        $measure->save();

        $message = $measure->status
            ? 'Unidad de medida reactivada satisfactoriamente.'
            : 'Unidad de medida inhabilitada satisfactoriamente.';

        session()->flash('success', $message);

        $this->redirectRoute('categoriesandmeasures.index', navigate: true);
    }

    public function render()
    {
        return view('livewire.categories-and-measures.index', [

            'categories' => Category::latest()->paginate(10, pageName: 'categoriesPage'),
            'measures' => Measure::latest()->paginate(10, pageName: 'measuresPage'),
        ]);
    }
}
