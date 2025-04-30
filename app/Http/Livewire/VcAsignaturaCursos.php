<?php

namespace App\Http\Livewire;
use App\Models\TmPeriodosLectivos;
use App\Models\TmHorarios;
use App\Models\TmActividades;

use Livewire\Component;

class VcAsignaturaCursos extends Component
{
    public $tblasignatura, $asignaturaId, $cursoId;
    public $tblparalelo=[];

    protected $listeners = ['setGrabar'];

    public function mount()
    {
        $this->docenteId = auth()->user()->personaId;

        $tblperiodos = TmPeriodosLectivos::where("aperturado",1)->first();
        $this->periodoId = $tblperiodos['id'];

    }
    
    public function render()
    {   
        $this->tblasignatura = TmHorarios::query()
        ->join("tm_horarios_docentes as d","d.horario_id","=","tm_horarios.id")
        ->join("tm_asignaturas as m","m.id","=","d.asignatura_id")
        ->where("d.docente_id",$this->docenteId)
        ->where("tm_horarios.periodo_id",$this->periodoId)
        ->selectRaw('m.id, m.descripcion')
        ->groupBy('m.id','m.descripcion')
        ->get();

        $this->updatedasignaturaId($this->asignaturaId);

        return view('livewire.vc-asignatura-cursos');
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
        ->where("m.id",$id)
        ->selectRaw('d.id, concat(s.descripcion," ",c.paralelo) as descripcion')
        ->get();

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



}
