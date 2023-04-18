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
        'fecha' => '',
        'mesingreso' => '',
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
        11=> 'Novimebre',
        12=> 'Diciembre',
    ];

    public function mount(){
        
        $tblgenerals = TmGeneralidades::where('superior',1)->first();
        $tblperiodos = TmPeriodosLectivos::orderBy("periodo","desc")->first();

        $this->filters['idperiodo'] = $tblperiodos['id'];
        $this->filters['idgrupo']   = $tblgenerals['id'];
        $this->filters['periodo']   = $tblperiodos['periodo'];
        
        $ldate = date('Y-m-d H:i:s');
        $this->filters['fecha']      = date('Y-m-d',strtotime($ldate));
        $this->filters['mescobro']   = intval(date('m',strtotime($ldate)));
        $this->filters['mesingreso'] = intval(date('m',strtotime($ldate)));

        $this->lngrupoId    = $tblgenerals['id'];
        $this->lnperiodoId  = $tblperiodos['id'];
        $this->lnmescobro   = intval(date('m',strtotime($ldate)));
        $this->lsfecha      = date('Y-m-d',strtotime($ldate));
        $this->lnmesingreso = intval(date('m',strtotime($ldate)));
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


    public function updatedlnmescobro() {
        
        $this->filters['mescobro'] = intval($this->lnmescobro);
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

    public function updatedlnperiodo() {
        
        $this->filters['periodo'] = $this->lnperiodo;
        $this->consulta();
        $this->actualizaGraph();
    }

    public function updatedlnperiodoId(){

        $periodo = TmPeriodosLectivos::find($this->lnperiodoId);

        $this->filters['idperiodo'] = $this->lnperiodoId;
        $this->filters['periodo'] = $periodo['periodo'];
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
        
        $tblcobros = DB::Select("select * from (
            select c.fecha,  sum(monto) AS monto
            from tr_cobros_cabs c
            inner join tm_matriculas m on c.matricula_id = m.id
            where c.tipo = 'CP' and c.fecha < '".$fechaFin."' and
            m.modalidad_id = ".$this->filters['idgrupo']." 
            and m.periodo_id = ".$this->filters['idperiodo']."
            group by c.fecha) as d
        order by fecha desc limit 7"    
        );

        $tbldeudas = TrDeudasCabs::query()
        ->join("tm_matriculas as m","m.id","=","tr_deudas_cabs.matricula_id")
        ->when($this->filters['idperiodo'],function($query){
            return $query->where('m.periodo_id',"{$this->filters['idperiodo']}");
        })
        ->when($this->filters['idgrupo'],function($query){
            return $query->where('m.modalidad_id',"{$this->filters['idgrupo']}");
        })
        ->when($this->filters['mescobro'],function($query){
            return $query->whereRaw('month(tr_deudas_cabs.fecha)<='.$this->filters['mescobro']);
        })
        ->select('tr_deudas_cabs.*')
        ->where('tr_deudas_cabs.estado','P')
        ->get();
        

        //Cobros ultimo 4 meses
        $tblIngresoMes = DB::Select("Select * from (
            select month(c.fecha) as mes,  sum(monto) AS monto
            from tr_cobros_cabs c
            inner join tm_matriculas m on c.matricula_id = m.id
            where c.tipo = 'CP' and month(c.fecha) < ".$this->filters['mesingreso']." and
            m.modalidad_id = ".$this->filters['idgrupo']." 
            and m.periodo_id = ".$this->filters['idperiodo']."
            group by month(c.fecha)) as d
        order by mes desc limit 4"    
        );

        //Cobro Mes
        $tblCobroMes = TrDeudasDets::query()
        ->join('tr_deudas_cabs','tr_deudas_cabs.id','=','tr_deudas_dets.deudacab_id')
        ->join('tm_matriculas','tm_matriculas.id','=','tr_deudas_cabs.matricula_id')
        ->selectRaw('left(tr_deudas_cabs.referencia,3) as tipo, month(tr_deudas_dets.fecha) as mes, sum(valor) as valor')
        ->whereRaw("tr_deudas_dets.tipo = 'PAG' and tr_deudas_dets.tipovalor = 'CR' and year(tr_deudas_dets.fecha) = ".$this->filters['periodo']."
        and tm_matriculas.modalidad_id = ".$this->filters['idgrupo'])
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

    public function graphsIngDia($tblcobros){

        $array=[];
        $linea = count($tblcobros)-1;

        for ($x=$linea;$x>=0;$x--) {
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
