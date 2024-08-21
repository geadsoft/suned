<?php

namespace App\Http\Livewire;
use App\Models\TrInventarioDets;
use App\Models\TmGeneralidades;

use Illuminate\Support\Facades\DB;
use Livewire\Component;
use PDF;

class VcReportCostoGastos extends Component
{
    public $catMonto, $catCantidad, $catUtilidad, $prdMonto, $prdCantidad, $prdUtilidad;
    public $tblcatMonto, $tblcatCantidad, $tblcatUtilidad, $tblprdMonto, $tblprdCantidad, $tblprdUtitlidad;
    public $startDate, $endDate, $talla=0, $categoria=0;
    public $tblrecords=[];
    public $tblcategoria=[];
    public $datos='';

    public $arrtalla=[
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

    public function mount(){

        $this->tblcategoria = TmGeneralidades::query()
        ->where('superior',11)
        ->get();
        
        $ldate = date('Y-m-d H:i:s');
        $ldate = date('Y',strtotime($ldate)).'-'.date('m',strtotime($ldate)).'-01';
       
        $ldateini = date('Y-m-d',strtotime($ldate));

        $ldate = date('Y-m-d H:i:s');
        $ldatefin = date('Y-m-d',strtotime($ldate));

        $this->startDate = date('Y-m-d',strtotime($ldateini));
        $this->endDate = date('Y-m-d',strtotime($ldatefin));
    }

    public function render()
    {
        return view('livewire.vc-report-costo-gastos',[
            'arrtalla' => $this->arrtalla
        ]);
    }

    public function updatedStartDate() {
        
        $this->consulta();
        $this->actualizaGraph();

    }

    public function updatedCategoria() {
        
        $this->consulta();
        $this->actualizaGraph();

    }

    public function updatedTalla() {
        
        $this->consulta();
        $this->actualizaGraph();

    }

    public function consulta(){

        $this->catmonto = '';
        $this->catcantidad = '';
        $this->catutilidad = '';

        //Categoria Monto
        $this->tblcatMonto = TrInventarioDets::query()
        ->join("tm_productos as p","p.id","=","tr_inventario_dets.producto_id")
        ->join("tm_generalidades as g","g.id","=","p.categoria_id")
        ->when($this->startDate,function($query){
            return $query->where('tr_inventario_dets.fecha',">=",date('Ymd',strtotime($this->startDate)));
        })
        ->when($this->endDate,function($query){
            return $query->where('tr_inventario_dets.fecha',"<=",date('Ymd',strtotime($this->endDate)));
        })
        ->when($this->categoria>0,function($query){
            return $query->where('g.id',"=",$this->categoria);
        })
        ->when($this->talla>0,function($query){
            return $query->where('p.talla',"=",$this->talla);
        })
        ->where('tr_inventario_dets.movimiento','VE')
        ->selectRaw('g.descripcion, sum(total) as valor')
        ->groupBy('g.descripcion')
        ->orderby('valor','desc')
        ->take(5)
        ->get();

        if($this->tblcatMonto!=null){
            $this->graphs($this->tblcatMonto,1);
        }

        //Categoria Cantidad
        $this->tblcatCantidad = TrInventarioDets::query()
        ->join("tm_productos as p","p.id","=","tr_inventario_dets.producto_id")
        ->join("tm_generalidades as g","g.id","=","p.categoria_id")
        ->when($this->startDate,function($query){
            return $query->where('tr_inventario_dets.fecha',">=",date('Ymd',strtotime($this->startDate)));
        })
        ->when($this->endDate,function($query){
            return $query->where('tr_inventario_dets.fecha',"<=",date('Ymd',strtotime($this->endDate)));
        })
        ->when($this->categoria>0,function($query){
            return $query->where('g.id',"=",$this->categoria);
        })
        ->when($this->talla>0,function($query){
            return $query->where('p.talla',"=",$this->talla);
        })
        ->where('tr_inventario_dets.movimiento','VE')
        ->selectRaw('g.descripcion, sum(cantidad) as valor')
        ->groupBy('g.descripcion')
        ->orderby('valor','desc')
        ->take(5)
        ->get();

        if($this->tblcatCantidad!=null){
            $this->graphs($this->tblcatCantidad,2);
        }

        //Categoria Utilidad
        $this->tblcatUtilidad = TrInventarioDets::query()
        ->join("tm_productos as p","p.id","=","tr_inventario_dets.producto_id")
        ->join("tm_generalidades as g","g.id","=","p.categoria_id")
        ->when($this->startDate,function($query){
            return $query->where('tr_inventario_dets.fecha',">=",date('Ymd',strtotime($this->startDate)));
        })
        ->when($this->endDate,function($query){
            return $query->where('tr_inventario_dets.fecha',"<=",date('Ymd',strtotime($this->endDate)));
        })
        ->when($this->categoria>0,function($query){
            return $query->where('g.id',"=",$this->categoria);
        })
        ->when($this->talla>0,function($query){
            return $query->where('p.talla',"=",$this->talla);
        })
        ->where('tr_inventario_dets.movimiento','VE')
        ->selectRaw('g.descripcion, sum(total)-sum(tr_inventario_dets.costo_total) as valor')
        ->groupBy('g.descripcion')
        ->orderby('valor','desc')
        ->take(5)
        ->get();

        if($this->tblcatUtilidad!=null){
            $this->graphs($this->tblcatUtilidad,3);
        }


        // Producto Monto
        $this->tblprdMonto = TrInventarioDets::query()
        ->join("tm_productos as p","p.id","=","tr_inventario_dets.producto_id")
        ->join("tm_generalidades as g","g.id","=","p.categoria_id")
        ->when($this->startDate,function($query){
            return $query->where('tr_inventario_dets.fecha',">=",date('Ymd',strtotime($this->startDate)));
        })
        ->when($this->endDate,function($query){
            return $query->where('tr_inventario_dets.fecha',"<=",date('Ymd',strtotime($this->endDate)));
        })
        ->when($this->categoria>0,function($query){
            return $query->where('g.id',"=",$this->categoria);
        })
        ->when($this->talla>0,function($query){
            return $query->where('p.talla',"=",$this->talla);
        })
        ->where('tr_inventario_dets.movimiento','VE')
        ->selectRaw('p.nombre, sum(total) as valor')
        ->groupBy('p.nombre')
        ->orderby('valor','desc')
        ->take(5)
        ->get();

        if($this->tblprdMonto!=null){
            $this->graphs($this->tblprdMonto,4);
        }

        // Producto Cantidad
        $this->tblprdCantidad = TrInventarioDets::query()
        ->join("tm_productos as p","p.id","=","tr_inventario_dets.producto_id")
        ->join("tm_generalidades as g","g.id","=","p.categoria_id")
        ->when($this->startDate,function($query){
            return $query->where('tr_inventario_dets.fecha',">=",date('Ymd',strtotime($this->startDate)));
        })
        ->when($this->endDate,function($query){
            return $query->where('tr_inventario_dets.fecha',"<=",date('Ymd',strtotime($this->endDate)));
        })
        ->when($this->categoria>0,function($query){
            return $query->where('g.id',"=",$this->categoria);
        })
        ->when($this->talla>0,function($query){
            return $query->where('p.talla',"=",$this->talla);
        })
        ->where('tr_inventario_dets.movimiento','VE')
        ->selectRaw('p.nombre, sum(cantidad) as valor')
        ->groupBy('p.nombre')
        ->orderby('valor','desc')
        ->take(5)
        ->get();

        if($this->tblprdCantidad!=null){
            $this->graphs($this->tblprdCantidad,5);
        }

        //Producto Utilidad
        $this->tblprdUtilidad = TrInventarioDets::query()
        ->join("tm_productos as p","p.id","=","tr_inventario_dets.producto_id")
        ->join("tm_generalidades as g","g.id","=","p.categoria_id")
        ->when($this->startDate,function($query){
            return $query->where('tr_inventario_dets.fecha',">=",date('Ymd',strtotime($this->startDate)));
        })
        ->when($this->endDate,function($query){
            return $query->where('tr_inventario_dets.fecha',"<=",date('Ymd',strtotime($this->endDate)));
        })
        ->when($this->categoria>0,function($query){
            return $query->where('g.id',"=",$this->categoria);
        })
        ->when($this->talla>0,function($query){
            return $query->where('p.talla',"=",$this->talla);
        })
        ->where('tr_inventario_dets.movimiento','VE')
        ->selectRaw('p.nombre, sum(total)-sum(tr_inventario_dets.costo_total) as valor')
        ->groupBy('p.nombre')
        ->orderby('valor','desc')
        ->take(5)
        ->get();

        if($this->tblprdUtilidad!=null){
            $this->graphs($this->tblprdUtilidad,6);
        }

        $arrdata = [
            'start_date' => $this->startDate,
            'end_date' => $this->endDate,
            'categoria' => $this->categoria,
            'talla' => $this->talla,
        ];
        $this->datos = json_encode($arrdata);

    }   

    public function graphs($tblData,$graph){

        $linea = count($tblData)-1;
        $array=[];
        for ($x=0;$x<=$linea;$x++) {
            $array[] = [
                'name' => $x+1,
                'y' => floatVal($tblData[$x]['valor']),
            ];
        };
        
        switch ($graph){
            case 1:
                $this->catMonto = json_encode($array);
                break;
            case 2:
                $this->catCantidad = json_encode($array);
                break;
            case 3:
                $this->catUtilidad = json_encode($array);
                break;
            case 4:
                $this->prdMonto = json_encode($array);
                break;
            case 5:
                $this->prdCantidad = json_encode($array);
                break;
            case 6:
                $this->prdUtilidad = json_encode($array);
                break;
        }
            
    }


    public function actualizaGraph(){
        $this->dispatchBrowserEvent('graph-catmonto', ['newObj' => $this->catMonto]);
        $this->dispatchBrowserEvent('graph-catcantidad', ['newObj' => $this->catCantidad]);
        $this->dispatchBrowserEvent('graph-catutilidad', ['newObj' => $this->catUtilidad]);
        $this->dispatchBrowserEvent('graph-prdmonto', ['newObj' => $this->prdMonto]);
        $this->dispatchBrowserEvent('graph-prdcantidad', ['newObj' => $this->prdCantidad]);
        $this->dispatchBrowserEvent('graph-prdutilidad', ['newObj' => $this->prdUtilidad]);
    }

    public function printPDF($objdata)
    { 
        $data = json_decode($objdata);
        $this->categoria = strval($data->categoria);
        $this->talla = strval($data->talla);
        
        $utilidad = TrInventarioDets::query()
        ->join("tm_productos as p","p.id","=","tr_inventario_dets.producto_id")
        ->join("tm_generalidades as g","g.id","=","p.categoria_id")
        ->when($this->startDate,function($query){
            return $query->where('tr_inventario_dets.fecha',">=",$data['start_date']);
        })
        ->when($this->endDate,function($query){
            return $query->where('tr_inventario_dets.fecha',"<=",$data['end_date']);
        })
        ->when($this->categoria>0,function($query){
            return $query->where('g.id',"=",$this->categoria);
        })
        ->when($this->talla>0,function($query){
            return $query->where('p.talla',"=",$this->talla);
        })
        ->where('tr_inventario_dets.movimiento','VE')
        ->selectRaw('sum(total) as vtasnetas, sum(tr_inventario_dets.costo_total) as cstventa')
        ->get()->toArray();

        $tblgraph1 = TrInventarioDets::query()
        ->join("tm_productos as p","p.id","=","tr_inventario_dets.producto_id")
        ->join("tm_generalidades as g","g.id","=","p.categoria_id")
        ->where('tr_inventario_dets.movimiento','VE')
        ->where('tr_inventario_dets.fecha','>=',$data->start_date)
        ->where('tr_inventario_dets.fecha','<=',$data->end_date)
        ->when($this->categoria>0,function($query){
            return $query->where('g.id',"=",$this->categoria);
        })
        ->when($this->talla>0,function($query){
            return $query->where('p.talla',"=",$this->talla);
        })
        ->selectRaw('g.descripcion, sum(total) as valor')
        ->groupBy('g.descripcion')
        ->orderby('valor','desc')
        ->take(5)
        ->get();

        $urlgraph1 = "https://quickchart.io/chart?c={type:'bar',data:{labels:[1,2,3,4,5],datasets:[{label:'Monto',";
        
        $dataset = "data:[";
        foreach($tblgraph1 as $recno){
            $dataset = $dataset.strval($recno->valor).', '; 
        }
        $dataset = $dataset.']}]}}';  
        $urlgraph1 = $urlgraph1.$dataset;

        $tblgraph2 = TrInventarioDets::query()
        ->join("tm_productos as p","p.id","=","tr_inventario_dets.producto_id")
        ->join("tm_generalidades as g","g.id","=","p.categoria_id")
        ->where('tr_inventario_dets.movimiento','VE')
        ->where('tr_inventario_dets.fecha','>=',$data->start_date)
        ->where('tr_inventario_dets.fecha','<=',$data->end_date)
        ->when($this->categoria>0,function($query){
            return $query->where('g.id',"=",$this->categoria);
        })
        ->when($this->talla>0,function($query){
            return $query->where('p.talla',"=",$this->talla);
        })
        ->selectRaw('g.descripcion, sum(cantidad) as valor')
        ->groupBy('g.descripcion')
        ->orderby('valor','desc')
        ->take(5)
        ->get();

        $urlgraph2 = "https://quickchart.io/chart?c={type:'bar',data:{labels:[1,2,3,4,5],datasets:[{label:'Monto',";
        
        $dataset = "data:[";
        foreach($tblgraph2 as $recno){
            $dataset = $dataset.strval($recno->valor).', '; 
        }
        $dataset = $dataset.']}]}}';  
        $urlgraph2 = $urlgraph2.$dataset;

        $tblgraph3 = TrInventarioDets::query()
        ->join("tm_productos as p","p.id","=","tr_inventario_dets.producto_id")
        ->join("tm_generalidades as g","g.id","=","p.categoria_id")
        ->where('tr_inventario_dets.movimiento','VE')
        ->where('tr_inventario_dets.fecha','>=',$data->start_date)
        ->where('tr_inventario_dets.fecha','<=',$data->end_date)
        ->when($this->categoria>0,function($query){
            return $query->where('g.id',"=",$this->categoria);
        })
        ->when($this->talla>0,function($query){
            return $query->where('p.talla',"=",$this->talla);
        })
        ->selectRaw('g.descripcion, sum(total)-sum(tr_inventario_dets.costo_total) as valor')
        ->groupBy('g.descripcion')
        ->orderby('valor','desc')
        ->take(5)
        ->get();

        $urlgraph3 = "https://quickchart.io/chart?c={type:'bar',data:{labels:[1,2,3,4,5],datasets:[{label:'Monto',";
        
        $dataset = "data:[";
        foreach($tblgraph3 as $recno){
            $dataset = $dataset.strval($recno->valor).', '; 
        }
        $dataset = $dataset.']}]}}';  
        $urlgraph3 = $urlgraph3.$dataset;

        $tblgraph4 = TrInventarioDets::query()
        ->join("tm_productos as p","p.id","=","tr_inventario_dets.producto_id")
        ->join("tm_generalidades as g","g.id","=","p.categoria_id")
        ->where('tr_inventario_dets.movimiento','VE')
        ->where('tr_inventario_dets.fecha','>=',$data->start_date)
        ->where('tr_inventario_dets.fecha','<=',$data->end_date)
        ->when($this->categoria>0,function($query){
            return $query->where('g.id',"=",$this->categoria);
        })
        ->when($this->talla>0,function($query){
            return $query->where('p.talla',"=",$this->talla);
        })
        ->selectRaw('p.nombre, sum(total) as valor')
        ->groupBy('p.nombre')
        ->orderby('valor','desc')
        ->take(5)
        ->get();

        $urlgraph4 = "https://quickchart.io/chart?c={type:'bar',data:{labels:[1,2,3,4,5],datasets:[{label:'Monto',";
        
        $dataset = "data:[";
        foreach($tblgraph4 as $recno){
            $dataset = $dataset.strval($recno->valor).', '; 
        }
        $dataset = $dataset.']}]}}';  
        $urlgraph4 = $urlgraph4.$dataset;

        $tblgraph5 = TrInventarioDets::query()
        ->join("tm_productos as p","p.id","=","tr_inventario_dets.producto_id")
        ->join("tm_generalidades as g","g.id","=","p.categoria_id")
        ->where('tr_inventario_dets.movimiento','VE')
        ->where('tr_inventario_dets.fecha','>=',$data->start_date)
        ->where('tr_inventario_dets.fecha','<=',$data->end_date)
        ->selectRaw('p.nombre, sum(cantidad) as valor')
        ->when($this->categoria>0,function($query){
            return $query->where('g.id',"=",$this->categoria);
        })
        ->when($this->talla>0,function($query){
            return $query->where('p.talla',"=",$this->talla);
        })
        ->groupBy('p.nombre')
        ->orderby('valor','desc')
        ->take(5)
        ->get();

        $urlgraph5 = "https://quickchart.io/chart?c={type:'bar',data:{labels:[1,2,3,4,5],datasets:[{label:'Monto',";
        
        $dataset = "data:[";
        foreach($tblgraph5 as $recno){
            $dataset = $dataset.strval($recno->valor).', '; 
        }
        $dataset = $dataset.']}]}}';  
        $urlgraph5 = $urlgraph5.$dataset;

        $tblgraph6 = TrInventarioDets::query()
        ->join("tm_productos as p","p.id","=","tr_inventario_dets.producto_id")
        ->join("tm_generalidades as g","g.id","=","p.categoria_id")
        ->where('tr_inventario_dets.movimiento','VE')
        ->where('tr_inventario_dets.fecha','>=',$data->start_date)
        ->where('tr_inventario_dets.fecha','<=',$data->end_date)
        ->when($this->categoria>0,function($query){
            return $query->where('g.id',"=",$this->categoria);
        })
        ->when($this->talla>0,function($query){
            return $query->where('p.talla',"=",$this->talla);
        })
        ->selectRaw('p.nombre, sum(total)-sum(tr_inventario_dets.costo_total) as valor')
        ->groupBy('p.nombre')
        ->orderby('valor','desc')
        ->take(5)
        ->get();
       
        $urlgraph6 = "https://quickchart.io/chart?c={type:'bar',data:{labels:[1,2,3,4,5],datasets:[{label:'Monto',";
        
        $dataset = "data:[";
        foreach($tblgraph6 as $recno){
            $dataset = $dataset.strval($recno->valor).', '; 
        }
        $dataset = $dataset.']}]}}';  
        $urlgraph6 = $urlgraph6.$dataset;


        //Vista
        $pdf = PDF::loadView('reports/reporte_utilidad',[
            'utilidad'  => $utilidad,
            'tblgraph1' => $tblgraph1,
            'tblgraph2' => $tblgraph2,
            'tblgraph3' => $tblgraph3,
            'tblgraph4' => $tblgraph4,
            'tblgraph5' => $tblgraph5,
            'tblgraph6' => $tblgraph6,
            'data' => $data,
            'urlgraph1' => $urlgraph1,
            'urlgraph2' => $urlgraph2,
            'urlgraph3' => $urlgraph3,
            'urlgraph4' => $urlgraph4,
            'urlgraph5' => $urlgraph5,
            'urlgraph6' => $urlgraph6,
        ]);

        return $pdf->setPaper('a4')->stream('Utilidad en Ventas.pdf');
    
    }

    /*public function downloadPDF($objdata)
    { 
        $data = json_decode($objdata);

        //Vista
        $pdf = PDF::loadView('reports/detail_producto',[
            'invtra' => $invtra,
            'info'  => $info,
            'filtros' => $filtros,
            'arrsuma' => $arrsuma,
            'arresta' => $arresta,
            'resumen' => $resumen,
            'fpago' => $fpago,
            'totalres' => $totalres,
            'formapago' => $formapago,
        ]);

        return $pdf->download('Detalle de Productos.pdf');
    }*/


}
