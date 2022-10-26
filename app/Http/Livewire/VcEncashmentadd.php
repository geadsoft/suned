<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\TmPersonas;
use App\Models\TrCobrosCabs;
use App\Models\TrCobrosDets;
use App\Models\TrDeudasDets;
use App\Models\TmPeriodosLectivos;
use App\Models\TmGeneralidades;

class VcEncashmentadd extends Component
{
    public $selectId;
    public $fila=1;
    public $documento;
    public $record;
    public $persona;
    public $idbuscar="";
    public $nombre="";
    public $fecha;
    public $monto=0;

    protected $listeners = ['postAdded'];

    public function render()
    {   
                
        $record  = TrCobrosCabs::find(0);
        $tblperiodos = TmPeriodosLectivos::all();
        $tblentidads = TmGeneralidades::where('superior',4)->get();

        $this->add();

        return view('livewire.vc-encashmentadd',[
            'record' => $record,
            'tblperiodos' => $tblperiodos,
            'tblentidads' => $tblentidads,
        ]);
        
    }

    public function add(){
        
        $ldate = date('Y-m-d H:i:s');
        $this->fecha = date('Y-m-d',strtotime($ldate));

        $this->reset(['record']);
        $this->record['fecha']= $this->fecha;
        $this->record['estudiante_id']= 1;
        $this->record['documento']= "";
        $this->record['concepto']= "";
        $this->record['monto']= 0;  
        $this->record['estado']= 'P';

    }


    public function createData(){
        
        $this ->validate([
            'record.fecha' => 'required',
            'record.estudiante_id' => 'required',
            'record.monto' => 'required',
        ]);
        
        $this->dispatchBrowserEvent('save-det');
  
    }


    public function postAdded($objPago=Null)
    {
        dd($objPago);

        TrCobrosCabs::Create([
            'fecha' => $this -> fecha,
            'periodo_id' => $this -> record['periodo_id'],
            'estudiante_id' => $this -> record['estudiante_id'],
            'monto' => $this -> record['monto'],
            'usuario' => auth()->user()->name,
            'estado' => "P",
        ]);

        $tblrecibo = TrCobrosCabs::orderBy('id', 'desc')->first();
        $this->selectId = $tblrecibo['id'];
        $this->monto = $tblrecibo['monto'];

        foreach ($objPago as $detalle)
        {
            
            TrCobrosDets::Create([
            'cobrocab_id' =>  $this->selectId,  
            'tipopago' => $detalle['tipopago'],
            'entidad_id' => $detalle['entidadid'],
            'numero' => $detalle['numero'],
            'valor' => $detalle['valor'],
            'estado' => "P",
            'usuario' => auth()->user()->name,
            ]);
            
        } 
        
        /*foreach ($objDeuda as $detalle)
        {
            $valor = $detalle['saldo'];
           
            if ($this->monto>$valor){
                $this->monto = $this->monto-$valor;
            }else{
                $valor = $this->monto;
            }

            TrCobrosDets::Create([
                'deudacab_id' =>  $detalle ['deudaid'],  
                'cobrocab_id' => $this->selectId,
                'fecha' => $this -> fecha,
                'detalle' => $detalle['detalle'],
                'tipo' => "PAG",
                'referencia' => "",
                'tipovalor' => "CR",
                'valor' => $this->valor,
                'estado' => "P",
                'usuario' => auth()->user()->name,
                ]);   
        }*/
        
        return redirect()->to('/financial/encashment');

    }


    public function search($tipo){

        if ($tipo=1){
            
            $this->persona   = TmPersonas::where('identificacion',$this->idbuscar)->first();     
            $this->nombre = $this->persona['nombres'].' '.$this->persona['apellidos'];

            $this->record['estudiante_id'] = $this->persona['id'];
            $this->record['monto'] = 100;
           
            $this->emitTo('vc-encashment-debts','deudas',$this->persona['id']);

        }else{

        }

    }
}
