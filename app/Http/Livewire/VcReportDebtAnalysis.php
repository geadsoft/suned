<?php

namespace App\Http\Livewire;
use App\Models\TmGeneralidades;
use App\Models\TmPeriodosLectivos;
use App\Models\TrDeudasCabs;
use App\Models\TmCursos;


use Livewire\Component;
use Livewire\WithPagination;
use PDF;

class VcReportDebtAnalysis extends Component
{
    use WithPagination;

    public $filters = [
        'srv_periodo' => '',
        'srv_grupo' => '',
        'srv_curso' => '',
        'srv_mes' => '',
    ];

    public $mes = [
        1 => 'Enero',
        2 => 'Febrero',
        3 => 'Marzo',
        4 => 'Abril',
        5 => 'Mayo',
        6 => 'Junio',
        7 => 'Julio',
        8 => 'Agosto',
        9 => 'Septiembre',
        10=> 'Octubre',
        11=> 'Novimebre',
        12=> 'Diciembre',
    ];

    public $consulta = [
        'periodo' => '',
        'grupo' => '',
        'curso' => '',
        'mes' => '',
    ];

    public function mount(){
        
        $ldate = date('Y-m-d H:i:s');
        $tblgenerals = TmGeneralidades::where('superior',1)->first();
        $tblperiodos = TmPeriodosLectivos::orderBy("periodo","desc")->first();

        $this->filters['srv_periodo'] = $tblperiodos['id'];
        $this->filters['srv_grupo'] = $tblgenerals['id'];
        $this->filters['srv_mes'] = intval(date('m',strtotime($ldate)));

    }

    public function render()
    {
        $tblgenerals = TmGeneralidades::where('superior',1)->get();
        $tblperiodos = TmPeriodosLectivos::orderBy("periodo","desc")->get();
        $tblcursos   = TmCursos::query()
        ->where('periodo_id',$this->filters['srv_periodo'])
        ->when($this->filters['srv_grupo'],function($query){
            return $query->where('grupo_id',"{$this->filters['srv_grupo']}");
        })
        ->orderByRaw('nivel_id,grado_id,paralelo')
        ->get();

        $tblrecords  = $this->consulta();

        return view('livewire.vc-report-debt-analysis',[
            'tblrecords' => $tblrecords,
            'tblgenerals' => $tblgenerals,
            'tblperiodos' => $tblperiodos,
            'tblcursos' => $tblcursos,
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
        ->when($this->filters['srv_curso'],function($query){
            return $query->where('m.curso_id',"{$this->filters['srv_curso']}");
        })
        ->when($this->filters['srv_mes'],function($query){
            return $query->whereRaw('month(tr_deudas_cabs.fecha) <= '.$this->filters['srv_mes']);
        })
        ->where('saldo','>',0)
        ->select('documento', 'tr_deudas_cabs.fecha', 'p.nombres', 'p.apellidos', 'g.descripcion as grupo', 's.descripcion as curso', 
        'c.paralelo','tr_deudas_cabs.glosa', 'debito','credito','descuento','saldo')
        ->orderBy('p.apellidos')
        ->orderBy('tr_deudas_cabs.fecha')
        ->paginate(15);
        
        $this->datos = json_encode($this->filters);

        return $tblrecords;
    }

    public function liveWirePDF($modo,$objdata)
    { 
        $data = json_decode($objdata);

        $this->filters['srv_periodo'] = $data->srv_periodo;
        $this->filters['srv_grupo']   = $data->srv_grupo;
        $this->filters['srv_curso']   = $data->srv_curso;
        $this->filters['srv_mes']     = $data->srv_mes;
           
        $tblrecords = $this->consulta();

        if(empty($tblrecords)){
            return;
        }

        $total = $tblrecords->sum('saldo');
        $grupo = $tblrecords->groupBy(['grupo','curso','paralelo'])->toArray();
       
        $periodo = TmPeriodosLectivos::find($this->filters['srv_periodo'])->toArray();
        $this->consulta['periodo'] = $periodo['descripcion'];
        $this->consulta['curso'] = 'Todos';
        $this->consulta['grupo'] = 'Todos';
        $this->consulta['mes'] = $this->mes[intval($this->filters['srv_mes'])];

        if(!empty($this->filters['srv_grupo'])){
            $objgrupo = TmGeneralidades::find($this->filters['srv_grupo']);
            $this->consulta['grupo'] = $objgrupo['descripcion'];
        }

        if(!empty($this->filters['srv_curso'])){
            $objcurso = TmCursos::find($this->filters['srv_curso']);
            $this->consulta['curso'] = $objcurso->servicio['descripcion']." ".$objcurso['paralelo'];
        }
      
        //Vista
        $pdf = PDF::loadView('reports/analisis_deudas',[
            'tblrecords' => $grupo,
            'data'  => $this->consulta,
            'total' => $total,
        ]);
        
        if ($modo=='Preview'){
            return $pdf->setPaper('a4')->stream('Analisis Deudas.pdf');
        }

        if ($modo=='Download'){
            return $pdf->download('Analisis Deudas.pdf');
        }
            
    }

}
