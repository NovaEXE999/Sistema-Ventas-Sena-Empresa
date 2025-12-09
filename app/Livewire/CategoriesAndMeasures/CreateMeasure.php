<?php

namespace App\Livewire\CategoriesAndMeasures;

use App\Models\Measure;
use Illuminate\Validation\Rule;
use Livewire\Component;

class CreateMeasure extends Component
{
    public $name = '';

    protected function rules(): array
    {
        return [
            'name' => ['required', 'max:255', 'regex:/^[\\p{L} ]+$/u', Rule::unique('measures', 'name')],
        ];
    }

    public function save(){
        if (! auth()->user()?->isAdmin()) {
            abort(403);
        }

        $this->validate();

        Measure::create([
            'name' => $this->name,
        ]);

        session()->flash('success', 'Unidad de medida creada satisfactoriamente.');
        $this->redirectRoute('categoriesandmeasures.index', navigate:true);
    }

    public function render()
    {
        return view('livewire.categories-and-measures.create-measure');
    }
}
