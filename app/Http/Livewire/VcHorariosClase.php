<?php

namespace App\Http\Livewire;
use App\Models\TmAsignaturas;

use Livewire\Component;

class VcHorariosClase extends Component
{
    public $objdetalle, $filas;
    
    public function mount(){

        $this->tblmaterias  = TmAsignaturas::all();
        $this->filas = 5;
        $this->newdetalle();
    
    }

    public function render()
    {
        return view('livewire.vc-horarios-clase');
    }

    public function newdetalle(){

        $this->objdetalle = [];

        for ($i = 1; $i <= $this->filas; $i++) {
            $horario = [];
            for ($col = 1; $col <= 5; $col++) {
                $horario[$col] = "";
            }
            array_push($this->objdetalle, $horario);
        } 
    }

}
