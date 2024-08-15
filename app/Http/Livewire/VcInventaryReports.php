<?php

namespace App\Http\Livewire;

use App\Models\TrInventarioCabs;
use App\Models\TrInventarioDets;
use App\Models\TrInventarioFpago;
use App\Models\TmProductos;
use App\Models\TmGeneralidades;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Livewire\WithPagination;
use PDF;


class VcInventaryReports extends Component
{
    
    use WithPagination;

    public $tblcategoria, $doctipo='EGR';
    public $datos='', $tipo='';

    public $filters=[
        'referencia' => '',
        'tipo' => 'EGR',
        'movimiento' => '',
        'categoria' => 0,
        'talla' => 0,
        'fechaini' => '',
        'fechafin' => '',
        'estudiante' => '',
        'cantidad' => 0,
        'precio' => 0,
        'monto' => 0,
        'tipopago' => '',
    ];

    public $arrtalla=[
        '0'=>'Seleccione Talla',
        '28'=>28,
        '30'=>30,
        '32'=>32,
        '34'=>34,
        '36'=>36,
        '38'=>38,
        '40'=>40,
        '42'=>42,
        '44'=>44,
        '46'=>46,
        '48'=>48,
        '50'=>50,
    ];

    public $movimiento=[];

    public $fpago=[
        "NN" => 'Ninguno',
        "EFE" => 'Efectivo',
        "CHQ" => 'Cheque',
        "TAR" => 'Tarjeta',
        "DEP" => 'Depósito',
        "TRA" => 'Transferencia',
        "APP" => 'App Movil',

    ];

    public function mount($tipo)
    {
        $this->tblcategorias = TmGeneralidades::where('superior',11)->get();
        $this->tipo = $tipo;
        
        $ldate = date('Y-m-d H:i:s');
        $ldate = date('Y',strtotime($ldate)).'-'.date('m',strtotime($ldate)).'-01';
       
        $fechaini = date('Y-m-d',strtotime($ldate));

        $ldate = date('Y-m-d H:i:s');
        $fechafin = date('Y-m-d',strtotime($ldate));

        $this->filters['fechaini'] = $fechaini;
        $this->filters['fechafin'] = $fechafin; 
        $this->filters['tipo'] = $this->tipo; 
        $this->updatedDoctipo('EGR');  
    
    }

    public function render()
    {
        
        $invtra = $this->consulta();

        return view('livewire.vc-inventary-reports',[
            'invtra' => $invtra,
        ]);

    }


    public function paginationView(){
        return 'vendor.livewire.bootstrap'; 
    }

    public function updatedDoctipo($tipo){

        $this->filters['tipo'] = $tipo;
        $this->filters['movimiento'] = '';

        if ($tipo=='ING'){
            $this->movimiento=[
                1 => ['codigo' => ' ', 'nombre' => 'Seleccione Movimiento', 'valor' => ''],
                2 => ['codigo' => 'II', 'nombre' => '(+) Inventario Inicial', 'valor' => '1'], 
                3 => ['codigo' => 'CL', 'nombre' => '(+) Compras Locales', 'valor' => '1'], 
                4 => ['codigo' => 'IA', 'nombre' => '(+) Ingreso por Ajuste', 'valor' => '1'],
                5 => ['codigo' => 'EA', 'nombre' => '(-) Egreso por Ajuste', 'valor' => '-1'],  
                6 => ['codigo' => 'DC', 'nombre' => '(-) Devolución por Compra', 'valor' => '-1'], 
            ];
        }else{
            $this->movimiento=[
                1 => ['codigo' => ' ', 'nombre' => 'Seleccione Movimiento', 'valor' => ''],
                2 => ['codigo' => 'VE', 'nombre' => '(-) Venta', 'valor' => '-1'], 
                3 => ['codigo' => 'DV', 'nombre' => '(+) Devolución por Venta', 'valor' => '1'],
            ];
        }
    }

