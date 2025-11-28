<?php

namespace App\Livewire\CategoriesAndMeasures;

use App\Models\Measure;
use Livewire\Attributes\Validate;
use Livewire\Component;

class CreateMeasure extends Component
{
    #[Validate('required|string|max:255')]
    public $name = '';

    public function save(){
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