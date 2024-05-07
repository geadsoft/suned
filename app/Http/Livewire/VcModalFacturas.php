<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\TrFacturasCabs;

class VcModalFacturas extends Component
{
    public $selectId;
    public $filters = [
        'srv_nombre' => '',
    ];
    
    public function render()
    {
        
        $facturas = [];
        if (!empty($this->filters['srv_nombre'])){

            $facturas = TrFacturasCabs::query()
            ->join("tm_personas as p","p.id","=","tr_facturas_cabs.persona_id")     
            ->when($this->filters['srv_nombre'],function($query){
                return $query->whereRaw("concat(p.apellidos,'',p.nombres) LIKE '%".$this->filters['srv_nombre']."%'");
            })
            ->select('p.id','apellidos','nombres','identificacion','tr_facturas_cabs.id as facturaId','establecimiento','puntoemision','documento')
            ->where('tr_facturas_cabs.estado','A')
            ->where('tr_facturas_cabs.tipo','FE')
            ->limit(15)
            ->get();

        }        

        return view('livewire.vc-modal-facturas',[
            'facturas' => $facturas,
        ]);

    }

    public function setFactura($facturaId){

        $this->emitTo('vc-create-credits','setDocModifica',$facturaId);
        $this->dispatchBrowserEvent('hide-form');
        $this->filters['srv_nombre'] = '';
     
    }

}
