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
use App\Models\TmMatricula;

class VcEncashmentadd extends Component
{
    public $selectId=0;
    public $documento;
    public $record;
    public $persona;
    public $idbuscar="";
    public $nombre="";
    public $periodo_id;
    public $fecha, $fechapago;
    public $secuencia=0;
    public $tblCobro, $objPago=[];
    public $estudiante_id=0, $grupo, $curso, $concepto, $comentario, $matricula_id, $nromatricula;
    public $tipopago='EFE', $entidadbco=0, $entidadtar=0, $valor=0, $referencia='', $cancela=0;

    public $totalPago = 0;
    public $valpago   = 0;
    public $despago   = 0;
    
    protected $listeners = ['postAdded','setCedula'];

    public function mount($periodoid,$matriculaid){

        $ldate = date('Y-m-d H:i:s');
        $this->fecha = date('Y-m-d',strtotime($ldate));
        $this->fechapago = date('Y-m-d',strtotime($ldate));


        $tblmatricula  = TmMatricula::find($matriculaid);
        $tblpersona    = TmPersonas::find($tblmatricula['estudiante_id']);

        $this->idbuscar      = $tblpersona['identificacion'];
        $this->periodo_id    = $periodoid;
        $this->estudiante_id = $tblpersona['id'];
        $this->matricula_id  = $matriculaid;
        $this->nromatricula  = $tblmatricula['documento'];

        $this->add();
        $this->search(1);
          
    }


    public function render()
    {   
                
        $record  = TrCobrosCabs::find(0);
        $tblperiodos = TmPeriodosLectivos::orderBy("periodo","desc")->get();
        $tblentidads = TmGeneralidades::where('superior',6)->get();
        $tbltarjetas = TmGeneralidades::where('superior',8)->get();

        return view('livewire.vc-encashmentadd',[
            'record' => $record,
            'tblperiodos' => $tblperiodos,
            'tblentidads' => $tblentidads,
            'tbltarjetas' => $tbltarjetas,
        ]);
        
    }

    public function add(){
        
        $this->reset(['record']);
        $this->record['fecha']= $this->fecha;
        $this->record['estudiante_id']= $this->estudiante_id;;
        $this->record['documento']= "";
        $this->record['concepto']= "";
        $this->record['monto']= 0;  
        $this->record['estado']= 'P';

    }


    public function createData(){

        $this->record['fecha'] = $this->fecha;
        $this->record['fechapago'] = $this->fechapago;
        $this->dispatchBrowserEvent('save-det');

    }

    public function addPago(){

        if ($this->valor==0){
            return;
        }

        $idEntidad = 32;

        if ($this->entidadbco>0){
            $idEntidad = $this->entidadbco;
        }
        
        if ($this->entidadtar>0){
            $idEntidad = $this->entidadtar;
        }

        $entidad = TmGeneralidades::find($idEntidad);

        $detpago = [];
        $detpago['tipopago']   = $this->tipopago;
        $detpago['entidadid']  = $idEntidad;
        $detpago['numero']     = '';
        $detpago['valor']      = $this->valor;
        $detpago['referencia'] = $this->referencia;

        if ($idEntidad>0){
            $detpago['detalle']    = $entidad['descripcion'].' '.$this->referencia;
        }
        

        $this->cancela = $this->cancela+floatval($this->valor);

        array_push($this->objPago, $detpago);
        $this->tipopago='EFE';
        $this->entidadbco=0;
        $this->entidadtar=0;
        $this->valor=0;
        $this->referencia='';

    }

    public function deletePago($row){

        $recnoToDelete = $this->objPago;
        foreach ($recnoToDelete as $index => $recno)
        {
            if ($index == $row){
                $this->cancela = $this->cancela-floatval($recno['valor']);
                unset ($recnoToDelete[$index]);
            } 
        }

        $this->reset(['objPago']);
        $this->objPago = $recnoToDelete;

    }

    public function validapago($objDeuda){

        $pago  = 0;
        $monto = 0;
        foreach ($objDeuda as $deuda)
        {
            $monto += floatval($deuda['valpago']);
        }

        if ($this->cancela>$monto){
            return true ; 
        }else{
            return false ; 
        }

    }

