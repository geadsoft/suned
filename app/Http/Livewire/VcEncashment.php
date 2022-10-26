<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\TmPersonas;
use App\Models\TrCobrosCabs;
use App\Models\TrCobrosDets;
use App\Models\TrDeudasCabs;
use App\Models\TmPeriodosLectivos;


class VcEncashment extends Component
{
    public $selectId;
    public $fila=1;
    public $documento;
    public $record;
    public $persona;
    public $idbuscar="";
    public $nombre="";

    public function render()
    { 
        
        $record  = TrCobrosCabs::orderBy('id', 'desc')->first();
        if ($record['id']=null){
            $this->selectId = 0;
        }else{
            $this->selectId = $record['id'];
        }

        $tblcobrodet = TrCobrosDets::where('cobrocab_id',$this->selectId)->get();
        $tbldeudas   = TrDeudasCabs::where('id',0)->get();
        $tblperiodos = TmPeriodosLectivos::all();

        return view('livewire.vc-encashment',[
            'record' => $record,
            'tblcobrodet' => $tblcobrodet,
            'tbldeudas' => $tbldeudas,
            'tblperiodos' => $tblperiodos,

        ]);
        
    }

    public function add(){

        /*$this->documento = $this -> record['documento'];*/
        $ldate = date('Y-m-d H:i:s');

        $this->idbuscar = "";
        $this->reset(['record']);
        $this->record['fecha']= date('d/m/Y',strtotime($ldate));
        $this->record['estudiante_id']= 0;
        $this->record['documento']= "";
        $this->record['concepto']= "";
        $this->record['monto']= 0;
        $this->record['estado']= "A";

        $this->search(1);
        
        /*$this->loadDetalle($tblniveles);*/
        /*$this->dispatchBrowserEvent('show-form');*/

    }

    public function search($tipo){

        if ($tipo=1){
            
            $this->persona   = TmPersonas::where('identificacion',$this->idbuscar)->first();     
            $tbldeudas = TrDeudasCabs::where('estudiante_id',$this->persona['id'])->get();
            $this->nombre = $this->persona['nombres'].' '.$this->persona['apellidos'];

           
            $this->emitTo('vc-encashment-debts','deudas',$this->persona['id']);

        }else{

        }

    }




}
