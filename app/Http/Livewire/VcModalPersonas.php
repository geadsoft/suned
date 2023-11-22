<?php

namespace App\Http\Livewire;
use App\Models\TmPersonas;

use Livewire\Component;

class VcModalPersonas extends Component
{
    public $selectId, $tblrecords=[];
    public $filters = [
        'srv_tipo' => 'D',
        'srv_nombre' => '',
        'srv_nui' => '',
    ];

    public function render()
    {
        $this->tblrecords = $this->loadpersona();

        return view('livewire.vc-modal-personas',[
            'tblrecords' => $this->tblrecords,
        ]);
    }

    public function loadpersona(){

        $tbldata = TmPersonas::query()
        ->when($this->filters['srv_tipo'],function($query){
            return $query->where('tipopersona',"{$this->filters['srv_tipo']}");
        })
        ->when($this->filters['srv_nui'],function($query){
            return $query->where('identificacion',"{$this->filters['srv_nui']}");
        })        
        ->when($this->filters['srv_nombre'],function($query){
            return $query->whereRaw("concat(apellidos,'',nombres) LIKE '%".$this->filters['srv_nombre']."%'");
        })
        ->select('id','apellidos','nombres','identificacion')
        ->where('estado','A')
        ->limit(15)
        ->get();

       return $tbldata;

    }

    public function setDocente($personaId){
        
        $this->emitTo('vc-horarios-docentes','setDocente',$personaId);
        $this->dispatchBrowserEvent('hide-form');
        $this->filters['srv_nombre'] = '';
    }

}
