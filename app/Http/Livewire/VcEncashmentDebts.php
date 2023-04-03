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

    public function mount($personaid){
        $this->cargadeuda($personaid);
    }    

    public function cargadeuda($idestudiante)
    {   
        $this->idestudiante = $idestudiante;
    }
    
    public function render()
    {   
        $tbldeudas   = TrDeudasCabs::where('estudiante_id','=',$this->idestudiante)
        ->where('saldo','>',0)
        ->orderbyRaw("case when left(referencia,3) = 'MAT' then 1
        when left(referencia,3) = 'PLA' then 2
        when left(referencia,3) = 'PLI' then 2
        when left(referencia,3) = 'PLE' then 3
        else 4 end")
        ->get();

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
