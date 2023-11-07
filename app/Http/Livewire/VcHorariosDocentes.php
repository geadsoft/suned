<?php

namespace App\Http\Livewire;
use App\Models\TmHorariosDocentes;

use Livewire\Component;

class VcHorariosDocentes extends Component
{
    public $tblrecords=[], $selectId;
    
    protected $listeners = ['setHorario','setDocente'];

    public function mount($horarioId){

        if ($horarioId>0){
            $this->setHorario($horarioId);
        }
        
    }
    
    public function render()
    {   
        return view('livewire.vc-horarios-docentes',[
            'tblrecords' => $this->tblrecords,
        ]);
    }

    public function add(TmHorariosDocentes $tblrecords){

        $record  = $tblrecords->toArray();
        $this->selectId = $record['id'];

        $this->dispatchBrowserEvent('show-form');
    }

    public function setHorario($horarioId){
        
        $this->horarioId    = $horarioId;
        $this->tblrecords = TmHorariosDocentes::where('horario_id',$this->horarioId)->get();
    
    }

    public function setDocente($id){
        
        $record = TmHorariosDocentes::find($this->selectId);
        $record->update([
            'docente_id' => $id,
        ]);

        $this->setHorario($this->horarioId);

    } 
    
}
