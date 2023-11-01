<?php

namespace App\Http\Livewire;
use App\Models\TmPeriodosLectivos;
use App\Models\TmGeneralidades;
use App\Models\TmHorarios;
use App\Models\TmCursos;
use App\Models\TmServicios;
use App\Models\TmAsignaturas;

use Livewire\Component;

class VcHorariosadd extends Component
{
    public $tblgenerals=null;
    public $tblperiodos=null;
    public $tblcursos=null;
    public $tblservicios=null;
    public $selectId,$grupoId,$servicioId,$nivelId,$gradoId,$especialidadId,$periodoId,$cursoId;
    public $tabHorario, $tabDocente;
    
    public function mount($horarioId){

        $this->tblgenerals  = TmGeneralidades::whereRaw('superior in (1,2,3,4)')->get();
        $this->tblperiodos  = TmPeriodosLectivos::orderBy("periodo","desc")->get();
        $this->tblmaterias  = TmAsignaturas::all();
        $this->tabHorario   = "disabled";
        $this->tabDocente   = "disabled"; 
        $this->selectId     = $horarioId;  
    }

    public function render()
    {
        if ($this->selectId==0){
            $tblrecords = TmHorarios::where('id',0)->get();
        }else{
           $this->loadData();
        }

        return view('livewire.vc-horariosadd',[
            'tblgenerals' => $this->tblgenerals,
            'tblperiodos' => $this->tblperiodos,
            'tblservicios'=> $this->tblservicios,
            'tblmaterias' => $this->tblmaterias,
        ]);

    }

    public function loadData(){

        $tblrecords = TmHorarios::find($this->selectId);
        $this->grupoId    = $tblrecords['grupo_id'];
        $this->updatedgrupoId($this->grupoId);

        $this->servicioId = $tblrecords['servicio_id']; 
        $this->updatedservicioId($this->servicioId);

        $this->periodoId  = $tblrecords['periodo_id'];
        $this->updatedperiodoId($this->periodoId);

        $this->cursoId    = $tblrecords['curso_id']; 
        //$this->emitTo('vc-horarios-clase','setHorario',$this->selectId);
    }

    public function loadHorario(){

        if($this->selectId==0){
            return;
        }
        
        $this->emitTo('vc-horarios-clase','setHorario',$this->selectId);
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

    public function createData(){
        
        $this ->validate([
            'grupoId'    => 'required',
            'servicioId' => 'required',
            'periodoId'  => 'required',
            'cursoId'    => 'required',
        ]);

        $tmhorarios = TmHorarios::Create([
            'grupo_id' => $this -> grupoId,
            'servicio_id' => $this -> servicioId,
            'periodo_id' => $this -> periodoId,
            'curso_id' => $this -> cursoId,
            'usuario' => auth()->user()->name,
        ]);
        
        $this->selectId = $tmhorarios['id'];
        $this->emitTo('vc-horarios-clase','setHorario',$this->selectId);
    }


}