    public function consulta(){

        
        /* Movimientos */
        $invtra = TrInventarioCabs::query()
        ->join(DB::raw('(select inventariocab_id,group_concat(distinct tipopago) as tipopago 
        from tr_inventario_fpagos  
        group by 1) fp'), 
        function($join)
        {
           $join->on('tr_inventario_cabs.id', '=', 'fp.inventariocab_id');
        })
        ->join("tr_inventario_dets as d","d.inventariocab_id","=","tr_inventario_cabs.id")
        ->join("tm_productos as p","p.id","=","d.producto_id")
        ->join("tm_generalidades as g","g.id","=","p.categoria_id")
        ->when($this->filters['referencia'],function($query){
            return $query->where('p.nombre', 'like' , "%{$this->filters['referencia']}%");
        })
        ->when($this->filters['estudiante'],function($query){
            return $query->where('tr_inventario_cabs.referencia', 'like' , "%{$this->filters['estudiante']}%");
        })
        ->when($this->filters['categoria'],function($query){
            return $query->where('categoria_id',"{$this->filters['categoria']}");
        })
        ->when($this->filters['tipo'],function($query){
            return $query->where('d.tipo',"{$this->filters['tipo']}");
        })
        ->when($this->filters['movimiento'],function($query){
            return $query->where('d.movimiento',"{$this->filters['movimiento']}");
        })
        ->when(intval($this->filters['talla'])>0,function($query){
            return $query->where('p.talla',"{$this->filters['talla']}");
        })
        ->when($this->filters['cantidad']>0,function($query){
            return $query->where('d.cantidad',"{$this->filters['cantidad']}");
        })
        ->when($this->filters['precio']>0,function($query){
            return $query->where('d.precio',"{$this->filters['precio']}");
        })
        ->when($this->filters['monto']>0,function($query){
            return $query->where('d.total',"{$this->filters['monto']}");
        })
        /*->when($this->filters['tipopago'],function($query){
            return $query->where('tipopago',"{$this->filters['tipopago']}");
        })*/
        ->where('d.fecha','>=',date('Ymd',strtotime($this->filters['fechaini'])))
        ->where('d.fecha','<=',date('Ymd',strtotime($this->filters['fechafin'])))
        ->selectRaw('tr_inventario_cabs.*,fp.tipopago as fpago,p.nombre,p.talla,d.precio,d.cantidad,d.total')
        ->orderBy('tr_inventario_cabs.documento','desc','fecha','desc')
        ->paginate(11);


        $arrdata[] = $this->filters;
        $this->datos = json_encode($arrdata);
        
        return $invtra;

    }

