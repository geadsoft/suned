<?php

namespace App\Http\Livewire;
use App\Models\TmHorarios;
use App\Models\TmHorariosDocentes;
use App\Models\TmPeriodosLectivos;
use App\Models\TmMatricula;
use App\Models\TmActividades;
use App\Models\TmPaseCursos;
use App\Models\TmCambiaModalidad;


use Livewire\Component;

class VcStudentSubject extends Component
{
    public $tblrecords = [];
    public $fecha;
    
    public function mount()
    {
        $ldate = date('Y-m-d H:i:s');
        $this->fecha = date('Y-m-d',strtotime($ldate));
        $this->personaId = auth()->user()->personaId;

        $tblperiodos = TmPeriodosLectivos::where("aperturado",1)->first();
        $this->periodoId = $tblperiodos['id'];

        $modalidad = TmCambiaModalidad::query()
        ->where('persona_id',$this->personaId)
        ->first();

        $this->cursoId = $modalidad->curso_id;

        //Si tiene pase de curso en otra modalidad
        $pasecurso = TmPaseCursos::query()
        ->where('matricula_id',$modalidad->matricula_id)
        ->where('estado','A')
        ->first();

        if (!empty($pasecurso)){
            
            $this->cursoId = $pasecurso->curso_id;
        }

        $this->loadAsignaturas();

    }
    
    public function render()
    {
       
        return view('livewire.vc-student-subject',[
            'tblrecords' =>  $this->tblrecords
        ]);

    }

    public function loadAsignaturas()
    {

        $this->tblrecords = [];

        $materias = TmHorarios::query()
        ->join("tm_horarios_docentes as d","d.horario_id","=","tm_horarios.id")
        ->join("tm_asignaturas as m","m.id","=","d.asignatura_id")
        ->join("tm_personas as p","p.id","=","d.docente_id")
        ->where("tm_horarios.curso_id",$this->cursoId)
        ->where("tm_horarios.periodo_id",$this->periodoId)
        ->selectRaw("tm_horarios.id, asignatura_id, docente_id, m.descripcion as asignatura, concat(p.apellidos,' ',p.nombres) as docente")
        ->get();

     
        foreach($materias as $recno){

            $asignatura = TmHorariosDocentes::query()
            ->where('horario_id',$recno->id)
            ->where('asignatura_id',$recno->asignatura_id)
            ->where('docente_id',$recno->docente_id)
            ->first();

            $clases = TmActividades::query()
            ->where('docente_id',$recno->docente_id) 
            ->where('paralelo',$asignatura->id)
            ->where('tipo','CV')
            ->where('estado','A')
            ->get();


            $actividad = TmActividades::query()
            ->where('docente_id',$recno->docente_id) 
            ->where('paralelo',$asignatura->id)
            ->where('tipo','AC')
            ->where('fecha','>=',$this->fecha)
            ->where('estado','A')
            ->get();

            $enlace="";
            if (count($clases)>0){{
                $enlace = $clases[0]['enlace'];
            }}

            $array['id'] = $recno->id;
            $array['asignatura_id'] = $recno->asignatura_id;
            $array['docente_id'] = $recno->docente_id;
            $array['asignatura'] = $recno->asignatura;
            $array['docente'] = $recno->docente;
            $array['actividad'] = count($actividad);
            $array['clases'] = count($clases);
            $array['enlace'] = $enlace;
            $array['data'] = json_encode([
                'horarioId' => $recno->id,
                'docenteId' => $recno->docente_id,
                'asignaturaId' => $asignatura->id, 
            ]);
            array_push($this->tblrecords,$array);


        }


    }


}
