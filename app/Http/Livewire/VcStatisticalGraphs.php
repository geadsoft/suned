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
        'srv_periodo' => '',
        'srv_grupo' => '',
        'srv_mes' => '',
        'srv_fecha' => '',
        'srv_ingmes' => '',
        'srv_ejercicio' => '',
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

    public function mount(){
        
        $tblgenerals = TmGeneralidades::where('superior',1)->first();
        $tblperiodos = TmPeriodosLectivos::orderBy("periodo","desc")->first();

        $this->filters['srv_periodo'] = $tblperiodos['id'];
        $this->filters['srv_grupo'] = $tblgenerals['id'];
        $this->filters['srv_ejercicio'] = $tblperiodos['periodo'];
        
        $ldate = date('Y-m-d H:i:s');
        $this->filters['srv_fecha'] = date('Y-m-d',strtotime($ldate));
        $this->filters['srv_mes'] = intval(date('m',strtotime($ldate)));
        $this->filters['srv_ingmes'] = intval(date('m',strtotime($ldate)));

        $this->lngrupo = $tblgenerals['id'];
        $this->lnperiodo = $tblperiodos['id'];
        $this->lnmes = intval(date('m',strtotime($ldate)));
        $this->graphIngDia  = date('Y-m-d',strtotime($ldate));
        $this->graphIngMes  = intval(date('m',strtotime($ldate)));
        $this->graphRubros = $tblperiodos['periodo'];

        $this->consulta();
    }

    public function render()
    {   
        $ldate     = date('Y-m-d H:i:s');
        $mesactual = intval(date('m',strtotime($ldate)));

        $tblgenerals = TmGeneralidades::where('superior',1)->get();
        $tblperiodos = TmPeriodosLectivos::orderBy("periodo","desc")->get();

        $personas = TmPersonas::query()
        ->where("tipopersona","E")
        ->get();
        
        $ingresos = TrCobrosCabs::query()
        ->whereRaw('year(fecha) = '.$tblperiodos[0]->periodo.' and month(fecha) = '.$mesactual)
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


    public function updatedLnMes() {
        
        $this->filters['srv_mes'] = intval($this->lnmes);
        $this->consulta();
        $this->actualizaGraph();

    }

    public function updatedGraphIngDia() {
        
        $this->filters['srv_fecha'] = $this->graphIngDia;
        $this->consulta();
        $this->actualizaGraph();
    }
    
    public function updatedGraphIngMes() {
        
        $this->filters['srv_ingmes'] = $this->graphIngMes;
        $this->consulta();
        $this->actualizaGraph();
    }

    public function updatedGraphRubros() {
        
        $this->filters['srv_ejercicio'] = $this->graphRubros;
        $this->consulta();
        $this->actualizaGraph();
    }

    public function updatedLnPeriodo(){

        $this->filters['srv_periodo'] = $this->lnperiodo;
        $this->consulta();
        $this->actualizaGraph();

    }

    public function actualizaGraph(){
        $this->dispatchBrowserEvent('name-updated', ['newObj' => $this->data]);
        $this->dispatchBrowserEvent('grahp-ingdia', ['newObj' => $this->datIngdia]);
        $this->dispatchBrowserEvent('grahp-ingmes', ['newObj' => $this->datIngmes]);
        $this->dispatchBrowserEvent('grahp-rubros', ['newObj' => $this->cobroMes]);
    }

    public function consulta(){

        $fechaFin = date("Y-m-d",strtotime($this->filters['srv_fecha']));
        
        $tblcobros = DB::Select("select * from (
            select fecha,  sum(monto) AS monto
            from tr_cobros_cabs c
            inner join (select d.cobro_id from tm_matriculas m
                inner join tr_deudas_cabs c on c.matricula_id = m.id
                inner join tr_deudas_dets d on d.deudacab_id = c.id
                where d.cobro_id > 0 and 
                m.modalidad_id = ".$this->filters['srv_grupo']." 
                and m.periodo_id = ".$this->filters['srv_periodo']."
                group by d.cobro_id 
            ) as de on de.cobro_id = c.id 
            where c.tipo = 'CP' and fecha < '".$fechaFin."'
            group by fecha) as d
        order by fecha desc limit 7"    
        );

        $tbldeudas = TrDeudasCabs::query()
        ->join("tm_matriculas as m","m.id","=","tr_deudas_cabs.matricula_id")
        ->when($this->filters['srv_periodo'],function($query){
            return $query->where('m.periodo_id',"{$this->filters['srv_periodo']}");
        })
        ->when($this->filters['srv_grupo'],function($query){
            return $query->where('m.modalidad_id',"{$this->filters['srv_grupo']}");
        })
        ->when($this->filters['srv_mes'],function($query){
            return $query->whereRaw('month(tr_deudas_cabs.fecha)<='.$this->filters['srv_mes']);
        })
        ->select('tr_deudas_cabs.*')
        ->where('tr_deudas_cabs.estado','P')
        ->get();
        

        //Cobros ultimo 4 meses
        $tblIngresoMes = DB::Select("Select * from (
            select month(c.fecha) as mes,  sum(monto) AS monto
            from tr_cobros_cabs c
            inner join (select d.cobro_id from tm_matriculas m
                inner join tr_deudas_cabs c on c.matricula_id = m.id
                inner join tr_deudas_dets d on d.deudacab_id = c.id
                where d.cobro_id > 0 and 
                m.modalidad_id = ".$this->filters['srv_grupo']." 
                and m.periodo_id = ".$this->filters['srv_periodo']."
                group by d.cobro_id 
            ) as de on de.cobro_id = c.id
            where c.tipo = 'CP' and month(c.fecha) < ".$this->filters['srv_ingmes']."
            group by month(c.fecha)) as d
        order by mes desc limit 4"    
        );

        //Cobro Mes
        $tblCobroMes = TrDeudasDets::query()
        ->join('tr_deudas_cabs','tr_deudas_cabs.id','=','tr_deudas_dets.deudacab_id')
        ->join('tm_matriculas','tm_matriculas.id','=','tr_deudas_cabs.matricula_id')
        ->selectRaw('left(tr_deudas_cabs.referencia,3) as tipo, month(tr_deudas_dets.fecha) as mes, sum(valor) as valor')
        ->whereRaw("tr_deudas_dets.tipo = 'PAG' and tr_deudas_dets.tipovalor = 'CR' and year(tr_deudas_dets.fecha) = ".$this->filters['srv_ejercicio'])
        ->groupbyRaw("left(tr_deudas_cabs.referencia,3), month(tr_deudas_dets.fecha), year(tr_deudas_dets.fecha)")
        ->orderbyRaw("month(tr_deudas_dets.fecha),left(tr_deudas_cabs.referencia,3)")
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

    public function graphsIngDia($tblcobros){

        $array=[];
        for ($x=6;$x>=0;$x--) {
            $array[] = [
                'name' =>  date('d/M/Y',strtotime($tblcobros[$x]->fecha)),
                'y' => floatVal($tblcobros[$x]->monto),
            ];
        };

        $this->datIngdia = json_encode($array); 
    
    }

    public function graphsIngMes($tblData){

        $linea = count($tblData)-1;
        $array=[];
        for ($x=$linea;$x>=0;$x--) {
            $array[] = [
                'name' => $this->mes[$tblData[$x]->mes],
                'y' => floatVal($tblData[$x]->monto),
            ];
        };

        $this->datIngmes = json_encode($array); 
            
    }

    public function graphsDeudas($tbldeudas){

        $array=[];

        $sinpago = $tbldeudas->where('credito','=',0)->count('estudiante_id');
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

    public function graphsCobros($tblcobros){

        $objGrupo = $tblcobros->groupBy('tipo');
        $total = $tblcobros->groupBy('mes');

        $valores = '';
        $this->cobroMes = "[";

        foreach ($objGrupo as $key => $grupo){
            
            $valores = '';
            $array=[1 => 0,2 => 0,3 => 0,4 => 0,5 => 0,6 => 0,
            7 => 0,8 => 0,9 => 0,10 => 0,11 => 0,12 => 0,];

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
            }

            for($x=1;$x<=12;$x++){
                $valores =  $valores.sprintf('%.2f', $array[$x]).' ,';
            }

            $this->cobroMes = $this->cobroMes."{
                name: '".$tipo ."',
                data: [".substr($valores, 0, -2)."]},";
        }
        
        $valores = '';
        foreach ($total as $data){
            $valor   = $data->sum('valor');
            $valores = $valores.sprintf('%.2f', $valor).' ,';
        }

        $this->cobroMes = $this->cobroMes."{
            name: 'Total',
            data: [".substr($valores, 0, -2)."]},";

        $this->cobroMes = substr($this->cobroMes, 0, -1)."]";
        
    }

    
}
