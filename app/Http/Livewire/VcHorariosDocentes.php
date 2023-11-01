<?php

namespace App\Http\Livewire;
use App\Models\TmHorariosDocentes;

use Livewire\Component;

class VcHorariosDocentes extends Component
{
    public $tblrecords=[];
    
    protected $listeners = ['setHorario'];
    
    public function render()
    {   
        return view('livewire.vc-horarios-docentes',[
            'tblrecords' => $this->tblrecords,
        ]);
    }

    public function setHorario($horarioId){
        $this->horarioId    = $horarioId;
        $this->tblrecords = TmHorariosDocentes::where('horario_id',$this->horarioId)->get();
    }

    

    
}