<?php

namespace App\Http\Livewire;
use App\Models\TmHorarios;
use App\Models\TmActividades;
use App\Models\TmPeriodosLectivos;
use App\Models\TmGeneralidades;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;

class VcClasesVirtual extends Component
{
    
    public $showEditModal, $paralelo, $actividadId=0, $asignaturaId=0, $display="display: none";
    public $cursosTodos, $selectId, $modalidadId, $periodoId;
    
    public $record=[];
    public $tblparalelo=[];
    public $tblasignatura=[];
    public $tblmodalidad=[];

    public $filters=[
        'paralelo' => '',
    ];

    use WithPagination;

    protected $listeners = ['setMensaje'];

    public function mount()
    {
        $ldate = date('Y-m-d H:i:s');
        $fecha = date('Y-m-d',strtotime($ldate));

        $this->docenteId = auth()->user()->personaId;

        $periodos = TmPeriodosLectivos::where("aperturado",1)->first();
        $this->periodoId = $periodos['id'];

        $this->cursosTodos = false;
        if (auth()->user()->can('Ver Cursos CV')) {
            $this->cursosTodos = true;
        };

    }

    public function render()
    {   
        $this->display = "display: none";

        $tblperiodos = TmPeriodosLectivos::orderBy("periodo","desc")->get();

        $this->tblmodalidad = TmGeneralidades::where('superior',1)->get();

        if ($this->cursosTodos){

            $this->loadCursos();

            $tblrecords = TmHorarios::query()
            ->join("tm_generalidades as g","g.id","=","tm_horarios.grupo_id")
            ->join("tm_servicios as s","s.id","=","tm_horarios.servicio_id")
            ->join("tm_cursos as c","c.id","=","tm_horarios.curso_id")
            ->join("tm_horarios_docentes as d","d.horario_id","=","tm_horarios.id")
            ->join("tm_asignaturas as m","m.id","=","d.asignatura_id")
            ->join("tm_actividades as a","a.paralelo","=","d.id")
            ->when($this->filters['paralelo'],function($query){
                return $query->where('tm_horarios.id',"{$this->filters['paralelo']}");
            })
            ->when($this->asignaturaId,function($query){
                return $query->where('d.id',"{$this->asignaturaId}");
            })
            ->when($this->modalidadId,function($query){
                return $query->where('tm_horarios.grupo_id',"{$this->modalidadId}");
            })
            ->where("tm_horarios.periodo_id",$this->periodoId)
            ->where("a.tipo","CV")
            ->where("a.estado","A")
            ->selectRaw('g.descripcion as modalidad, m.descripcion as asignatura, s.descripcion as curso, c.paralelo as aula, a.*')
            ->orderbyRaw('g.descripcion, m.descripcion')
            ->paginate(12);

            $this->updatedParalelo($this->filters['paralelo']);

        }else{
            
            $this->tblasignatura = TmHorarios::query()
            ->join("tm_horarios_docentes as d","d.horario_id","=","tm_horarios.id")
            ->join("tm_asignaturas as m","m.id","=","d.asignatura_id")
            ->where("d.docente_id",$this->docenteId)
            ->where("tm_horarios.periodo_id",$this->periodoId)
            ->where("tm_horarios.grupo_id",$this->modalidadId)
            ->selectRaw('m.id, m.descripcion')
            ->groupBy('m.id','m.descripcion')
            ->get();

            $tblrecords = TmHorarios::query()
            ->join("tm_generalidades as g","g.id","=","tm_horarios.grupo_id")
            ->join("tm_servicios as s","s.id","=","tm_horarios.servicio_id")
            ->join("tm_cursos as c","c.id","=","tm_horarios.curso_id")
            ->join("tm_horarios_docentes as d","d.horario_id","=","tm_horarios.id")
            ->join("tm_asignaturas as m","m.id","=","d.asignatura_id")
            ->join("tm_actividades as a","a.paralelo","=","d.id")
            ->when($this->modalidadId,function($query){
                return $query->where('tm_horarios.grupo_id',"{$this->modalidadId}");
            })
            ->when($this->filters['paralelo'],function($query){
                return $query->where('a.paralelo',"{$this->filters['paralelo']}");
            })
            ->where("a.docente_id",$this->docenteId)
            ->where("tm_horarios.periodo_id",$this->periodoId)
            ->where("a.tipo","CV")
            ->where("a.estado","A")
            ->selectRaw('g.descripcion as modalidad, m.descripcion as asignatura, s.descripcion as curso, c.paralelo as aula, a.*')
            ->orderbyRaw('g.descripcion,m.descripcion')
            ->paginate(12);

            $this->updatedasignaturaId($this->asignaturaId);
        }

        return view('livewire.vc-clases-virtual',[
            'tblrecords' =>  $tblrecords,
            'tblperiodos' => $tblperiodos,
        ]);
    }

