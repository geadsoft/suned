<?php

namespace App\Http\Livewire;

use App\Models\TrCobrosCabs;
use App\Models\TrDeudasCabs;
use Livewire\Component;

class VcStatisticalGraphs extends Component
{   
    public $data,$datIngdia,$datIngmes;
    public $fecha;
    public $filters = [
        'srv_plectivo' => '',
        'srv_grupo' => '',
        'srv_mes' => '',
        'srv_periodo' => '',
        'srv_fecha' => '',
    ];

    public function mount(){
        $ldate = date('Y-m-d H:i:s');
        $this->filters['srv_fecha'] = date('Y-m-d',strtotime($ldate));
        $this->filters['srv_mes'] = date('m',strtotime($ldate));
        $this->filters['srv_periodo'] = date('Y',strtotime($ldate));
    }
    

    public function render()
    {   
        $this->filters['srv_mes'] = 2;
        $this->filters['srv_periodo'] = 2023;
        
        $tblcobros = TrCobrosCabs::whereBetween('fecha', ['20230208', '20230214'])
        ->selectRaw('fecha, sum(monto) as monto')
        ->groupBy('fecha')
        ->get();

        $tbldeudas = TrDeudasCabs::whereRaw('month(fecha) = '.$this->filters['srv_mes'].' and year(fecha) = '.$this->filters['srv_periodo']
        )->get();

        $this->graphsIngesos($tblcobros);
        $this->graphsDeudas($tbldeudas);

        return view('livewire.vc-statistical-graphs',[
            "data" => $this->data,
            "datadia" => $this->datIngdia,
            "datames" => $this->datIngmes,
        ]);

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
