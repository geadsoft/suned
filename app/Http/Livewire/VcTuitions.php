<?php

namespace App\Http\Livewire;
use App\Models\TmPeriodosLectivos;
use App\Models\TmGeneralidades;
use App\Models\TmPersonas;
use App\Models\TmMatricula;

use Livewire\Component;
use Livewire\WithPagination;

class VcTuitions extends Component
{
    use WithPagination;
    public $showEditModal = false;
    public $previus='', $current='';
    public $filterdata='M';

    public $filters = [
        'srv_periodo' => '',
        'srv_grupo' => '',
        'srv_nombre' => '',
    ];
    
    public function render()
    {
        
        if ($this->filterdata=='M'){

            $tblrecords = TmPersonas::query()
            ->join("tm_matriculas","tm_personas.id","=","tm_matriculas.estudiante_id")
            ->join("tm_cursos","tm_cursos.id","=","tm_matriculas.curso_id")
            ->join("tm_periodos_lectivos","tm_periodos_lectivos.id","=","tm_matriculas.periodo_id")
            ->join("tm_servicios","tm_servicios.id","=","tm_cursos.servicio_id")
            ->join("tm_generalidades","tm_generalidades.id","=","tm_servicios.modalidad_id")
            ->when($this->filters['srv_nombre'],function($query){
                return $query->where('tm_personas.nombres','LIKE','%'.$this->filters['srv_nombre'].'%')
                            ->orWhere('tm_personas.apellidos','LIKE','%'.$this->filters['srv_nombre'].'%');
            })
            ->when($this->filters['srv_periodo'],function($query){
                return $query->where('tm_matriculas.periodo_id',"{$this->filters['srv_periodo']}");
            })
            ->when($this->filters['srv_grupo'],function($query){
                return $query->where('tm_matriculas.modalidad_id',"{$this->filters['srv_grupo']}");
            })
            ->select('identificacion','nombres','apellidos', 'documento', 'fecha', 'tm_generalidades.descripcion as nomgrupo','tm_periodos_lectivos.descripcion as nomperiodo','tm_servicios.descripcion as nomgrado','paralelo')
            ->orderBy('documento','desc')
            ->paginate(10);

        
        } else{
            
            $tblrecords = TmPersonas::query()
            ->when($this->filters['srv_nombre'],function($query){
                return $query->where('tm_personas.nombres','LIKE','%'."{$this->filters['srv_nombre']}".'%')
                            ->orWhere('tm_personas.apellidos','LIKE','%'."{$this->filters['srv_nombre']}".'%');
            })
            ->where('tm_personas.tipopersona','=','E')
            ->select('identificacion','nombres','apellidos')
            ->orderBy('apellidos','asc')
            ->paginate(10);            
            
        }

        $tblgenerals = TmGeneralidades::where('superior',1)->get();
        $tblperiodos = TmPeriodosLectivos::orderBy("periodo","desc")->get();

        return view('livewire.vc-tuitions',[
            'tblrecords' => $tblrecords,
            'tblgenerals' => $tblgenerals,
            'tblperiodos' => $tblperiodos
        ]);

    }    

  
    public function paginationView(){
        return 'vendor.livewire.bootstrap'; 
    }

        
}


