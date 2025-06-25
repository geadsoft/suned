<?php

namespace App\Http\Livewire;
use App\Models\TmPeriodosLectivos;
use App\Models\TmCambiaModalidad;
use App\Models\TmHorarios;
use App\Models\TmRecursos;
use App\Models\TmAsignaturas;


use Livewire\Component;
use Livewire\WithPagination;

class VcStudentResources extends Component
{
    use WithPagination;

    public $asignatura="TODOS";
    public $filters=[
        'asignaturaId' => "",
    ];
    
    public function mount()
    {
        $ldate = date('Y-m-d H:i:s');
        $this->fecha = date('Y-m-d',strtotime($ldate));
        $this->personaId = auth()->user()->personaId;

        $tblperiodos = TmPeriodosLectivos::where("aperturado",1)->first();
        $this->periodoId = $tblperiodos['id'];

        $matricula = TmCambiaModalidad::query()
        ->where('persona_id',$this->personaId)
        ->first();

        $this->cursoId = $matricula->curso_id;
        $this->modalidadId = $matricula->modalidad_id;

        //Si tiene pase de curso en otra modalidad
        $pasecurso = TmPaseCursos::query()
        ->where('matricula_id',$matricula->matricula_id)
        ->where('estado','A')
        ->first();

        if (!empty($pasecurso)){
            
            $this->cursoId = $pasecurso->curso_id;
        }
        
    }
    
    public function render()
    {
        
        $this->materias = TmHorarios::query()
        ->join("tm_horarios_docentes as a","a.horario_id","=","tm_horarios.id")
        ->join("tm_asignaturas as m","m.id","=","a.asignatura_id")
        ->where("tm_horarios.curso_id",$this->cursoId)
        ->where("tm_horarios.periodo_id",$this->periodoId)
        ->selectRaw("a.asignatura_id, m.descripcion as asignatura")
        ->orderByRaw('m.descripcion')
        ->get();
        
        $tblrecords = TmRecursos::query()
        ->join("td_recursos_cursos as r","r.recurso_id","=","tm_recursos.id")
        ->join("tm_personas as p","p.id","=","tm_recursos.docente_id")
        ->join("tm_asignaturas as a","a.id","=","tm_recursos.asignatura_id")
        ->when($this->filters['asignaturaId'],function($query){
            return $query->where('a.id',"{$this->filters['asignaturaId']}");
        })
        ->where("r.curso_id",$this->cursoId)
        ->select("tm_recursos.*","a.descripcion as asignatura","p.apellidos","p.nombres")        
        ->orderBy("id","desc")
        ->paginate(6);
        
        return view('livewire.vc-student-resources',[
            'tblrecords' => $tblrecords,
        ]);
    }

    public function paginationView(){
        return 'vendor.livewire.bootstrap'; 
    }

    public function asignatura($id){

        $this->asignatura = "TODAS";
        if ($id<>''){
            $asignatura = TmAsignaturas::find($id);
            $this->asignatura = $asignatura->descripcion;
        }
        
        $this->filters['asignaturaId']  = $id;
    }

    public function mostrar($id){

        return redirect()->to('/student/resource-view/'.$id);

    }

}
