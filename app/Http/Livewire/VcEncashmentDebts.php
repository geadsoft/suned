<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\TrDeudasCabs;

class VcEncashmentDebts extends Component
{

    public $fila=1;
    public $idestudiante=0;
    public $iddeuda=0;
    public array $deudas = [];

    protected $listeners = ['deudas' => 'cargadeuda'];

    public function cargadeuda($idestudiante)
    {   
        $this->idestudiante = $idestudiante;
    }
    
    public function render()
    {   
        $tbldeudas   = TrDeudasCabs::where('estudiante_id','=',$this->idestudiante)->where('saldo','>',0)->get();

        return view('livewire.vc-encashment-debts',[
            'tbldeudas' => $tbldeudas,
        ]);
    }


    public function selectdeuda($selectId)
    {
        $this->iddeuda = $selectId;
        /*$this->emitTo('vc-encashment','selects',$this->iddeuda);*/
        $this->emitUp('postAdded',$this->iddeuda,0,0);        
    }
}
