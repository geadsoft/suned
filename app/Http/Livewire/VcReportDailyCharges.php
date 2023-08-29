<?php

namespace App\Http\Livewire;
use App\Models\TrCobrosCabs;
use App\Models\TmGeneralidades;
use App\Models\TmPeriodosLectivos;
use App\Models\User;
use PDF;

use Livewire\Component;
use Livewire\WithPagination;

class VcReportDailyCharges extends Component
{
    use WithPagination;

    public $fecha, $nombre, $fechaini, $fechafin, $cia, $nomgrupo='TODOS', $nomperiodo, $datos, $users;
    public $filters = [
        'srv_periodo' => '',
        'srv_grupo' => '',
        'srv_fechaini' => '',
        'srv_fechafin' => '',
        'srv_nombre' => '',
        'srv_usuario' => '',
    ];

    public $data=[
        'periodo' => '',
        'grupo' => '',
        'fechaini' => '',
        'fechafin' => '',
    ];

    public function mount(){
        
        $dataperiodo = TmPeriodosLectivos::orderBy("periodo","desc")->first();
        
        $ldateini = date('Y-m-d H:i:s');
        $ldatefin = date('Y-m-d H:i:s');

        $this->filters['srv_periodo']  = $dataperiodo['id'];
        $this->filters['srv_fechaini'] = date('Y-m-d',strtotime($ldateini));
        $this->filters['srv_fechafin'] = date('Y-m-d',strtotime($ldatefin));
        $this->filters['srv_nombre'] = '';

        $this->users = User::where('id','<>',2)->get();
    }

    public function render()
    {
        $this->tblgenerals = TmGeneralidades::where('superior',1)->get();
        $this->tblperiodos = TmPeriodosLectivos::orderBy("periodo","desc")->get();
        $tblrecords  = $this->consulta();

        return view('livewire.vc-report-daily-charges',[
            'tblrecords' => $tblrecords,
            'tblgenerals' => $this->tblgenerals,
            'tblperiodos' => $this->tblperiodos,
            'users' => $this->users,
        ]);

    }

    public function paginationView(){
        return 'vendor.livewire.bootstrap'; 
    }

    public function consulta(){

        //$this->filters['srv_periodo'] = $this->tblperiodos[0]->id;
           
        $tblrecords = TrCobrosCabs::query()
        ->join("tm_personas","tm_personas.id","=","tr_cobros_cabs.estudiante_id")
        ->when($this->filters['srv_nombre'],function($query){
            return $query->whereRaw("concat(tm_personas.apellidos,' ',tm_personas.nombres) LIKE '%".$this->filters['srv_nombre']."%'");
        })
        ->when($this->filters['srv_usuario'],function($query){
            return $query->where('tr_cobros_cabs.usuario',"{$this->filters['srv_usuario']}");
        })
        //->whereBetween('tr_cobros_cabs.fecha',["'".date('Ymd',strtotime($this->filters['srv_fechaini']))."'","'".date('Ymd',strtotime($this->filters['srv_fechafin']))."'"])
        ->where('tr_cobros_cabs.fecha','>=',date('Ymd',strtotime($this->filters['srv_fechaini'])))
        ->where('tr_cobros_cabs.fecha','<=',date('Ymd',strtotime($this->filters['srv_fechafin'])))
        ->where('tr_cobros_cabs.tipo','=','CP')
        ->select('tr_cobros_cabs.id','tr_cobros_cabs.fecha','tr_cobros_cabs.documento','tr_cobros_cabs.concepto','tr_cobros_cabs.monto','tr_cobros_cabs.estado','tr_cobros_cabs.usuario','tm_personas.nombres', 'tm_personas.apellidos')
        ->orderBy('tr_cobros_cabs.fecha','desc')
        ->paginate(15);

        $this->datos = json_encode($this->filters);
        
        return $tblrecords;

    }

    public function print($objdata){

        $this->filters['srv_periodo'] = $objdata->srv_periodo;
        $this->filters['srv_grupo'] = $objdata->srv_grupo;
        $this->filters['srv_fechaini'] = $objdata->srv_fechaini;
        $this->filters['srv_fechafin'] = $objdata->srv_fechafin;
        $this->filters['srv_nombre'] = $objdata->srv_nombre;
        $this->filters['srv_usuario'] = $objdata->srv_usuario;

        $this->data['grupo'] = "TODOS";
        $this->tblgenerals = TmGeneralidades::where('superior',1)->get();
        $this->tblperiodos = TmPeriodosLectivos::orderBy("periodo","desc")->get();

        $tblrecords = TrCobrosCabs::query()
        //->join("tr_cobros_dets as cd","tr_cobros_cabs.id","=","cd.cobrocab_id")
        ->join("tr_deudas_dets as dd","dd.cobro_id","=","tr_cobros_cabs.id")
        ->join("tr_deudas_cabs as dc","dc.id","=","dd.deudacab_id")
        ->join("tm_matriculas as m","m.id","=","dc.matricula_id")
        ->join("tm_personas as p","p.id","=","m.estudiante_id")
        ->join("tm_cursos as c","c.id","=","m.curso_id")
        ->join("tm_servicios as s","s.id","=","c.servicio_id")   
        ->when($this->filters['srv_nombre'],function($query){
            return $query->where('p.nombres','like','%'.$this->filters['srv_nombre'].'%')
                        ->orWhere('p.apellidos','like','%'.$this->filters['srv_nombre'].'%');
        })        
        ->when($this->filters['srv_periodo'],function($query){
            return $query->where('m.periodo_id',"{$this->filters['srv_periodo']}");
        })
        ->when($this->filters['srv_grupo'],function($query){
            return $query->where('m.modalidad_id',"{$this->filters['srv_grupo']}");
        })
        ->when($this->filters['srv_usuario'],function($query){
            return $query->where('tr_cobros_cabs.usuario',"{$this->filters['srv_usuario']}");
        })
        ->selectRaw('tr_cobros_cabs.fecha, sum(debito) as monto, sum(descuento) as descuento, sum(dd.valor) as pago')
        ->where('tr_cobros_cabs.fecha','>=',date('Ymd',strtotime($this->filters['srv_fechaini'])))
        ->where('tr_cobros_cabs.fecha','<=',date('Ymd',strtotime($this->filters['srv_fechafin'])))
        ->where('dd.tipo','=','PAG')
        ->where('tr_cobros_cabs.tipo','=','CP')
        ->orderBy('fecha','asc')
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


}
