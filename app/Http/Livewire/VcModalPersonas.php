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

    public function mount($tipo)
    {
        $this->filters['srv_tipo'] = $tipo;
    }

    public function render()
    {
        $this->tblrecords  = [];

        if (!empty($this->filters['srv_nombre'])){
            
            if ($this->filters['srv_tipo']=='R'){
                $this->tblrecords = $this->loadclientes();
            }else{
                $this->tblrecords = $this->loadpersona();
            }

        }

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

    public function loadclientes(){

        $tbldata = TmPersonas::query()
        ->join("tm_familiar_estudiantes as f","f.estudiante_id","=","tm_personas.id")
        ->join("tm_personas as p","p.id","=","f.persona_id")
        ->when($this->filters['srv_tipo'],function($query){
            return $query->where('p.tipopersona',"{$this->filters['srv_tipo']}");
        })
        ->when($this->filters['srv_nui'],function($query){
            return $query->where('tm_personas.identificacion',"{$this->filters['srv_nui']}");
        })        
        ->when($this->filters['srv_nombre'],function($query){
            return $query->whereRaw("concat(tm_personas.apellidos,'',tm_personas.nombres) LIKE '%".$this->filters['srv_nombre']."%'");
        })
        ->select('p.id','p.apellidos','p.nombres','p.identificacion','f.estudiante_id')
        ->where('p.estado','A')
        ->limit(15)
        ->get();

        return $tbldata;

    }

    public function setPersona($personaId,$estudianteId){

        if ($this->filters['srv_tipo']=='D'){
            $this->emitTo('vc-horarios-docentes','setDocente',$personaId);
            $this->dispatchBrowserEvent('hide-form');
            $this->filters['srv_nombre'] = '';
        }else {
            $this->emitTo('vc-createinvoice','setPersona',$personaId,$estudianteId);
            $this->dispatchBrowserEvent('hide-form');
            $this->filters['srv_nombre'] = '';
        }        
        
    }

}
