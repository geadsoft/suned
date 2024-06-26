<?php

namespace App\Http\Livewire;
use App\Models\TmGeneralidades;
use App\Models\TmPeriodosLectivos;
use App\Models\TrCobrosCabs;
use App\Models\TrDeudasCabs;
use App\Models\TrDeudasDets;
use App\Models\TmMatricula;
use App\Models\TmPersonas;

use Illuminate\Support\Facades\DB;
use Livewire\Component;

class VcStatisticalGraphs extends Component
{   
    public $data,$datIngdia,$datIngmes,$cobroMes;
    public $fecha,$lnmes,$graphIngDia,$graphIngMes,$graphRubros,$lnperiodo,$lngrupo,$hombres, $mujeres, $totalIngresos=0.00;
    public $filters = [
        'idperiodo' => '',
        'idgrupo' => '',
        'mescobro' => '',
        'aniocobro' => '',
        'fecha' => '',
        'mesingreso' => '',
        'anioingreso' => '',
        'periodo' => '',
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
        11=> 'Noviembre',
        12=> 'Diciembre',
    ];

    public function mount(){
        
        $año   = date('Y');
        $tblgenerals = TmGeneralidades::where('superior',1)->first();
        $tblperiodos = TmPeriodosLectivos::where("estado",'A')->first();

        $this->filters['idperiodo'] = $tblperiodos['id'];
        $this->filters['idgrupo']   = $tblgenerals['id'];
        $this->filters['periodo']   = $tblperiodos['periodo'];
        
        $ldate = date('Y-m-d H:i:s');
        $this->filters['fecha']      = date('Y-m-d',strtotime($ldate));
        $this->filters['mescobro']   = intval(date('m',strtotime($ldate)));
        $this->filters['aniocobro'] = intval(date('Y',strtotime($ldate)));
        $this->filters['mesingreso']  = intval(date('m',strtotime($ldate)));
        $this->filters['anioingreso'] = intval(date('Y',strtotime($ldate)));

        $this->lngrupoId    = $tblgenerals['id'];
        $this->lnperiodoId  = $tblperiodos['id'];
        $this->lnmescobro   = intval(date('m',strtotime($ldate)));
        $this->lnaniocobro  = intval(date('Y',strtotime($ldate)));
        $this->lsfecha      = date('Y-m-d',strtotime($ldate));
        $this->lnmesingreso  = intval(date('m',strtotime($ldate)));
        $this->lnanioingreso = intval(date('Y',strtotime($ldate)));
        $this->lnperiodo    = $tblperiodos['periodo'];

        $this->consulta();
    }

    public function render()
    {   
        $ldate     = date('Y-m-d H:i:s');
        $mesactual = intval(date('m',strtotime($ldate)));

        $tblgenerals = TmGeneralidades::where('superior',1)->get();
        $tblperiodos = TmPeriodosLectivos::orderBy("periodo","desc")->get();

        $personas = TmMatricula::query()
        ->join('tm_personas as p','p.id','tm_matriculas.estudiante_id')
        ->when($this->filters['idperiodo'],function($query){
            return $query->where('tm_matriculas.periodo_id',"{$this->filters['idperiodo']}");
        })
        ->when($this->filters['idgrupo'],function($query){
            return $query->where('tm_matriculas.modalidad_id',"{$this->filters['idgrupo']}");
        })
        ->where("tipopersona","E")
        ->where("tm_matriculas.estado","A")
        ->get();
        
        $ingresos = TrCobrosCabs::query()
        ->whereRaw('year(fechapago) = '.$tblperiodos[0]->periodo.' and month(fechapago) = '.$mesactual." and estado = 'P'")
        ->get();

        $this->totalIngresos = $ingresos->sum('monto');

        $this->hombres = $personas->where('genero','M')->count('id');
        $this->mujeres = $personas->where('genero','F')->count('id'); 

        return view('livewire.vc-statistical-graphs',[
            'tblgenerals' => $tblgenerals,
            'tblperiodos' => $tblperiodos,
            "data"    => $this->data,
            "datadia" => $this->datIngdia,
            "datames" => $this->datIngmes,
        ]);

    }


