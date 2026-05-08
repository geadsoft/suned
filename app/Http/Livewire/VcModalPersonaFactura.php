<?php

namespace App\Http\Livewire;
use App\Models\TmPersonas;

use Illuminate\Support\Facades\DB;
use Livewire\Component;

class VcModalPersonaFactura extends Component
{   
    public $selectId, $tblrecords=[];
    public $filters = [
        'srv_view' => '',
        'srv_tipo' => 'D',
        'srv_nombre' => '',
        'srv_nui' => '',
    ];

    public function mount($vista,$tipo)
    {
        $this->filters['srv_view'] = $vista;
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

        return view('livewire.vc-modal-persona-factura',[
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
        ->selectRaw("id,apellidos,nombres,identificacion, 0 as estudiante_id")
        ->where('estado','A')
        ->limit(15)
        ->get();

       return $tbldata;

    }

    public function loadclientes(){

        $tbldata = TmPersonas::query()
        ->join("tm_matriculas as m","m.estudiante_id","=","tm_personas.id")
        ->join("tm_servicios as s","s.id","=","m.grado_id")
        ->join("tm_generalidades as g","g.id","=","m.modalidad_id")
        ->join(DB::raw("(select estudiante_id,persona_id from tm_familiar_estudiantes
            union all
            select estudiante_id,persona_id from td_factura_estudiantes
        ) as f"),function($join){
            $join->on('f.estudiante_id', '=', 'tm_personas.id');
        })
        ->join("tm_personas as p","p.id","=","f.persona_id")

        ->when($this->filters['srv_nui'],function($query){
            return $query->where('tm_personas.identificacion',"{$this->filters['srv_nui']}");
        })        
        ->when($this->filters['srv_nombre'],function($query){
            return $query->whereRaw("concat(tm_personas.apellidos,'',tm_personas.nombres) LIKE '%".$this->filters['srv_nombre']."%'");
        })
        ->selectRaw("
            p.id,
            p.apellidos,
            p.nombres,
            p.identificacion,
            f.estudiante_id,
            tm_personas.nombres as nomestudent,
            tm_personas.apellidos as apeestudent,
            g.descripcion as modalidad,
            s.descripcion as grado,
            m.id as matriculaId
        ")
        ->where('p.estado','A')
        ->groupBy(
            'p.id',
            'p.apellidos',
            'p.nombres',
            'p.identificacion',
            'f.estudiante_id',
            'tm_personas.nombres',
            'tm_personas.apellidos',
            'g.descripcion',
            's.descripcion',
            'm.id'
        )
        ->orderBy('tm_personas.apellidos')
        ->orderBy('tm_personas.nombres')
        ->orderBy('g.descripcion')
        ->orderBy('s.descripcion')
        ->get();

        return $tbldata;

    }
    

    public function setPersona($personaId,$estudianteId,$matriculaId){

        switch ($this->filters['srv_view']) {
        case 'horarios-docentes':
            $this->emitTo('vc-horarios-docentes','setDocente',$personaId);
            $this->dispatchBrowserEvent('hide-form');
            $this->filters['srv_nombre'] = '';
            break;
        case 'createinvoice':
            $this->emitTo('vc-createinvoice','setPersona',$personaId,$estudianteId,$matriculaId);
            $this->dispatchBrowserEvent('hide-form');
            $this->filters['srv_nombre'] = '';
            break;
        case 'remove-teacher':
            $this->emitTo('vc-remove-teacher','setDocente',$personaId);
            $this->dispatchBrowserEvent('hide-form');
            $this->filters['srv_nombre'] = '';
            break;
        }      
        
    }

}
