<?php

namespace App\Http\Livewire;
use App\Models\TrDeudasCabs;
use Livewire\Component;

class VcDebtGraph extends Component
{
    
    public $data;
    public $filters = [
        'srv_periodo' => '',
        'srv_grupo' => '',
        'srv_mes' => '',
    ];

    public function mount($periodo,$grupo,$mes){
        
        $this->filters['srv_periodo'] = $periodo;
        $this->filters['srv_grupo'] = $grupo;
        $this->filters['srv_mes'] = $mes;

        $this->consulta();
       
    }

    public function render()
    {
        
        return view('livewire.vc-debt-graph');
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

        $this->dispatchBrowserEvent('load-funcion');

    }



}
