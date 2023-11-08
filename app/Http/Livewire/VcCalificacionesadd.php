<?php

namespace App\Http\Livewire;
use App\Models\TrCalificacionesCabs;
use App\Models\TrCalificacionesDets;
use App\Models\TmPeriodosLectivos;
use App\Models\TmGeneralidades;
use App\Models\TmHorarios;
use App\Models\TmHorariosDocentes;
use App\Models\TmCursos;
use App\Models\TmServicios;
use App\Models\TmAsignaturas;
use App\Models\TmMatricula;

use Livewire\Component;

class VcCalificacionesadd extends Component
{
    public $tblgenerals=null;
    public $tblperiodos=null;
    public $tblcursos=null;
    public $tblservicios=null;
    public $tblmaterias=null;
    public $selectId,$grupoId,$servicioId,$nivelId,$gradoId,$especialidadId,$periodoId,$cursoId,$componenteId;
    public $modo='T', $pacademico, $fecha;
    public $tbldetalle=[];
    
    public function mount(){

        $this->tblgenerals  = TmGeneralidades::whereRaw('superior in (1,2,3,4)')->get();
        $this->tblperiodos  = TmPeriodosLectivos::orderBy("periodo","desc")->get();

    }

    public function render()
    {
        return view('livewire.vc-calificacionesadd');
    }

    public function updatedgrupoId($id){   
        
        $this->tblservicios = TmServicios::where('modalidad_id',$id)->get();
    }

    public function updatedservicioId($id){
        
        $servicio =  TmServicios::find($id);
        $this->nivelId = $servicio->nivel_id;
        $this->gradoId = $servicio->grado_id;
        $this->especialidadId = $servicio->especializacion_id;
        $this->periodoId = '';
        $this->cursoId = '';
    }

    public function updatedperiodoId($id){
        
      $this->tblcursos = TmCursos::where('periodo_id',$id)
                         ->where('servicio_id',$this->servicioId)
                         ->get();  

    }

    public function updatedcursoId($id){
        
        $horarios =  TmHorarios::where("grupo_id",$this->grupoId)
        ->where("servicio_id",$this->servicioId)
        ->where("periodo_id",$this->periodoId)
        ->where("curso_id",$id)
        ->first();

        $this->tblmaterias = TmHorariosDocentes::where('horario_id',$horarios['id'])
        ->get();
  
    }

    public function updatedpacademico(){

        $alumnos = TmMatricula::join("tm_personas","tm_matriculas.estudiante_id","=","tm_personas.id")
        ->where('periodo_id',$this->periodoId)
        ->where('curso_id',$this->cursoId)
        ->select('tm_personas.id','tm_personas.apellidos','tm_personas.nombres','tm_personas.identificacion')
        ->orderBy('tm_personas.apellidos','asc')
        ->get();

        foreach ($alumnos as $recno)
        {
            $detalle=[]; 
            $detalle['estudiante_id'] = $recno['id'];
            $detalle['nui']       = $recno['identificacion'];
            $detalle['apellidos'] = $recno['apellidos'];
            $detalle['nombres']   = $recno['nombres'];
            $detalle['fecha']     = $this->fecha;
            $detalle['nota']      = 0;
            $detalle['escala']      = "";
            $detalle['observacion'] = "";
            array_push($this->tbldetalle, $detalle);
        }

    }                 


}
