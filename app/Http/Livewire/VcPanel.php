<?php

namespace App\Http\Livewire;
use App\Models\TmPeriodosLectivos;
use App\Models\TmMatricula;

use Livewire\Component;

class VcPanel extends Component
{
    public $lnperiodoId, $hombres, $mujeres, $chartsmatricula=[];
    
    public function mount(){    
        $periodo = TmPeriodosLectivos::orderBy("periodo","desc")->first();
        $this->lnperiodoId = $periodo['id'];
    }
    
    public function render()
    {
        $personas = TmMatricula::query()
        ->join('tm_personas as p','p.id','tm_matriculas.estudiante_id')
        ->where('tm_matriculas.periodo_id',$this->lnperiodoId)
        ->where("tipopersona","E")
        ->get();
        
        $this->hombres = $personas->where('genero','M')->count('id');
        $this->mujeres = $personas->where('genero','F')->count('id');
        
        $this->chartsmatricula = json_encode($personas);

        return view('livewire.vc-panel');
    }
}

?>
