<?php

namespace App\Livewire\Providers;

use Livewire\Attributes\Validate;
use Livewire\Component;
use App\Models\Provider;


class Update extends Component
{
    public ?Provider $provider;

    #[Validate('required|string|max:255')]
    public $name = '';


    public function mount(Provider $provider){
        $this->setProvider($provider);
    }

    public function setProvider(Provider $provider){
        $this->provider = $provider;
        $this->name = $provider->name;
    }

    public function update(){
        $this->validate();
        
        $this->provider->update($this->all());
    }
    
    public function save(){
        $this->update();

        session()->flash('success', 'Proveedor actualizado satisfactoriamente.');
        $this->redirectRoute('providers.index', navigate:true);
    }

    public function render()    
    {
        return view('livewire.providers.create');
    }
}
