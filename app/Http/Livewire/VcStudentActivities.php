<?php

namespace App\Http\Livewire;
use App\Models\TmPeriodosLectivos;
use App\Models\TmCambiaModalidad;
use App\Models\TmHorarios;
use App\Models\TmActividades;
use App\Models\TmAsignaturas;
use App\Models\TmPaseCursos;
use App\Models\TdPeriodoSistemaEducativos;

use Livewire\Component;
use Livewire\WithPagination;

class VcStudentActivities extends Component
{   
    use WithPagination;

    public $fecha, $personaId, $periodoId, $cursoId, $modalidadId, $pendientes, $asignatura="TODOS";
    public $tab1 = "active", $tab2="", $tab3="", $tab4,  $tab5;
    public $materias=[];
    public $filters=[
        'actividad' => "",
        'asignaturaId' => "",
        'pendientes' => "",
    ];

    public function mount()
    {
        $ldate = date('Y-m-d H:i:s');
        $this->fecha = date('Y-m-d',strtotime($ldate));
        $this->personaId = auth()->user()->personaId;

        $periodos = TmPeriodosLectivos::where("aperturado",1)->first();
        $this->periodoId = $periodos['id'];

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
        $tblperiodos = TmPeriodosLectivos::orderBy("periodo","desc")->get();
        
        $this->materias = TmHorarios::query()
        ->join("tm_horarios_docentes as a","a.horario_id","=","tm_horarios.id")
        ->join("tm_asignaturas as m","m.id","=","a.asignatura_id")
        ->where("tm_horarios.curso_id",$this->cursoId)
        ->where("tm_horarios.periodo_id",$this->periodoId)
        ->selectRaw("a.asignatura_id, m.descripcion as asignatura")
        ->orderByRaw('m.descripcion')
        ->get();
        
        $tblrecords = TmActividades::query()
        ->join("tm_personas as p","p.id","=","tm_actividades.docente_id")
        ->join("tm_horarios_docentes as d","d.id","=","tm_actividades.paralelo")
        ->join("tm_horarios as h","h.id","=","d.horario_id")
        ->join("tm_asignaturas as a","a.id","=","d.asignatura_id")
        ->leftJoin('td_actividades_entregas as e', function ($join){
            $join->on('e.actividad_id', '=', 'tm_actividades.id')
            ->where('e.persona_id', '=', $this->personaId);
        })
        ->leftJoin('td_calificacion_actividades as c', function ($join){
            $join->on('c.actividad_id', '=', 'tm_actividades.id')
            ->where('c.persona_id', '=', $this->personaId);
        })
        ->when($this->filters['actividad'],function($query){
            return $query->where('tm_actividades.actividad',"{$this->filters['actividad']}");
        })
        ->when($this->filters['asignaturaId'],function($query){
            return $query->where('a.id',"{$this->filters['asignaturaId']}");
        })
        ->when($this->filters['pendientes'],function($query){
            return $query->whereRaw("c.nota is null and tm_actividades.subir_archivo = 'SI'");
        })
        //->where("tipo",'AC')
        ->where("h.curso_id",$this->cursoId)
        ->select("tm_actividades.*","a.descripcion as asignatura","p.apellidos","p.nombres","c.nota","e.fecha as fechaentrega")        
        ->orderBy("fecha","desc")
        ->paginate(6);

        $this->pendientes = TmActividades::query()
        ->join("tm_horarios_docentes as d","d.id","=","tm_actividades.paralelo")
        ->join("tm_horarios as h","h.id","=","d.horario_id")
        ->leftJoin('td_calificacion_actividades as e', function ($join){
            $join->on('e.actividad_id', '=', 'tm_actividades.id')
            ->where('e.persona_id', '=', $this->personaId);
        })
        ->when($this->filters['actividad'],function($query){
            return $query->where('tm_actividades.actividad',"{$this->filters['actividad']}");
        })
        ->when($this->filters['asignaturaId'],function($query){
            return $query->where('d.asignatura_id',"{$this->filters['asignaturaId']}");
        })
        ->whereRaw("e.nota is null")
        //->where("tipo",'AC')
        ->where("h.curso_id",$this->cursoId)  
        ->where("subir_archivo",'SI')   
        ->orderBy("fecha","desc")
        ->count();
                
        return view('livewire.vc-student-activities',[
            'tblrecords' => $tblrecords,
        ]);
    }

    public function paginationView(){
        return 'vendor.livewire.bootstrap'; 
    }
    
    public function filtrar($data){

        $this->tab1=""; 
        $this->tab2="";
        $this->tab3="";
        $this->tab4="";
        $this->tab5="";

        switch ($data) {
        case "AI":
            $this->tab2 = "active";
            $this->filters['actividad'] = $data;
            break;
        case "AG":
            $this->tab3 = "active";
            $this->filters['actividad'] = $data;
            break;
        case "EX":
            $this->tab5 = "active";
            $this->filters['actividad'] = $data;
            break;
        default:
            $this->tab1 = "active";
            $this->filters=[
                'actividad' => "",
                'asignaturaId' => $this->filters['asignaturaId'],
                'pendientes' => "",
            ];
        }

        
    }

    public function pendientes(){

        $this->tab1="";
        $this->tab2="";
        $this->tab3="";
        $this->tab4="";

        $this->tab14= "active";
        $this->filters['actividad']  = "";
        $this->filters['pendientes'] = "S";

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

        /*$record = TmActividades::find($id);

        $sistema = TdPeriodoSistemaEducativos::query()
        ->where("codigo",$record->termino)
        ->where("periodo_id",$this->periodoId)
        ->first();

        if ($sistema->cerrar==1){
           $this->dispatchBrowserEvent('trimestre-cerrado');
           return;
        }*/

        $datos = TmActividades::query()
        ->join("tm_horarios_docentes as d","d.id","=","tm_actividades.paralelo")
        ->where("tm_actividades.id",$id)
        ->select("d.id","d.horario_id","tm_actividades.docente_id")
        ->first();

        $datos=[
            'horarioId' => $datos->horario_id,
            'docenteId' => $datos->docente_id,
            'asignaturaId' => $datos->id,
        ];

        $datos=json_encode($datos);
        return redirect()->to('/student/deliver-activity/' . $id . ',' . $datos);
    }
    
}
