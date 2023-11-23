<?php

namespace App\Http\Livewire;
use App\Models\TmPeriodosLectivos;
use App\Models\TmGeneralidades;
use App\Models\TmPersonas;
use App\Models\TmMatricula;
use App\Models\TmServicios;
use App\Models\TmCursos;
use App\Models\TdTitulosActas;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;

class VcTitlesFiles extends Component
{
    use WithPagination;
    public $previus='', $current='', $nomnivel, $nomcurso, $documento;
    public $estudianteId,$periodoId,$grupoId,$nivelId,$gradoId,$cursoId,$numreg,$matriculaId;
    public $alumno,$titulo=false,$acta=false,$comentario,$fecha;
    public $filters = [
        'srv_periodo' => '',
        'srv_grupo' => '',
        'srv_nombre' => '',
        'srv_estado' => 'A',
    ];

    public function mount(){

        $año   = date('Y');
        $ldate = date('Y-m-d H:i:s');
        $this->fecha = date('Y-m-d',strtotime($ldate));
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
        ->leftJoin('td_titulos_actas as t', function($join)
        {
            $join->on('t.estudiante_id', '=', 'm.estudiante_id');
            $join->on('t.periodo_id', '=','m.periodo_id');
        })
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
        ->select('m.id','identificacion','nombres','apellidos', 'documento', 'm.fecha', 'g.descripcion as nomgrupo','p.descripcion as nomperiodo',
        's.descripcion as nomgrado','c.paralelo','m.periodo_id','m.modalidad_id','m.nivel_id','c.servicio_id','m.curso_id','m.estudiante_id',
        'titulo','acta','t.comentario')
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

    public function edit( $recnoId ){
               
        $this->selectId = $recnoId;
        $matricula = TmMatricula::find($this->selectId);
        $this->alumno = $matricula->estudiante['apellidos'].' '.$matricula->estudiante['nombres'];
        $this->estudianteId = $matricula['estudiante_id'];
        $this->dispatchBrowserEvent('show-form');

    }

    public function createData(){
        
        $this ->validate([
            'fecha' => 'required',
            'titulo' => 'required',
            'acta' => 'required',
            'comentario' => 'required',
        ]);

        TdTitulosActas::Create([
            'fecha' => $this -> fecha,
            'periodo_id' => $this->filters['srv_periodo'],
            'estudiante_id' => $this->estudianteId,
            'titulo' => $this -> titulo,
            'acta' => $this -> acta,
            'comentario' => $this -> comentario,
            'usuario' => auth()->user()->name,
        ]);

        $this->dispatchBrowserEvent('hide-form', ['message'=> 'added successfully!']);  
        $this->titulo=false;
        $this->acta=false;
        $this->comentario='';

    }

}
