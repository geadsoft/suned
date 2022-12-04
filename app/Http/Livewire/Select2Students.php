<?php

namespace App\Http\Livewire;
use App\Models\TmPersonas;
use Livewire\Component;

class Select2Students extends Component
{
    public $students, $studentSelectedId, $studentSelectedName; 

    public function mount()
    {
      $this->students = [];
    }
    
    public function render()
    {
        $this->students = TmPersonas::orderBy('apellidos','asc')->get();

        return view('livewire.select2-students');
    }
}
