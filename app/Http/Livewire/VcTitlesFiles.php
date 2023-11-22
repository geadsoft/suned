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
use Illuminate\Support\Facades\DB;

class VcTitlesFiles extends Component
{
    use WithPagination;
    public $previus='', $current='', $nomnivel, $nomcurso, $fecha, $documento, $alumno;
    public $estudianteId,$periodoId,$grupoId,$nivelId,$gradoId,$cursoId,$numreg,$matriculaId;
    public $filters = [
        'srv_periodo' => '',
        'srv_grupo' => '',
        'srv_nombre' => '',
        'srv_estado' => 'A',
    ];

    public function mount(){

        $año   = date('Y');
        $tblperiodos = TmPeriodosLectivos::where("periodo",$año)->first();
        $this->filters['srv_periodo'] = $tblperiodos['id'];
    }
    
    public function render()
    {   
        $tblrecords = TmPersonas::query()
        ->join("tm_matriculas as m","tm_personas.id","=","m.estudiante_id")
        ->join("tm_cursos as c","c.id","=","m.curso_id")
        ->join("tm_servicios as s","s.id","=","c.servicio_id")
        ->join("tm_periodos_lectivos as p","p.id","=","m.periodo_id")
        ->join("tm_generalidades as g","g.id","=","m.modalidad_id")
        ->when($this->filters['srv_nombre'],function($query){
            return $query->where(DB::raw('concat(ltrim(rtrim(apellidos))," ",ltrim(rtrim(nombres)))'), 'LIKE' , "%{$this->filters['srv_nombre']}%");
        })
        ->when($this->filters['srv_periodo'],function($query){
            return $query->where('m.periodo_id',"{$this->filters['srv_periodo']}");
        })
        ->when($this->filters['srv_grupo'],function($query){
            return $query->where('m.modalidad_id',"{$this->filters['srv_grupo']}");
        })
        ->where('tm_personas.estado',$this->filters['srv_estado'])
        ->where('s.nivel_id',11)
        ->where('s.grado_id',17)
        ->select('m.id','identificacion','nombres','apellidos', 'documento', 'fecha', 'g.descripcion as nomgrupo','p.descripcion as nomperiodo',
        's.descripcion as nomgrado','c.paralelo','m.periodo_id','m.modalidad_id','m.nivel_id','c.servicio_id','m.curso_id','m.estudiante_id')
        ->orderbyRaw('m.modalidad_id,apellidos')
        ->paginate(10);
    
        $tblgenerals = TmGeneralidades::where('superior',1)->get();
        $tblperiodos = TmPeriodosLectivos::orderBy("periodo","desc")->get();
        $this->tblservicios = TmServicios::all();
        $this->tblcursos    = TmCursos::all();
        $this->tbldatogen   = TmGeneralidades::all();
        
        return view('livewire.vc-titles-files',[
            'tblrecords' => $tblrecords,
            'tblgenerals' => $tblgenerals,
            'tblperiodos' => $tblperiodos
        ]);

    }

    public function paginationView(){
        return 'vendor.livewire.bootstrap'; 
    }

}
