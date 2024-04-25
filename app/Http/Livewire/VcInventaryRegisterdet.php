<?php

namespace App\Http\Livewire;

use Livewire\Component;

class VcInventaryRegisterdet extends Component
{
    
    public $detalle = [];
      
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

        dd('print');

    }

    public function calcular($linea){

        $cantidad = $this->detalle[$linea]['cantidad'];
        $precio = $this->detalle[$linea]['precio'];
        $total = $cantidad*$precio;

        $this->detalle[$linea]['total'] = floatval($total);

    }

}
