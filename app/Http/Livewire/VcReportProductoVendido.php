<?php

namespace App\Http\Livewire;
use App\Models\TrInventarioDets;

use Livewire\Component;
use PDF;

class VcReportProductoVendido extends Component
{
    public $vtaUnd, $vtaMonto, $vtaCant, $catvta1;
    public $tblUnd, $tblMonto, $tblCant;
    public $startDate, $endDate, $talla, $categoria, $vtatop=10;
    public $tblrecords=[];
    public $datos='';

    public function mount(){
        $ldateini = date('Y-m-d H:i:s');
        $ldatefin = date('Y-m-d H:i:s');

        $this->startDate = date('Y-m-d',strtotime($ldateini));
        $this->endDate = date('Y-m-d',strtotime($ldatefin));
    }

    public function render()
    {
        return view('livewire.vc-report-producto-vendido');
    }

    public function updatedStartDate() {
        
        $this->consulta();
        $this->actualizaGraph();

    }


    public function consulta(){

        $this->catmonto = '';
        $this->catcantidad = '';
        $this->catutilidad = '';

        //Categoria Cantidad
        $this->tblUnd= TrInventarioDets::query()
        ->join("tm_productos as p","p.id","=","tr_inventario_dets.producto_id")
        ->join("tm_generalidades as g","g.id","=","p.categoria_id")
        ->when($this->startDate,function($query){
            return $query->where('tr_inventario_dets.fecha',">=",date('Ymd',strtotime($this->startDate)));
        })
        ->when($this->endDate,function($query){
            return $query->where('tr_inventario_dets.fecha',"<=",date('Ymd',strtotime($this->endDate)));
        })
        ->where('tr_inventario_dets.movimiento','VE')
        ->selectRaw('p.nombre, sum(cantidad) as cantidad, sum(total) as valor')
        ->groupBy('p.nombre')
        ->orderby('cantidad','desc')
        ->take($this->vtatop)
        ->get();

        if($this->tblUnd!=null){
            $this->graphs($this->tblUnd,1);
        }        
           
        //Categoria Monto
        $this->tblMonto = TrInventarioDets::query()
        ->join("tm_productos as p","p.id","=","tr_inventario_dets.producto_id")
        ->join("tm_generalidades as g","g.id","=","p.categoria_id")
        ->when($this->startDate,function($query){
            return $query->where('tr_inventario_dets.fecha',">=",date('Ymd',strtotime($this->startDate)));
        })
        ->when($this->endDate,function($query){
            return $query->where('tr_inventario_dets.fecha',"<=",date('Ymd',strtotime($this->endDate)));
        })
        ->where('tr_inventario_dets.movimiento','VE')
        ->selectRaw('p.nombre, sum(cantidad) as cantidad, sum(total) as valor')
        ->groupBy('p.nombre')
        ->orderby('valor','desc')
        ->take($this->vtatop)
        ->get();

        if($this->tblMonto!=null){
            $this->graphs($this->tblMonto,2);
        }

        $arrdata = [
            'start_date' => $this->startDate,
            'end_date' => $this->endDate,
        ];
        $this->datos = json_encode($arrdata);

    }   

    public function graphs($tblData,$graph){

        $linea = count($tblData)-1;
        $arraycat=[];
        $array=[];

        $valores  = '';
        $dataline = '';
        for ($x=0;$x<=$linea;$x++) {
            $dataline = $dataline."'".strval($x+1)."',";
            $valores =  $valores.sprintf('%.2f', $tblData[$x]['valor']).' ,'; 
        };
        $array[] = substr($valores, 0, -2);

        $arraycat[] = substr($dataline, 0, -1);
        $strarray = json_encode($array);
        $strarray = str_replace('"','',$strarray);
        
        switch ($graph){
            case 1:
                $this->catvta1 = json_encode($arraycat);
                $this->vtaUnd  = json_encode($strarray);
                break;
            case 2:
                $this->vatMonto = json_encode($array);
                break;
            case 3:
                $this->vtaCant = json_encode($array);
                break;
        }
            
    }


    public function actualizaGraph(){
        $this->dispatchBrowserEvent('graph-vtaund', ['newObj1' => $this->catvta1, 
                                                     'newObj2' => $this->vtaUnd]);
        $this->dispatchBrowserEvent('graph-vtamonto', ['newObj' => $this->vtaMonto]);
        $this->dispatchBrowserEvent('graph-vtacant', ['newObj' => $this->vtaCant]);
    }

    public function printPDF($objdata)
    { 
        $data = json_decode($objdata);

        $utilidad = TrInventarioDets::query()
        ->join("tm_productos as p","p.id","=","tr_inventario_dets.producto_id")
        ->join("tm_generalidades as g","g.id","=","p.categoria_id")
        ->when($this->startDate,function($query){
            return $query->where('tr_inventario_dets.fecha',">=",$data['start_date']);
        })
        ->when($this->endDate,function($query){
            return $query->where('tr_inventario_dets.fecha',"<=",$data['end_date']);
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
        ->selectRaw('p.nombre, sum(total)-sum(tr_inventario_dets.costo_total) as valor')
        ->groupBy('p.nombre')
        ->orderby('valor','desc')
        ->take(5)
        ->get();
       
        $urlgraph6 = "https://quickchart.io/chart?c={type:'bar',data:{labels:[1,2,3,4,5],datasets:[{label:'Monto',";
        
        $dataset = "data:[";
        foreach($tblgraph1 as $recno){
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

    public function downloadPDF($objdata)
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
    }
}