    public function updatedlnmescobro() {
        
        $this->filters['mescobro'] = intval($this->lnmescobro);
        $this->consulta();
        $this->actualizaGraph();

    }

    public function updatedlnaniocobro() {
        
        $this->filters['aniocobro'] = intval($this->lnaniocobro);
        $this->consulta();
        $this->actualizaGraph();

    }

    public function updatedlsfecha() {
        
        $this->filters['fecha'] = $this->lsfecha;
        $this->consulta();
        $this->actualizaGraph();
    }
    
    public function updatedlnmesingreso() {
        
        $this->filters['mesingreso'] = $this->lnmesingreso;
        $this->consulta();
        $this->actualizaGraph();
    }

    public function updatedlnanioingreso() {
        
        $this->filters['anioingreso'] = $this->lnanioingreso;
        $this->consulta();
        $this->actualizaGraph();
    }

    public function updatedlnperiodo() {
        
        $this->filters['periodo'] = $this->lnperiodo;
        $this->consulta();
        $this->actualizaGraph();
    }

    public function updatedlnperiodoId(){

        if ($this->lnperiodoId=="0"){
            $this->filters['idperiodo'] = '';
        }else{
            $periodo = TmPeriodosLectivos::find($this->lnperiodoId);

            $this->filters['idperiodo'] = $this->lnperiodoId;
            $this->filters['periodo']   = $periodo['periodo'];
        }

        $this->consulta();
        $this->actualizaGraph();
        
    }

    public function updatedlngrupoId(){

        $this->filters['idgrupo'] = $this->lngrupoId;
        $this->consulta();
        $this->actualizaGraph();

    }

    public function actualizaGraph(){
        $this->dispatchBrowserEvent('graph-cobros', ['newObj' => $this->data]);
        $this->dispatchBrowserEvent('graph-ingdia', ['newObj' => $this->datIngdia]);
        $this->dispatchBrowserEvent('graph-ingmes', ['newObj' => $this->datIngmes]);
        $this->dispatchBrowserEvent('graph-rubros', ['newObj' => $this->cobroMes]);

    }

    public function consulta(){

        $this->data      = '';
        $this->datIngdia = '';
        $this->datIngmes = '';
        $this->cobroMes  = '';

        $fechaFin = date("Y-m-d",strtotime($this->filters['fecha']));
                
        $cobros = TrCobrosCabs::query()
        ->join("tr_deudas_dets as d","d.cobro_id","=","tr_cobros_cabs.id")
        ->join("tm_matriculas as m","m.id","=","tr_cobros_cabs.matricula_id")
        ->when($this->filters['idperiodo'],function($query){
            return $query->where('m.periodo_id',"{$this->filters['idperiodo']}");
        })
        ->when($this->filters['idgrupo'],function($query){
            return $query->where('m.modalidad_id',"{$this->filters['idgrupo']}");
        })
        ->where('tr_cobros_cabs.tipo','CP')
        ->where('d.tipo','PAG')
        ->where('tr_cobros_cabs.fecha','<',$fechaFin)
        ->selectRaw('tr_cobros_cabs.fecha,  sum(d.valor) AS monto')
        ->groupbyRaw('tr_cobros_cabs.fecha')
        ->orderby('tr_cobros_cabs.fecha','desc')
        ->get()->toArray();

        $datos = count($cobros,0);
        if ($datos>7){
            $datos = 7;
        }
        $tblcobros =  array_slice( $cobros,0,$datos);

        
        //Deudas Cancelada, Abonado
        $tipo = 'OTR';
        $tbldeudas = TrDeudasCabs::query()
        ->join("tm_matriculas as m","m.id","=","tr_deudas_cabs.matricula_id")
        ->join("tm_personas as p","p.id","=","m.estudiante_id")
        ->leftJoin(DB::raw("(select c.id from tm_matriculas m
        inner join tr_deudas_cabs c on c.matricula_id = m.id
        inner join tr_deudas_dets d on c.id = d.deudacab_id
        where d.tipo = 'OTR') as d"),function($join){
            $join->on('tr_deudas_cabs.id', '=', 'd.id');
        })
        ->when($this->filters['idperiodo'],function($query){
            return $query->where('m.periodo_id',"{$this->filters['idperiodo']}");
        })
        ->when($this->filters['idgrupo'],function($query){
            return $query->where('m.modalidad_id',"{$this->filters['idgrupo']}");
        })
        ->when($this->filters['mescobro'],function($query){
            return $query->whereRaw('month(tr_deudas_cabs.fecha)='.$this->filters['mescobro']);
        })
        ->when($this->filters['aniocobro'],function($query){
            return $query->whereRaw('year(tr_deudas_cabs.fecha)='.$this->filters['aniocobro']);
        })
        ->select('tr_deudas_cabs.*')
        ->where('tr_deudas_cabs.estado','P')
        ->where('m.estado','A')
        ->whereraw("left(tr_deudas_cabs.referencia,3)='PEN' and d.id is null")
        ->get();
        

