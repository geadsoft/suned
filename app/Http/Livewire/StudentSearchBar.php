<?php

namespace App\Http\Livewire;

use App\Models\TmPersonas;
use Livewire\Component;

class StudentSearchBar extends Component
{
    public $query;
    public $students;
    public $highlightIndex;

    public function mount(){

        $this->borrar();
    }

    public function borrar(){

        $this->query = "";
        $this->students = [];
        $this->highlightIndex = 0;
    }

    public function incrementHighlight()
    {
        if ($this->highlightIndex === count($this->students) - 1) {
            $this->highlightIndex = 0;
            return;
        }
        $this->highlightIndex++;
    }
 
    public function decrementHighlight()
    {
        if ($this->highlightIndex === 0) {
            $this->highlightIndex = count($this->students) - 1;
            return;
        }
        $this->highlightIndex--;
    }
 
    public function selectStudent()
    {   
        
        $student = $this->students[$this->highlightIndex] ?? null;
        $cedula  = $student['identificacion'];
        $this->borrar();
        $this->emitTo('vc-encashmentadd','setCedula',$cedula);


        //if ($student) {
        //    $this->redirect(url("show-student/{$student['id']}"));
        //}

    }

    public function updatedQuery(){
        
        $this->students = TmPersonas::where('nombres','like','%'.$this->query.'%')
        ->orWhere('apellidos','like','%'.$this->query.'%')
        ->get()
        ->toArray();

    }

    
    public function render()
    {
        return view('livewire.student-search-bar');
    }
}
