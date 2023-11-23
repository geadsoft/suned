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
    public $ciclo='T',$parcial,$fecha,$evaluacion='N';
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

    public function updatedcomponenteId(){
        $this->parcial="";
        $this->tbldetalle=[];
    }

    public function updatedparcial(){

        $record = TrCalificacionesCabs::where('grupo_id',$this->grupoId)
        ->where('servicio_id',$this->servicioId)
        ->where('periodo_id',$this->periodoId)
        ->where('curso_id',$this->cursoId)
        ->where('asignatura_id',$this->componenteId)
        ->where('ciclo_academico',$this->ciclo)
        ->where('parcial',$this->parcial)
        ->first();

        if(!empty($record)){
            $this->selectId = $record['id'];
            $this->fecha    = date('Y-m-d',strtotime($record['fecha'])); 
            $this->loadCalificacion();
        }else{
            $this->selectId = 0;
            $this->fecha    = "";
            $this->loadEstudiantes();
        }

    } 
    
    public function loadEstudiantes(){

        $alumnos = TmMatricula::join("tm_personas","tm_matriculas.estudiante_id","=","tm_personas.id")
        ->where('periodo_id',$this->periodoId)
        ->where('curso_id',$this->cursoId)
        ->select('tm_personas.id','tm_personas.apellidos','tm_personas.nombres','tm_personas.identificacion')
        ->orderBy('tm_personas.apellidos','asc')
        ->get();

        foreach ($alumnos as $recno)
        {
            $detalle=[]; 
            $detalle['id']            = 0;
            $detalle['estudiante_id'] = $recno['id'];
            $detalle['nui']       = $recno['identificacion'];
            $detalle['apellidos'] = $recno['apellidos'];
            $detalle['nombres']   = $recno['nombres'];
            $detalle['fecha']     = $this->fecha;
            $detalle['nota']        = null;
            $detalle['escala']      = "";
            $detalle['observacion'] = "";
            array_push($this->tbldetalle, $detalle);
        }
        
    }

    public function loadCalificacion(){

        $alumnos = TrCalificacionesDets::where('calificacioncab_id',$this->selectId)
        ->get();

        foreach ($alumnos as $recno)
        {
            $detalle=[]; 
            $detalle['id']            = $recno->id;
            $detalle['estudiante_id'] = $recno->estudiante_id;
            $detalle['nui']         = $recno->estudiante->identificacion;
            $detalle['apellidos']   = $recno->estudiante->apellidos;
            $detalle['nombres']     = $recno->estudiante->nombres;
            $detalle['fecha']       = date('Y-m-d',strtotime($recno->fecha));
            $detalle['nota']        = $recno->calificacion;
            $detalle['escala']      = $recno->escala_cualitativa;
            $detalle['observacion'] = $recno->observacion;
            array_push($this->tbldetalle, $detalle);
        }

    }
    
    public function createData(){
        
        $this ->validate([
            'grupoId'    => 'required',
            'servicioId' => 'required',
            'periodoId'  => 'required',
            'cursoId'    => 'required',
            'componenteId' => 'required',
            'ciclo'        => 'required',
            'parcial'      => 'required',
            'fecha'        => 'required',
        ]);

        if ($this->selectId>0){
            $this->updatedData();
            return;
        }

        $tmnotas = TrCalificacionesCabs::Create([
            'fecha'     => $this->fecha,
            'grupo_id'  => $this -> grupoId,
            'servicio_id' => $this -> servicioId,
            'periodo_id' => $this -> periodoId,
            'curso_id' => $this -> cursoId,
            'asignatura_id' => $this -> componenteId,
            'ciclo_academico' => $this -> ciclo,
            'parcial' => $this -> parcial,
            'usuario' => auth()->user()->name,
        ]);
        
        $this->selectId = $tmnotas['id'];

        $objdetalle=[];
        foreach ($this->tbldetalle as $key => $data){

            $detalle=[];
            $detalle['calificacioncab_id'] = $this->selectId;
            $detalle['fecha'] = $data['fecha'];
            $detalle['estudiante_id'] = $data['estudiante_id'];
            $detalle['calificacion']  = $data['nota'];
            $detalle['escala_cualitativa'] = $data['escala'];
            $detalle['observacion'] = $data['observacion'];
            $detalle['usuario'] = auth()->user()->name;
            array_push($objdetalle, $detalle);
        }

        TrCalificacionesDets::insert($objdetalle); 
        
        $this->dispatchBrowserEvent('msg-grabar');
        
    }

    public function updatedData(){

        foreach ($this->tbldetalle as $data){

            $record = TrCalificacionesDets::find($data['id']);
            $record->update([
                'fecha'        => $data['fecha'],
                'calificacion' => $data['nota'],
                'escala_cualitativa' => $data['escala'],
                'observacion'  => $data['observacion'],
            ]);

        }

        $this->dispatchBrowserEvent('msg-editar');

    }


}
