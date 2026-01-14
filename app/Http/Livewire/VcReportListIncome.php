<?php

namespace App\Http\Livewire;
use App\Models\TrCobrosCabs;
use App\Models\TmGeneralidades;
use App\Models\TmPeriodosLectivos;
use App\Models\TmCursos;
use PDF;

use Livewire\Component;
use Livewire\WithPagination;

class VcReportListIncome extends Component
{
    use WithPagination;

    public $fecha, $nombre, $fechaini, $fechafin, $cia, $nomgrupo='TODOS', $nomperiodo, $datos, $estado=false;
    public $filters = [
        'srv_periodo' => '',
        'srv_grupo' => '',
        'srv_fechaini' => '',
        'srv_fechafin' => '',
        'srv_nombre' => '',
        'srv_curso' => '',
        'srv_estado' => 'P',
    ];

    public $data=[
        'periodo' => '',
        'grupo' => '',
        'fechaini' => '',
        'fechafin' => '',
    ];

    public function mount(){

        $año = date('Y');
        $dataperiodo = TmPeriodosLectivos::where("estado",'A')->first();
        
        $ldateini = date('Y-m-d H:i:s');
        $ldatefin = date('Y-m-d H:i:s');

        $this->filters['srv_fechaini'] = '';
        $this->filters['srv_fechafin'] = '';
        $this->filters['srv_nombre'] = '';
        $this->filters['srv_grupo'] = '2';
        $this->filters['srv_periodo'] = $dataperiodo['id'];

    }

    public function render()
    {
        $this->tblgenerals = TmGeneralidades::where('superior',1)->get();
        $this->tblperiodos = TmPeriodosLectivos::orderBy("periodo","desc")->get();

        $tblcursos   = TmCursos::query()
        ->when($this->filters['srv_periodo'],function($query){
            return $query->where('periodo_id',"{$this->filters['srv_periodo']}");
        })
        ->when($this->filters['srv_grupo'],function($query){
            return $query->where('grupo_id',"{$this->filters['srv_grupo']}");
        })
        ->orderByRaw('nivel_id,grado_id,paralelo')
        ->get();
        
        $tblrecords  = $this->consulta();

        return view('livewire.vc-report-list-income',[
            'tblrecords' => $tblrecords,
            'tblgenerals' => $this->tblgenerals,
            'tblperiodos' => $this->tblperiodos,
            'tblcursos' => $tblcursos,
        ]);

    }

    public function paginationView(){
        return 'vendor.livewire.bootstrap'; 
    }

    public function consulta(){

        //$this->filters['srv_periodo'] = $this->tblperiodos[0]->id;

        $tblrecords = TrCobrosCabs::query("")
        ->join("tm_personas as p","p.id","=","tr_cobros_cabs.estudiante_id")
        ->join("tm_matriculas as m","m.id","=","tr_cobros_cabs.matricula_id")
        ->join("tm_cursos as c","c.id","=","m.curso_id")
        ->join("tm_servicios as s","s.id","=","c.servicio_id")
        ->when($this->filters['srv_nombre'],function($query){
            return $query->whereRaw("concat(p.apellidos,' ',p.nombres,' ',tr_cobros_cabs.documento) LIKE '%".$this->filters['srv_nombre']."%'");
        })
        ->when($this->filters['srv_periodo'],function($query){
            return $query->where('m.periodo_id',"{$this->filters['srv_periodo']}");
        })
        ->when($this->filters['srv_grupo'],function($query){
            return $query->where('m.modalidad_id',"{$this->filters['srv_grupo']}");
        })
        ->when($this->filters['srv_curso'],function($query){
            return $query->where('m.id',"{$this->filters['srv_curso']}");
        })
        ->when($this->filters['srv_fechaini'],function($query){
            return $query->where('tr_cobros_cabs.fecha','>=',date('Ymd',strtotime($this->filters['srv_fechaini'])))
            ->where('tr_cobros_cabs.fecha','<=',date('Ymd',strtotime($this->filters['srv_fechafin'])));
        })
        ->where('tr_cobros_cabs.tipo','=','CP')
        ->where('tr_cobros_cabs.estado','=',$this->filters['srv_estado'])
        ->select('tr_cobros_cabs.id','tr_cobros_cabs.fecha','tr_cobros_cabs.documento','tr_cobros_cabs.concepto','tr_cobros_cabs.monto',
        'tr_cobros_cabs.estado','tr_cobros_cabs.usuario','p.nombres', 'p.apellidos', 's.descripcion', 'c.paralelo')
        ->orderBy('tr_cobros_cabs.documento','desc')
        ->paginate(15);

        $this->datos = json_encode($this->filters);
        
        return $tblrecords;

    }

    public function updatedEstado(){

        $this->filters['srv_estado'] = 'P';
        if($this->estado){
            $this->filters['srv_estado'] = 'A';
        }

    }

