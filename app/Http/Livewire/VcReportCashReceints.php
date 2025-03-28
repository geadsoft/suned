<?php

namespace App\Http\Livewire;
use App\Models\TrCobrosCabs;
use App\Models\TrCobrosDets;
use App\Models\TmGeneralidades;
use App\Models\TmPeriodosLectivos;
use App\Models\TmSedes;

use Livewire\Component;
use Illuminate\Support\Facades\DB;

use Livewire\WithPagination;
use PDF;

class VcReportCashReceints extends Component
{   
    use WithPagination;
    public $sede,$nomperiodo, $tblgenerals, $tblperiodos, $nomgrupo='TODOS', $dfecha;
    public $dataPdf = [],$datos;
    public $filters = [
        'srv_periodo' => '',
        'srv_grupo' => '',
        'srv_fecha' => '',
        'srv_fechapago' => '',
        'srv_nombre' => '',

    ];
    public $datosfilters = [
        'periodo' => '',
        'grupo' => '',
        'fecha' => '',
    ];

    public $neto=0, $descuento=0, $cancelado=0, $pago=0;
    public $valorEfe=0, $valorChq=0, $valorTar=0, $valorDep=0, $valorTra=0, $valorCon=0;

    protected $listeners = ['dataReport']; 

    public function mount(){
        
        $año   = date('Y');
        $ldate = date('Y-m-d H:i:s');
        $periodo = TmPeriodosLectivos::where("estado",'A')->first();

        $this->filters['srv_fecha'] = date('Y-m-d',strtotime($ldate));
        $this->filters['srv_fechapago'] = '';
        $this->filters['srv_periodo'] = $periodo['id'];
        $this->filters['srv_grupo'] = '';
        $this->filters['srv_nombre'] = '';

    }
    
    public function render()
    {
       
        $this->tblgenerals = TmGeneralidades::where('superior',1)->get();
        $this->tblperiodos = TmPeriodosLectivos::orderBy("periodo","desc")->get();
        $tblrecords  = $this->consulta();

        return view('livewire.vc-report-cash-receints',[
            'tblrecords' => $tblrecords,
            'tblgenerals' => $this->tblgenerals,
            'tblperiodos' => $this->tblperiodos,
        ]);

    }

    public function paginationView(){
        return 'vendor.livewire.bootstrap'; 
    }

    public function consulta(){
                
        $tblrecords = TrCobrosCabs::query()
        ->join(DB::raw('(select cobrocab_id,group_concat(distinct tipopago) as tipopago 
        from tr_cobros_dets  
        group by 1) d'), 
        function($join)
        {
           $join->on('tr_cobros_cabs.id', '=', 'd.cobrocab_id');
        })
        ->join("tr_deudas_dets","tr_deudas_dets.cobro_id","=","tr_cobros_cabs.id")
        ->join("tr_deudas_cabs","tr_deudas_cabs.id","=","tr_deudas_dets.deudacab_id")
        ->join("tm_matriculas","tm_matriculas.id","=","tr_deudas_cabs.matricula_id")
        ->join("tm_personas","tm_personas.id","=","tm_matriculas.estudiante_id")
        ->join("tm_cursos","tm_cursos.id","=","tm_matriculas.curso_id")
        ->join("tm_servicios","tm_servicios.id","=","tm_cursos.servicio_id")
        ->when($this->filters['srv_nombre'],function($query){
            return $query->whereRaw("concat(p.apellidos,' ',p.nombres) LIKE '%".$this->filters['srv_nombre']."%'");
        })       
        ->when($this->filters['srv_periodo'],function($query){
            return $query->where('tm_matriculas.periodo_id',"{$this->filters['srv_periodo']}");
        })
        ->when($this->filters['srv_grupo'],function($query){
            return $query->where('tm_matriculas.modalidad_id',"{$this->filters['srv_grupo']}");
        })
        ->when($this->filters['srv_fecha'],function($query){
            return $query->where('tr_cobros_cabs.fecha',"{$this->filters['srv_fecha']}");
        })
        ->when($this->filters['srv_fechapago'],function($query){
            return $query->where('tr_cobros_cabs.fechapago',"{$this->filters['srv_fechapago']}");
        })
        ->where([
            ['tr_deudas_dets.tipo','PAG'],
            ['tr_cobros_cabs.tipo','CP'],
        ])
        ->select('tr_cobros_cabs.id','tr_cobros_cabs.documento', 'tm_personas.nombres', 'tm_personas.apellidos', 'tm_servicios.descripcion', 'tm_cursos.paralelo', 'detalle', 'tipopago', 'saldo','credito', 'descuento', 'tr_deudas_dets.valor as pago',  'tr_cobros_cabs.usuario')
        ->orderBy('tr_cobros_cabs.fecha')
        ->paginate(15);
        
        $this->dfecha = $this->filters['srv_fecha'];
        $this->datos = json_encode($this->filters);
         
        return $tblrecords;

    }