    public function report(){ 

        $fechaini = date('Ymd',strtotime($this->filters['fechaini']));
        $fechafin = date('Ymd',strtotime($this->filters['fechafin'])); 

        /* Movimientos */
        //$invtra = DB::select("call reporte_movimientos_inventario('".$fechaini."','".$fechafin."','".$this->filters['referencia']."','',0,'".$this->filters['tipo']."','".$this->filters['movimiento']."',0,0,0,0)");
        $invtra = DB::select("call reporte_movimientos_inventario(?,?,?,?,?,?,?,?,?,?,?)",array($fechaini,$fechafin,$this->filters['referencia'],$this->filters['estudiante'],$this->filters['categoria'],$this->filters['tipo'],$this->filters['movimiento'],$this->filters['talla'],$this->filters['cantidad'],$this->filters['precio'],$this->filters['monto']));
        

        /*$invtra = TrInventarioCabs::query()
        ->join(DB::raw('(select inventariocab_id,group_concat(distinct tipopago) as tipopago 
        from tr_inventario_fpagos  
        group by 1) fp'), 
        function($join)
        {
           $join->on('tr_inventario_cabs.id', '=', 'fp.inventariocab_id');
        })
        ->join("tr_inventario_dets as d","d.inventariocab_id","=","tr_inventario_cabs.id")
        ->join("tm_productos as p","p.id","=","d.producto_id")
        ->join("tm_generalidades as g","g.id","=","p.categoria_id")
        ->join(DB::raw("(
        select 'II' as trans, 1 as variable
        union all
        select 'CL' as trans, 1 as variable
        union all
        select 'IA' as trans, 1 as variable
        union all
        select 'DC' as trans, -1 as variable
        union all
        select 'VE' as trans, 1 as variable
        union all
        select 'EA' as trans, -1 as variable
        union all
        select 'DV' as trans, 1 as variable) as tr"),function($join){
            $join->on('tr.trans', '=', 'd.movimiento');
        })
        ->when($this->filters['referencia'],function($query){
            return $query->where('p.nombre', 'like' , "%{$this->filters['referencia']}%");
        })
        ->when($this->filters['estudiante'],function($query){
            return $query->where('tr_inventario_cabs.referencia', 'like' , "%{$this->filters['estudiante']}%");
        })
        ->when($this->filters['categoria'],function($query){
            return $query->where('categoria_id',"{$this->filters['categoria']}");
        })
        ->when($this->filters['tipo'],function($query){
            return $query->where('d.tipo',"{$this->filters['tipo']}");
        })
        ->when($this->filters['movimiento'],function($query){
            return $query->where('d.movimiento',"{$this->filters['movimiento']}");
        })
        ->when(intval($this->filters['talla'])>0,function($query){
            return $query->where('p.talla',"{$this->filters['talla']}");
        })
        ->when($this->filters['cantidad'],function($query){
            return $query->where('d.cantidad',"{$this->filters['cantidad']}");
        })
        ->when($this->filters['precio'],function($query){
            return $query->where('d.precio',"{$this->filters['precio']}");
        })
        ->when($this->filters['monto'],function($query){
            return $query->where('d.total',"{$this->filters['monto']}");
        })
        /*->when($this->filters['tipopago'],function($query){
            return $query->where('tipopago',"{$this->filters['tipopago']}");
        })
        ->where('d.fecha','>=',date('Ymd',strtotime($this->filters['fechaini'])))
        ->where('d.fecha','<=',date('Ymd',strtotime($this->filters['fechafin'])))
        ->selectRaw('tr_inventario_cabs.*,fp.tipopago as fpago,p.nombre,p.talla,d.precio,(d.cantidad*tr.variable) as cantidad,(d.total*tr.variable) as total')
        ->orderBy('fecha')
        ->get();*/
        
        $arrdata[] = $this->filters;
        $this->datos = json_encode($arrdata);
        
        return $invtra;

    }

    public function deleteFilters(){ 

        $this->filters['referencia'] = '';
        $this->filters['tipo'] = 'EGR';
        $this->filters['movimiento'] = '';
        $this->filters['categoria'] = '';
        $this->filters['talla'] = '0';
        $this->filters['estudiante']  = '';
        $this->filters['cantidad']  = '';
        $this->filters['precio']  = '';
        $this->filters['monto']  = '';
        $this->filters['tipopago']  = '';

    }

