<?php

namespace App\Http\Livewire;
use App\Models\TmProductos;

use Livewire\Component;

class VcSearchProduct extends Component
{
    public $filters;
    public $linea;
    public $result=[];

    public function mount()
    {
        $this->reset();
        $this->filters="";
        $this->result=[];
    }

    public function render()
    {
        if (!empty($this->filters)){
            
            $this->results  = TmProductos::query()
            ->when($this->filters,function($query){
                return $query->whereRaw("nombre like '%".$this->filters."%'");
            })
            ->get();

        }else{
            $this->results = [];
        }

        return view('livewire.vc-search-product',[
            'results' => $this->results,
        ]);

    }

    public function addDetalle($productoId){
        $this->filters="";
        $this->result=[];
        $this->emitTo('vc-inventary-registerdet','setDetalle',$productoId);
    }

}
