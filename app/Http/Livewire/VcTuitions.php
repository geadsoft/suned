<?php

namespace App\Http\Livewire;
use App\Models\TmPeriodosLectivos;
use App\Models\TmGeneralidades;
use App\Models\TmPersonas;
use App\Models\TmMatricula;
use App\Models\TmServicios;
use App\Models\TmCursos;
use App\Models\TrDeudasCabs;
use App\Models\TrDeudasDets;
use App\Models\TrCobrosCabs;
use App\Models\TrCobrosDets;
use App\Models\TmPensionesDet;

use Livewire\Component;
use Livewire\WithPagination;

class VcTuitions extends Component
{
    use WithPagination;
    public $showEditModal = false;
    public $selectId = 0;
    public $previus='', $current='', $nomnivel, $nomcurso, $fecha, $documento, $alumno;
    public $filterdata='M', $trDeudasCabs;
    public $tblcursos=null;
    public $tblservicios=null;
    public $tbldatogen=null;
    public $estudianteId,$periodoId,$grupoId,$nivelId,$gradoId,$cursoId,$numreg,$matriculaId;
    public $tblmontos,$valorpen,$estado;

    public $meses = [ 
        1 => 'ENE',
        2 => 'FEB',
        3 => 'MAR',
        4 => 'ABR',
        5 => 'MAY',
        6 => 'JUN',
        7 => 'JUL',
        8 => 'AGO',
        9 => 'SEP',
        10 => 'OCT',
        11 => 'NOV',
        12 => 'DIC'];

    public $filters = [
        'srv_periodo' => '',
        'srv_grupo' => '',
        'srv_nombre' => '',
        'srv_estado' => 'A',
    ];
    
    protected $listeners = ['setData'];

    public function render()
    {
        
        if ($this->filterdata=='M'){

            $tblrecords = TmPersonas::query()
            ->join("tm_matriculas as m","tm_personas.id","=","m.estudiante_id")
            ->join("tm_cursos as c","c.id","=","m.curso_id")
            ->join("tm_servicios as s","s.id","=","c.servicio_id")
            ->join("tm_periodos_lectivos as p","p.id","=","m.periodo_id")
            ->join("tm_generalidades as g","g.id","=","m.modalidad_id")
            ->when($this->filters['srv_nombre'],function($query){
                return $query->whereRaw("concat(tm_personas.apellidos,' ',tm_personas.nombres) LIKE '%".$this->filters['srv_nombre']."%'");
            })
            ->when($this->filters['srv_periodo'],function($query){
                return $query->where('m.periodo_id',"{$this->filters['srv_periodo']}");
            })
            ->when($this->filters['srv_grupo'],function($query){
                return $query->where('m.modalidad_id',"{$this->filters['srv_grupo']}");
            })
            ->where('tm_personas.estado',$this->filters['srv_estado'])
            ->select('m.id','identificacion','nombres','apellidos', 'documento', 'fecha', 'g.descripcion as nomgrupo','p.descripcion as nomperiodo',
            's.descripcion as nomgrado','c.paralelo','m.periodo_id','m.modalidad_id','m.nivel_id','c.servicio_id','m.curso_id','m.estudiante_id')
            ->orderBy('documento','desc')
            ->paginate(10);

        
        } else{
            
            $tblrecords = TmPersonas::query()
            ->when($this->filters['srv_nombre'],function($query){
                return $query->where('tm_personas.nombres','LIKE','%'."{$this->filters['srv_nombre']}".'%')
                            ->orWhere('tm_personas.apellidos','LIKE','%'."{$this->filters['srv_nombre']}".'%');
            })
            ->where('tm_personas.tipopersona','=','E')
            ->select('identificacion','nombres','apellidos')
            ->orderBy('apellidos','asc')
            ->paginate(10);            
            
        }

        $tblgenerals = TmGeneralidades::where('superior',1)->get();
        $tblperiodos = TmPeriodosLectivos::orderBy("periodo","desc")->get();
        $this->tblservicios = TmServicios::all();
        $this->tblcursos    = TmCursos::all();
        $this->tbldatogen   = TmGeneralidades::all();
        
        return view('livewire.vc-tuitions',[
            'tblrecords' => $tblrecords,
            'tblgenerals' => $tblgenerals,
            'tblperiodos' => $tblperiodos
        ]);

    }    

  
    public function paginationView(){
        return 'vendor.livewire.bootstrap'; 
    }

    public function updatedEstado(){

        $this->filters['srv_estado']  = 'A';

        if ($this->estado){
            $this->filters['srv_estado']  = 'R';
        }
    }

