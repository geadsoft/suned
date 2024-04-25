<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\TmProductos;

class VcInventaryRegisterdet extends Component
{
    
    public $detalle = [];
    public $linea;
    
    protected $listeners = ['setDetalle'];

    public function mount() {

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

    }

    public function search($linea){
        $this->linea = $linea;
        $this->emitTo('vc-inventary-register','view',$linea);
    }

    public function calcular($linea){

        $cantidad = $this->detalle[$linea]['cantidad'];
        $precio = $this->detalle[$linea]['precio'];
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


}
