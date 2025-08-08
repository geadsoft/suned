<?php

namespace App\Http\Controllers;

use _PDF;
use Illuminate\Http\Request;
use Elibyy\TCPDF\Facades\TCPDF;
use Illuminate\Support\Facades\DB;

class PdfController extends Controller
{
    
    public $filters=[];

    public function informe_docente_trimestral($data) 
    {   

        $data = json_decode($data);
        dd($data);

    }


    public function index($report,$objdata) 
    {
        
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

        /*Impresión*/       

        $filename = 'hello_world.pdf';

        $data = [
            'title' => 'Hello world!'
        ];

        $view = \View::make('reports/detail_producto',[
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
        $html = $view->render();

        $pdf = new TCPDF;

        $pdf::SetTitle('Hello World');
        $pdf::AddPage();
        $pdf::writeHTML($html, true, false, true, false, '');

        $pdf::Output(public_path($filename), 'F');

        return response()->download(public_path($filename));
    }

    public function report(){ 

        $fechaini = date('Ymd',strtotime($this->filters['fechaini']));
        $fechafin = date('Ymd',strtotime($this->filters['fechafin'])); 
    
        $invtra = DB::select("call reporte_movimientos_inventario(?,?,?,?,?,?,?,?,?,?,?)",array($fechaini,$fechafin,$this->filters['referencia'],$this->filters['estudiante'],$this->filters['categoria'],$this->filters['tipo'],$this->filters['movimiento'],$this->filters['talla'],$this->filters['cantidad'],$this->filters['precio'],$this->filters['monto']));
        
        return $invtra;
    }
}
