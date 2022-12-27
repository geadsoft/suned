<?php

namespace App\Http\Livewire;
use App\Models\TrCobrosCabs;
use App\Models\TmGeneralidades;
use App\Models\TmPeriodosLectivos;
use App\Models\TmSedes;

use Livewire\Component;
use Livewire\WithPagination;
use PDF;

class VcReportCashReceints extends Component
{   
    use WithPagination;
    public $sede;
    public $dataPdf = [];
    public $filters = [
        'srv_periodo' => '',
        'srv_grupo' => '',
        'srv_fecha' => '',
    ];
    public $neto=0, $descuento=0, $cancelado=0;

    public function mount(){
        
        $ldate = date('Y-m-d H:i:s');
        $this->filters['srv_fecha'] = date('Y-m-d',strtotime($ldate));
    }
    
    public function render()
    {
       
        $tblgenerals = TmGeneralidades::where('superior',1)->get();
        $tblperiodos = TmPeriodosLectivos::orderBy("periodo","desc")->get();
        $tblrecords  = $this->consulta();

        return view('livewire.vc-report-cash-receints',[
            'tblrecords' => $tblrecords,
            'tblgenerals' => $tblgenerals,
            'tblperiodos' => $tblperiodos,
        ]);

    }

    public function paginationView(){
        return 'vendor.livewire.bootstrap'; 
    }

    public function consulta(){
        
        $tblrecords = TrCobrosCabs::query()
        ->join("tr_cobros_dets","tr_cobros_cabs.id","=","tr_cobros_dets.cobrocab_id")
        ->join("tr_deudas_dets","tr_deudas_dets.cobro_id","=","tr_cobros_cabs.id")
        ->join("tr_deudas_cabs","tr_deudas_cabs.id","=","tr_deudas_dets.deudacab_id")
        ->join("tm_matriculas","tm_matriculas.id","=","tr_deudas_cabs.matricula_id")
        ->join("tm_personas","tm_personas.id","=","tm_matriculas.estudiante_id")
        ->join("tm_cursos","tm_cursos.id","=","tm_matriculas.curso_id")
        ->join("tm_servicios","tm_servicios.id","=","tm_cursos.grado_id")            
        ->when($this->filters['srv_periodo'],function($query){
            return $query->where('tm_matriculas.periodo_id',"{$this->filters['srv_periodo']}");
        })
        ->when($this->filters['srv_grupo'],function($query){
            return $query->where('tm_matriculas.modalidad_id',"{$this->filters['srv_grupo']}");
        })
        
        ->select('tr_cobros_cabs.documento', 'tm_personas.nombres', 'tm_personas.apellidos', 'tm_servicios.descripcion', 'tm_cursos.paralelo', 'detalle', 'tipopago', 'saldo','credito', 'descuento', 'tr_cobros_dets.valor as pago',  'tr_cobros_cabs.usuario')
        ->orderBy('tr_cobros_cabs.fecha')
        ->paginate(15);

        return $tblrecords;
    }


    public function downloadPDF()
    {   
        $tblrecords = $this->consulta();
        $sede    = TmSedes::where('id',1)->first();
        $filter  = $this->filters;
        $resumen   = [
            'detalle' => '',
            'valor' => 0,
        ];
        $total   = [];
        
        foreach ($tblrecords as $record)
        {
            $this->neto = $this->neto + floatval($record['saldo']);
            $this->descuento =  $this->descuento + floatval($record['descuento']);
            $this->pago = $this->pago = floatval($record['pago']);
            
        }
        $resumen['detalle'] = 'Valor sin desc.';
        $resumen['valor'] = $this->neto;
        array_push($total,$resumen);

        $resumen['detalle'] = 'Descuento';
        $resumen['valor'] = $this->descuento;
        array_push($total,$resumen);

        $resumen['detalle'] = 'Cancelado';
        $resumen['valor'] = $this->pago;
        array_push($total,$resumen);        

        $pdf = PDF::loadView('reports/cuadre_caja',[
            'tblrecords' => $tblrecords,
            'sede' => $sede,
            'filter' => $filter,
            'total' => $total,
        ]);

        return $pdf->download('cuadre de caja.pdf');
    }


}
