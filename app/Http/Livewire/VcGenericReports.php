<?php

namespace App\Http\Livewire;
use App\Models\TmGeneralidades;
use App\Models\TmPeriodosLectivos;
use App\Models\TrDeudasCabs;
use App\Models\TmCursos;

use Livewire\Component;
use Livewire\WithPagination;
use PDF;

class VcGenericReports extends Component
{
    use WithPagination;
    public $referencia='PEN', $relacion='>', $tipo='saldo', $valor='0.00';
    public $tblgenerals, $tblperiodos, $tblniveles, $datos;

    public $filters = [
        'srv_periodo' => '',
        'srv_grupo' => '',
        'srv_nivel' => '',
        'srv_curso' => '',
        'srv_referencia' => '',
        'srv_relacion' => '',
        'srv_tipo' => '',
        'srv_valor' => '',
    ];

    public $consulta = [
        'periodo' => '',
        'grupo' => '',
        'nivel' => '',
        'curso' => '',
        'consulta' => '',
        'tipo' => '',        
    ];

    public function mount(){
        
        $ldate = date('Y-m-d H:i:s');
        $this->tblgenerals = TmGeneralidades::where('superior',1)->get();
        $this->tblperiodos = TmPeriodosLectivos::orderBy("periodo","desc")->get();
        $this->tblniveles  = TmGeneralidades::where('superior',2)->get();

        $this->filters['srv_periodo'] = $this->tblperiodos[0]['id'];
        $this->filters['srv_grupo']   = $this->tblgenerals[0]['id'];
        $this->filters['srv_nivel']   = $this->tblniveles[0]['id'];

    }

    public function render()
    {

        $tblcursos   = TmCursos::query()
        ->where('periodo_id',$this->filters['srv_periodo'])
        ->when($this->filters['srv_grupo'],function($query){
            return $query->where('grupo_id',"{$this->filters['srv_grupo']}");
        })
        ->when($this->filters['srv_nivel'],function($query){
            return $query->where('nivel_id',"{$this->filters['srv_nivel']}");
        })
        ->orderByRaw('nivel_id,grado_id,paralelo')
        ->get();

        $tblrecords  = $this->consulta();
        
        return view('livewire.vc-generic-reports',[
            'tblrecords'  => $tblrecords,
            'tblgenerals' => $this->tblgenerals,
            'tblperiodos' => $this->tblperiodos,
            'tblniveles'  => $this->tblniveles,
            'tblcursos'  => $tblcursos,
        ]);

    }

    public function paginationView(){
        return 'vendor.livewire.bootstrap'; 
    }

    public function consulta(){
               
        $tblrecords = TrDeudasCabs::query()
        ->join("tm_matriculas as m","m.id","=","tr_deudas_cabs.matricula_id")
        ->join("tm_personas as p","p.id","=","m.estudiante_id")
        ->join("tm_cursos as c","c.id","=","m.curso_id")
        ->join("tm_servicios as s","s.id","=","c.servicio_id")
        ->join("tm_generalidades as g","g.id","=","m.modalidad_id")   
        ->when($this->filters['srv_periodo'],function($query){
            return $query->where('m.periodo_id',"{$this->filters['srv_periodo']}");
        })
        ->when($this->filters['srv_grupo'],function($query){
            return $query->where('m.modalidad_id',"{$this->filters['srv_grupo']}");
        })
        ->when($this->filters['srv_nivel'],function($query){
            return $query->where('s.nivel_id',"{$this->filters['srv_nivel']}");
        })
        ->when($this->filters['srv_curso'],function($query){
            return $query->where('m.curso_id',"{$this->filters['srv_curso']}");
        })
        ->when($this->referencia,function($query){
            return $query->whereRaw("left(tr_deudas_cabs.referencia,3) = '{$this->referencia}'");
        })
        ->where('p.estado','A')
        ->whereRaw($this->tipo.$this->relacion.floatval($this->valor))
        ->select('documento', 'tr_deudas_cabs.fecha', 'p.nombres', 'p.apellidos', 'g.descripcion as grupo', 's.descripcion as curso', 
        'c.paralelo','tr_deudas_cabs.glosa', 'debito','credito','descuento','saldo')
        ->orderBy('p.apellidos')
        ->orderBY('p.nombres')
        ->orderBy('tr_deudas_cabs.fecha')
        ->paginate(15);
         
        $this->filters['srv_referencia'] = $this->referencia;
        $this->filters['srv_tipo']       = $this->tipo;
        $this->filters['srv_relacion']   = $this->relacion;
        $this->filters['srv_valor']      = $this->valor;
        
        $this->datos = json_encode($this->filters);

        return $tblrecords;
    }


