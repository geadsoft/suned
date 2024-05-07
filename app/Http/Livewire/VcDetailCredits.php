<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\TrFacturasCabs;
use App\Models\TrFacturasDets;

class VcDetailCredits extends Component
{
    public $tbldetails = [], $invCab;
    public $linea, $total=0, $cantidad=0;
    
    protected $listeners = ['setGrabaDetalle'];

    public function mount($facturaId) {

        if ($facturaId>0){
            $this->loadDetalle($facturaId);
        }else {
            $this->tbldetails = [];
            $recno=[
                'linea' => 1,
                'productoid' => 0,
                'codigo' => 'AF0001',
                'descripcion' => 'DESCUENTO EN FACTURA',
                'unidad' => 'UND',
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

        if (empty($precio)){
            $precio=0;
            $this->tbldetails[$linea]['precio']=0;
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

    public function removeItem($linea){

        $recnoToDelete = $this->tbldetails;
        foreach ($recnoToDelete as $index => $recno)
        {
            if ($recno['linea'] == $linea){
                unset ($recnoToDelete[$index]);
            } 
        }

        $this->reset(['tbldetails']);
        $this->tbldetails = $recnoToDelete;

        $total = array_sum(array_column($this->tbldetails,'total'));
        $arrtotales['TotalSinImpto'] = $total;
        $arrtotales['Subtotal0'] = $total;
        $arrtotales['Total'] = $total;

        $this->emitTo('vc-createinvoice','setTotales',$arrtotales);
    }

    public function setGrabaDetalle($facturaId){

        $this->facturaCab = TrFacturasCabs::find($facturaId);
        $this->createData();
    }

    public function createData(){

        foreach ($this->tbldetails as $index => $recno)
        {
            TrFacturasDets::Create([
                'periodo' => $this->facturaCab->periodo,
                'mes' => $this->facturaCab->mes,
                'facturacab_id' => $this->facturaCab->id,
                'linea' => $recno['linea'],
                'codigo' => $recno['codigo'],
                'descripcion' => $recno['descripcion'],
                'unidad' => $recno['unidad'],
                'cantidad' => $recno['cantidad'],
                'precio' => $recno['precio'],
                'descuento' => 0,
                'impuesto' => 0,
                'total' => $recno['total'],
                'estado' => 'C',
                'usuario' => auth()->user()->name,
            ]);

        }

    }

}