    public function edit($objData){
        
        $this->record  = $objData;
        $this->selectId = $this->record['id'];
        $this->nomnivel = $this->record['nomgrupo'];
        $this->nomcurso = $this->record['nomgrado'].' - '.$this->record['paralelo'];
        $this->documento = $this->record['documento'];
        
        $this->estudianteId = $this -> record['estudiante_id'];
        $this->periodoId    = $this -> record['periodo_id'];
        $grupoId = $this -> record['modalidad_id'];
        $nivelId = $this -> record['nivel_id'];
        $gradoId = $this -> record['servicio_id'];
        $cursoId = $this -> record['curso_id'];

        $this->tblmontos = TmPensionesDet::join("tm_pensiones_cabs","tm_pensiones_cabs.id","=","tm_pensiones_dets.pension_id")
        ->where([
                ['tm_pensiones_cabs.periodo_id',$this -> record['periodo_id']],
                ['tm_pensiones_cabs.modalidad_id',$this -> record['modalidad_id']],
                ['tm_pensiones_dets.nivel_id',$this -> record['nivel_id']],
            ])->first();
        
        $this->valorpen = $this->tblmontos['pension'];
        
        $this->dispatchBrowserEvent('show-form');
        $this->emitTo('vc-modal-sections','setSection',$this->periodoId,$grupoId,$nivelId,$gradoId,$cursoId );

    }

    public function updateData(){

        $this->dispatchBrowserEvent('get-data');
        
    }

    public function delete($selectId){

        $matricula = TmMatricula::find($selectId);
        $this->documento = $matricula['documento'];
        $this->selectId  = $selectId;

        $deudas = TrDeudasCabs::where('matricula_id',$selectId)->get();
        $pagos  = $deudas->sum('credito');

        if($pagos>0){
            $this->dispatchBrowserEvent('msg-alert');
            return;
        }else{
            $this->dispatchBrowserEvent('show-delete');
        }
        
    }

    public function deleteData(){

        $deudas = TrDeudasCabs::where('matricula_id',$this->selectId)->get();

        foreach($deudas as $data){
            TrDeudasDets::where('deudacab_id',$data['id'])->delete();
            TrDeudasCabs::find($data['id'])->delete();
        }
        
        TmMatricula::find($this->selectId)->delete();

        $this->dispatchBrowserEvent('hide-delete');
        
    }

    public function setData($objData){

        $matricula = TmMatricula::find($this->selectId);

        $this->grupoId = $objData['grupoid'];
        $this->nivelId = $objData['nivelid'];
        $this->gradoId = $objData['gradoid'];
        $this->cursoId = $objData['cursoid'];

        $valoresnex = TmPensionesDet::join("tm_pensiones_cabs","tm_pensiones_cabs.id","=","tm_pensiones_dets.pension_id")
        ->where([
                ['tm_pensiones_cabs.periodo_id',$this->periodoId],
                ['tm_pensiones_cabs.modalidad_id',$this->grupoId],
                ['tm_pensiones_dets.nivel_id',$this->nivelId],
            ])->first();
        
        $pesionnew = $valoresnex['pension'];
             
        if ($matricula['modalidad_id'] != $this -> grupoId)  {

            $this->generaCobro();
            $this->generaDeuda($this->periodoId,$this->grupoId,$this->nivelId);

        } else {

            if (($matricula['nivel_id'] != $this->nivelId) && ($this->valorpen != $pesionnew)){

                $this->generaCobro();
                $this->generaDeuda($this->periodoId,$this->grupoId,$this->nivelId);

            }

        } 

        $matricula->update([
            'nivel_id'      => $this -> nivelId,
            'modalidad_id'  => $this -> grupoId,
            'grado_id'      => $this -> gradoId,
            'curso_id'      => $this -> cursoId,
        ]);

        $this->dispatchBrowserEvent('hide-form');
        $this->dispatchBrowserEvent('msg-edit');
                
    }

    public function generaCobro(){

        $ldate = date('Y-m-d H:i:s');
        $this->fecha = date('Y-m-d',strtotime($ldate));

        $deuda = TrDeudasCabs::query()
        ->where('matricula_id','=',$this->selectId)
        ->where('saldo','>',0)
        ->where('credito','=',0)
        ->get();
        
        $this->numreg = count($deuda);
        $this->trDeudasCabs = $deuda;
        
        $tblCobro  = TrCobrosCabs::orderBy('id', 'desc')->first();
        $secuencia = intval($tblCobro['documento'])+1;
        $docCobro  = str_pad($secuencia, 7, "0", STR_PAD_LEFT);
         
        $monto = 0;
        foreach ($deuda as $obj){
            $monto = $monto+$obj['saldo'];
        }

        TrCobrosCabs::Create([
            'fecha' => $this -> fecha,
            'estudiante_id' => $this -> record['estudiante_id'],
            'matricula_id' => $this->selectId,
            'tipo' => 'CM',
            'documento' => $docCobro,
            'concepto' => 'Se cancela deuda por cambio de Grupo/Sección en matrícula - Recibo No. '.$docCobro, 
            'monto' => $monto,
            'usuario' => auth()->user()->name,
            'estado' => "P",
        ]);

        $tblCobro = TrCobrosCabs::orderBy("id", "desc")->first();

        TrCobrosDets::Create([
            'cobrocab_id' =>  $tblCobro['id'],  
            'tipopago' => 'OTR',
            'entidad_id' => 32,
            'referencia' => '',
            'numero' => 0,
            'cuenta' => "",
            'valor' => $monto,
            'estado' => "P",
            'usuario' => auth()->user()->name,
        ]);

        $this->generaPago($deuda,$monto, $tblCobro['id']);
    }

