<?php

namespace App\Http\Livewire;
use App\Models\TmGeneralidades;
use App\Models\TmPeriodosLectivos;
use App\Models\TmHorarios;

use App\Models\TmActividades;

use Livewire\Component;

class VcAsignaturaCursos extends Component
{
    public $selectId, $tblmodalidad, $tblasignatura = [], $modalidadId, $asignaturaId, $cursoId;
    public $tblparalelo=[];
    public $eSelectA = 'disabled';
    public $eSelectC = 'disabled';    

    protected $listeners = ['setEdit','setGrabar','setUpdate'];

    public function mount()
    {
        $this->docenteId = auth()->user()->personaId;

        $tblperiodos = TmPeriodosLectivos::where("aperturado",1)->first();
        $this->periodoId = $tblperiodos['id'];

    }
    
    public function render()
    {   
        $this->tblmodalidad = TmHorarios::query()
        ->join("tm_horarios_docentes as d","d.horario_id","=","tm_horarios.id")
        ->join("tm_generalidades as g","g.id","=","tm_horarios.grupo_id")
        ->where("d.docente_id",$this->docenteId)
        ->where("tm_horarios.periodo_id",$this->periodoId)
        ->selectRaw('g.id, g.descripcion')
        ->groupBy('g.id','g.descripcion')
        ->get();

        /*$this->tblasignatura = TmHorarios::query()
        ->join("tm_horarios_docentes as d","d.horario_id","=","tm_horarios.id")
        ->join("tm_asignaturas as m","m.id","=","d.asignatura_id")
        ->where("d.docente_id",$this->docenteId)
        ->where("tm_horarios.periodo_id",$this->periodoId)
        ->selectRaw('m.id, m.descripcion')
        ->groupBy('m.id','m.descripcion')
        ->get();*/
        
        $this->updatedmodalidadId($this->modalidadId);
        $this->updatedasignaturaId($this->asignaturaId);

        return view('livewire.vc-asignatura-cursos');
    }

    public function updatedmodalidadId($id){

        $this->modalidadId = $id;
        $this->eSelectA = 'disabled';

        if ($this->modalidadId>0){
            $this->eSelectA = '';  
        }

        $this->tblasignatura = TmHorarios::query()
        ->join("tm_horarios_docentes as d","d.horario_id","=","tm_horarios.id")
        ->join("tm_asignaturas as m","m.id","=","d.asignatura_id")
        ->where("d.docente_id",$this->docenteId)
        ->where("tm_horarios.periodo_id",$this->periodoId)
        ->where("tm_horarios.grupo_id",$this->modalidadId)
        ->selectRaw('m.id, m.descripcion')
        ->groupBy('m.id','m.descripcion')
        ->get();

    }

    public function updatedasignaturaId($id){

        $this->asignaturaId = $id;
        $this->eSelectC = 'disabled'; 

        if ($this->asignaturaId>0){
            $this->eSelectC = '';  
        }

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

    public function setEdit($id){

        $this->tblmodalidad = TmGeneralidades::where('superior',1);

        $this->selectId = $id;
        $actividad = TmActividades::find($id);

        $this->docenteId = $actividad->docente_id;

        $data = TmHorarios::query()
        ->join("tm_horarios_docentes as d","d.horario_id","=","tm_horarios.id")
        ->where('d.id',$actividad['paralelo'])
        ->where('d.docente_id',$this->docenteId)
        ->first();

        $this->modalidadId = $data['grupo_id'];
        $this->updatedmodalidadId($this->modalidadId);
        $this->asignaturaId = $data['asignatura_id'];
        $this->updatedasignaturaId($this->asignaturaId);

        $this->cursoId = $actividad['paralelo'];

    }
 
    public function setGrabar($enlace){

        $ldate = date('Y-m-d H:i:s');

        TmActividades::Create([
            'docente_id' => $this->docenteId,
            'paralelo' => $this->cursoId,
            'termino' => '',
            'bloque' => '',
            'tipo' => 'CV',
            'actividad' => 'AI',
            'nombre' => 'Clase Virtual',
            'descripcion' => "",
            'enlace' => $enlace,
            'fecha' => date('Y-m-d',strtotime($ldate)),
            'subir_archivo' => 'NO',
            'puntaje' => 0,
            'estado' => "A",
            'usuario' => auth()->user()->name,
        ]);
       
        $this->emitTo('vc-clases-virtual','setMensaje');
        
    }

     public function setUpdate($enlace){

        $record = TmActividades::find($this->selectId);
        $record->update([
            'paralelo' => $this->cursoId,
            'enlace' => $enlace,
        ]);

        $this->emitTo('vc-clases-virtual','setMensaje');
     }

}
