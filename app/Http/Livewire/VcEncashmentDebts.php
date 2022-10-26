<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\TrDeudasCabs;

class VcEncashmentDebts extends Component
{

    public $fila=1;
    public $idestudiante=0;

    protected $listeners = ['deudas' => 'cargadeuda'];

    public function cargadeuda($idestudiante)
    {   

        $this->idestudiante = $idestudiante;
    
    }
    
    public function render()
    {   
        $tbldeudas   = TrDeudasCabs::where('estudiante_id',$this->idestudiante)->get();
        
        return view('livewire.vc-encashment-debts',[
            'tbldeudas' => $tbldeudas,
        ]);
       
    }


}
