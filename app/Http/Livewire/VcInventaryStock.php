<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\TmGeneralidades;

class VcInventaryStock extends Component
{
    public $detalle = [];
    public $tblcategorias=[];
    public $filters=[
        'fechaini' => '',
        'fechafin' => '',
    ];

    public $movimiento=[
        '1' => 'Saldo Anterior',
        '2' => '(+)Inventario Inicial',
        '3' => '(+)Compras Locales',
        '4' => '(-)Ingreso por Ajuste',
        '5' => '(-)Venta',
        '6' => '(-)Egreso por Ajuste',
    ];

    public function mount()
    {
        $this->tblcategorias = TmGeneralidades::where('superior',11)->get();
        $this->load();
       
    }

    public function render()
    {
        return view('livewire.vc-inventary-stock');
    }

    public function load()
    {
        foreach ($this->tblcategorias as $key => $recno){
            $array[$key]=$key;
            $array['nombre']=$recno['descripcion'];
            $arrdet=[];
            for ($i = 1; $i <= 6; $i++){
                
                $arrtalla = $this->newarray();
                $arrtalla['nombre'] = $this->movimiento[$i];
                array_push($arrdet,$arrtalla);
            }
            
            $array['data']=$arrdet;

            array_push($this->detalle,$array);
            
        }
                
    }

    public function newarray(){
        
        $arrtalla=[
            'codigo' =>'',
            'nombre'=>'',
            '0'=>'Ninguna',
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
        return $arrtalla;
    }



}
