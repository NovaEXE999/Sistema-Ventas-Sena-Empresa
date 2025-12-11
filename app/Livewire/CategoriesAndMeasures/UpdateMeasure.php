<?php

namespace App\Livewire\CategoriesAndMeasures;

use App\Models\Measure;
use Livewire\Attributes\Validate;
use Illuminate\Validation\Rule;
use Livewire\Component;

class UpdateMeasure extends Component
{
    public ?Measure $measure;

    public $name = '';
    public $status = true;

    protected function rules(): array
    {
        return [
            'name' => [
                'required',
                'max:256',
                'regex:/^[\\p{L} ]+$/u',
                Rule::unique('measures', 'name')->ignore($this->measure?->id),
            ],
            'status' => ['boolean'],
        ];
    }

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
