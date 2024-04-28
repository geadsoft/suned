<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\TmProductos;
use App\Models\TrInventarioCabs;
use App\Models\TrInventarioDets;

class VcInventaryRegisterdet extends Component
{
    
    public $detalle = [], $invCab;
    public $linea, $total=0, $cantidad=0;
    
    protected $listeners = ['setDetalle','setGrabaDetalle','mount'];

    public function mount($id) {

        if ($id>0){
            $this->loadDetalle($id);
        }else {
            $this->detalle = [];
            $recno=[
                'linea' => 1,
                'productoid' => 0,
                'producto' => '',
                'unidad' => '',
                'cantidad' => 1,
                'precio' => 0.00,
                'total' => 0.00
            ];
            array_push($this->detalle,$recno);
        }

    }
    
    public function render()
    {
        return view('livewire.vc-inventary-registerdet',[
            'detalle' => $this->detalle,
        ]);
    }

    public function add(){

        $linea = count($this->detalle);
        $linea = $linea+1;

        $recno=[
            'linea' => $linea,
            'productoid' => 0,
            'producto' => '',
            'unidad' => '',
            'cantidad' => 1,
            'precio' => 0.00,
            'total' => 0.00
        ];

        array_push($this->detalle,$recno);
        
        $this->linea = $linea-1;
        $this->emitTo('vc-inventary-register','view',$this->linea);
        $this->emit('newfocus');

    }

    public function search($linea){

        $this->linea = $linea;
        $this->emitTo('vc-inventary-register','view',$linea);

    }

    public function calcular($linea){

        $cantidad = $this->detalle[$linea]['cantidad'];
        $precio = $this->detalle[$linea]['precio'];
        if (empty($cantidad)){
            $cantidad=0;
            $this->detalle[$linea]['cantidad']=0;
        }
        $total = $cantidad*$precio;

        $this->detalle[$linea]['total'] = floatval($total);

    }

    public function setDetalle($productoId){


        $record = TmProductos::find($productoId);
        $linea = $this->linea;
      
        $cantidad = floatval($this->detalle[$linea]);
        $this->detalle[$linea]['productoid'] = $record->id;
        $this->detalle[$linea]['producto'] = $record->nombre;
        $this->detalle[$linea]['unidad'] = $record->unidad;
        $this->detalle[$linea]['precio'] = $record->precio;
        $this->detalle[$linea]['total'] =  $cantidad*floatval($record->precio);
        
        
        $this->dispatchBrowserEvent('hide-form');

    }


    public function setGrabaDetalle($iventarioId){

        $this->invCab = TrInventarioCabs::find($iventarioId);
        $this->createData();
    }

    public function loadDetalle($id){

       $invtra = TrInventarioDets::where('inventariocab_id',$id)->get();
       
       foreach ($invtra as $index => $record)
       {
            $this->add();
            $this->detalle[$index]['linea'] = $record->linea;
            $this->detalle[$index]['productoid'] = $record->productoId;
            $this->detalle[$index]['producto'] = $record->producto->nombre;
            $this->detalle[$index]['cantidad'] = $record->cantidad;
            $this->detalle[$index]['unidad'] = $record->unidad;
            $this->detalle[$index]['precio'] = $record->precio;
            $this->detalle[$index]['total'] =  $record->total;

       }

    }

    public function createData(){

        $total = 0;

        foreach ($this->detalle as $index => $recno)
        {
            if ($recno['cantidad']>0){

                TrInventarioDets::Create([
                    'periodo' => $this->invCab->periodo,
                    'mes' => $this->invCab->mes,
                    'inventariocab_id' => $this->invCab->id,
                    'tipo' => $this->invCab->tipo,
                    'documento' => $this->invCab->documento,
                    'fecha' => $this->invCab->fecha,
                    'movimiento' => $this->invCab->movimiento,
                    'linea' => $recno['linea'],
                    'producto_id' => $recno['productoid'],
                    'unidad' => $recno['unidad'],
                    'cantidad' => $recno['cantidad'],
                    'precio' => $recno['precio'],
                    'total' => $recno['total'],
                    'estado' => 'G',
                    'usuario' => auth()->user()->name,
                ]);
                
                $total = $total + $recno['total'];

            }
        }

        $this->invCab->update([
            'neto' => $total,
        ]);

    }

}
