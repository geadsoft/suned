<?php

namespace App\Http\Livewire;
use App\Models\TmPeriodosLectivos;
use App\Models\TmMatricula;
use App\Models\TrDeudasCabs;

use Livewire\Component;
use Illuminate\Support\Facades\DB;

class VcPanel extends Component
{
    public $lnperiodoId, $periodoOld, $hombres, $mujeres;
    public $chartsmatricula=[], $chartsregistros=[], $chartsmodalidad=[], $chartspension=[];
    public $glosa, $ejercicio, $mes;

    public $objmes = [
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

        $año     = date('Y');
        $periodo = TmPeriodosLectivos::where("estado","A")->first();
        $anioant = TmPeriodosLectivos::where('periodo',$periodo->periodo-1)->first();

        $ldate     = date('Y-m-d H:i:s');
        $this->mes = date('m',strtotime($ldate));

        $this->glosa       = $periodo['descripcion'];
        $this->ejercicio  = $periodo['periodo'];
        $this->lnperiodoId = $periodo['id'];
        $this->periodoOld  = $anioant['id'];
    }
    
    public function render()
    {
        $personas = TmMatricula::query()
        ->join('tm_personas as p','p.id','tm_matriculas.estudiante_id')
        ->where('tm_matriculas.periodo_id',$this->lnperiodoId)
        ->where("tipopersona","E")
        ->where("tm_matriculas.estado","A")
        ->get();
        
        $this->hombres = $personas->where('genero','M')->count('id');
        $this->mujeres = $personas->where('genero','F')->count('id');
        
        $matricula = TmMatricula::query()
        ->join('tm_personas as p','p.id','tm_matriculas.estudiante_id')
        ->leftJoin('tm_matriculas as a', function($join)
        {
            $join->on('a.estudiante_id', '=', 'tm_matriculas.estudiante_id');
            $join->on('a.periodo_id', '=',DB::raw($this->periodoOld));
        })
        ->selectRaw("count(tm_matriculas.estudiante_id) as cantidad, Case When a.id is null then 'N' else 'A' End as tipo") 
        ->where('tm_matriculas.periodo_id',$this->lnperiodoId)
        ->where("tipopersona","E")
        ->where("tm_matriculas.estado","A")
        ->whereRaw("tm_matriculas.modalidad_id in (2,4)")
        ->groupByRaw("Case When a.id is null then 'N' else 'A' End")
        ->get();

        $this->chartsmatricula = json_encode($personas);
        $array=[];
        foreach($matricula as $recno){

            if($recno->tipo=='N'){
                $array[] = [
                    'name' =>  'Estudiantes Nuevos',
                    'y' => floatVal($recno->cantidad)
                ];
            }else{
                $array[] = [
                    'name' =>  'Estudiantes Propios',
                    'y' => floatVal($recno->cantidad)
                ];
            }

        }
   
        $this->chartsregistros = json_encode($array);

        $this->matricula();
        $this->deudaPension();

        return view('livewire.vc-panel');
    }

    public function matricula(){

        $personas = TmMatricula::query()
        ->join('tm_personas as p','p.id','tm_matriculas.estudiante_id')
        ->join('tm_generalidades as g','g.id','tm_matriculas.modalidad_id')
        ->selectRaw('g.descripcion,p.genero, count(p.identificacion) as cantidad')
        ->where('tm_matriculas.periodo_id',$this->lnperiodoId)
        ->where("p.tipopersona","E")
        ->where("tm_matriculas.estado","A")
        ->groupbyRaw('g.descripcion,p.genero')
        ->get();

        $grupo = $personas->groupBy('genero');

        $valores = '';
        $objArray=[];
        foreach ($grupo as $key => $recno){

            $valores = '';
            $array=['Presencial'=> 0,'Distancia' => 0,'Virtual' => 0];

            foreach ($recno as $data){
                $array[$data['descripcion']] = $data['cantidad'];
            }

            switch ($key){
                case "M":
                    $tipo = 'Hombres';
                    break;
                case "F":
                    $tipo = 'Mujeres';
                    break;
            }

            $valores =  $valores.sprintf('%.2f', $array['Presencial']).' ,';
            $valores =  $valores.sprintf('%.2f', $array['Distancia']).' ,';
            $valores =  $valores.sprintf('%.2f', $array['Virtual']).' ,';            

            $objArray[] = [
                'name' => $tipo,
                'data' => [substr($valores, 0, -2)],
            ];

        }

        $strarray = json_encode($objArray);
        $strarray = str_replace('"name"','name',$strarray);
        $strarray = str_replace('"data"','data',$strarray);
        $strarray = str_replace('["','[',$strarray);
        $strarray = str_replace('"]',']',$strarray);
                
        $this->chartsmodalidad =  $strarray;
        
    }

    public function deudaPension(){

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
        ->when($this->lnperiodoId,function($query){
            return $query->where('m.periodo_id',"{$this->lnperiodoId}");
        })
        ->when($this->mes,function($query){
            return $query->whereRaw('month(tr_deudas_cabs.fecha)='.$this->mes);
        })
        ->when($this->ejercicio,function($query){
            return $query->whereRaw('year(tr_deudas_cabs.fecha)='.$this->ejercicio);
        })
        ->select('tr_deudas_cabs.*')
        ->where('tr_deudas_cabs.estado','P')
        ->where('p.estado','A')
        ->whereraw("left(tr_deudas_cabs.referencia,3)='PEN' and d.id is null")
        ->get();

        if($tbldeudas!=null){
            $this->graphsDeudas($tbldeudas);
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

        $this->chartspension = json_encode($array);
       
    }


}

?>