    public function deleteFilters(){

        $dataperiodo = TmPeriodosLectivos::orderBy("periodo","desc")->first();

        $this->filters['srv_periodo'] = $dataperiodo['id'];
        $this->filters['srv_grupo'] = '2';
        $this->filters['srv_fechaini'] = '';
        $this->filters['srv_fechafin'] = '';
        $this->filters['srv_nombre'] = '';
        $this->filters['srv_curso'] = '';
    }

    public function print($objdata){

        $this->filters['srv_periodo'] = $objdata->srv_periodo;
        $this->filters['srv_grupo'] = $objdata->srv_grupo;
        $this->filters['srv_fechaini'] = $objdata->srv_fechaini;
        $this->filters['srv_fechafin'] = $objdata->srv_fechafin;
        $this->filters['srv_nombre'] = $objdata->srv_nombre;

        $this->data['grupo'] = "TODOS";
        $this->tblgenerals = TmGeneralidades::where('superior',1)->get();
        $this->tblperiodos = TmPeriodosLectivos::orderBy("periodo","desc")->get();

        $tblrecords = TrCobrosCabs::query()
        ->join("tr_cobros_dets as cd","tr_cobros_cabs.id","=","cd.cobrocab_id")
        ->join("tr_deudas_dets as dd","dd.cobro_id","=","tr_cobros_cabs.id")
        ->join("tr_deudas_cabs as dc","dc.id","=","dd.deudacab_id")
        ->join("tm_matriculas as m","m.id","=","dc.matricula_id")
        ->join("tm_personas as p","p.id","=","m.estudiante_id")
        ->join("tm_cursos as c","c.id","=","m.curso_id")
        ->join("tm_servicios as s","s.id","=","c.servicio_id")   
        ->when($this->filters['srv_nombre'],function($query){
            return $query->where('tr_cobros_cabs.documento',"{$this->filters['srv_nombre']}");
        })        
        ->when($this->filters['srv_periodo'],function($query){
            return $query->where('m.periodo_id',"{$this->filters['srv_periodo']}");
        })
        ->when($this->filters['srv_grupo'],function($query){
            return $query->where('m.modalidad_id',"{$this->filters['srv_grupo']}");
        })
        ->selectRaw('tr_cobros_cabs.fecha, sum(debito) as monto, sum(descuento) as descuento, sum(dd.valor) as pago')
        ->where('tr_cobros_cabs.fecha','>=',date('Ymd',strtotime($this->filters['srv_fechaini'])))
        ->where('tr_cobros_cabs.fecha','<=',date('Ymd',strtotime($this->filters['srv_fechafin'])))
        ->where('dd.tipo','<>','DES')
        ->where('tr_cobros_cabs.tipo','=','CP')
        ->groupBy('fecha')
        ->get();

        for ($x=0; $x<count($this->tblgenerals);$x++){
            if ($this->tblgenerals[$x]->id == $this->filters['srv_grupo']){
                $this->data['grupo'] = $this->tblgenerals[$x]->descripcion;
            }
        }

        for ($x=0; $x<count($this->tblperiodos);$x++){
            if ($this->tblperiodos[$x]->id == $this->filters['srv_periodo']){
                $this->data['periodo'] = $this->tblperiodos[$x]->descripcion;
            }
        }        

        $this->data['fechaini'] = $this->filters['srv_fechaini'];
        $this->data['fechafin'] = $this->filters['srv_fechafin'];

        return $tblrecords;
        
    }

    public function downloadPDF($objdata)
    { 
        $data = json_decode($objdata);
        $tblrecords = $this->print($data);
        $dias = [0=>'Domingo',1=>'Lunes',2=>'Martes',3=>'Miercoles',4=>'Jueves',5=>'Viernes',6=>'Sabado'];

        $ldate = date('Y-m-d H:i:s');
        $this->fecha = date('Y-m-d',strtotime($ldate));
        
         //Vista
         $pdf = PDF::loadView('reports/cobros_diarios',[
            'tblrecords' => $tblrecords,
            'data' => $this->data,
            'fecha' => $this->fecha,
            'dias' => $dias,
        ]);

        return $pdf->download('Cobros diarios.pdf');
    }

    public function liveWirePDF($objdata)
    {   
        $data = json_decode($objdata);
        $tblrecords = $this->print($data);
        $dias = [0=>'Domingo',1=>'Lunes',2=>'Martes',3=>'Miercoles',4=>'Jueves',5=>'Viernes',6=>'Sabado'];

        $this->fecha = date('Y-m-d H:i:s');
                
         //Vista
         $pdf = PDF::loadView('reports/cobros_diarios',[
            'tblrecords' => $tblrecords,
            'data' => $this->data,
            'fecha' => $this->fecha,
            'dias' => $dias,
        ]);

        return $pdf->setPaper('a4')->stream('Cobros diarios.pdf');
    }

    public function exportExcel(){

        $data = json_encode($this->filters);
        return Excel::download(new ListadoIngresosExport($data), 'Calificaciones Totales.xlsx');

    }


}
