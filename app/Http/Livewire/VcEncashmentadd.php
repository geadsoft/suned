<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\TmPersonas;
use App\Models\TrCobrosCabs;
use App\Models\TrCobrosDets;
use App\Models\TrDeudasCabs;
use App\Models\TrDeudasDets;
use App\Models\TmPeriodosLectivos;
use App\Models\TmGeneralidades;

class VcEncashmentadd extends Component
{
    public $selectId=0;
    public $documento;
    public $record;
    public $persona;
    public $idbuscar="";
    public $nombre="";
    public $periodo;
    public $fecha;
    public $secuencia=0;
    public $tblCobro;
    public $estudiante_id=0;

    public $totalPago = 0;
    public $valpago   = 0;
    public $despago   = 0;
    
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
        $this->record['estudiante_id']= $this->estudiante_id;;
        $this->record['documento']= "";
        $this->record['concepto']= "";
        $this->record['monto']= 0;  
        $this->record['estado']= 'P';

    }


    public function createData(){
               
        $this->dispatchBrowserEvent('save-det');
    }

    public function postAdded($objDeuda=null,$objPago=null)
    {
        
        foreach ($objPago as $pago)
        {
            $this->totalPago += $pago['valor'];
        }    

        $this->record['monto']= $this->totalPago;
        
        $this ->validate([
            'record.fecha' => 'required',
            'record.estudiante_id' => 'required',
            'record.monto' => 'required',
        ]);
        

        $comentario = "";
        $this->tblCobro = TrCobrosCabs::orderBy('id', 'desc')->first();

        if ($this->tblCobro==null){
            $this->secuencia = 1;  
        } else {  
            $this->secuencia = intval($this->tblCobro['documento'])+1;
        }

        $this->document = str_pad($this->secuencia, 7, "0", STR_PAD_LEFT);
        
        TrCobrosCabs::Create([
            'fecha' => $this -> fecha,
            'estudiante_id' => $this -> record['estudiante_id'],
            'documento' => $this -> document,
            'concepto' => 'Gestión de Cobro - Recibo No. '.$this -> document, 
            'monto' => $this -> record['monto'],
            'usuario' => auth()->user()->name,
            'estado' => "P",
        ]);

        $this->tblCobro = TrCobrosCabs::orderBy("id", "desc")->first();
        $this->selectId = $this->tblCobro['id'];
                
        foreach ($objPago as $pago)
        {
            
            TrCobrosDets::Create([
            'cobrocab_id' =>  $this->selectId,  
            'tipopago' => $pago['tipopago'],
            'entidad_id' => $pago['entidadid'],
            'institucion' => "",
            'numero' => $pago['numero'],
            'cuenta' => "",
            'valor' => $pago['valor'],
            'estado' => "P",
            'usuario' => auth()->user()->name,
            ]);
            
        } 
       
        foreach ($objDeuda as $deuda)
        {
            $this->valpago = floatval($deuda['saldo']);
            $this->despago = floatval($deuda['desct']);
           
            if ($this->totalPago>$this->valpago){
                $this->totalPago = $this->totalPago-$this->valpago;
            }else{
                $this->valpago = $this->totalPago;
            }

            TrDeudasDets::Create([
                'deudacab_id' =>  $deuda ['id'],  
                'cobro_id' => $this->selectId,
                'fecha' => $this -> fecha,
                'detalle' => $deuda['detalle'],
                'tipo' => "PAG",
                'referencia' => $this->document,
                'tipovalor' => "CR",
                'valor' => $this->valpago,
                'estado' => "P",
                'usuario' => auth()->user()->name,
                ]);
            
            if ($this->despago>0){

                TrDeudasDets::Create([
                    'deudacab_id' =>  $deuda['id'],  
                    'cobro_id' => $this->selectId,
                    'fecha' => $this -> fecha,
                    'detalle' => $deuda['detalle'],
                    'tipo' => "DES",
                    'referencia' => $this->document,
                    'tipovalor' => "CR",
                    'valor' => $this->despago,
                    'estado' => "P",
                    'usuario' => auth()->user()->name,
                    ]);
            }

            $tbldeuda = TrDeudasCabs::find($deuda['id']);
            $tbldeuda->update([
                'credito' => $tbldeuda['credito']+($this->valpago+$this->despago),
                'saldo' => $tbldeuda['saldo']-($this->valpago+$this->despago),
            ]); 
        
        }
        
        return redirect()->to('/financial/encashment');
    }

    
    public function search($tipo){

        if ($tipo=1){
            
            $this->persona   = TmPersonas::where('identificacion',$this->idbuscar)->first();     
            $this->nombre    = $this->persona['nombres'].' '.$this->persona['apellidos'];
            $this->estudiante_id = $this->persona['id'];
                                               
            $this->emitTo('vc-encashment-debts','deudas',$this->persona['id']);

        }else{

        }

    }
}
