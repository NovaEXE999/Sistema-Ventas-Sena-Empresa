<?php

namespace App\Livewire\CategoriesAndMeasures;

use App\Models\Category;
use App\Models\Measure;
use Livewire\Attributes\Validate;
use Livewire\Component;

class CreateCategory extends Component
{
    #[Validate('required|string|max:255')]
    public $name = '';
    #[Validate('required|exists:measures,id')]
    public $measure_id = null;
    #[Validate('boolean')]
    public $status = true;

    public string $measureSearch = '';
    public array $measureResults = [];

    public function mount(): void
    {
        $first = Measure::where('status', true)->orderBy('name')->first();
        if ($first) {
            $this->measure_id = $first->id;
            $this->measureSearch = $first->name;
        }
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

    public function save(){
        $this->validate();

        Category::create([
            'name' => $this->name,
            'measure_id' => $this->measure_id,
            'status' => $this->status,
        ]);

        session()->flash('success', 'Categoria creada satisfactoriamente.');
        $this->redirectRoute('categoriesandmeasures.index', navigate:true);
    }

    public function render()
    {
        return view('livewire.categories-and-measures.create-category');
    }
}
