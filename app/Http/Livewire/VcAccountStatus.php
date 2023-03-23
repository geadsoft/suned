<?php

namespace App\Http\Livewire;
use App\Models\TmPersonas;
use App\Models\TmPeriodosLectivos;
use App\Models\TmGeneralidades;
use App\Models\TrDeudasCabs;
use App\Models\TmMatricula;
use PDF;


use Livewire\Component;
use Livewire\WithPagination;

class VcAccountStatus extends Component
{
    use WithPagination;

    public $datos;
    public $filters = [
        'srv_periodo' => '',
        'srv_grupo' => '',
        'srv_nombre' => '',
    ];

    public $consulta = [
        'nombre' => '',
        'curso' => '',
        'grupo' => '',
        'fecha' => '',
        'periodo' => '',
        'idactual' => 0,
    ];

    public function render()
    {
       
        $tblrecords = TmPersonas::query()
        ->join("tm_matriculas as m","tm_personas.id","=","m.estudiante_id")
        ->join("tm_cursos as c","c.id","=","m.curso_id")
        ->join("tm_servicios as s","s.id","=","c.servicio_id")
        ->join("tm_periodos_lectivos as p","p.id","=","m.periodo_id")
        ->join("tm_generalidades as g","g.id","=","m.modalidad_id")
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

        $tblgenerals = TmGeneralidades::where('superior',1)->get();
        $tblperiodos = TmPeriodosLectivos::orderBy("periodo","desc")->get();

        return view('livewire.vc-account-status',[
            'tblrecords' => $tblrecords,
            'tblgenerals' => $tblgenerals,
            'tblperiodos' => $tblperiodos
        ]);


    }

    public function paginationView(){
        return 'vendor.livewire.bootstrap'; 
    }

    public function consulta(){

        $tblrecords = TrDeudasCabs::query()
        ->join("tr_deudas_dets as d","tr_deudas_cabs.id","=","d.deudacab_id")
        ->selectraw("d.*,tr_deudas_cabs.saldo, tr_deudas_cabs.referencia as documento")
        ->where("tr_deudas_cabs.matricula_id",$this->consulta['idactual'])
        ->get();

        return $tblrecords;                
    }

    public function liveWirePDF($matriculaId)
    {   
        $this->consulta['idactual'] = $matriculaId;
    
        $tblrecords = $this->consulta();

        $matricula = TmMatricula::find($matriculaId);
        $this->consulta['nombre'] = $matricula->estudiante->apellidos.' '.$matricula->estudiante->nombres;
        $this->consulta['fecha'] = date('Y-m-d H:i:s');

        $records = [];

        $totneto = $tblrecords->sum('saldo');
        $totaldb = 0.00;
        $totalcr = 0.00;
        $totalsa = 0.00;
        
        foreach ($tblrecords as $data){

            $debe  = 0.00;
            $haber = 0.00;
            $documento = '';

            if ($data->tipovalor == 'DB'){
                $debe       = $data->valor;
                $documento  = $data->documento;
                $totaldb    = $totaldb + $debe;
            }else{
                $haber      = $data->valor;
                $documento  = $data->referencia;
                $totalcr    = $totalcr + $haber;
            }
            $totalsa = $totalsa+$debe-$haber;
            
            $detalle = [
                'fecha' =>  date('d/m/Y',strtotime($data->fecha)),
                'concepto' =>  $data->detalle,
                'tipo' =>  $data->tipo,
                'documento' =>  $documento,
                'neto' => $data->saldo,
                'debe' => $debe,
                'haber' => $haber,
                'saldo' => $totalsa,
            ];

            array_push($records,$detalle);
        }

        $arrtotal = [
            'totneto' => $totneto,
            'totaldb' => $totaldb,
            'totalcr' => $totalcr,
            'totalsa' => $totalsa,
        ];
        
         //Vista
         $pdf = PDF::loadView('reports/estado_cuenta',[
            'tblrecords' => $records,
            'data' => $this->consulta,
            'arrtotal' => $arrtotal,
        ]);

        return $pdf->setPaper('a4')->stream('Estado de Cuenta.pdf');
    }

    
    
}
