<?php

namespace App\Http\Livewire;
use App\Models\TrInventarioDets;

use Illuminate\Support\Facades\DB;
use Livewire\Component;

class VcReportCostoGastos extends Component
{
    public $catMonto, $catCantidad, $catUtilidad, $prdMonto, $prdCantidad, $prdUtilidad;
    public $tblcatMonto, $tblcatCantidad;
    public $startDate, $endDate;
    public $tblrecords=[];

    public function mount(){
        $ldateini = date('Y-m-d H:i:s');
        $ldatefin = date('Y-m-d H:i:s');

        $this->startDate = date('Y-m-d',strtotime($ldateini));
        $this->endDate = date('Y-m-d',strtotime($ldatefin));
    }

    public function render()
    {
        return view('livewire.vc-report-costo-gastos');
    }

    public function updatedStartDate() {
        
        $this->consulta();
        $this->actualizaGraph();

    }


    public function consulta(){

        $this->catmonto = '';
        $this->catcantidad = '';
        $this->catutilidad = '';

        $this->tblcatMonto = TrInventarioDets::query()
        ->join("tm_productos as p","p.id","=","tr_inventario_dets.producto_id")
        ->join("tm_generalidades as g","g.id","=","p.categoria_id")
        ->when($this->startDate,function($query){
            return $query->where('tr_inventario_dets.fecha',">=",date('Ymd',strtotime($this->startDate)));
        })
        ->when($this->endDate,function($query){
            return $query->where('tr_inventario_dets.fecha',"<=",date('Ymd',strtotime($this->endDate)));
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

        //Cantidad
        $this->tblcatCantidad = TrInventarioDets::query()
        ->join("tm_productos as p","p.id","=","tr_inventario_dets.producto_id")
        ->join("tm_generalidades as g","g.id","=","p.categoria_id")
        ->when($this->startDate,function($query){
            return $query->where('tr_inventario_dets.fecha',">=",date('Ymd',strtotime($this->startDate)));
        })
        ->when($this->endDate,function($query){
            return $query->where('tr_inventario_dets.fecha',"<=",date('Ymd',strtotime($this->endDate)));
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
    }


}
