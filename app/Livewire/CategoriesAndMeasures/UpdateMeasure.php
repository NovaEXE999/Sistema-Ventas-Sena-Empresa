<?php

namespace App\Livewire\CategoriesAndMeasures;

use App\Models\Measure;
use Livewire\Attributes\Validate;
use Livewire\Component;

class UpdateMeasure extends Component
{
    public ?Measure $measure;

    #[Validate('required|string|max:255')]
    public $name = '';


    public function mount(Measure $measure)
    {
        $this->setMeasure($measure);
    }

    public function setMeasure (Measure $measure){
        $this->measure = $measure;
        $this->name = $measure->name;
    }

    public function update()
    {
        if (! auth()->user()?->isAdmin()) {
            abort(403);
        }

        $this->validate();
        
        $this->measure->update($this->all());
    }

     public function save()
    {
        $this->update();

        session()->flash('success', 'Unidad de medida actualizada correctamente.');
        $this->redirectRoute('categoriesandmeasures.index', navigate:true);
    }

    public function render()
    {
        return view('livewire.categories-and-measures.create-measure');
    }
}
