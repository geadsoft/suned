<?php

namespace App\Http\Livewire;

use App\Models\TrInventarioCabs;
use App\Models\TrInventarioDets;
use App\Models\TmProductos;
use App\Models\TmGeneralidades;

use Livewire\Component;
use Livewire\WithPagination;
use PDF;


class VcInventaryReports extends Component
{
    
    use WithPagination;

    public $tblcategoria;
    public $datos='';

    public $filters=[
        'referencia' => '',
        'movimiento' => 'VE',
        'categoria' => '',
        'talla' => '',
        'fechaini' => '',
        'fechafin' => '',
    ];

    public $movimiento=[
        2 => ['codigo' => 'II', 'nombre' => '(+) Inventario Inicial', 'valor' => '1'], 
        3 => ['codigo' => 'CL', 'nombre' => '(+) Compras Locales', 'valor' => '1'], 
        4 => ['codigo' => 'IA', 'nombre' => '(+) Ingreso por Ajuste', 'valor' => '1'], 
        5 => ['codigo' => 'DC', 'nombre' => '(-) Devolución por Compra', 'valor' => '-1'], 
        6 => ['codigo' => 'VE', 'nombre' => '(-) Venta', 'valor' => '-1'], 
        7 => ['codigo' => 'EA', 'nombre' => '(-) Egreso por Ajuste', 'valor' => '-1'], 
        8 => ['codigo' => 'DV', 'nombre' => '(+) Devolución por Venta', 'valor' => '1'],
    ];

    public $fpago=[
        "NN" => 'Ninguno',
        "EFE" => 'Efectivo',
        "CHQ" => 'Cheque',
        "TAR" => 'Tarjeta',
        "DEP" => 'Depósito',
        "TRA" => 'Transferencia',
        "APP" => 'App Movil',

    ];

    public function mount()
    {
        $this->tblcategorias = TmGeneralidades::where('superior',11)->get();
        
        $ldate = date('Y-m-d H:i:s');
        $ldate = date('Y',strtotime($ldate)).'-'.date('m',strtotime($ldate)).'-01';
       
        $fechaini = date('Y-m-d',strtotime($ldate));

        $ldate = date('Y-m-d H:i:s');
        $fechafin = date('Y-m-d',strtotime($ldate));

        $this->filters['fechaini'] = $fechaini;
        $this->filters['fechafin'] = $fechafin;   
    
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

    public function consulta(){

        /* Movimientos */
        $invtra = TrInventarioCabs::query()
        ->join("tr_inventario_dets as d","d.inventariocab_id","=","tr_inventario_cabs.id")
        ->join("tm_productos as p","p.id","=","d.producto_id")
        ->join("tm_generalidades as g","g.id","=","p.categoria_id")
        ->when($this->filters['referencia'],function($query){
            return $query->where('tr_inventario_cabs.referencia', 'like' , "%{$this->filters['referencia']}%");
        })
        ->when($this->filters['categoria'],function($query){
            return $query->where('categoria_id',"{$this->filters['categoria']}");
        })
        ->when($this->filters['movimiento'],function($query){
            return $query->where('d.movimiento',"{$this->filters['movimiento']}");
        })
        ->when($this->filters['talla'],function($query){
            return $query->where('d.talla',"{$this->filters['talla']}");
        })
        ->where('d.fecha','>=',date('Ymd',strtotime($this->filters['fechaini'])))
        ->where('d.fecha','<=',date('Ymd',strtotime($this->filters['fechafin'])))
        ->selectRaw('tr_inventario_cabs.*,p.nombre,p.talla,d.precio,d.cantidad,d.total')
        ->paginate(13);


        $this->datos = json_encode($this->filters);
        
        return $invtra;

    }

    public function printPDF($objdata)
    { 
        $data = json_decode($objdata);

        $this->filters['referencia'] = $data->referencia;
        $this->filters['movimiento'] = $data->movimiento;
        $this->filters['categoria'] = $data->categoria;
        $this->filters['talla'] = $data->talla;
        $this->filters['fechaini'] = $data->fechaini;
        $this->filters['fechafin']  = $data->fechafin;

        $invtra  = $this->consulta();

        $transac=[
            'II' => '(+) Inventario Inicial', 
            'CL' => '(+) Compras Locales',  
            'IA' => '(+) Ingreso por Ajuste', 
            'DC' => '(-) Devolución por Compra', 
            'VE' => '(-) Venta',  
            'EA' => '(-) Egreso por Ajuste', 
            'DV' => '(+) Devolución por Venta',
        ];

        $info['fechaini'] = $data->fechaini; 
        $info['fechafin'] = $data->fechafin; 
        $info['referencia'] = $data->referencia;
        $info['movimiento'] = $transac[$data->movimiento];

        //Vista
        $pdf = PDF::loadView('reports/detail_producto',[
            'invtra' => $invtra,
            'info'  => $info,
        ]);

        return $pdf->setPaper('a4')->stream('Detalle Productos.pdf');

    }


    public function downloadPDF($objdata)
    { 
        $data = json_decode($objdata);

        $this->filters['referencia'] = $data->referencia;
        $this->filters['movimiento'] = $data->movimiento;
        $this->filters['categoria'] = $data->categoria;
        $this->filters['talla'] = $data->talla;
        $this->filters['fechaini'] = $data->fechaini;
        $this->filters['fechafin']  = $data->fechafin;

        $invtra  = $this->consulta();

        $transac=[
            'II' => '(+) Inventario Inicial', 
            'CL' => '(+) Compras Locales',  
            'IA' => '(+) Ingreso por Ajuste', 
            'DC' => '(-) Devolución por Compra', 
            'VE' => '(-) Venta',  
            'EA' => '(-) Egreso por Ajuste', 
            'DV' => '(+) Devolución por Venta',
        ];

        $info['fechaini'] = date('d/m/Y',strtotime($data->fechaini)); 
        $info['fechafin'] = date('d/m/Y',strtotime($data->fechafin)); 
        $info['referencia'] = $data->referencia;
        $info['movimiento'] = $transac[$data->movimiento];

        //Vista
        $pdf = PDF::loadView('reports/detail_producto',[
            'invtra' => $invtra,
            'info'  => $info,
        ]);

        return $pdf->download('Detalle de Productos.pdf');

    }


}
