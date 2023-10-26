<?php

namespace App\Http\Livewire;
use App\Models\TmPeriodosLectivos;
use App\Models\TmGeneralidades;
use App\Models\TmHorarios;
use App\Models\TmCursos;
use App\Models\TmServicios;

use Livewire\Component;

class VcHorariosadd extends Component
{
    public $tblgenerals=null;
    public $tblperiodos=null;
    public $tblcursos=null;
    public $tblservicios=null;
    public $selectId,$grupoId,$servicioId,$nivelId,$gradoId,$especialidadId,$periodoId,$cursoId;
    
    public function mount(){

        $this->tblgenerals  = TmGeneralidades::whereRaw('superior in (1,2,3,4)')->get();
        $this->tblperiodos  = TmPeriodosLectivos::orderBy("periodo","desc")->get();
    
    }

    public function render()
    {

        $tblrecords = TmHorarios::where('id',0)->get();

        return view('livewire.vc-horariosadd',[
            'tblgenerals' => $this->tblgenerals,
            'tblperiodos' => $this->tblperiodos,
            'tblservicios' => $this->tblservicios,

        ]);

    }

    public function updatedgrupoId($id){   
        
        $this->tblservicios = TmServicios::where('modalidad_id',$id)->get();
    }

    public function updatedservicioId($id){
        
        $servicio =  TmServicios::find($id);
        $this->nivelId = $servicio->nivel_id;
        $this->gradoId = $servicio->grado_id;
        $this->especialidadId = $servicio->especializacion_id;

    }

    public function updatedperiodoId($id){
        
      $this->tblcursos = TmCursos::where('periodo_id',$id)
                         ->where('servicio_id',$this->servicioId)
                         ->get();  

    }


}