    public function reporte(){
               
        $tblrecords = TrDeudasCabs::query()
        ->join("tm_matriculas as m","m.id","=","tr_deudas_cabs.matricula_id")
        ->join("tm_personas as p","p.id","=","m.estudiante_id")
        ->join("tm_cursos as c","c.id","=","m.curso_id")
        ->join("tm_servicios as s","s.id","=","c.servicio_id")
        ->join("tm_generalidades as g","g.id","=","m.modalidad_id")   
        ->when($this->filters['srv_periodo'],function($query){
            return $query->where('m.periodo_id',"{$this->filters['srv_periodo']}");
        })
        ->when($this->filters['srv_grupo'],function($query){
            return $query->where('m.modalidad_id',"{$this->filters['srv_grupo']}");
        })
        ->when($this->filters['srv_nivel'],function($query){
            return $query->where('s.nivel_id',"{$this->filters['srv_nivel']}");
        })
        ->when($this->filters['srv_curso'],function($query){
            return $query->where('m.curso_id',"{$this->filters['srv_curso']}");
        })
        ->when($this->referencia,function($query){
            return $query->whereRaw("left(tr_deudas_cabs.referencia,3) = '{$this->referencia}'");
        })
        ->where('p.estado','A')
        ->whereRaw($this->tipo.$this->relacion.floatval($this->valor))
        ->select('documento', 'tr_deudas_cabs.fecha', 'p.nombres', 'p.apellidos', 'p.identificacion', 'g.descripcion as grupo', 's.descripcion as curso', 
        'c.paralelo','tr_deudas_cabs.glosa', 'debito','credito','descuento','saldo')
        ->orderByRaw('s.modalidad_id, s.nivel_id, s.grado_id, p.apellidos asc, tr_deudas_cabs.fecha')
        ->get();
         
        return $tblrecords;
    }


    public function liveWirePDF($modo,$objdata)
    { 
        $data = json_decode($objdata);

        $this->filters['srv_periodo'] = $data->srv_periodo;
        $this->filters['srv_grupo']   = $data->srv_grupo;
        $this->filters['srv_nivel']   = $data->srv_nivel;
        $this->filters['srv_curso']   = $data->srv_curso;
        $this->referencia =  $data->srv_referencia;   
        $this->tipo =  $data->srv_tipo;  
        $this->relacion = $data->srv_relacion;
        $this->valor = $data->srv_valor;

        
        $tblrecords = $this->reporte();
        
        if(empty($tblrecords)){
            return;
        }

        $total = $tblrecords->sum($this->tipo);
        $grupo = $tblrecords->groupBy(['grupo','curso','paralelo'])->toArray();
        $totalalumno = $tblrecords->groupBy('identificacion')->count(); 
       
        $periodo = TmPeriodosLectivos::find($this->filters['srv_periodo'])->toArray();
        $this->consulta['periodo'] = $periodo['descripcion'];
        $this->consulta['curso'] = 'Todos';
        $this->consulta['grupo'] = 'Todos';
        $this->consulta['nivel'] = 'Todos';
        $this->consulta['tipo'] = $this->tipo;

        if(!empty($this->filters['srv_grupo'])){
            $objgrupo = TmGeneralidades::find($this->filters['srv_grupo']);
            $this->consulta['grupo'] = $objgrupo['descripcion'];
        }

        if(!empty($this->filters['srv_curso'])){
            $objcurso = TmCursos::find($this->filters['srv_curso']);
            $this->consulta['curso'] = $objcurso->servicio['descripcion']." ".$objcurso['paralelo'];
        }

        if(!empty($this->filters['srv_nivel'])){
            $objnivel = TmGeneralidades::find($this->filters['srv_nivel']);
            $this->consulta['nivel'] = $objnivel['descripcion'];
        }

        $this->consulta['consulta'] = $this->tipo.$this->relacion.$this->valor;
        
        //Vista
        $pdf = PDF::loadView('reports/reporte_generico',[
            'tblrecords' => $grupo,
            'data'  => $this->consulta,
            'total' => $total,
            'totalalumno' => $totalalumno,
        ]);
        
        if ($modo=='Preview'){
            return $pdf->setPaper('a4')->stream('Reporte Generico.pdf');
        }

        if ($modo=='Download'){
            return $pdf->download('Reporte Generico.pdf');
        }
            
    }

}
