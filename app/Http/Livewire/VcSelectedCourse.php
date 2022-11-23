<?php

namespace App\Http\Livewire;
use App\Models\TmGeneralidades;
use App\Models\TmPeriodosLectivos;
use App\Models\TmServicios;
use App\Models\TmCursos;




use Livewire\Component;

class VcSelectedCourse extends Component
{
    
    public $selectedCourse=null;
    public $periodoId;
    public $grupoId;
    public $tblcursos=null;
    public $tblservicios=null;
    public $nivelId;
    public $gradoId;
    public $cursoId;
    public $datos =[
        'grupoId' => 0,
        'periodoId' => 0,
        'nivelId' => 0,
        'gradoId' => 0,
        'seccionId' => 0,
    ];

    public function render()
    {   
        $tblgenerals = TmGeneralidades::all();
        $tblperiodos = TmPeriodosLectivos::orderBy('periodo', 'desc')->get();

        return view('livewire.vc-selected-course',[
            'tblgenerals' => $tblgenerals,
            'tblperiodos' => $tblperiodos,
        ]);
    }

    public function updatedgrupoId($id){
        $this->datos['grupoId'] =  $id;
    }

    public function updatedperiodoId($id){
        $this->datos['periodoId'] =  $id;
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

        $servicio = TmServicios::where('id',$id)->first();   
        
        if ($servicio!=null){
        
            $grado = $servicio['grado_id'];
            
            $this->tblcursos = TmCursos::where([
                    ['periodo_id',$this->periodoId],
                    ['nivel_id',$this->nivelId],
                    ['grado_id',$grado],
                ])->get();


        }

    }

    public function updatedcursoId($id){
        
        $this->datos['seccionId'] =  $id;

    }


}