    public function dataReport($objdata=null)
    {   
        $this->datosfilters['periodo'] = $objdata['periodo'];
        $this->datosfilters['grupo'] = $objdata['grupo'];
        $this->datosfilters['fecha'] = $objdata['fecha'];
    }

    public function impresion(){

        $tblrecords = TrCobrosCabs::query()
        ->join(DB::raw('(select cobrocab_id,group_concat(distinct tipopago) as tipopago 
        from tr_cobros_dets  
        group by 1) c'), 
        function($join)
        {
           $join->on('tr_cobros_cabs.id', '=', 'c.cobrocab_id');
        })
        ->join(DB::raw("(select sum(case when tipo in ('PAG','OTR') then valor else 0 end) as valor,
        sum(case when tipo = 'DES' then valor else 0 end) as descuento,
        deudacab_id, fecha, detalle, cobro_id
        from tr_deudas_dets d 
        group by deudacab_id,fecha, detalle, cobro_id) as d"),function($join){
            $join->on('d.cobro_id', '=', 'tr_cobros_cabs.id');
        })
        ->join("tr_deudas_cabs","tr_deudas_cabs.id","=","d.deudacab_id")
        ->leftjoin(DB::raw("(select sum(case when tipo in ('PAG','OTR') then valor else 0 end) as pagoant,
        sum(case when tipo = 'DES' then valor else 0 end) as desant,
        deudacab_id
        from tr_deudas_dets d
        where d.tipovalor = 'CR' and fecha < '".$this->filters['srv_fecha']."'
        group by deudacab_id) as p"),function($join){
            $join->on('p.deudacab_id', '=', 'tr_deudas_cabs.id');
        })
        ->join("tm_matriculas","tm_matriculas.id","=","tr_deudas_cabs.matricula_id")
        ->join("tm_personas","tm_personas.id","=","tm_matriculas.estudiante_id")
        ->join("tm_cursos","tm_cursos.id","=","tm_matriculas.curso_id")
        ->join("tm_servicios","tm_servicios.id","=","tm_cursos.servicio_id")
        ->when($this->filters['srv_nombre'],function($query){
            return $query->where('tm_personas.nombres','like','%'.$this->filters['srv_nombre'].'%')
                        ->orWhere('tm_personas.apellidos','like','%'.$this->filters['srv_nombre'].'%');
        })       
        ->when($this->filters['srv_periodo'],function($query){
            return $query->where('tm_matriculas.periodo_id',"{$this->filters['srv_periodo']}");
        })
        ->when($this->filters['srv_grupo'],function($query){
            return $query->where('tm_matriculas.modalidad_id',"{$this->filters['srv_grupo']}");
        })
        ->when($this->filters['srv_fecha'],function($query){
            return $query->where('tr_cobros_cabs.fecha',"{$this->filters['srv_fecha']}");
        })
        ->where([
            /*['tr_deudas_dets.tipo','PAG'],*/
            ['tr_cobros_cabs.tipo','CP'],
        ])
        ->select('tr_cobros_cabs.id','tr_cobros_cabs.documento', 'tm_personas.nombres', 'tm_personas.apellidos', 'tm_servicios.descripcion', 'tm_cursos.paralelo', 'detalle', 
        'tipopago', 'saldo','debito','credito', 'd.descuento', 'd.valor as pago',  'tr_cobros_cabs.usuario', 'tr_cobros_cabs.estado', 'p.pagoant', 'p.desant')
        ->orderBy('tr_cobros_cabs.fecha')
        ->get();

        return $tblrecords;

    }

    public function downloadPDF($objdata)
    {   
        $data = json_decode($objdata);
        $this->filters['srv_fecha']   = $data->srv_fecha;
        $this->filters['srv_periodo'] = $data->srv_periodo;
        $this->filters['srv_grupo']   = $data->srv_grupo;
        $this->filters['srv_nombre']  = $data->srv_nombre;

        $tblrecords = $this->impresion(); 
        
        //Detalle Pago
        $detCobro = $tblrecords->groupBy('id');

        $idCobro = "";
        foreach ($detCobro as $key => $value) {
            $idCobro = $idCobro.strval($key).',';
        }
        $idCobro = substr($idCobro,0,-1);
        $tbldetalle = TrCobrosDets::query()
        ->join("tr_cobros_cabs","tr_cobros_cabs.id","=","tr_cobros_dets.cobrocab_id")
        ->selectRaw("tr_cobros_cabs.documento,tr_cobros_dets.*")
        ->whereRaw("tr_cobros_cabs.id in (".$idCobro.") and tr_cobros_dets.estado<>'A'")
        ->get(); 

        $sede    = TmSedes::where('id',1)->first();
        
        $tblTotal  = [];
        $resumen   = [
            'detalle' => '',
            'valor' => 0,
        ];
        
        $formapago   = [];
        $detallepago = [
            'nombre' => '',
            'valor' => 0,
        ];

        $resumenpago = [];
        $detalle = [
            'tipo'       => '',
            'recibo'     => '',
            'referencia' => '',
            'entidad'    => '',
            'valor'      => 0,
        ];

        $objgrupo = TmGeneralidades::find($this->filters['srv_grupo']);
        $this->datosfilters['grupo']   = 'TODOS';
        if ($objgrupo!=""){
            $this->datosfilters['grupo']   =  $objgrupo['descripcion']; 
        }

        $objperiodo = TmPeriodosLectivos::find($this->filters['srv_periodo']);
        if ($objperiodo!=""){
            $this->datosfilters['periodo'] =  $objperiodo['descripcion'];
        }
        
        $this->datosfilters['fecha']   =  date('d/m/Y',strtotime($this->filters['srv_fecha'])) ;

        foreach ($tblrecords as $record)
        {
            if($record['estado']=='A'){
                continue;
            }
            
            $this->neto      = floatval($this->neto) + (floatval($record['debito']) - floatval($record['pagoant']) + floatval($record['desant']));
            $this->descuento = floatval($this->descuento) + floatval($record['descuento']);
            $this->pago      = floatval($this->pago)+ floatval($record['pago']);
        }

        $this->valorEfe = $tbldetalle->where('tipopago','EFE')->sum('valor');
        $this->valorChq = $tbldetalle->where('tipopago','CHQ')->sum('valor');
        $this->valorTar = $tbldetalle->where('tipopago','TAR')->sum('valor');
        $this->valorDep = $tbldetalle->where('tipopago','DEP')->sum('valor');
        $this->valorTra = $tbldetalle->where('tipopago','TRA')->sum('valor');
        $this->valorCon = $tbldetalle->where('tipopago','CON')->sum('valor');
        $this->valorRet = $tbldetalle->where('tipopago','RET')->sum('valor');
        $this->valorApp = $tbldetalle->where('tipopago','APP')->sum('valor');
        $this->valorOtr = $tbldetalle->where('tipopago','OTR')->sum('valor');

        foreach ($tbldetalle as $detpago){

            $entidad = Tmgeneralidades::find($detpago['entidad_id']);

            $detalle['tipo']        = $detpago['tipopago'];
            $detalle['recibo']      = $detpago['documento'];
            $detalle['referencia']  = $detpago['referencia'];
            $detalle['entidad']     = $entidad['descripcion'];
            $detalle['valor']       = $detpago['valor'];
            array_push($resumenpago,$detalle);
        }

        $resumen['detalle'] = 'Valor sin desc.';
        $resumen['valor'] = $this->neto;
        array_push($tblTotal,$resumen);

        $resumen['detalle'] = 'Descuento';
        $resumen['valor'] = $this->descuento;
        array_push($tblTotal,$resumen);

        $resumen['detalle'] = 'Cancelado';
        $resumen['valor'] = $this->pago;
        array_push($tblTotal,$resumen);   
        
        //Forma de Pago
        $detallepago['nombre'] = 'Efectivo';
        $detallepago['valor'] = $this->valorEfe;
        array_push($formapago,$detallepago);

        $detallepago['nombre'] = 'Cheque';
        $detallepago['valor'] = $this->valorChq;
        array_push($formapago,$detallepago);

        $detallepago['nombre'] = 'Tarjeta de Crédito';
        $detallepago['valor'] = $this->valorTar;
        array_push($formapago,$detallepago);

        $detallepago['nombre'] = 'Depósito';
        $detallepago['valor'] = $this->valorDep;
        array_push($formapago,$detallepago);

        $detallepago['nombre'] = 'Transferencia';
        $detallepago['valor'] = $this->valorTra;
        array_push($formapago,$detallepago);

        $detallepago['nombre'] = 'Retención';
        $detallepago['valor'] = $this->valorRet;
        array_push($formapago,$detallepago);

        $detallepago['nombre'] = 'App Movil';
        $detallepago['valor'] = $this->valorApp;
        array_push($formapago,$detallepago);

        $detallepago['nombre'] = 'Otros';
        $detallepago['valor'] = $this->valorOtr;
        array_push($formapago,$detallepago);

        $detallepago['nombre'] = 'Convenio';
        $detallepago['valor'] = $this->valorCon;
        array_push($formapago,$detallepago);

        //Vista
        $pdf = PDF::loadView('reports/cuadre_caja',[
            'tblrecords' => $tblrecords,
            'sede' => $sede,
            'filter' => $this->datosfilters,
            'tblTotal' => $tblTotal,
            'tblfpago' => $formapago,
            'resumenpago' => $resumenpago,
        ]);

        return $pdf->download('cuadre de caja.pdf');
    }

    public function liveWirePDF($objdata)
    {   

        $data = json_decode($objdata);
        $this->filters['srv_fecha']   = $data->srv_fecha;
        $this->filters['srv_periodo'] = $data->srv_periodo;
        $this->filters['srv_grupo']   = $data->srv_grupo;
        $this->filters['srv_nombre']  = $data->srv_nombre;
        
        $tblrecords = $this->impresion();
        
        //Detalle Pago
        $detCobro = $tblrecords->groupBy('id');

        $idCobro = "";
        foreach ($detCobro as $key => $value) {
            $idCobro = $idCobro.strval($key).',';
        }
        $idCobro = substr($idCobro,0,-1);
        $tbldetalle = TrCobrosDets::query()
        ->join("tr_cobros_cabs","tr_cobros_cabs.id","=","tr_cobros_dets.cobrocab_id")
        ->selectRaw("tr_cobros_cabs.documento,tr_cobros_dets.*")
        ->whereRaw("tr_cobros_cabs.id in (".$idCobro.") and tr_cobros_dets.estado<>'A'")
        ->get(); 

        $sede    = TmSedes::where('id',1)->first();
        $tblTotal  = [];
        $resumen   = [
            'detalle' => '',
            'valor' => 0,
        ]; 

        $formapago   = [];
        $detallepago = [
            'nombre' => '',
            'valor' => 0,
        ];

        $resumenpago = [];
        $detalle = [
            'tipo'       => '',
            'recibo'     => '',
            'referencia' => '',
            'entidad'    => '',
            'valor'      => 0,
        ];

        $objgrupo = TmGeneralidades::find($this->filters['srv_grupo']);
        $this->datosfilters['grupo']   = 'TODOS';
        if ($objgrupo!=""){
            $this->datosfilters['grupo']   =  $objgrupo['descripcion']; 
        }

        $objperiodo = TmPeriodosLectivos::find($this->filters['srv_periodo']);
        if ($objperiodo!=""){
            $this->datosfilters['periodo'] =  $objperiodo['descripcion'];
        }

        $this->datosfilters['fecha']   =  date('d/m/Y',strtotime($this->filters['srv_fecha'])) ;

        foreach ($tblrecords as $record)
        {
            if($record['estado']=='A'){
                continue;
            }

            $this->neto      = floatval($this->neto) + (floatval($record['debito']) - floatval($record['pagoant']) + floatval($record['desant']));
            $this->descuento = floatval($this->descuento) + floatval($record['descuento']);
            $this->pago      = floatval($this->pago)+ floatval($record['pago']);
        
        }

        $this->valorEfe = $tbldetalle->where('tipopago','EFE')->sum('valor');
        $this->valorChq = $tbldetalle->where('tipopago','CHQ')->sum('valor');
        $this->valorTar = $tbldetalle->where('tipopago','TAR')->sum('valor');
        $this->valorDep = $tbldetalle->where('tipopago','DEP')->sum('valor');
        $this->valorTra = $tbldetalle->where('tipopago','TRA')->sum('valor');
        $this->valorCon = $tbldetalle->where('tipopago','CON')->sum('valor');
        $this->valorRet = $tbldetalle->where('tipopago','RET')->sum('valor');
        $this->valorApp = $tbldetalle->where('tipopago','APP')->sum('valor');
        $this->valorOtr = $tbldetalle->where('tipopago','OTR')->sum('valor');

        foreach ($tbldetalle as $detpago){

            $entidad = Tmgeneralidades::find($detpago['entidad_id']);

            $detalle['tipo']        = $detpago['tipopago'];
            $detalle['recibo']      = $detpago['documento'];
            $detalle['referencia']  = $detpago['referencia'];
            $detalle['entidad']     = $entidad['descripcion'];
            $detalle['valor']       = $detpago['valor'];
            array_push($resumenpago,$detalle);
        }

        $resumen['detalle'] = 'Valor sin desc.';
        $resumen['valor'] = $this->neto;
        array_push($tblTotal,$resumen);

        $resumen['detalle'] = 'Descuento';
        $resumen['valor'] = $this->descuento;
        array_push($tblTotal,$resumen);

        $resumen['detalle'] = 'Cancelado';
        $resumen['valor'] = $this->pago;
        array_push($tblTotal,$resumen);   
        
        //Forma de Pago
        $detallepago['nombre'] = 'Efectivo';
        $detallepago['valor'] = $this->valorEfe;
        array_push($formapago,$detallepago);

        $detallepago['nombre'] = 'Cheque';
        $detallepago['valor'] = $this->valorChq;
        array_push($formapago,$detallepago);

        $detallepago['nombre'] = 'Tarjeta de Crédito';
        $detallepago['valor'] = $this->valorTar;
        array_push($formapago,$detallepago);

        $detallepago['nombre'] = 'Depósito';
        $detallepago['valor'] = $this->valorDep;
        array_push($formapago,$detallepago);

        $detallepago['nombre'] = 'Transferencia';
        $detallepago['valor'] = $this->valorTra;
        array_push($formapago,$detallepago);

        $detallepago['nombre'] = 'Retención';
        $detallepago['valor'] = $this->valorRet;
        array_push($formapago,$detallepago);

        $detallepago['nombre'] = 'App Movil';
        $detallepago['valor'] = $this->valorApp;
        array_push($formapago,$detallepago);

        $detallepago['nombre'] = 'Otros';
        $detallepago['valor'] = $this->valorOtr;
        array_push($formapago,$detallepago);

        $detallepago['nombre'] = 'Convenio';
        $detallepago['valor'] = $this->valorCon;
        array_push($formapago,$detallepago);

        $pdf = PDF::loadView('reports/cuadre_caja',[
            'tblrecords' => $tblrecords,
            'sede' => $sede,
            'filter' => $this->datosfilters,
            'tblTotal' => $tblTotal,
            'tblfpago' => $formapago,
            'resumenpago' => $resumenpago,
        ]);

        return $pdf->setPaper('a4')->stream('cuadre de caja.pdf');
    }

}

?>