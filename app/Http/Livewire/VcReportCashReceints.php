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
    public $sede,$nomperiodo, $tblgenerals, $tblperiodos, $nomgrupo='TODOS', $dfecha;
    public $dataPdf = [];
    public $filters = [
        'srv_periodo' => '',
        'srv_grupo' => '',
        'srv_fecha' => '',
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
        
        $ldate = date('Y-m-d H:i:s');
        $periodo = TmPeriodosLectivos::orderBy("periodo","desc")->first();

        $this->filters['srv_fecha'] = date('Y-m-d',strtotime($ldate));
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
        ->join("tr_cobros_dets","tr_cobros_cabs.id","=","tr_cobros_dets.cobrocab_id")
        ->join("tr_deudas_dets","tr_deudas_dets.cobro_id","=","tr_cobros_cabs.id")
        ->join("tr_deudas_cabs","tr_deudas_cabs.id","=","tr_deudas_dets.deudacab_id")
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
        ->where('tr_deudas_dets.tipo','<>','DES')
        ->where('tr_cobros_cabs.tipo','=','CP')
        ->select('tr_cobros_cabs.documento', 'tm_personas.nombres', 'tm_personas.apellidos', 'tm_servicios.descripcion', 'tm_cursos.paralelo', 'detalle', 'tipopago', 'saldo','credito', 'descuento', 'tr_deudas_dets.valor as pago',  'tr_cobros_cabs.usuario', 'tr_cobros_dets.referencia', 'entidad_id')
        ->orderBy('tr_cobros_cabs.fecha')
        ->paginate(15);

        
        if ($this->tblgenerals != null){
            foreach ($this->tblgenerals as $index => $recno)
            {
                if ($recno['id'] == $this->filters['srv_grupo']){
                    $this->nomgrupo = $recno['descripcion'];
                } 
            }
        }

        if ($this->tblperiodos != null){
            foreach ($this->tblperiodos as $index => $recno)
            {
                if ($recno['id'] == $this->filters['srv_periodo']){
                    $this->nomperiodo = $recno['descripcion'];
                } 
            }
        }

        $this->dfecha = $this->filters['srv_fecha'];
        return $tblrecords;
    }

    public function dataReport($objdata=null)
    {   
        $this->datosfilters['periodo'] = $objdata['periodo'];
        $this->datosfilters['grupo'] = $objdata['grupo'];
        $this->datosfilters['fecha'] = $objdata['fecha'];
    }

    public function downloadPDF($ngrupo,$nperiodo,$nfecha)
    {   
        $this->filters['srv_fecha']=$nfecha;

        $tblrecords = $this->consulta();        
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

        $this->datosfilters['grupo']   =  $ngrupo; 
        $this->datosfilters['periodo'] =  $nperiodo;
        $this->datosfilters['fecha']   =  date('d/m/Y',strtotime($nfecha)) ;

        foreach ($tblrecords as $record)
        {
            
            $this->neto      = floatval($this->neto) + floatval($record['saldo']) + floatval($record['credito']);
            $this->descuento = floatval($this->descuento) + floatval($record['descuento']);
            $this->pago      = floatval($this->pago)+ floatval($record['pago']);

            if ($record['tipopago']=="EFE") {
                $this->valorEfe = $this->valorEfe + floatval($record['pago']);
            }

            if ($record['tipopago']=="CHQ") {
                $this->valorChq = $this->valorChq + floatval($record['pago']);
            }
            if ($record['tipopago']=="TAR") {

                $this->valorTar = $this->valorTar + floatval($record['pago']);
                $entidad = Tmgeneralidades::find($record['entidad_id']);

                $detalle['tipo'] = "TAR";
                $detalle['recibo'] = $record['documento'];
                $detalle['referencia'] = $record['referencia'];
                $detalle['entidad'] = $entidad['descripcion'];
                $detalle['valor'] = $record['pago'];
                array_push($resumenpago,$detalle);
                
            }
            if ($record['tipopago']=="DEP") {
                
                $this->valorDep = $this->valorDep + floatval($record['pago']);
                $entidad = Tmgeneralidades::find($record['entidad_id']);

                $detalle['tipo'] = "DEP";
                $detalle['recibo'] = $record['documento'];
                $detalle['referencia'] = $record['referencia'];
                $detalle['entidad'] = $entidad['descripcion'];
                $detalle['valor'] = $record['pago'];
                array_push($resumenpago,$detalle);
            }
            if ($record['tipopago']=="TRA") {

                $this->valorTra = $this->valorTra + floatval($record['pago']);
                $entidad = Tmgeneralidades::find($record['entidad_id']);

                $detalle['tipo'] = "TRA";
                $detalle['recibo'] = $record['documento'];
                $detalle['referencia'] = $record['referencia'];
                $detalle['entidad'] = $entidad['descripcion'];
                $detalle['valor'] = $record['pago'];
                array_push($resumenpago,$detalle);

            }
            if ($record['tipopago']=="CON") {
                $this->valorCon = $this->valorCon + floatval($record['pago']);
            }

            

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

    public function liveWirePDF($ngrupo,$nperiodo,$nfecha)
    {   
        $this->filters['srv_fecha']=$nfecha;
        
        $tblrecords = $this->consulta();        
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

        $this->datosfilters['grupo']   =  $ngrupo; 
        $this->datosfilters['periodo'] =  $nperiodo;
        $this->datosfilters['fecha']   =  date('d/m/Y',strtotime($nfecha)) ;

        foreach ($tblrecords as $record)
        {
            
            $this->neto      = floatval($this->neto) + floatval($record['saldo']) + floatval($record['credito']);
            $this->descuento = floatval($this->descuento) + floatval($record['descuento']);
            $this->pago      = floatval($this->pago)+ floatval($record['pago']);
            
            if ($record['tipopago']=="EFE") {
                $this->valorEfe = $this->valorEfe + floatval($record['pago']);
            }

            if ($record['tipopago']=="CHQ") {
                $this->valorChq = $this->valorChq + floatval($record['pago']);
            }
            if ($record['tipopago']=="TAR") {
                
                $this->valorTar = $this->valorTar + floatval($record['pago']);
                $entidad = Tmgeneralidades::find($record['entidad_id']);

                $detalle['tipo'] = "TAR";
                $detalle['recibo'] = $record['documento'];
                $detalle['referencia'] = $record['referencia'];
                $detalle['entidad'] = $entidad['descripcion'];
                $detalle['valor'] = $record['pago'];
                array_push($resumenpago,$detalle);

            }
            if ($record['tipopago']=="DEP") {
                
                $this->valorDep = $this->valorDep + floatval($record['pago']);
                $entidad = Tmgeneralidades::find($record['entidad_id']);

                $detalle['tipo'] = "DEP";
                $detalle['recibo'] = $record['documento'];
                $detalle['referencia'] = $record['referencia'];
                $detalle['entidad'] = $entidad['descripcion'];
                $detalle['valor'] = $record['pago'];
                array_push($resumenpago,$detalle);
            }
            if ($record['tipopago']=="TRA") {

                $this->valorTra = $this->valorTra + floatval($record['pago']);
                $entidad = Tmgeneralidades::find($record['entidad_id']);

                $detalle['tipo'] = "TRA";
                $detalle['recibo'] = $record['documento'];
                $detalle['referencia'] = $record['referencia'];
                $detalle['entidad'] = $entidad['descripcion'];
                $detalle['valor'] = $record['pago'];
                array_push($resumenpago,$detalle);

            }
            if ($record['tipopago']=="CON") {
                $this->valorCon = $this->valorCon + floatval($record['pago']);
            }

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

        return $pdf->setPaper('a4', 'landscape')->stream('cuadre de caja.pdf');
    }




}