        //Cobros ultimo 4 meses
        $anio = $this->lnanioingreso;
        $mes = $this->lnmesingreso;

        $fecha = strval($anio)."-".str_pad($mes, 2, "0", STR_PAD_LEFT).'-01';
        $fecha = date("Y-m-t", strtotime($fecha));

        $cobros = TrCobrosCabs::query()
        ->join("tr_deudas_dets as d","d.cobro_id","=","tr_cobros_cabs.id")
        ->join("tm_matriculas as m","m.id","=","tr_cobros_cabs.matricula_id")
        ->when($this->filters['idperiodo'],function($query){
            return $query->where('m.periodo_id',"{$this->filters['idperiodo']}");
        })
        ->when($this->filters['idgrupo'],function($query){
            return $query->where('m.modalidad_id',"{$this->filters['idgrupo']}");
        })
        ->where('tr_cobros_cabs.tipo','CP')
        ->where('d.tipo','PAG')
        ->where('d.estado','P')
        ->whereRaw('year(tr_cobros_cabs.fechapago) = '.$this->filters['anioingreso'])
        ->whereRaw('month(tr_cobros_cabs.fechapago) <= '.$this->filters['mesingreso'])
        ->selectRaw('month(tr_cobros_cabs.fechapago) as mes,  sum(d.valor) AS monto')
        ->groupbyRaw('month(tr_cobros_cabs.fechapago)')
        ->orderby('mes','desc')
        ->get()->toArray();

        $tblIngresoMes =  array_slice( $cobros,0,4);

        //Cobro Mes
        $tblCobroMes = TrDeudasDets::query()
        ->join('tr_cobros_cabs as cr','cr.id','=','tr_deudas_dets.cobro_id')
        ->join('tr_deudas_cabs as c','c.id','=','tr_deudas_dets.deudacab_id')
        ->join('tm_matriculas as m','m.id','=','c.matricula_id')
        ->selectRaw('left(c.referencia,3) as tipo, month(cr.fechapago) as mes, sum(valor) as valor')
        ->whereRaw("tr_deudas_dets.tipo = 'PAG' and tr_deudas_dets.estado = 'P' and year(cr.fechapago) = ".$this->filters['periodo'])
        ->when($this->filters['idperiodo'],function($query){
            return $query->where('m.periodo_id',"{$this->filters['idperiodo']}");
        })
        ->when($this->filters['idgrupo'],function($query){
            return $query->where('m.modalidad_id',"{$this->filters['idgrupo']}");
        })
        ->groupbyRaw("left(c.referencia,3), month(cr.fechapago), year(cr.fechapago)")
        ->orderbyRaw("month(cr.fechapago),left(c.referencia,3)")
        ->get();
        
        if($tbldeudas!=null){
            $this->graphsDeudas($tbldeudas);
        }

