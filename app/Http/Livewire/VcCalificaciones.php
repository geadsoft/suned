<?php

namespace App\Http\Livewire;
use App\Models\TrCalificacionesCabs;
use App\Models\TmPeriodosLectivos;
use App\Models\TmGeneralidades;
use App\Models\TmCursos;
use App\Models\TmAsignaturas;
use App\Models\TmServicios;

use Livewire\Component;
use Livewire\WithPagination;

class VcCalificaciones extends Component
{
    use WithPagination;
    public $tblrecords;
    public $periodoId, $grupoId, $nivelId, $gradoId, $especialidadId, $seccionId, $asignaturaId, $parcial;
    
    public function mount(){

        $this->tblgenerals  = TmGeneralidades::whereRaw('superior in (1,2,4)')->get();
        $this->tblgrados    = TmGeneralidades::where('superior','3')->get();
        $this->tblperiodos  = TmPeriodosLectivos::orderBy("periodo","desc")->get();
        $this->asignaturas  = TmAsignaturas::all();
        $this->periodoId    = $this->tblperiodos[0]['id'];
        $this->parcial  = 'P1';
        $this->grupoId  = 2;

    }
    
    public function render()
    {      
        return view('livewire.vc-calificaciones',[
            'tblrecords'  => $this->tblrecords,
            'tblperiodos' => $this->tblperiodos,
            'tblgenerals' => $this->tblgenerals,
        ]);
    }

    public function paginationView(){
        return 'vendor.livewire.bootstrap'; 
    }

    public function updatedNivelId(){   
        
        $this->tblgrados = TmServicios::where('modalidad_id',$this->grupoId)
        ->where('nivel_id',$this->nivelId)
        ->get();

    }

    public function loadData(){   
        
        $this->tblrecords = TrCalificacionesCabs::query()
        ->join("tm_servicios  as s","tr_calificaciones_cabs.servicio_id","=","s.id")
        ->when($this->grupoId,function($query){
            return $query->where('grupo_id',"{$this->grupoId}");
        })
        ->when($this->nivelId,function($query){
            return $query->where('s.nivel_id',"{$this->nivelId}");
        })
        ->when($this->gradoId,function($query){
            return $query->where('s.grado_id',"{$this->gradoId}");
        })
        ->when($this->especialidadId,function($query){
            return $query->where('s.especializacion_id',"{$this->especialidadId}");
        })
        ->when($this->seccionId,function($query){
            return $query->where('curso_id',"{$this->seccionId}");
        })
        ->when($this->asignaturaId,function($query){
            return $query->where('asignatura_id',"{$this->asignaturaId}");
        })
        ->when($this->parcial,function($query){
            return $query->where('parcial',"{$this->parcial}");
        })  
        ->where('periodo_id',$this->periodoId)  
        ->select('tr_calificaciones_cabs.*')          
        ->get(); 

    }





}
