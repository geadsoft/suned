<?php

namespace App\Http\Livewire;
use App\Models\TmPersonas;
use App\Models\TmPeriodosLectivos;
use App\Models\TmGeneralidades;
use App\Models\TrDeudasCabs;
use App\Models\TmMatricula;
use App\Models\TmCursos;

use PDF;
use Illuminate\Support\Facades\DB;

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
        'estado' => '',
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

    public function genConsulta(){

        $records = TrDeudasCabs::query()
        ->join("tr_deudas_dets as d","tr_deudas_cabs.id","=","d.deudacab_id")
        /*->leftJoin("tr_cobros_dets as p","p.cobrocab_id","=","d.cobro_id")*/
        ->join(DB::raw('(select cobrocab_id,group_concat(distinct tipopago) as tipopago 
        from tr_cobros_dets  
        group by 1) d'), 
        function($join)
        {
           $join->on('tr_cobros_cabs.id', '=', 'd.cobrocab_id');
        })
        ->leftJoin("tm_generalidades as g","g.id","=","p.entidad_id")
        ->selectraw("d.*,tr_deudas_cabs.saldo, tr_deudas_cabs.descuento, d.tipopago, g.descripcion, tr_deudas_cabs.referencia as documento")
        ->where("tr_deudas_cabs.matricula_id",$this->consulta['idactual'])
        ->where("tipo","<>","'DES'")
        ->orderByRaw("d.tipovalor desc,case when left(tr_deudas_cabs.referencia,3) = 'MAT' then 1
        when left(tr_deudas_cabs.referencia,3) = 'PLA' then 2
        when left(tr_deudas_cabs.referencia,3) = 'PLI' then 2
        when left(tr_deudas_cabs.referencia,3) = 'PEN' then 3
        when left(tr_deudas_cabs.referencia,3) = 'PLE' then 4
        else 5 end,d.fecha")
        ->get();

        $tblrecords = $records->where('tipo','<>','DES');
        return $tblrecords;                
    }

    public function detConsulta(){

        $tblrecords = TrDeudasCabs::query()
        ->join("tr_deudas_dets as d","tr_deudas_cabs.id","=","d.deudacab_id")
        ->selectraw("d.*,tr_deudas_cabs.saldo, tr_deudas_cabs.descuento, tr_deudas_cabs.referencia as documento", )
        ->where("tr_deudas_cabs.matricula_id",$this->consulta['idactual'])
        ->get();

        return $tblrecords;                
    }

    //General 
    public function liveWireGenPDF($matriculaId)
    { 
        $this->consulta['idactual'] = $matriculaId;
    
        $tblrecords = $this->genConsulta();

        $tbldetalle = TrCobrosDets::query()
        ->join("tr_cobros_cabs","tr_cobros_cabs.id","=","tr_cobros_dets.cobrocab_id")
        ->selectRaw("tr_cobros_cabs.documento,tr_cobros_dets.*")
        ->where('tr_cobros_cabs.matricula_id',$matriculaId)
        ->get(); 

        $matricula = TmMatricula::find($matriculaId);
        $this->consulta['nombre'] = $matricula->estudiante->apellidos.' '.$matricula->estudiante->nombres;
        $this->consulta['estado'] = $matricula->estudiante->estado;
        $this->consulta['fecha'] = date('Y-m-d H:i:s');

        $curso = TmCursos::query()
        ->join("tm_servicios as s","s.id","=","tm_cursos.servicio_id")
        ->join("tm_generalidades as g","g.id","=","s.grado_id")
        ->select("s.descripcion","tm_cursos.paralelo")
        ->where("tm_cursos.id",$matricula['curso_id'])
        ->first();

        $this->consulta['curso'] = $curso['descripcion'].' / '.$curso['paralelo'];

        $grupo = TmGeneralidades::find($matricula['modalidad_id']);
        $this->consulta['grupo'] = $grupo['descripcion']; 

        $periodo = TmPeriodosLectivos::find($matricula['periodo_id']);
        $this->consulta['periodo'] = $periodo['descripcion'];
        
        $dias = [0=>'Domingo',1=>'Lunes',2=>'Martes',3=>'Miercoles',4=>'Jueves',5=>'Viernes',6=>'Sabado'];

        //Vista
        $pdf = PDF::loadView('reports/estado_cuenta2',[
            'tblrecords' => $tblrecords,
            'tbldetalle' => $tbldetalle,
            'data' => $this->consulta,
            'dias' => $dias,
        ]);

        return $pdf->setPaper('a4')->stream('Estado de Cuenta.pdf');

    }

    public function downloadGenPDF($matriculaId)
    {

        $this->consulta['idactual'] = $matriculaId;
    
        $tblrecords = $this->genConsulta();

        $tbldetalle = TrCobrosDets::query()
        ->join("tr_cobros_cabs","tr_cobros_cabs.id","=","tr_cobros_dets.cobrocab_id")
        ->selectRaw("tr_cobros_cabs.documento,tr_cobros_dets.*")
        ->where('tr_cobros_cabs.matricula_id',$matriculaId)
        ->get();

        $matricula = TmMatricula::find($matriculaId);
        $this->consulta['nombre'] = $matricula->estudiante->apellidos.' '.$matricula->estudiante->nombres;
        $this->consulta['estado'] = $matricula->estudiante->estado;
        $this->consulta['fecha'] = date('Y-m-d H:i:s');

        $curso = TmCursos::query()
        ->join("tm_servicios as s","s.id","=","tm_cursos.servicio_id")
        ->join("tm_generalidades as g","g.id","=","s.grado_id")
        ->select("s.descripcion","tm_cursos.paralelo")
        ->where("tm_cursos.id",$matricula['curso_id'])
        ->first();

        $this->consulta['curso'] = $curso['descripcion'].' / '.$curso['paralelo'];

        $grupo = TmGeneralidades::find($matricula['modalidad_id']);
        $this->consulta['grupo'] = $grupo['descripcion']; 

        $periodo = TmPeriodosLectivos::find($matricula['periodo_id']);
        $this->consulta['periodo'] = $periodo['descripcion'];
        
        $dias = [0=>'Domingo',1=>'Lunes',2=>'Martes',3=>'Miercoles',4=>'Jueves',5=>'Viernes',6=>'Sabado'];
        
        //Vista
        $pdf = PDF::loadView('reports/estado_cuenta2',[
            'tblrecords' => $tblrecords,
            'tbldetalle' => $tbldetalle,
            'data' => $this->consulta,
            'dias' => $dias,
        ]);

        return $pdf->download('Estado de Cuenta.pdf');
    }


    //Detallado
    public function liveWireDetPDF($matriculaId)
    {   
        $this->consulta['idactual'] = $matriculaId;
    
        $tblrecords = $this->detConsulta();

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
