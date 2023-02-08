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

use Livewire\Component;
use Livewire\WithPagination;

class VcTuitions extends Component
{
    use WithPagination;
    public $showEditModal = false;
    public $selectId = 0;
    public $previus='', $current='', $nomnivel, $nomcurso;
    public $filterdata='M';
    public $tblcursos=null;
    public $tblservicios=null;
    public $tbldatogen=null;
    public $estudianteId,$periodoId,$grupoId,$nivelId,$gradoId,$cursoId,$numreg;

    public $filters = [
        'srv_periodo' => '',
        'srv_grupo' => '',
        'srv_nombre' => '',
    ];
    
    public function render()
    {
        
        if ($this->filterdata=='M'){

            $tblrecords = TmPersonas::query()
            ->join("tm_matriculas as m","tm_personas.id","=","m.estudiante_id")
            ->join("tm_cursos as c","c.id","=","m.curso_id")
            ->join("tm_periodos_lectivos as p","p.id","=","m.periodo_id")
            ->join("tm_servicios as s","s.id","=","c.servicio_id")
            ->join("tm_generalidades as g","g.id","=","s.modalidad_id")
            ->when($this->filters['srv_nombre'],function($query){
                return $query->where('tm_personas.nombres','LIKE','%'.$this->filters['srv_nombre'].'%')
                            ->orWhere('tm_personas.apellidos','LIKE','%'.$this->filters['srv_nombre'].'%');
            })
            ->when($this->filters['srv_periodo'],function($query){
                return $query->where('m.periodo_id',"{$this->filters['srv_periodo']}");
            })
            ->when($this->filters['srv_grupo'],function($query){
                return $query->where('m.modalidad_id',"{$this->filters['srv_grupo']}");
            })
            ->select('m.id','identificacion','nombres','apellidos', 'documento', 'fecha', 'g.descripcion as nomgrupo','p.descripcion as nomperiodo','s.descripcion as nomgrado','paralelo','m.periodo_id','m.modalidad_id','m.nivel_id','c.servicio_id','m.curso_id','m.estudiante_id')
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

    public function edit($objData){
        
        $this->record  = $objData;
        $this->selectId = $this->record['id'];
        $this->nomnivel = $this->record['nomgrupo'];
        $this->nomcurso = $this->record['nomgrado'].' - '.$this->record['paralelo'];
        
        $this->estudianteId = $this->record['estudiante_id'];
        $this->periodoId = $this -> record['periodo_id'];
        $this->grupoId = $this -> record['modalidad_id'];
        $this->nivelId = $this -> record['nivel_id'];
        $this->gradoId = $this -> record['servicio_id'];
        $this->cursoId = $this -> record['curso_id'];

        $this->dispatchBrowserEvent('show-form');
        $this->emitTo('vc-modal-sections','setSection',$this->periodoId,$this->grupoId,$this->nivelId,$this->gradoId,$this->cursoId );

    }

    public function updateData(){

        $matricula = TmMatricula::find($this->selectId);
        
        $matricula->update([
            'nivel_id'      => $this -> record['nivel_id'],
            'modalidad_id'  => $this -> record['modalidad_id'],
            'grado_id'      => $this -> record['grado_id'],
            'curso_Id'      => $this -> record['curso_id'],
        ]);     
        
        if ($matricula['modalidad_id']<>$this -> record['modalidad_id']){
            $this->generaCobro();
            $this->generaDeuda();
        }
    }

    public function generaCobro(){

        $deuda = TrDeudasCabs::where([['matricula_id',$this->selectId],['debito','saldo']])->get();
        $this->numreg = count($deuda);
        
        $tblCobro  = TrCobrosCabs::orderBy('id', 'desc')->first();
        $secuencia = intval($tblCobro['documento'])+1;
        $documento = str_pad($secuencia, 7, "0", STR_PAD_LEFT);
         
        $monto = 0;
        foreach ($deuda as $obj){
            $monto = $monto+$obj['saldo'];
        }

        TrCobrosCabs::Create([
            'fecha' => $this -> fecha,
            'estudiante_id' => $this -> record['estudiante_id'],
            'documento' => $documento,
            'concepto' => 'Se cancela deuda por cambio en matricula Grupo/Sección - Recibo No. '.$this -> document, 
            'monto' => $monto,
            'usuario' => auth()->user()->name,
            'estado' => "P",
        ]);

        $tblCobro = TrCobrosCabs::orderBy("id", "desc")->first();

        TrCobrosDets::Create([
            'cobrocab_id' =>  $tblCobro['id'],  
            'tipopago' => 'OTR',
            'entidad_id' => 32,
            'referencia' => 'Cambio en matrícula',
            'numero' => 0,
            'cuenta' => "",
            'valor' => $monto,
            'estado' => "P",
            'usuario' => auth()->user()->name,
        ]);

        $this->generaPago($deuda,$monto);
    }

    public function generaPago($objDeuda,$totalPago){

        foreach ($objDeuda as $deuda)
        {
            $valpago = floatval($deuda['valpago']);

            if ($totalPago>$valpago){
                $totalPago = $totalPago-$valpago;
            }else{
                $valpago = $totalPago;
            }

            TrDeudasDets::Create([
                'deudacab_id' =>  $deuda ['id'],  
                'cobro_id' => $this->selectId,
                'fecha' => $this -> fecha,
                'detalle' => $deuda['detalle'],
                'tipo' => "OTR",
                'referencia' => $this->document,
                'tipovalor' => "CR",
                'valor' => $this->valpago,
                'estado' => "P",
                'usuario' => auth()->user()->name,
            ]);

            $tbldeuda = TrDeudasCabs::find($deuda['id']);
            $tbldeuda->update([ 
                'credito' => $tbldeuda['credito']+($valpago),
                'saldo' => $tbldeuda['saldo']-($valpago),
            ]); 

        }

    }

    public function generaDeuda($periodoId,$grupoId,$nivelId){

        $ldate = date('Y-m-d H:i:s');
        $fecha = date('Y-m-d',strtotime($ldate));

        $valores = TmPensionesDet::join("tm_pensiones_cabs","tm_pensiones_cabs.id","=","tm_pensiones_dets.pension_id")
        ->where([
                ['tm_pensiones_cabs.periodo_id',$this->periodoId],
                ['tm_pensiones_cabs.modalidad_id',$this->grupoId],
                ['tm_pensiones_dets.nivel_id',$this->nivelId],
            ])->first();

        $valorPension     = $pensiones['pension'];
        $valorePlataforma = $pensiones['eplataforma'];
        $valoriPlataforma = $pensiones['iplataforma'];
        
        $cuotapag = 10-$this->numreg;
        $cuotas   = 10-$cuotapag;

        //Matricula
        $mes = date('m',strtotime($this->fecha));
        $año = date('Y',strtotime($this->fecha));

        //Pension
        for ($i=$cuotapag; $i < $cuotas; $i++){
           
            $mes++ ;

            if ($mes==13){
                $mes = 1;
                $año = $año+1;
            }
            
            TrDeudasCabs::Create([
                'matricula_id' => $this->selectId,
                'estudiante_id' => $this -> estudiante_id,
                'periodo_id' => $this -> periodoId,
                'referencia' => 'PEN-'.$this->meses[$mes].substr($codperiodo, -2).str_pad($nromatricula, 4, "0", STR_PAD_LEFT),
                'fecha' =>  strval($año)."-".str_pad($mes, 2, "0", STR_PAD_LEFT).'-01',
                'basedifgravada' => $valorPension,
                'basegravada' =>0.00,
                'impuesto' =>0.00,
                'descuento' =>0.00,
                'neto' => $valorPension,
                'debito' => $valorPension,
                'credito' =>0.00,
                'saldo' => $valorPension,
                'glosa' => 'Pensión Cuota '.strval($i+1).' '.$nomperiodo,
                'estado' => 'P',
                'usuario' => auth()->user()->name,
            ]);

            $deuda = TrDeudasCabs::orderBy("id", "desc")->first();
            $deudaId = $deuda['id'];
    
            TrDeudasDets::Create([
                'deudacab_id' => $deudaId,
                'cobro_id' => 0,
                'fecha' => strval($año)."-".str_pad($mes, 2, "0", STR_PAD_LEFT).'-01',
                'detalle' => 'Pensión '.$this->meses[$mes]." ".$nomperiodo,
                'tipo' => "",
                'referencia' => "",
                'tipovalor' => "DB",
                'valor' => $valorPension,
                'estado' => 'P',
                'usuario' => auth()->user()->name,
            ]);
        }

    }

        
}


