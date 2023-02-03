<?php

namespace App\Http\Livewire;
use App\Models\TmGeneralidades;
use App\Models\TmPeriodosLectivos;
use App\Models\TmServicios;
use App\Models\TmCursos;

use Livewire\Component;

class VcModalSections extends Component
{
    
    public $selectedCourse=null;
    public $periodoId;
    public $grupoId;
    public $tblcursos=null;
    public $tblservicios=null;
    public $nivelId;
    public $gradoId;
    public $cursoId;
    public $grupoid,$nivelid,$gradoid,$cursoid;
    public $datos =[
        'grupoId' => 0,
        'nivelId' => 0,
        'gradoId' => 0,
        'seccionId' => 0,
    ];

    protected $listeners = ['setSection'];

    public function render()
    {   
        $tblgenerals = TmGeneralidades::all();
        $tblperiodos = TmPeriodosLectivos::orderBy('periodo', 'desc')->get();

        return view('livewire.vc-modal-sections',[
            'tblgenerals' => $tblgenerals,
            'tblperiodos' => $tblperiodos,
        ]);
    }

    public function setSection($periodoid,$grupoid,$nivelid,$gradoid,$cursoid){

        $this->periodoId = $periodoid;
        $this->grupoId = $grupoid;
        $this->nivelId = $nivelid;
        $this->updatednivelId($this->nivelId);

        $this->gradoId = $gradoid;
        $this->updatedgradoId($this->gradoId);

        $this->cursoId = $cursoid;
    }

    public function updatedgrupoId($id){
        $this->datos['grupoId'] =  $id;
    }

    public function updatednivelId($id){

        $this->datos['nivelId'] =  $id;        
        
        $this->tblservicios = TmServicios::where([
            ['nivel_id',$id],
            ['modalidad_id',$this->grupoId],
        ])->get();

    }

    public function updatedgradoId($id){

        $this->datos['gradoId'] =  $id; 

        $this->tblcursos = TmCursos::where([
                ['periodo_id',$this->periodoId],
                ['servicio_id',$id],
            ])->get();

    }

    public function updatedcursoId($id){
        
        $this->datos['seccionId'] =  $id;

    }

}