    public function postAdded($objDeuda=null)
    {

        if ($this->validapago($objDeuda)){
            $this->dispatchBrowserEvent('msg-pago');
            return;
        }

        foreach ($this->objPago as $pago)
        {
            $this->totalPago += $pago['valor'];
        }    

        if ($this->totalPago==0){ 
            return;
        }
        
        $this->record['monto']= $this->totalPago;
        
        $this ->validate([
            'record.fecha' => 'required',
            'record.estudiante_id' => 'required',
            'record.monto' => 'required',
        ]);
        

        $comentario = "";
        $this->tblCobro = TrCobrosCabs::orderBy('id', 'desc')->first();

        /*if ($this->tblCobro==null){
            $this->secuencia = 1;  
        } else {  
            $this->secuencia = intval($this->tblCobro['documento'])+1;
        }*/

        /*-- Begin Registro de Recibo */
        $pLectivo        = TmPeriodosLectivos::find($this->periodo_id);
        $this->secuencia = $pLectivo['num_recibo']+1;

        $this->document = str_pad($this->secuencia, 7, "0", STR_PAD_LEFT);
        
        TrCobrosCabs::Create([
            'fecha' => $this -> record['fecha'],
            'estudiante_id' => $this -> record['estudiante_id'],
            'matricula_id' =>  $this->matricula_id,
            'tipo' => "CP",
            'documento' => $this -> document,
            'fechapago' => $this -> record['fechapago'],
            'concepto' => 'Gestión de Cobro - Recibo No. '.$this -> document, 
            'monto' => $this -> record['monto'],
            'usuario' => auth()->user()->name,
            'estado' => "P",
        ]);

        $pLectivo['num_recibo'] = $this->secuencia;
        $pLectivo->update();
        /* End Registro Recibo --*/

        $this->tblCobro = TrCobrosCabs::orderBy("id", "desc")->first();
        $this->selectId = $this->tblCobro['id'];
                
        foreach ($this->objPago as $pago)
        {
            
            TrCobrosDets::Create([
            'cobrocab_id' =>  $this->selectId,  
            'tipopago' => $pago['tipopago'],
            'entidad_id' => $pago['entidadid'],
            'referencia' => $pago['referencia'],
            'numero' => $pago['numero'],
            'cuenta' => "",
            'valor' => $pago['valor'],
            'estado' => "P",
            'usuario' => auth()->user()->name,
            ]);
            
        } 
       
        foreach ($objDeuda as $deuda)
        {
            $this->valpago = floatval($deuda['valpago']);
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
                    'fecha' => $this -> record['fecha'],
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
                'descuento' => $tbldeuda['descuento']+($this->despago), 
                'credito' => $tbldeuda['credito']+($this->valpago+$this->despago),
                'saldo' => $tbldeuda['saldo']-($this->valpago+$this->despago),
            ]); 
        
        }
        
        return redirect()->to('/financial/encashment');
    }

    public function setCedula($data){
        
        $this->idbuscar = $data;
        $this->search(1);
    }
    
    public function search($tipo){


        if ($tipo=1){
            
            $this->persona   = TmPersonas::where('identificacion',$this->idbuscar)->first(); 
            
            
            if (  $this->persona != null) {

                $this->nombre    = $this->persona['nombres'].' '.$this->persona['apellidos'];
                $this->estudiante_id = $this->persona['id'];

                $matricula = TmMatricula::join("tm_cursos","tm_matriculas.curso_id","=","tm_cursos.id")
                ->join("tm_servicios","tm_cursos.servicio_id","=","tm_servicios.id")
                ->join("tm_generalidades","tm_servicios.modalidad_id","=","tm_generalidades.id")
                ->where("tm_matriculas.id",$this->matricula_id)
                ->select('tm_generalidades.descripcion AS nomGrupo', 'tm_servicios.descripcion AS nomGrado', 'tm_cursos.paralelo', 'tm_matriculas.comentario')
                ->first();
                   
                if($matricula!=null){
                    $this->grupo = $matricula['nomGrupo'];
                    $this->curso = $matricula['nomGrado']." - ".$matricula['paralelo'];
                    $this->comentario = $matricula['comentario'];
                }
                                                
                $this->emitTo('vc-encashment-debts','deudas',$this->persona['id']);

            } else {

                $this->dispatchBrowserEvent('show-message');

            }

        }else{

        }

    }

    

}