    public function paginationView(){
        return 'vendor.livewire.bootstrap'; 
    }

    
    public function updatedmodalidadId($id){
        $this->loadCursos();
    }


    public function updatedasignaturaId($id){
        
        $this->asignaturaId = $id;

        $this->tblparalelo = TmHorarios::query()
        ->join("tm_servicios as s","s.id","=","tm_horarios.servicio_id")
        ->join("tm_cursos as c","c.id","=","tm_horarios.curso_id")
        ->join("tm_horarios_docentes as d","d.horario_id","=","tm_horarios.id")
        ->join("tm_asignaturas as m","m.id","=","d.asignatura_id")
        ->where("d.docente_id",$this->docenteId)
        ->where("tm_horarios.periodo_id",$this->periodoId)
        ->where("tm_horarios.grupo_id",$this->modalidadId)
        ->where("m.id",$id)
        ->selectRaw('d.id, concat(s.descripcion," ",c.paralelo) as descripcion')
        ->get();
        
    }

    public function add(){

        $ldate = date('Y-m-d H:i:s');
        
        $this->showEditModal = false;
        $this->reset(['record']);
        $this->record['docente_id']= '';
        $this->record['termino']= '';
        $this->record['bloque']= '';
        $this->record['actividad']= 'AI';
        $this->record['tipo']= 'CV';
        $this->record['nombre']= 0;
        $this->record['paralelo']= 0;
        $this->record['enlace']= '';
        $this->record['fecha']= date('Y-m-d',strtotime($ldate));
        $this->record['estado']= 'A';       
        $this->dispatchBrowserEvent('show-form');

    }


    public function createData(){

        $this->emitTo('vc-asignatura-cursos','setGrabar',$this->record['enlace']);
                
    }

    public function edit($id){

        $this->showEditModal = true;

        $actividad = TmActividades::find($id);
        $this->record['enlace'] =  $actividad['enlace'];

        $this->dispatchBrowserEvent('show-form');
        $this->emitTo('vc-asignatura-cursos','setEdit',$id);
    }

    public function updateData(){

        $this->emitTo('vc-asignatura-cursos','setUpdate',$this->record['enlace']);
                
    }

    public function delete($Id){

        $this->selectId = $Id;
        $this->dispatchBrowserEvent('show-delete');

    }
    
    public function deleteData(){

        TmActividades::find($this->selectId)->delete();
        $this->dispatchBrowserEvent('hide-delete');

    }

    public function setMensaje(){

        $message = "Registro grabado con éxito!";

        if ($this->showEditModal){
            $message = "Registro actualizado con éxito!";
        }

        $this->dispatchBrowserEvent('msg-grabar', ['newName' => $message]);

        $this->dispatchBrowserEvent('hide-form');

    }

    public function loadCursos(){

        $this->tblparalelo = TmActividades::query()
        ->join('tm_horarios_docentes as d', function($join)
        {
            $join->on('d.id', '=', 'tm_actividades.paralelo');
            $join->on('d.docente_id', '=','tm_actividades.docente_id');
        })
        ->join('tm_horarios as h','h.id','=','d.horario_id')
        ->join('tm_servicios as s','s.id','=','h.servicio_id')
        ->join('tm_cursos as c','c.id','=','h.curso_id')
        ->where('tm_actividades.tipo','CV')
        ->where('h.grupo_id',$this->modalidadId)
        ->select('h.id','s.descripcion','c.paralelo')
        ->groupBy('h.id','s.descripcion','c.paralelo')
        ->orderBy('s.descripcion')
        ->get();
       

    }

    public function updatedParalelo($id){
        
        $this->filters['paralelo'] = $id;

        $this->tblasignatura = TmActividades::query()
        ->join('tm_horarios_docentes as d', function($join)
        {
            $join->on('d.id', '=', 'tm_actividades.paralelo');
            $join->on('d.docente_id', '=','tm_actividades.docente_id');
        })
        ->join('tm_horarios as h','h.id','=','d.horario_id')
        ->join('tm_asignaturas as m','m.id','=','d.asignatura_id')
        ->where('tm_actividades.tipo','CV')
        ->where('h.id',$id)
        ->select('d.id','m.descripcion')
        ->groupBy('d.id','m.descripcion')
        ->orderBy('m.descripcion')
        ->get();
        
    }


}