    public function printPDF($report,$objdata)
    { 

        ini_set('memory_limit', '256M');
        ini_set('max_execution_time', 300);

        $data = json_decode($objdata);

        $this->filters['referencia'] = $data[0]->referencia;
        $this->filters['tipo'] = $data[0]->tipo;
        $this->filters['movimiento'] = $data[0]->movimiento;
        $this->filters['categoria'] = $data[0]->categoria;
        $this->filters['talla'] = $data[0]->talla;
        $this->filters['fechaini'] = $data[0]->fechaini;
        $this->filters['fechafin']  = $data[0]->fechafin;
        $this->filters['estudiante']  = $data[0]->estudiante;
        $this->filters['cantidad']  = $data[0]->cantidad;
        $this->filters['precio']  = $data[0]->precio;
        $this->filters['monto']  = $data[0]->monto;
        $this->filters['tipopago']  = $data[0]->tipopago;

        $invtra   = $this->report();

        if ($report=='PRD'){

            $fechaini = date('Ymd',strtotime($this->filters['fechaini']));
            $fechafin = date('Ymd',strtotime($this->filters['fechafin'])); 

            $sqldetPago = DB::select("call reporte_productos_detallepagos('".$fechaini."','".$fechafin."','','',0,'".$this->filters['tipo']."','".$this->filters['movimiento']."',0,0,0,0)");
            $collection = collect($sqldetPago);

            $grouped = $collection->groupBy('tipopago');
                    
            $resumen=[];
            foreach($grouped as $key => $tipopago){
                
                $detalle=[];
                foreach($tipopago as $tpago){ 
                    $detpago['fecha'] = $tpago->fecha;
                    $detpago['documento'] = $tpago->documento;
                    $detpago['valor'] = $tpago->valor;                
                    array_push($detalle,$detpago);
                }
                $resumen[$key] = $detalle;
            }
        

            $sqlPagos = DB::select("call reporte_productos('".$fechaini."','".$fechafin."','','',0,'".$this->filters['tipo']."','".$this->filters['movimiento']."',0,0,0,0)");
            $formapago=[];
            foreach($sqlPagos as $key){
                
                $array['tipopago'] = $key->tipopago;
                $array['total'] = $key->total;
                array_push($formapago,$array);
            }
            
            $lsreport = 'reports/detail_producto';
        }else{

            $fechaini = date('Ymd',strtotime($this->filters['fechaini']));
            $fechafin = date('Ymd',strtotime($this->filters['fechafin']));
            
            $sqlPagos = DB::select("call reporte_productos('".$fechaini."','".$fechafin."','','',0,'".$this->filters['tipo']."','".$this->filters['movimiento']."',0,0,0,0)");
            
            $resumen  =[];
            $formapago=[];
            foreach($sqlPagos as $key){
                
                $array['tipopago'] = $key->tipopago;
                $array['total'] = $key->total;
                array_push($formapago,$array);
            }

            $lsreport = 'reports/detail_movimientos';
        }

        $transac=[
            'II' => '(+) Inventario Inicial', 
            'CL' => '(+) Compras Locales',  
            'IA' => '(+) Ingreso por Ajuste', 
            'DC' => '(-) Devolución por Compra', 
            'VE' => '(-) Venta',  
            'EA' => '(-) Egreso por Ajuste', 
            'DV' => '(+) Devolución por Venta',
        ];

        $filtros = '';
        foreach($this->filters as $key=>$value){
            
            if( $value!='' & str_contains($key, 'fecha') == false & $value!='Seleccione Talla'){
                
                if($key=='movimiento'){
                    $filtros = $filtros.' '.$key.': '.$transac[$value].",\n";
                }else{
                    $filtros = $filtros.' '.$key.': '.$value.",\n";
                }

            }
        }

        $info['fechaini'] = $data[0]->fechaini; 
        $info['fechafin'] = $data[0]->fechafin; 

        $arrsuma=['II','CL','IA','DV'];
        $arresta=['DC','VE','EA'];

        $fpago=[
            'NN' => 'Ninguno',
            'EFE' => 'Efectivo',
            'CHQ' => 'Cheque',
            'TAR' => 'Crédito',
            'DEP' => 'Deposito',
            'TRA' => 'Transferencia',
            'APP' => 'Aplicación Movil',
        ];

        $totalmonto  = (array_sum(array_column($invtra,'total')));
        $totcantidad = (array_sum(array_column($invtra,'cantidad')));
        $totalres    = 0;

        //Vista
        $pdf = PDF::loadView($lsreport,[
            'invtra'  => $invtra,
            'info'    => $info,
            'filtros' => $filtros,
            'arrsuma' => $arrsuma,
            'arresta' => $arresta,
            'resumen' => $resumen,
            'fpago'     => $fpago,
            'totalres'  => $totalres,
            'formapago' => $formapago,
            'totalmonto' => $totalmonto,
            'totcantidad' => $totcantidad,
        ]);

        return $pdf->setPaper('a4')->stream('Detalle Productos.pdf');

    }