        if($tblcobros!=null){
            $this->graphsIngDia($tblcobros);
        }

        if($tblIngresoMes!=null){
            $this->graphsIngMes($tblIngresoMes);
        }

        if($tblCobroMes!=null){
            $this->graphsCobros($tblCobroMes);
        }

 
    }

    public function graphsDeudas($tbldeudas){

        $array=[];

        $sinpago = $tbldeudas->where('credito','=',0)
        ->where('saldo','>',0)
        ->count('estudiante_id');
        $array[] = [
            'name' =>  'Sin registro',
            'y' => floatVal($sinpago)
        ];

        $abono = $tbldeudas->where('credito','>',0)
        ->where('saldo','>',0)
        ->count('estudiante_id');
        $array[] = [
            'name' =>  'Abonado',
            'y' => floatVal($abono)
        ];

        $array[] = [
            'name' =>  'Cancelado',
            'y' => count($tbldeudas)-floatVal( $sinpago+$abono)
        ];        

        $this->data = json_encode($array);
       
    }

    public function graphsIngDia($tblcobros){

        $array=[];
        $linea = count($tblcobros)-1;

        for ($x=$linea;$x>=0;$x--) {
            $array[] = [
                'name' =>  date('d/M/Y',strtotime($tblcobros[$x]['fecha'])),
                'y' => floatVal($tblcobros[$x]['monto']),
            ];
        };

        $this->datIngdia = json_encode($array); 
    
    }

    public function graphsIngMes($tblData){

        $linea = count($tblData)-1;
        $array=[];
        for ($x=$linea;$x>=0;$x--) {
            $array[] = [
                'name' => $this->mes[$tblData[$x]['mes']],
                'y' => floatVal($tblData[$x]['monto']),
            ];
        };

        $this->datIngmes = json_encode($array); 
            
    }

    public function graphsCobros($tblCobroMes){

        $objGrupo = $tblCobroMes->groupBy('tipo');
        $total    = $tblCobroMes->groupBy('mes');

        $valores = '';
        //$this->cobroMes = "[";
        $objArray=[];
        foreach ($objGrupo as $key => $grupo){
            
            $valores = '';
            $array=[1 => 0,2 => 0,3 => 0,4 => 0,5 => 0,6 => 0,7 => 0,8 => 0,9 => 0,10 => 0,11 => 0,12 => 0];

            foreach ($grupo as $data){
                $array[$data['mes']] = $data['valor'];
            }
            
            switch ($key){
                case "MAT":
                    $tipo = 'Matricula';
                    break;
                case "PEN":
                    $tipo = 'Pension';
                    break;
                case "PLA":
                    $tipo = 'Plataforma';
                    break;
                case "PLI":
                    $tipo = 'Plataforma Ingles';
                    break;
                case "PLE":
                    $tipo = 'Plataforma Español';
                    break;
                case "DGR":
                    $tipo = 'Derecho de Grado';
                    break;
            }

            for($x=1;$x<=12;$x++){
                $valores =  $valores.sprintf('%.2f', $array[$x]).' ,';
            }

            $objArray[] = [
                'name' => $tipo,
                'data' => [substr($valores, 0, -2)],
            ];
        }

        $valores = '';
        $array=[1 => 0,2 => 0,3 => 0,4 => 0,5 => 0,6 => 0,
        7 => 0,8 => 0,9 => 0,10 => 0,11 => 0,12 => 0];

        foreach ($total as $key => $data){
            $array[$key] = $data->sum('valor');
        }

        for($x=1;$x<=12;$x++){
            $valores =  $valores.sprintf('%.2f', $array[$x]).' ,';
        }

        $objArray[] = [
            'name' => 'Total',
            'data' => [substr($valores, 0, -2)],
        ];
    
        $strarray = json_encode($objArray);
        $strarray = str_replace('["','[',$strarray);
        $strarray = str_replace('"]',']',$strarray);
        
        $this->cobroMes =  $strarray;
     

    }

    
}
