<?php

namespace App\Http\Livewire;
use App\Models\TrInventarioDets;
use App\Models\TmGeneralidades;

use Livewire\Component;
use PDF;

class VcReportProductoVendido extends Component
{
    public $vtaUnd, $vtaMonto, $vtaCant, $catvta1;
    public $tblUnd, $tblMonto, $tblCant;
    public $startDate, $endDate, $talla=0, $categoria=0, $vtatop=10;
    public $tblrecords=[];
    public $tblcategoria=[];
    public $datos='';
    public $filters = [
        'start_date' => '',
        'end_date' => '',
        'categoria' => '',
        'talla' => '',
        'cantidad' => ''
    ];

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
       
            $this->consulta();
            $this->actualizaGraph();
        
                
        return view('livewire.vc-report-producto-vendido',[
            'arrtalla' => $this->arrtalla
        ]);
    }

    public function updatedStartDate() {
        //dd($this->categoria);
        $this->consulta();
        $this->actualizaGraph();
    }

    public function consulta(){

        $this->catmonto = '';
        $this->catcantidad = '';
        $this->catutilidad = '';

        //Cantidad
        $this->tblUnd= TrInventarioDets::query()
        ->join("tm_productos as p","p.id","=","tr_inventario_dets.producto_id")
        ->join("tm_generalidades as g","g.id","=","p.categoria_id")
        ->when($this->categoria>0,function($query){
            return $query->where('g.id',"=",$this->categoria);
        })
        ->when($this->talla>0,function($query){
            return $query->where('p.talla',"=",$this->talla);
        })
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
        ->when($this->vtatop>0,function($query){
             return $query->take($this->vtatop);
        })
        ->get();

        if($this->tblUnd!=null){
            $this->graphs($this->tblUnd,1);
        }        
           
        //Monto
        $this->tblMonto = TrInventarioDets::query()
        ->join("tm_productos as p","p.id","=","tr_inventario_dets.producto_id")
        ->join("tm_generalidades as g","g.id","=","p.categoria_id")
        ->when($this->categoria>0,function($query){
            return $query->where('g.id',"=",$this->categoria);
        })
        ->when($this->talla>0,function($query){
            return $query->where('p.talla',"=",$this->talla);
        })
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
        ->when($this->vtatop>0,function($query){
            return $query->take($this->vtatop);
        })
        ->get();

        if($this->tblMonto!=null){
            $this->graphs($this->tblMonto,2);
        }

        //Unidad
        $this->tblCant= TrInventarioDets::query()
        ->join("tm_productos as p","p.id","=","tr_inventario_dets.producto_id")
        ->join("tm_generalidades as g","g.id","=","p.categoria_id")
        ->when($this->categoria>0,function($query){
            return $query->where('g.id',"=",$this->categoria);
        })
        ->when($this->talla>0,function($query){
            return $query->where('p.talla',"=",$this->talla);
        })
        ->when($this->startDate,function($query){
            return $query->where('tr_inventario_dets.fecha',">=",date('Ymd',strtotime($this->startDate)));
        })
        ->when($this->endDate,function($query){
            return $query->where('tr_inventario_dets.fecha',"<=",date('Ymd',strtotime($this->endDate)));
        })
        ->where('tr_inventario_dets.movimiento','VE')
        ->selectRaw('p.nombre, max(cantidad) as cantidad, sum(total) as valor')
        ->groupBy('p.nombre')
        ->orderby('cantidad','desc')
        ->when($this->vtatop>0,function($query){
            return $query->take($this->vtatop);
        })
        ->get();

        if($this->tblCant!=null){
            $this->graphs($this->tblCant,3);
        }    

        $this->filters = [
            'start_date' => $this->startDate,
            'end_date' => $this->endDate,
            'categoria' => $this->categoria,
            'talla' => $this->talla,
            'cantidad' => $this->vtatop
        ];
        
        $this->datos = json_encode($this->filters);

    }   

    public function graphs($tblData,$graph){

        $linea = count($tblData)-1;
        $arraycat=[];
        $array=[];

        $valores  = '';
        $dataline = '';

        if ($graph==1){
            for ($x=0;$x<=$linea;$x++) {
                $dataline = $dataline."'".strval($x+1)."',";
                $valores =  $valores.sprintf('%.2f', $tblData[$x]['cantidad']).' ,'; 
            };
            $array[]  = substr($valores, 0, -2);
            $strarray = json_encode($array);
            $strarray = str_replace('"','',$strarray);
        }

        if ($graph==2){
            for ($x=0;$x<=$linea;$x++) {
                $dataline = $dataline."'".strval($x+1)."',";
                $valores =  $valores.sprintf('%.2f', $tblData[$x]['valor']).' ,'; 
            };
            $array[] = substr($valores, 0, -2);
            $strarray = json_encode($array);
            $strarray = str_replace('"','',$strarray);
        }

        if ($graph==3){
            for ($x=0;$x<=$linea;$x++) {
                $dataline = $dataline."'".strval($x+1)."',";
                $valores =  $valores.sprintf('%.2f', $tblData[$x]['cantidad']).' ,'; 
            };
            $array[] = substr($valores, 0, -2);
            $strarray = json_encode($array);
            $strarray = str_replace('"','',$strarray);
        }
                  
        switch ($graph){
            case 1:
                $this->catvta1 = json_encode($arraycat);
                $this->vtaUnd  = $strarray;
                break;
            case 2:
                $this->vtaMonto  = $strarray;
                break;
            case 3:
                $this->vtaCant = $strarray;
                break;
        }
            
    }

    public function actualizaGraph(){
        $this->dispatchBrowserEvent('graph-vtaund', ['newObj' => $this->vtaUnd]);
        $this->dispatchBrowserEvent('graph-vtamonto', ['newObj' => $this->vtaMonto]);
        $this->dispatchBrowserEvent('graph-vtacant', ['newObj' => $this->vtaCant]);
    }

    public function printPDF($objdata)
    { 
        $data = json_decode($objdata);
        $this->filters['start_date'] =  $data->start_date;
        $this->filters['end_date'] =  $data->end_date;
        $this->filters['categoria'] =  $data->categoria;
        $this->filters['talla'] =  $data->talla;
        $this->filters['cantidad'] =  $data->cantidad;  

        $tblgraph1 = TrInventarioDets::query()
        ->join("tm_productos as p","p.id","=","tr_inventario_dets.producto_id")
        ->join("tm_generalidades as g","g.id","=","p.categoria_id")
        ->where('tr_inventario_dets.movimiento','VE')
        ->when($this->filters['categoria'],function($query){
            return $query->where('g.id',"{$this->filters['categoria']}");
        })
        ->when($this->filters['talla'],function($query){
            return $query->where('p.talla',"{$this->filters['talla']}");
        })
        ->where('tr_inventario_dets.fecha','>=',$this->filters['start_date'])
        ->where('tr_inventario_dets.fecha','<=',$this->filters['end_date'])
        ->selectRaw('p.nombre, sum(cantidad) as cantidad, sum(total) as valor')
        ->groupBy('p.nombre')
        ->orderby('cantidad','desc')
        ->when($this->filters['cantidad'],function($query){
            return $query->take($this->filters['cantidad']);
        })
        ->get();

        $urlgraph1 = "https://quickchart.io/chart?c={type:'horizontalBar',data:{labels:['1','2','3','4','5','6','7','8','9','10'],datasets:[{label:'Unidades',";
        $dataset = "data:[";
        foreach($tblgraph1 as $recno){
            $dataset = $dataset.strval($recno->cantidad).', '; 
        }
        $dataset = $dataset."], backgroundColor: 'rgb(17, 183, 205)', }]}}";  
        $urlgraph1 = $urlgraph1.$dataset;

        $tblgraph2 = TrInventarioDets::query()
        ->join("tm_productos as p","p.id","=","tr_inventario_dets.producto_id")
        ->join("tm_generalidades as g","g.id","=","p.categoria_id")
        ->where('tr_inventario_dets.movimiento','VE')
        ->when($this->filters['categoria'],function($query){
            return $query->where('g.id',"{$this->filters['categoria']}");
        })
        ->when($this->filters['talla'],function($query){
            return $query->where('p.talla',"{$this->filters['talla']}");
        })
        ->where('tr_inventario_dets.fecha','>=',$this->filters['start_date'])
        ->where('tr_inventario_dets.fecha','<=',$this->filters['end_date'])
        ->when($this->filters['categoria'],function($query){
            return $query->where('g.id',"=",$this->filters['categoria']);
        })
        ->when($this->filters['talla'],function($query){
            return $query->where('p.talla',"=",$this->filters['talla']);
        })
        ->selectRaw('p.nombre, sum(cantidad) as cantidad, sum(total) as valor')
        ->groupBy('p.nombre')
        ->orderby('valor','desc')
        ->when($this->filters['cantidad'],function($query){
            return $query->take($this->filters['cantidad']);
        })
        ->get();

        $urlgraph2 = "https://quickchart.io/chart?c={type:'horizontalBar',data:{labels:['1','2','3','4','5','6','7','8','9','10'],datasets:[{label:'Monto',";
        $dataset = "data:[";
        foreach($tblgraph2 as $recno){
            $dataset = $dataset.strval($recno->valor).', '; 
        }
        $dataset = $dataset."], backgroundColor: 'rgb(157, 187, 45)', }]}}";  
        $urlgraph2 = $urlgraph2.$dataset;

        $tblgraph3 = TrInventarioDets::query()
        ->join("tm_productos as p","p.id","=","tr_inventario_dets.producto_id")
        ->join("tm_generalidades as g","g.id","=","p.categoria_id")
        ->where('tr_inventario_dets.movimiento','VE')
        ->when($this->filters['categoria'],function($query){
            return $query->where('g.id',"{$this->filters['categoria']}");
        })
        ->when($this->filters['talla'],function($query){
            return $query->where('p.talla',"{$this->filters['talla']}");
        })
        ->where('tr_inventario_dets.fecha','>=',$this->filters['start_date'])
        ->where('tr_inventario_dets.fecha','<=',$this->filters['end_date'])
        ->when($this->filters['categoria'],function($query){
            return $query->where('g.id',"=",$this->filters['categoria']);
        })
        ->when($this->filters['talla'],function($query){
            return $query->where('p.talla',"=",$this->filters['talla']);
        })
        ->selectRaw('p.nombre, max(cantidad) as cantidad, sum(total) as valor')
        ->groupBy('p.nombre')
        ->orderby('cantidad','desc')
        ->when($this->filters['cantidad'],function($query){
            return $query->take($this->filters['cantidad']);
        })
        ->get();

        $urlgraph3 = "https://quickchart.io/chart?c={type:'horizontalBar',data:{labels:['1','2','3','4','5','6','7','8','9','10'],datasets:[{label:'Cantidad',";
        $dataset = "data:[";
        foreach($tblgraph3 as $recno){
            $dataset = $dataset.strval($recno->cantidad).', '; 
        }
        $dataset = $dataset."], backgroundColor: 'rgb(250, 131, 11)', }]}}";   
        $urlgraph3 = $urlgraph3.$dataset;

        //Vista
        $pdf = PDF::loadView('reports/reporte_productovendidos',[
            'tblgraph1' => $tblgraph1,
            'tblgraph2' => $tblgraph2,
            'tblgraph3' => $tblgraph3,
            'urlgraph1' => $urlgraph1,
            'urlgraph2' => $urlgraph2,
            'urlgraph3' => $urlgraph3,
            'data' => $data,
        ]);

        return $pdf->setPaper('a4')->stream('Productos Vendidos.pdf');
    
    }

    public function downloadPDF($objdata)
    { 
        
        $data = json_decode($objdata);
        $this->filters['start_date'] =  $data->start_date;
        $this->filters['end_date'] =  $data->end_date;
        $this->filters['categoria'] =  $data->categoria;
        $this->filters['talla'] =  $data->talla;
        $this->filters['cantidad'] =  $data->cantidad;  

        $tblgraph1 = TrInventarioDets::query()
        ->join("tm_productos as p","p.id","=","tr_inventario_dets.producto_id")
        ->join("tm_generalidades as g","g.id","=","p.categoria_id")
        ->where('tr_inventario_dets.movimiento','VE')
        ->when($this->filters['categoria'],function($query){
            return $query->where('g.id',"{$this->filters['categoria']}");
        })
        ->when($this->filters['talla'],function($query){
            return $query->where('p.talla',"{$this->filters['talla']}");
        })
        ->where('tr_inventario_dets.fecha','>=',$this->filters['start_date'])
        ->where('tr_inventario_dets.fecha','<=',$this->filters['end_date'])
        ->selectRaw('p.nombre, sum(cantidad) as cantidad, sum(total) as valor')
        ->groupBy('p.nombre')
        ->orderby('cantidad','desc')
        ->when($this->filters['cantidad'],function($query){
            return $query->take($this->filters['cantidad']);
        })
        ->get();

        $urlgraph1 = "https://quickchart.io/chart?c={type:'horizontalBar',data:{labels:['1','2','3','4','5','6','7','8','9','10'],datasets:[{label:'Unidades',";
        $dataset = "data:[";
        foreach($tblgraph1 as $recno){
            $dataset = $dataset.strval($recno->cantidad).', '; 
        }
        $dataset = $dataset."], backgroundColor: 'rgb(17, 183, 205)', }]}}";  
        $urlgraph1 = $urlgraph1.$dataset;

        $tblgraph2 = TrInventarioDets::query()
        ->join("tm_productos as p","p.id","=","tr_inventario_dets.producto_id")
        ->join("tm_generalidades as g","g.id","=","p.categoria_id")
        ->where('tr_inventario_dets.movimiento','VE')
        ->when($this->filters['categoria'],function($query){
            return $query->where('g.id',"{$this->filters['categoria']}");
        })
        ->when($this->filters['talla'],function($query){
            return $query->where('p.talla',"{$this->filters['talla']}");
        })
        ->where('tr_inventario_dets.fecha','>=',$this->filters['start_date'])
        ->where('tr_inventario_dets.fecha','<=',$this->filters['end_date'])
        ->when($this->filters['categoria'],function($query){
            return $query->where('g.id',"=",$this->filters['categoria']);
        })
        ->when($this->filters['talla'],function($query){
            return $query->where('p.talla',"=",$this->filters['talla']);
        })
        ->selectRaw('p.nombre, sum(cantidad) as cantidad, sum(total) as valor')
        ->groupBy('p.nombre')
        ->orderby('valor','desc')
        ->when($this->filters['cantidad'],function($query){
            return $query->take($this->filters['cantidad']);
        })
        ->get();

        $urlgraph2 = "https://quickchart.io/chart?c={type:'horizontalBar',data:{labels:['1','2','3','4','5','6','7','8','9','10'],datasets:[{label:'Monto',";
        $dataset = "data:[";
        foreach($tblgraph2 as $recno){
            $dataset = $dataset.strval($recno->valor).', '; 
        }
        $dataset = $dataset."], backgroundColor: 'rgb(157, 187, 45)', }]}}";  
        $urlgraph2 = $urlgraph2.$dataset;

        $tblgraph3 = TrInventarioDets::query()
        ->join("tm_productos as p","p.id","=","tr_inventario_dets.producto_id")
        ->join("tm_generalidades as g","g.id","=","p.categoria_id")
        ->where('tr_inventario_dets.movimiento','VE')
        ->when($this->filters['categoria'],function($query){
            return $query->where('g.id',"{$this->filters['categoria']}");
        })
        ->when($this->filters['talla'],function($query){
            return $query->where('p.talla',"{$this->filters['talla']}");
        })
        ->where('tr_inventario_dets.fecha','>=',$this->filters['start_date'])
        ->where('tr_inventario_dets.fecha','<=',$this->filters['end_date'])
        ->when($this->filters['categoria'],function($query){
            return $query->where('g.id',"=",$this->filters['categoria']);
        })
        ->when($this->filters['talla'],function($query){
            return $query->where('p.talla',"=",$this->filters['talla']);
        })
        ->selectRaw('p.nombre, max(cantidad) as cantidad, sum(total) as valor')
        ->groupBy('p.nombre')
        ->orderby('cantidad','desc')
        ->when($this->filters['cantidad'],function($query){
            return $query->take($this->filters['cantidad']);
        })
        ->get();

        $urlgraph3 = "https://quickchart.io/chart?c={type:'horizontalBar',data:{labels:['1','2','3','4','5','6','7','8','9','10'],datasets:[{label:'Cantidad',";
        $dataset = "data:[";
        foreach($tblgraph3 as $recno){
            $dataset = $dataset.strval($recno->cantidad).', '; 
        }
        $dataset = $dataset."], backgroundColor: 'rgb(250, 131, 11)', }]}}";   
        $urlgraph3 = $urlgraph3.$dataset;

        //Vista
        $pdf = PDF::loadView('reports/reporte_productovendidos',[
            'tblgraph1' => $tblgraph1,
            'tblgraph2' => $tblgraph2,
            'tblgraph3' => $tblgraph3,
            'urlgraph1' => $urlgraph1,
            'urlgraph2' => $urlgraph2,
            'urlgraph3' => $urlgraph3,
            'data' => $data,
        ]);

        return $pdf->download('Productos Vendidos.pdf');
    }
}
