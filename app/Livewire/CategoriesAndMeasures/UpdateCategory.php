<?php

namespace App\Livewire\CategoriesAndMeasures;

use App\Models\Category;
use App\Models\Measure;
use Livewire\Attributes\Validate;
use Livewire\Component;

class UpdateCategory extends Component
{
    public ?Category $category;

    #[Validate('required|string|max:255')]
    public $name = '';
    #[Validate('required|exists:measures,id')]
    public $measure_id = null;
    #[Validate('boolean')]
    public $status = true;

    public string $measureSearch = '';
    public array $measureResults = [];


    public function mount(Category $category)
    {
        $this->setCategory($category);
    }

    public function setCategory (Category $category){
        $this->category = $category;
        $this->name = $category->name;
        $this->measure_id = $category->measure_id;
        $this->status = (bool) $category->status;
        $this->measureSearch = optional($category->measure)->name ?? '';
    }

    public function updatedMeasureSearch(): void
    {
        $this->measureResults = Measure::query()
            ->where('status', true)
            ->where('name', 'like', '%'.$this->measureSearch.'%')
            ->orderBy('name')
            ->limit(8)
            ->get(['id', 'name'])
            ->toArray();
    }

    public function selectMeasure(int $id, string $name): void
    {
        $this->measure_id = $id;
        $this->measureSearch = $name;
        $this->measureResults = [];
    }

    public function update()
    {
        $this->validate();
        
        $this->category->update([
            'name' => $this->name,
            'measure_id' => $this->measure_id,
            'status' => $this->status,
        ]);
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
