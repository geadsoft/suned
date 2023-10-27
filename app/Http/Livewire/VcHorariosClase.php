<?php

namespace App\Http\Livewire;
use App\Models\TmAsignaturas;

use Livewire\Component;

class VcHorariosClase extends Component
{
    public $objdetalle, $filas, $horarioId, $detalle=[];
    
    public function mount($horarioId){

        $this->horarioId    = $horarioId;
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

    public function createData(){
        
        $this ->validate([
            'horarioId' => 'required',
        ]);

        foreach ($this->objdetalle as $key => $asignatura){
            $objdata = [];
            for ($col = 1; $col <= 5; $col++) {
                
                $objdata['horario_id'] = $this->horarioId;
                $objdata['linea'] = $key;
                $objdata['dia'] = $col;
                $objdata['asignatura_id'] = $asignatura[$col];
                $objdata['usuario'] = auth()->user()->name;
                array_push($this->detalle, $objdata);
            }
            
        }

        dd($this->detalle);

        /*TmGeneralidades::Create([
            'codigo' => $this -> codigo,
            'descripcion' => $this -> record['descripcion'],
            'superior' => $this -> superior,
            'estado' => $this -> record['estado'],
            'root' => $this -> record['root'],
            'usuario' => auth()->user()->name,
        ]);*/

        $this->dispatchBrowserEvent('hide-form', ['message'=> 'added successfully!']);  
        
    }

}
