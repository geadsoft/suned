<?php

namespace App\Http\Livewire;
use App\Models\TmDomicilioEstudiantes;

use Livewire\Component;

class VcPersonDirection extends Component
{
    
    public $estudianteId;
    public $showEditModal=false;
    public $record;
    public $ldireccion, $lunes, $martes, $miercoles, $jueves, $viernes, $sabado, $domingo;


    public function mount(){
        
        $this->estudianteId = 0;

    }
    
    public function render()
    {
        $tblrecords = TmDomicilioEstudiantes::where('',$this->estudianteId);

        return view('livewire.vc-person-direction',[
            'tblrecords' => $tblrecords,
        ]);
    }

    public function add(){
        
        $this->showEditModal = false;
        $this->emitTo('vc-personadd','modalDirection');

    }

    public function edit(TmGeneralidades $tblrecords ){
        
        $this->showEditModal = true;
        $this->record  = $tblrecords->toArray();
       
        $this->selectId = $this -> record['id'];
        $this->dispatchBrowserEvent('show-form');

    }
    
}
