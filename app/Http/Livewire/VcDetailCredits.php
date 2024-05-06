<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\TrFacturasCabs;
use App\Models\TrFacturasDets;

class VcDetailCredits extends Component
{
    public $tbldetails = [], $invCab;
    public $linea, $total=0, $cantidad=0;
    
    protected $listeners = ['setDetalle','setGrabaDetalle','mount'];

    public function mount($facturaId) {

        if ($facturaId>0){
            $this->loadDetalle($facturaId);
        }else {
            $this->tbldetails = [];
            $recno=[
                'linea' => 1,
                'productoid' => 0,
                'codigo' => 'AF0001',
                'descripcion' => 'Anulación de Factura No.',
                'cantidad' => 1,
                'precio' => 0.00,
                'total' => 0.00
            ];
            array_push($this->tbldetails,$recno);
        }

    }
    
    public function render()
    {
        return view('livewire.vc-detail-credits');
    }

    public function add(){

        $linea = count($this->tbldetails);
        $linea = $linea+1;

        $recno=[
            'linea' => $linea,
            'productoid' => 0,
            'codigo' => '',
            'descripcion' => '',
            'cantidad' => 1,
            'precio' => 0.00,
            'total' => 0.00
        ];

        array_push($this->tbldetails,$recno);
        $this->linea = $linea-1;
        
    }

    public function calcular($linea){

        $cantidad = $this->tbldetails[$linea]['cantidad'];
        $precio = $this->tbldetails[$linea]['precio'];
        if (empty($cantidad)){
            $cantidad=0;
            $this->tbldetails[$linea]['cantidad']=0;
        }
        $total = $cantidad*$precio;

        $this->tbldetails[$linea]['total'] = floatval($total);

        $arrtotales['TotalSinImpto'] = $total;
        $arrtotales['Subtotal0'] = $total;
        $arrtotales['Total'] = $total;

        $this->emitTo('vc-create-credits','setTotales',$arrtotales);
    }

    /*public function setDetalle($productoId){


        $record = TmProductos::find($productoId);
        $linea = $this->linea;
      
        $cantidad = floatval($this->detalle[$linea]);
        $this->detalle[$linea]['productoid'] = $record->id;
        $this->detalle[$linea]['producto'] = $record->nombre;
        $this->detalle[$linea]['unidad'] = $record->unidad;
        $this->detalle[$linea]['precio'] = $record->precio;
        $this->detalle[$linea]['total'] =  $cantidad*floatval($record->precio);
        
        
        $this->dispatchBrowserEvent('hide-form');

    }*/

    public function setGrabaDetalle($iventarioId){

        $this->invCab = TrInventarioCabs::find($iventarioId);
        $invTra = TrInventarioDets::where('inventariocab_id',$iventarioId)->get();
        
        if(!empty($invTra)){
            TrInventarioDets::where('inventariocab_id',$iventarioId)->delete();
        }

        $this->createData();
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

    }



}
