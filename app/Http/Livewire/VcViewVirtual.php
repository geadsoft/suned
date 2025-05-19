<?php

namespace App\Http\Livewire;
use App\Models\TmHorarios;
use App\Models\TmPeriodosLectivos;
use App\Models\TmMatricula;
use App\Models\TmPaseCursos;


use Livewire\Component;
use Livewire\WithPagination;

class VcViewVirtual extends Component
{
    public $cursoId;
    public $tblparalelo=[];
     
    use WithPagination;

    public function mount()
    {
        $this->personaId = auth()->user()->personaId;

        $tblperiodos = TmPeriodosLectivos::where("aperturado",1)->first();
        $this->periodoId = $tblperiodos['id'];

        $matricula = TmMatricula::where('estudiante_id',$this->personaId)
        ->where('periodo_id',$this->periodoId)
        ->orderBy('periodo_id','desc')->first();
        $this->cursoId = $matricula['curso_id'];

        $pasecurso = TmPaseCursos::query()
        ->where('matricula_id',$matricula->id)
        ->where('estado','A')
        ->first();

        if (!empty($pasecurso)){
            $this->cursoId = $pasecurso->curso_id;
        }

    }

    public function render()
    {
        $tblrecords = TmHorarios::query()
        ->join("tm_servicios as s","s.id","=","tm_horarios.servicio_id")
        ->join("tm_cursos as c","c.id","=","tm_horarios.curso_id")
        ->join("tm_horarios_docentes as d","d.horario_id","=","tm_horarios.id")
        ->join("tm_asignaturas as m","m.id","=","d.asignatura_id")
        ->join("tm_actividades as a","a.paralelo","=","d.id")
        ->where("tm_horarios.curso_id",$this->cursoId)
        ->where("tm_horarios.periodo_id",$this->periodoId)
        ->where("a.tipo","CV")
        ->where("a.estado","A")
        ->selectRaw('m.descripcion as asignatura, s.descripcion as curso, c.paralelo as aula, a.*')
        ->orderby("m.descripcion")
        ->paginate(12);

        return view('livewire.vc-view-virtual',[
            'tblrecords' =>  $tblrecords
        ]);

    }

    public function paginationView(){
        return 'vendor.livewire.bootstrap'; 
    }

}
