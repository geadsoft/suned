<?php

namespace App\Http\Livewire;
use App\Models\TmGeneralidades;
use App\Models\TmPeriodosLectivos;
use App\Models\TrCobrosCabs;
use App\Models\TrDeudasCabs;


use Livewire\Component;

class VcStatisticalGraphs extends Component
{   
    public $data,$datIngdia,$datIngmes;
    public $fecha;
    public $filters = [
        'srv_periodo' => '',
        'srv_grupo' => '',
        'srv_mes' => '',
        'srv_fecha' => '',
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

        $ldate = date('Y-m-d H:i:s');
        $this->filters['srv_fecha'] = date('Y-m-d',strtotime($ldate));
        $this->filters['srv_mes'] = intval(date('m',strtotime($ldate)));
       
    }
    

    public function render()
    {   
        
        $tblgenerals = TmGeneralidades::where('superior',1)->get();
        $tblperiodos = TmPeriodosLectivos::orderBy("periodo","desc")->get();

        $tblcobros = TrCobrosCabs::whereBetween('fecha', ['20230208', '20230214'])
        ->selectRaw('fecha, sum(monto) as monto')
        ->groupBy('fecha')
        ->get();

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
        ->get();

        $this->graphsIngesos($tblcobros);
        $this->graphsDeudas($tbldeudas);

        return view('livewire.vc-statistical-graphs',[
            'tblgenerals' => $tblgenerals,
            'tblperiodos' => $tblperiodos,
            "data" => $this->data,
            "datadia" => $this->datIngdia,
            "datames" => $this->datIngmes,
        ]);

    }

    public function consulta(){

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
        ->get();

        $this->graphsDeudas($tbldeudas);
        
    }

    public function graphsIngesos($tblcobros){

        $array=[];
        foreach ($tblcobros as $cobro) {
            $array[] = [
                'name' =>  date('d/M/Y',strtotime($cobro['fecha'])),
                'y' => floatVal($cobro['monto'])
            ];
        }

        $this->datIngdia = json_encode($array);
        

    }

    public function graphsDeudas($tbldeudas){

        $array=[];
        $cancelado = $tbldeudas->where('credito','=','debito')->count('estudiante_id');

        $array[] = [
            'name' =>  'Cancelado',
            'y' => floatVal($cancelado)
        ];


        $abono = $tbldeudas->where('credito','>',0)
        ->where('saldo','>',0)
        ->count('estudiante_id');

        $array[] = [
            'name' =>  'Abonado',
            'y' => floatVal($abono)
        ];

        $sinpago = $tbldeudas->where('credito','=',0)->count('estudiante_id');
        $array[] = [
            'name' =>  'Sin registro',
            'y' => floatVal($sinpago)
        ];

        $this->data = json_encode($array);

    }

    
}
