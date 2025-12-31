<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

use Illuminate\Support\Facades\DB;

class MovInventarioExport implements FromView, ShouldAutoSize
{
    use Exportable;
    /*
    * @return \Illuminate\Support\Collection
    */
    public $filters, $resumenMatricula=[], $resumenNivel=[];
    public $dias = [
        0=>'Domingo',
        1=>'Lunes',
        2=>'Martes',
        3=>'Miercoles',
        4=>'Jueves',
        5=>'Viernes',
        6=>'Sabado'
    ];
    
    public $meses = [
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

    public $fpago=[
        "NN" => 'Ninguno',
        "EFE" => 'Efectivo',
        "CHQ" => 'Cheque',
        "TAR" => 'Tarjeta',
        "DEP" => 'Depósito',
        "TRA" => 'Transferencia',
        "APP" => 'App Movil',
        "CON" => 'Convenio',

    ];

    public function __construct($filters)
    {
        $this->filters = json_decode($filters, true);
    }

    public function view(): View 
    {   
        
        $fechaini = date('Ymd',strtotime($this->filters['fechaini']));
        $fechafin = date('Ymd',strtotime($this->filters['fechafin'])); 

        /* Movimientos */
        $invtra = DB::select("call reporte_movimientos_inventario(?,?,?,?,?,?,?,?,?,?,?)",array($fechaini,$fechafin,$this->filters['referencia'],$this->filters['estudiante'],$this->filters['categoria'],$this->filters['tipo'],$this->filters['movimiento'],$this->filters['talla'],$this->filters['cantidad'],$this->filters['precio'],$this->filters['monto']));        
        $sqlPagos = DB::select("call reporte_productos(?,?,?,?,?,?,?,?,?,?,?)",array($fechaini,$fechafin,$this->filters['referencia'],$this->filters['estudiante'],$this->filters['categoria'],$this->filters['tipo'],$this->filters['movimiento'],$this->filters['talla'],$this->filters['cantidad'],$this->filters['precio'],$this->filters['monto']));
        
        $sqldetPago = DB::select("call reporte_productos_detallepagos(?,?,?,?,?,?,?,?,?,?,?)",array($fechaini,$fechafin,$this->filters['referencia'],$this->filters['estudiante'],$this->filters['categoria'],$this->filters['tipo'],$this->filters['movimiento'],$this->filters['talla'],$this->filters['cantidad'],$this->filters['precio'],$this->filters['monto']));
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

        $formapago=[];
        foreach($sqlPagos as $key){
            
            $array['tipopago'] = $key->tipopago;
            $array['total'] = $key->total;
            array_push($formapago,$array);
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

        $totalres=0;
        return view('export.movimientosInv',[
            'invtra' => $invtra,
            'data'  => $this->filters,
            'formapago' => $formapago,
            'totalres' => $totalres,
            'resumen' => $resumen,
            'fpago' => $this->fpago,
        ]);

    }
}