    public function generaPago($objDeuda,$totalPago,$cobroId){

        foreach ($objDeuda as $deuda)
        {
            $valpago = floatval($deuda['saldo']);

            if ($totalPago>$valpago){
                $totalPago = $totalPago-$valpago;
            }else{
                $valpago = $totalPago;
            }

            TrDeudasDets::Create([
                'deudacab_id' =>  $deuda ['id'],  
                'cobro_id' => $cobroId,
                'fecha' => $this -> fecha,
                'detalle' => 'Pago '.$deuda['glosa'],
                'tipo' => "OTR",
                'referencia' => $this->documento,
                'tipovalor' => "CR",
                'valor' => $valpago,
                'estado' => "P",
                'usuario' => auth()->user()->name,
            ]);

            $tbldeuda = TrDeudasCabs::find($deuda['id']);
            $tbldeuda->update([ 
                'credito' => $tbldeuda['credito']+$valpago,
                'saldo'   => $tbldeuda['saldo']-$valpago
            ]); 

        }

    }

    public function generaDeuda($periodoId,$grupoId,$nivelId){

        $ldate = date('Y-m-d H:i:s');
        $fecha = date('Y-m-d',strtotime($ldate));

        $pLectivo   = TmPeriodosLectivos::find($this->periodoId);
        $codperiodo = $pLectivo['periodo'];
        $nomperiodo = $pLectivo['descripcion'];

        //$nromatricula = $pLectivo['num_matricula']+1;

        $valores    = TmPensionesDet::join("tm_pensiones_cabs","tm_pensiones_cabs.id","=","tm_pensiones_dets.pension_id")
        ->where([
                ['tm_pensiones_cabs.periodo_id',$periodoId],
                ['tm_pensiones_cabs.modalidad_id',$grupoId],
                ['tm_pensiones_dets.nivel_id',$nivelId],
            ])->first();

        $valorMatricula   = $valores['matricula'];
        $valorPension     = $valores['pension'];
        $valorePlataforma = $valores['eplataforma'];
        $valoriPlataforma = $valores['iplataforma'];
        $valorGrado       = $valores['grado'];
                
        //$cuotapag = 10-$this->numreg;
        //$cuotas   = 10-$cuotapag;

        //Matricula
        

        //Pension
        //for ($i=$cuotapag; $i <= $cuotas; $i++){
        foreach ($this->trDeudasCabs as $deudasCabs){
           
            $mes = date('m',strtotime($deudasCabs->fecha));
            $año = date('Y',strtotime($deudasCabs->fecha));
            $tipodeuda =  substr($deudasCabs->referencia, 0, 3);

            switch ($tipodeuda){
                case "MAT":
                    $valor = $valorMatricula;
                    break;
                case "PEN":
                    $valor = $valorPension;
                    break;
                case "PLI":
                    $valor = $valoriPlataforma;
                    break;
                case "PLE":
                    $valor = $valorePlataforma;
                    break;
                case "DGR":
                    $valor = $valorGrado;
                    break;
            }
                        
            TrDeudasCabs::Create([
                'matricula_id' => $this->selectId,
                'estudiante_id' => $this->estudianteId,
                'periodo_id' => $this -> periodoId,
                'referencia' => $deudasCabs->referencia,
                'fecha' =>  strval($año)."-".str_pad($mes, 2, "0", STR_PAD_LEFT).'-01',
                'basedifgravada' => $valor,
                'basegravada' =>0.00,
                'impuesto' =>0.00,
                'descuento' =>0.00,
                'neto' => $valor,
                'debito' => $valor,
                'credito' =>0.00,
                'saldo' => $valor,
                'glosa' => $deudasCabs->glosa,
                'estado' => 'P',
                'usuario' => auth()->user()->name,
            ]);

            $deuda = TrDeudasCabs::orderBy("id", "desc")->first();
            $deudaId = $deuda['id'];
    
            TrDeudasDets::Create([
                'deudacab_id' => $deudaId,
                'cobro_id' => 0,
                'fecha' => strval($año)."-".str_pad($mes, 2, "0", STR_PAD_LEFT).'-01',
                'detalle' => 'Pensión '.$this->meses[intval($mes)]." ".$nomperiodo,
                'tipo' => "",
                'referencia' => "",
                'tipovalor' => "DB",
                'valor' => $valor,
                'estado' => 'P',
                'usuario' => auth()->user()->name,
            ]);

            

        }

    }

    public function valoresPagar($objData){

        $this->alumno = $objData['apellidos'].' '.$objData['nombres'];
        
        $this->record  = $objData;
        $this->dispatchBrowserEvent('show-valores');
        $this->emitTo('vc-modal-valores','setValores',$this->record['id']);

        
    }

        
}


