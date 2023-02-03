<?php

namespace App\Http\Livewire;
use App\Models\TmPeriodosLectivos;
use App\Models\TmGeneralidades;
use App\Models\TmPersonas;
use App\Models\TmMatricula;
use App\Models\TmServicios;
use App\Models\TmCursos;

use Livewire\Component;
use Livewire\WithPagination;

class VcTuitions extends Component
{
    use WithPagination;
    public $showEditModal = false;
    public $selectId = 0;
    public $previus='', $current='', $nomnivel, $nomcurso;
    public $filterdata='M';
    public $tblcursos=null;
    public $tblservicios=null;
    public $tbldatogen=null;

    public $filters = [
        'srv_periodo' => '',
        'srv_grupo' => '',
        'srv_nombre' => '',
    ];
    
    public function render()
    {
        
        if ($this->filterdata=='M'){

            $tblrecords = TmPersonas::query()
            ->join("tm_matriculas as m","tm_personas.id","=","m.estudiante_id")
            ->join("tm_cursos as c","c.id","=","m.curso_id")
            ->join("tm_periodos_lectivos as p","p.id","=","m.periodo_id")
            ->join("tm_servicios as s","s.id","=","c.servicio_id")
            ->join("tm_generalidades as g","g.id","=","s.modalidad_id")
            ->when($this->filters['srv_nombre'],function($query){
                return $query->where('tm_personas.nombres','LIKE','%'.$this->filters['srv_nombre'].'%')
                            ->orWhere('tm_personas.apellidos','LIKE','%'.$this->filters['srv_nombre'].'%');
            })
            ->when($this->filters['srv_periodo'],function($query){
                return $query->where('m.periodo_id',"{$this->filters['srv_periodo']}");
            })
            ->when($this->filters['srv_grupo'],function($query){
                return $query->where('m.modalidad_id',"{$this->filters['srv_grupo']}");
            })
            ->select('m.id','identificacion','nombres','apellidos', 'documento', 'fecha', 'g.descripcion as nomgrupo','p.descripcion as nomperiodo','s.descripcion as nomgrado','paralelo','m.periodo_id','m.modalidad_id','m.nivel_id','c.servicio_id','m.curso_id')
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
        $this->tblservicios = TmServicios::all();
        $this->tblcursos    = TmCursos::all();
        $this->tbldatogen   = TmGeneralidades::all();

        return view('livewire.vc-tuitions',[
            'tblrecords' => $tblrecords,
            'tblgenerals' => $tblgenerals,
            'tblperiodos' => $tblperiodos
        ]);

    }    

  
    public function paginationView(){
        return 'vendor.livewire.bootstrap'; 
    }

    public function edit($objData){
        
        $this->record  = $objData;
        $this->selectId = $this -> record['id'];
        $this->nomnivel = $this->record['nomgrupo'];
        $this->nomcurso = $this->record['nomgrado'].' '.$this->record['paralelo'];
        
        $periodoId  = $this -> record['periodo_id'];
        $grupoId = $this -> record['modalidad_id'];
        $nivelId = $this -> record['nivel_id'];
        $gradoId = $this -> record['servicio_id'];
        $cursoId = $this -> record['curso_id'];


        $this->dispatchBrowserEvent('show-form');
        $this->emitTo('vc-modal-sections','setSection',$periodoId,$grupoId,$nivelId,$gradoId,$cursoId );

    }

    public function updateData(){

        $record = TmMatricula::find($this->selectId);
        $record->update([
            'nivel_id'      => $this -> record['nivel_id'],
            'modalidad_id'  => $this -> record['modalidad_id'],
            'grado_id'      => $this -> record['grado_id'],
            'curso_Id'      => $this -> record['curso_id'],
        ]);

                

    }

        
}


