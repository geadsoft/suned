<?php

namespace App\Http\Livewire;
use App\Models\TmGeneralidades;
use App\Models\TmPeriodosLectivos;
use App\Models\TmServicios;
use App\Models\TmCursos;
use App\Models\TrDeudasCabs;




use Livewire\Component;

class VcSelectedCourse extends Component
{
    public $estudiante_id;
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

    public function mount($estudianteId){

        $this->estudiante_id = $estudianteId;

    }

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

        /* Mantiene Deuda */
        $this->deudas = TrDeudasCabs::query()
        ->join("tm_periodos_lectivos as p","p.id","=","tr_deudas_cabs.periodo_id")
        ->selectRaw("p.descripcion, sum(saldo) as monto")
        ->where("tr_deudas_cabs.estudiante_id",$this->estudiante_id)
        ->where("tr_deudas_cabs.periodo_id","<>",$this->id)
        ->groupBy("p.descripcion")
        ->get()->toArray();

        $montoDeuda = (array_sum(array_column($this->deudas,'monto')));

        if ($montoDeuda>0 && $this->estudiante_id>0){
            $this->dispatchBrowserEvent('show-deuda');
        }
        
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
