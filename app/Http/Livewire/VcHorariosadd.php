<?php

namespace App\Http\Livewire;
use App\Models\TmPeriodosLectivos;
use App\Models\TmGeneralidades;
use App\Models\TmHorarios;
use App\Models\TmCursos;
use App\Models\TmServicios;
use App\Models\TmAsignaturas;
use App\Models\TmHorariosDocentes;
use App\Models\TmActividades;

use Livewire\Component;

class VcHorariosadd extends Component
{
    public $tblgenerals=null;
    public $tblperiodos=null;
    public $tblcursos=null;
    public $tblservicios=null;
    public $selectId,$grupoId,$servicioId,$nivelId,$gradoId,$especialidadId,$periodoId,$cursoId;
    public $tabHorario, $tabDocente, $edit=false;
    public $nombreCurso, $nombreGrupo, $asignaturaDocenteId;
    public $clasTab1="tab-pane fade show active";
    public $clasTab2="tab-pane fade";
    public $clasTab3="tab-pane fade";
    public $tab1='active', $tab2, $tab3;

    protected $listeners = ['setDelete','deleteData'];
    
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

        if ($this->edit==true){
            return;
        }

        $tblrecords = TmHorarios::find($this->selectId);
        $this->grupoId    = $tblrecords['grupo_id'];
        $this->updatedgrupoId($this->grupoId);

        $this->servicioId = $tblrecords['servicio_id']; 
        $this->updatedservicioId($this->servicioId);

        $this->periodoId  = $tblrecords['periodo_id'];
        $this->updatedperiodoId($this->periodoId);

        $this->cursoId    = $tblrecords['curso_id']; 
        $this->edit = true;

        $servicio = TmServicios::find($this->servicioId);
        $curso = TmCursos::find($this->cursoId);
        $grupo = TmGeneralidades::find($this->grupoId);
        $this->nombreCurso = $servicio->descripcion.' - '.$curso->paralelo;
        $this->nombreGrupo = $grupo->descripcion;
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

        if ($this->edit==true){
            $this->editData();
            return;
        }

        $tmhorarios = TmHorarios::Create([
            'grupo_id' => $this -> grupoId,
            'servicio_id' => $this -> servicioId,
            'periodo_id' => $this -> periodoId,
            'curso_id' => $this -> cursoId,
            'usuario' => auth()->user()->name,
        ]);

        $message = "Horario de Escolar grabado con éxito!, debe asignar materias.";
        $this->dispatchBrowserEvent('msg-grabar', ['newName' => $message]);
        
        $this->selectId = $tmhorarios['id'];
        $this->emitTo('vc-horarios-clase','setHorario',$this->selectId);
    }

    public function editData(){

        $record = TmHorarios::find($this->selectId);
        $record->update([
            'grupo_id' => $this -> grupoId,
            'servicio_id' =>$this -> servicioId,
            'periodo_id' => $this -> periodoId,
            'curso_id' => $this -> cursoId,
        ]);

        $message = "Horario de Escolar actualizado con éxito!";
        $this->dispatchBrowserEvent('msg-grabar', ['newName' => $message]);

    }
    

    public function setDelete($id){

        $this->asignaturaDocenteId = $id;
        $actividad = TmActividades::where('paralelo',$id)->get();

        if (!empty($actividad)){
            $this->dispatchBrowserEvent('msg-error');
        }else{
            $this->dispatchBrowserEvent('msg-confirm');
        }
       
        $this->clasTab1 = "tab-pane fade";
        $this->clasTab2 = "tab-pane fade";
        $this->clasTab3 = "tab-pane fade show active";
        $this->tab1='';
        $this->tab2='';
        $this->tab3="active";

    }

    public function deleteData(){

        TmHorariosDocentes::find($this->asignaturaDocenteId)->delete();
        $this->loadData();

    } 

    
}
