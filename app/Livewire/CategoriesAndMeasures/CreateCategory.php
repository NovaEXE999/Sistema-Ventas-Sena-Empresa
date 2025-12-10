<?php

namespace App\Livewire\CategoriesAndMeasures;

use App\Models\Category;
use App\Models\Measure;
use Illuminate\Validation\Rule;
use Livewire\Component;

class CreateCategory extends Component
{
    public $name = '';
    public $measure_id = null;

    public string $measureSearch = '';
    public array $measureResults = [];

    protected function rules(): array
    {
        return [
            'name' => ['required', 'max:256', 'regex:/^[\\p{L} ]+$/u', Rule::unique('categories', 'name')],
            'measure_id' => ['required', 'exists:measures,id'],
        ];
    }

    public function mount(): void
    {
        $this->measure_id = null;
        $this->measureSearch = '';
    }

    public function updatedMeasureSearch(): void
    {
        $this->measure_id = null;
        $this->resetErrorBag(['measureSearch', 'measure_id']);

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
        $this->resetErrorBag(['measureSearch', 'measure_id']);
    }

    public function hideMeasureResults(): void
    {
        $this->measureResults = [];
    }

    public function ensureMeasureSelected(): void
    {
        $this->measureResults = [];
        $this->resetErrorBag(['measure_id', 'measureSearch']);

        if (!$this->measure_id) {
            $this->addError('measure_id', 'Selecciona una unidad de la lista. Si no existe, regístrala en "Unidades de medida".');
        }
    }

    protected function messages(): array
    {
        return [
            'name.regex' => 'El nombre solo puede contener letras y espacios.',
            'measure_id.required' => 'Selecciona una unidad de la lista. Si no existe, regístrala en "Unidades de medida".',
            'measure_id.exists' => 'La unidad de medida no existe. Regístrala primero en "Unidades de medida".',
        ];
    }

    public function save(){
        if (! auth()->user()?->isAdmin()) {
            abort(403);
        }

        $this->validate();

        Category::create([
            'name' => $this->name,
            'measure_id' => $this->measure_id,
            'status' => true,
        ]);

        session()->flash('success', 'Categoria creada satisfactoriamente.');
        $this->redirectRoute('categoriesandmeasures.index', navigate:true);
    }

    public function render()
    {
        return view('livewire.categories-and-measures.create-category');
    }
}