    public function downloadPDF($report,$objdata)
    { 
        ini_set('memory_limit', '256M');
        ini_set('max_execution_time', 300);
        
        $data = json_decode($objdata);

        $this->filters['referencia'] = $data[0]->referencia;
        $this->filters['tipo'] = $data[0]->tipo;
        $this->filters['movimiento'] = $data[0]->movimiento;
        $this->filters['categoria'] = $data[0]->categoria;
        $this->filters['talla'] = $data[0]->talla;
        $this->filters['fechaini'] = $data[0]->fechaini;
        $this->filters['fechafin']  = $data[0]->fechafin;
        $this->filters['estudiante']  = $data[0]->estudiante;
        $this->filters['cantidad']  = $data[0]->cantidad;
        $this->filters['precio']  = $data[0]->precio;
        $this->filters['monto']  = $data[0]->monto;
        $this->filters['tipopago']  = $data[0]->tipopago;

        $invtra  = $this->report();

        if ($report=='PRD'){
        
            $fechaini = date('Ymd',strtotime($this->filters['fechaini']));
            $fechafin = date('Ymd',strtotime($this->filters['fechafin'])); 

            $sqldetPago = DB::select("call reporte_productos_detallepagos('".$fechaini."','".$fechafin."','','',0,'".$this->filters['tipo']."','".$this->filters['movimiento']."',0,0,0,0)");
            $collection = collect($sqldetPago);

            $grouped = $collection->groupBy('tipopago');
                    
            $resumen=[];
            foreach($grouped as $key => $tipopago){
                
                $detalle=[];
                foreach($tipopago as $tpago){ 
                    $detpago['fecha'] = $tpago->fecha;
                    $detpago['documento'] = $tpago->documento;
                    $detpago['valor'] = $tpago->valor;                
                    array_push($detalle,$detpago);
                }
                $resumen[$key] = $detalle;
            }
        

            $sqlPagos = DB::select("call reporte_productos('".$fechaini."','".$fechafin."','','',0,'".$this->filters['tipo']."','".$this->filters['movimiento']."',0,0,0,0)");
            $formapago=[];
            foreach($sqlPagos as $key){
                
                $array['tipopago'] = $key->tipopago;
                $array['total'] = $key->total;
                array_push($formapago,$array);
            }
            
            $lsreport = 'reports/detail_producto';
        }else{

            $fechaini = date('Ymd',strtotime($this->filters['fechaini']));
            $fechafin = date('Ymd',strtotime($this->filters['fechafin']));
            
            $sqlPagos = DB::select("call reporte_productos('".$fechaini."','".$fechafin."','','',0,'".$this->filters['tipo']."','".$this->filters['movimiento']."',0,0,0,0)");
            
            $resumen  =[];
            $formapago=[];
            foreach($sqlPagos as $key){
                
                $array['tipopago'] = $key->tipopago;
                $array['total'] = $key->total;
                array_push($formapago,$array);
            }

            $lsreport = 'reports/detail_movimientos';
        }
        
        $transac=[
            'II' => '(+) Inventario Inicial', 
            'CL' => '(+) Compras Locales',  
            'IA' => '(+) Ingreso por Ajuste', 
            'DC' => '(-) Devolución por Compra', 
            'VE' => '(-) Venta',  
            'EA' => '(-) Egreso por Ajuste', 
            'DV' => '(+) Devolución por Venta',
        ];

        $filtros = '';
        foreach($this->filters as $key=>$value){
            
            if( $value!='' & str_contains($key, 'fecha') == false & $value!='Seleccione Talla'){
                
                if($key=='movimiento'){
                    $filtros = $filtros.' '.$key.': '.$transac[$value].",\n";
                }else{
                    $filtros = $filtros.' '.$key.': '.$value.",\n";
                }

            }
        }

        $info['fechaini'] = $data[0]->fechaini; 
        $info['fechafin'] = $data[0]->fechafin; 

        $arrsuma=['II','CL','IA','DV'];
        $arresta=['DC','VE','EA'];

        $fpago=[
            'NN' => 'Ninguno',
            'EFE' => 'Efectivo',
            'CHQ' => 'Cheque',
            'TAR' => 'Tarjeta de Crédito',
            'DEP' => 'Deposito',
            'TRA' => 'Transferencia',
            'APP' => 'Aplicación Movil',
        ];
        
        $totalmonto  = (array_sum(array_column($invtra,'total')));
        $totcantidad = (array_sum(array_column($invtra,'cantidad')));
        $totalres = 0;

        //Vista
        $pdf = PDF::loadView($lsreport,[
            'invtra' => $invtra,
            'info'  => $info,
            'filtros' => $filtros,
            'arrsuma' => $arrsuma,
            'arresta' => $arresta,
            'resumen' => $resumen,
            'fpago' => $fpago,
            'totalres' => $totalres,
            'formapago' => $formapago,
            'totalmonto' => $totalmonto,
            'totcantidad' => $totcantidad,
        ]);

        return $pdf->download('Detalle de Productos.pdf');

    }


}
